<?php

namespace App\Http\Controllers\Admin;

use App\Authorization\PermissionCatalog;
use App\Http\Controllers\Controller;
use App\Support\ActivityLogger;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Role::class);
        return view('admin.roles.index', ['roles'=>Role::query()->with('permissions')->orderBy('name')->get(),'permissionGroups'=>PermissionCatalog::groups()]);
    }

    public function create()
    {
        Gate::authorize('create', Role::class);
        return view('admin.roles.create', ['permissionGroups'=>PermissionCatalog::groups()]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Role::class);
        $data = $request->validate([
            'name'=>['required','string','max:64','regex:/^[A-Za-z0-9 _-]+$/','unique:roles,name'],
            'permissions'=>['nullable','array'],
            'permissions.*'=>['string','exists:permissions,name'],
        ]);
        abort_if(strcasecmp($data['name'],'Super Admin')===0,403,'Only the protected built-in role can be Super Admin.');
        $names = $data['permissions'] ?? [];
        if (! $request->user()->hasRole('Super Admin')) foreach ($names as $name) abort_unless($request->user()->can($name),403,'You cannot grant permissions you do not have.');
        $role = Role::query()->create(['name'=>$data['name'],'guard_name'=>'web']);
        $role->syncPermissions(Permission::query()->whereIn('name',$names)->where('guard_name','web')->get());
        ActivityLogger::record('role.created',$role,'Created role');
        return redirect()->route('admin.roles.index')->with('success','Role created.');
    }

    public function update(Request $request, Role $role)
    {
        Gate::authorize('update', $role);
        abort_if($role->name === 'Super Admin', 403, 'The protected Super Admin role cannot be edited.');
        abort_if(! $request->user()->hasRole('Super Admin') && $request->user()->hasRole($role->name), 403, 'You cannot change a role assigned to your own account.');
        $data = $request->validate(['permissions'=>['nullable','array'],'permissions.*'=>['string','exists:permissions,name']]);
        $names = $data['permissions'] ?? [];
        if (! $request->user()->hasRole('Super Admin')) {
            foreach ($names as $name) abort_unless($request->user()->can($name), 403, 'You cannot grant permissions you do not have.');
            $preserved = $role->permissions->filter(fn ($permission) => ! $request->user()->can($permission->name))->pluck('name')->all();
            $names = array_values(array_unique([...$names, ...$preserved]));
        }
        $role->syncPermissions(Permission::query()->whereIn('name',$names)->where('guard_name','web')->get());
        ActivityLogger::record('role.updated', $role, 'Updated role permissions');
        return back()->with('success','Role permissions updated.');
    }

    public function destroy(Request $request, Role $role)
    {
        Gate::authorize('delete',$role);
        abort_if(in_array($role->name,['Super Admin','Admin','Manager','Employee'],true),403,'Built-in roles are protected.');
        abort_if(User::role($role->name)->exists(),422,'Remove this role from its users before deleting it.');
        $role->delete();
        ActivityLogger::record('role.deleted',$role,'Deleted role');
        return back()->with('success','Role deleted.');
    }
}

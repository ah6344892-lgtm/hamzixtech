<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', User::class);
        $query = User::query()->with('roles')->orderBy('name');
        if ($request->filled('q')) $query->where(fn ($q) => $q->where('name','like','%'.$request->string('q').'%')->orWhere('email','like','%'.$request->string('q').'%'));
        return view('admin.users.index', ['users' => $query->paginate(20)->withQueryString()]);
    }

    public function create(Request $request)
    {
        Gate::authorize('create', User::class);
        $this->authorizeRoleAssignment($request->user());
        return view('admin.users.form', ['user' => new User(), 'roles' => $this->assignableRoles($request->user())]);
    }

    public function store(Request $request)
    {
        Gate::authorize('create', User::class);
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:190','unique:users,email'],
            'password' => ['required','string','min:12','confirmed'],
            'is_active' => ['nullable','boolean'],
            'roles' => ['nullable','array'],
            'roles.*' => ['integer','exists:roles,id'],
        ]);
        $user = User::query()->create(['name'=>$data['name'],'email'=>strtolower($data['email']),'password'=>Hash::make($data['password']),'is_active'=>$request->has('is_active') ? $request->boolean('is_active') : true]);
        if ($request->has('roles')) $user->syncRoles($this->validatedRoles($request, $data['roles'] ?? []));
        ActivityLogger::record('user.created', $user, 'Created staff account');
        return redirect()->route('admin.users.index')->with('success', 'Staff account created.');
    }

    public function edit(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        return view('admin.users.form', ['user' => $user->load('roles'), 'roles' => $this->assignableRoles($request->user())]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('update', $user);
        $data = $request->validate([
            'name' => ['required','string','max:120'],
            'email' => ['required','email','max:190',Rule::unique('users','email')->ignore($user->id)],
            'password' => ['nullable','string','min:12','confirmed'],
            'is_active' => ['nullable','boolean'],
            'roles' => ['nullable','array'],
            'roles.*' => ['integer','exists:roles,id'],
        ]);
        $active = $request->has('is_active') ? $request->boolean('is_active') : $user->is_active;
        if ($user->is_active && ! $active) Gate::authorize('deactivate', $user);
        if ($request->has('roles') && $user->hasRole('Super Admin') && ! in_array('Super Admin', Role::query()->whereIn('id',$data['roles'] ?? [])->pluck('name')->all(), true)) {
            abort_unless($request->user()->hasRole('Super Admin') && User::role('Super Admin')->where('is_active',true)->count() > 1, 403, 'The last active Super Admin cannot lose this role.');
        }
        $user->name = $data['name'];
        $user->email = strtolower($data['email']);
        $user->is_active = $active;
        if (filled($data['password'] ?? null)) $user->password = Hash::make($data['password']);
        $user->save();
        if ($request->has('roles')) $user->syncRoles($this->validatedRoles($request, $data['roles'] ?? []));
        ActivityLogger::record('user.updated', $user, 'Updated staff account');
        return redirect()->route('admin.users.index')->with('success', 'Staff account updated.');
    }

    public function destroy(User $user)
    {
        Gate::authorize('delete', $user);
        ActivityLogger::record('user.deleted', $user, 'Deleted staff account');
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Staff account deleted.');
    }

    private function authorizeRoleAssignment(User $actor): void
    {
        abort_unless($actor->hasRole('Super Admin') || $actor->can('assign user roles'), 403);
    }

    private function assignableRoles(User $actor)
    {
        $this->authorizeRoleAssignment($actor);
        return Role::query()->when(! $actor->hasRole('Super Admin'), fn ($q) => $q->where('name','<>','Super Admin'))->with('permissions')->orderBy('name')->get()->filter(fn ($role) => $actor->hasRole('Super Admin') || $role->permissions->every(fn ($permission) => $actor->can($permission->name)));
    }

    private function validatedRoles(Request $request, array $ids): array
    {
        $actor = $request->user();
        $this->authorizeRoleAssignment($actor);
        $roles = Role::query()->with('permissions')->whereIn('id',$ids)->get();
        if (! $actor->hasRole('Super Admin')) {
            abort_if($roles->contains(fn ($role) => $role->name === 'Super Admin'), 403, 'Only Super Admin can assign that role.');
            $roles->each(function ($role) use ($actor): void {
                abort_unless($role->permissions->every(fn ($permission) => $actor->can($permission->name)), 403, 'You cannot grant permissions you do not have.');
            });
        }
        return $roles->all();
    }
}

<?php

namespace Tests\Feature;

use App\Livewire\Admin\DashboardOverview;
use App\Models\Tag;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_management_routes_require_authentication_and_permissions(): void
    {
        $this->get('/admin')->assertRedirect('/login');

        $employee = User::factory()->create();
        $employee->assignRole(Role::findByName('Employee','web'));
        $this->actingAs($employee)->get('/admin/posts')->assertOk();
        $this->actingAs($employee)->get('/admin/settings')->assertForbidden();
        $this->actingAs($employee)->post('/admin/posts', [
            'title'=>'Unauthorized post','content'=>'Not permitted.','status'=>'draft',
        ])->assertForbidden();
    }

    public function test_last_active_super_admin_cannot_be_deactivated_or_demoted(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin','web'));
        $employeeRole = Role::findByName('Employee','web');

        $this->actingAs($superAdmin)->put('/admin/users/'.$superAdmin->id, [
            'name'=>$superAdmin->name,
            'email'=>$superAdmin->email,
            'is_active'=>'0',
            'roles'=>[$employeeRole->id],
        ])->assertForbidden();

        $this->assertTrue($superAdmin->fresh()->is_active);
        $this->assertTrue($superAdmin->fresh()->hasRole('Super Admin'));
    }

    public function test_roles_cannot_grant_permissions_the_actor_does_not_have(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole(Role::findByName('Admin','web'));
        $role = Role::findByName('Manager','web');
        $admin->givePermissionTo('manage roles');

        $this->actingAs($admin)->put('/admin/roles/'.$role->id, [
            'permissions'=>['manage permissions'],
        ])->assertForbidden();
    }

    public function test_super_admin_can_create_a_draft_and_open_management_pages(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin','web'));

        $this->actingAs($superAdmin)->get('/admin')
            ->assertOk()
            ->assertSee('wire:id', false)
            ->assertSee('class="admin-sidebar-link admin-sidebar-link-active"', false)
            ->assertSee('x-on:click="sidebarOpen = true"', false)
            ->assertSee('data-flux-button', false)
            ->assertDontSee('@livewireStyles')
            ->assertDontSee('@fluxScripts');

        $this->actingAs($superAdmin)->get('/admin/roles')->assertOk();
        config()->set('hamzixtech.ui_mode', 'livewire');
        $this->actingAs($superAdmin)->get('/admin/posts/create')
            ->assertOk()
            ->assertSee('wire:model.live.debounce.300ms="value"', false);
        $this->actingAs($superAdmin)->post('/admin/posts', [
            'title'=>'First editorial note',
            'slug'=>'',
            'excerpt'=>'A short draft summary.',
            'content'=>'## Working draft'."\n\n".'This content is saved as a draft.',
            'status'=>'draft',
        ])->assertRedirect(route('admin.posts.index'));

        $this->assertDatabaseHas('posts', [
            'slug'=>'first-editorial-note',
            'status'=>'draft',
            'author_id'=>$superAdmin->id,
        ]);
    }

    public function test_dashboard_livewire_component_refreshes_and_rechecks_access(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin', 'web'));

        Livewire::actingAs($superAdmin)
            ->test(DashboardOverview::class)
            ->assertSee('Recent activity')
            ->call('refreshDashboard')
            ->assertHasNoErrors();

        $unauthorizedUser = User::factory()->create();

        Livewire::actingAs($unauthorizedUser)
            ->test(DashboardOverview::class)
            ->assertStatus(403);
    }

    public function test_super_admin_can_edit_and_delete_content_records(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin', 'web'));
        $tag = Tag::query()->create(['name' => 'Old label', 'slug' => 'old-label']);

        $this->actingAs($superAdmin)
            ->get(route('admin.tags.edit', $tag->id))
            ->assertOk()
            ->assertSee('Edit item');

        $this->put(route('admin.tags.update', $tag->id), [
            'name' => 'Updated label',
            'slug' => 'updated-label',
        ])->assertRedirect(route('admin.tags.index'));

        $this->assertDatabaseHas('tags', ['id' => $tag->id, 'name' => 'Updated label']);

        $this->delete(route('admin.tags.destroy', $tag->id))
            ->assertRedirect(route('admin.tags.index'));

        $this->assertDatabaseMissing('tags', ['id' => $tag->id]);
    }

    public function test_staff_accounts_can_be_deleted_but_not_by_themselves(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin', 'web'));
        $staffMember = User::factory()->create();
        $staffMember->assignRole(Role::findByName('Employee', 'web'));

        $this->actingAs($superAdmin)
            ->get(route('admin.users.index'))
            ->assertOk()
            ->assertSee(route('admin.users.destroy', $staffMember));

        $this->delete(route('admin.users.destroy', $staffMember))
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseMissing('users', ['id' => $staffMember->id]);
        $this->delete(route('admin.users.destroy', $superAdmin))->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $superAdmin->id]);
    }

    public function test_only_super_admins_can_delete_super_admin_accounts_and_one_must_remain(): void
    {
        $administrator = User::factory()->create();
        $administrator->assignRole(Role::findByName('Admin', 'web'));
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin', 'web'));
        $anotherSuperAdmin = User::factory()->create();
        $anotherSuperAdmin->assignRole(Role::findByName('Super Admin', 'web'));

        $this->actingAs($administrator)
            ->delete(route('admin.users.destroy', $superAdmin))
            ->assertForbidden();

        $this->actingAs($superAdmin)
            ->delete(route('admin.users.destroy', $anotherSuperAdmin))
            ->assertRedirect(route('admin.users.index'));

        $this->assertDatabaseHas('users', ['id' => $superAdmin->id]);
        $this->assertDatabaseMissing('users', ['id' => $anotherSuperAdmin->id]);
    }

    public function test_unused_custom_roles_can_be_deleted_from_the_roles_page(): void
    {
        $superAdmin = User::factory()->create();
        $superAdmin->assignRole(Role::findByName('Super Admin', 'web'));
        $role = Role::query()->create(['name' => 'Custom Editor', 'guard_name' => 'web']);

        $this->actingAs($superAdmin)
            ->get(route('admin.roles.index'))
            ->assertOk()
            ->assertSee('form="delete-role-'.$role->id.'"', false);

        $this->delete(route('admin.roles.destroy', $role))
            ->assertRedirect(route('admin.roles.index'));

        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }
}

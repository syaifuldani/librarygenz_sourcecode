<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminUserManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $librarian;
    protected User $member;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed initial data (roles, users) using the project's DatabaseSeeder
        $this->seed(\Database\Seeders\DatabaseSeeder::class);

        $this->admin     = User::where('email', 'admin@librarygenz.com')->first();
        $this->librarian = User::where('email', 'librarian@librarygenz.com')->first();
        $this->member    = User::where('email', 'member@librarygenz.com')->first();
    }

    // -------------------------------------------------------------------------
    // Access Control
    // -------------------------------------------------------------------------

    public function test_admin_can_access_user_management_index(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));
        $response->assertOk();
    }

    public function test_librarian_cannot_access_user_management_index(): void
    {
        $response = $this->actingAs($this->librarian)->get(route('admin.users.index'));
        $response->assertForbidden();
    }

    public function test_member_cannot_access_user_management_index(): void
    {
        $response = $this->actingAs($this->member)->get(route('admin.users.index'));
        $response->assertForbidden();
    }

    public function test_guest_is_redirected_from_user_management(): void
    {
        $response = $this->get(route('admin.users.index'));
        $response->assertRedirect(route('login'));
    }

    // -------------------------------------------------------------------------
    // Index with Filters
    // -------------------------------------------------------------------------

    public function test_admin_can_filter_users_by_role(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['role' => 'member']));
        $response->assertOk();
        // Member should be visible in member-filtered results
        $response->assertSee($this->member->name);
    }


    public function test_admin_can_search_users_by_name(): void
    {
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['search' => $this->member->name]));
        $response->assertOk();
        $response->assertSee($this->member->name);
    }

    public function test_admin_can_filter_users_by_status(): void
    {
        $this->member->update(['status' => 'inactive']);
        $response = $this->actingAs($this->admin)
            ->get(route('admin.users.index', ['status' => 'inactive']));
        $response->assertOk();
        // The inactive member should appear in results
        $response->assertSee($this->member->name);
    }

    // -------------------------------------------------------------------------
    // Create User
    // -------------------------------------------------------------------------

    public function test_admin_can_view_create_user_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.create'));
        $response->assertOk();
        $response->assertSee('Buat Akun');
    }

    public function test_admin_can_create_new_user(): void
    {
        $memberRole = Role::where('name', 'member')->first();

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name'     => 'Test Baru',
            'email'    => 'testbaru@example.com',
            'password' => 'Password1',
            'role_id'  => $memberRole->id,
            'status'   => 'active',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', [
            'email'  => 'testbaru@example.com',
            'status' => 'active',
        ]);
    }

    public function test_create_user_fails_with_duplicate_email(): void
    {
        $memberRole = Role::where('name', 'member')->first();

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name'     => 'Duplicate',
            'email'    => $this->member->email, // already taken
            'password' => 'Password1',
            'role_id'  => $memberRole->id,
            'status'   => 'active',
        ]);

        $response->assertSessionHasErrors('email');
    }

    public function test_create_user_fails_with_weak_password(): void
    {
        $memberRole = Role::where('name', 'member')->first();

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), [
            'name'     => 'Weak Pass User',
            'email'    => 'weak@example.com',
            'password' => '123',
            'role_id'  => $memberRole->id,
            'status'   => 'active',
        ]);

        $response->assertSessionHasErrors('password');
    }

    // -------------------------------------------------------------------------
    // Edit User
    // -------------------------------------------------------------------------

    public function test_admin_can_view_edit_user_form(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.users.edit', $this->member));
        $response->assertOk();
        $response->assertSee($this->member->name);
    }

    public function test_admin_can_update_user_name_and_email(): void
    {
        $memberRole = Role::where('name', 'member')->first();

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $this->member), [
            'name'    => 'Nama Diperbarui',
            'email'   => 'updated@example.com',
            'role_id' => $memberRole->id,
            'status'  => 'active',
        ]);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'updated@example.com', 'name' => 'Nama Diperbarui']);
    }

    public function test_admin_cannot_deactivate_their_own_account(): void
    {
        $adminRole = Role::where('name', 'admin')->first();

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $this->admin), [
            'name'    => $this->admin->name,
            'email'   => $this->admin->email,
            'role_id' => $adminRole->id,
            'status'  => 'inactive',
        ]);

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'status' => 'active']);
    }

    // -------------------------------------------------------------------------
    // Toggle Status
    // -------------------------------------------------------------------------

    public function test_admin_can_toggle_user_status_to_inactive(): void
    {
        $this->assertEquals('active', $this->member->status);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.toggleStatus', $this->member));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->member->id, 'status' => 'inactive']);
    }

    public function test_admin_can_toggle_user_status_back_to_active(): void
    {
        $this->member->update(['status' => 'inactive']);

        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.toggleStatus', $this->member));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $this->member->id, 'status' => 'active']);
    }

    public function test_admin_cannot_toggle_their_own_status(): void
    {
        $response = $this->actingAs($this->admin)
            ->post(route('admin.users.toggleStatus', $this->admin));

        $response->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $this->admin->id, 'status' => 'active']);
    }

    // -------------------------------------------------------------------------
    // Reset Password
    // -------------------------------------------------------------------------

    public function test_admin_can_reset_user_password(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.resetPassword', $this->member), [
            'new_password'              => 'NewPass99',
            'new_password_confirmation' => 'NewPass99',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $this->member->refresh();
        $this->assertTrue(Hash::check('NewPass99', $this->member->password));
    }

    public function test_reset_password_fails_if_confirmation_mismatch(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.users.resetPassword', $this->member), [
            'new_password'              => 'NewPass99',
            'new_password_confirmation' => 'WrongPass99',
        ]);

        $response->assertSessionHasErrors('new_password');
    }
}

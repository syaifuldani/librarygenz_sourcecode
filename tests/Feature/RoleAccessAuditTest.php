<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

beforeEach(function () {
    // Seed roles and initial data
    $this->seed(\Database\Seeders\DatabaseSeeder::class);
    
    // Retrieve seeded accounts
    $this->admin = User::where('email', 'admin@librarygenz.com')->first();
    $this->librarian = User::where('email', 'librarian@librarygenz.com')->first();
    $this->member = User::where('email', 'member@librarygenz.com')->first();
});

test('member is forbidden from accessing system management, user list, activity logs, and settings', function () {
    // 1. Users list
    $this->actingAs($this->member)->get(route('users.index'))->assertStatus(403);
    
    // 2. User delete action
    $this->actingAs($this->member)->delete(route('users.destroy', $this->librarian))->assertStatus(403);

    // 3. System settings
    $this->actingAs($this->member)->get(route('admin.settings'))->assertStatus(403);

    // 4. Activity logs
    $this->actingAs($this->member)->get(route('admin.activity-logs'))->assertStatus(403);
});

test('librarian can access user listing but is forbidden from system settings, logs, and deleting users', function () {
    // 1. User listing (Librarian allowed to view)
    $this->actingAs($this->librarian)->get(route('users.index'))->assertStatus(200);

    // 2. User delete action (Librarian forbidden)
    $this->actingAs($this->librarian)->delete(route('users.destroy', $this->member))->assertStatus(403);

    // 3. System settings (Librarian forbidden)
    $this->actingAs($this->librarian)->get(route('admin.settings'))->assertStatus(403);

    // 4. Activity logs (Librarian forbidden)
    $this->actingAs($this->librarian)->get(route('admin.activity-logs'))->assertStatus(403);
});

test('admin has full access to user list, deleting users, settings, and logs', function () {
    // 1. User listing
    $this->actingAs($this->admin)->get(route('users.index'))->assertStatus(200);

    // 2. System settings
    $this->actingAs($this->admin)->get(route('admin.settings'))->assertStatus(200);

    // 3. Activity logs
    $this->actingAs($this->admin)->get(route('admin.activity-logs'))->assertStatus(200);

    // 4. User delete action
    $tempUser = User::factory()->create(['role_id' => 3]);
    $response = $this->actingAs($this->admin)->delete(route('users.destroy', $tempUser));
    $response->assertRedirect();
    $this->assertDatabaseMissing('users', ['id' => $tempUser->id]);
});

test('member can load profile and settings pages', function () {
    // 1. Profil Saya (profile.edit)
    $this->actingAs($this->member)->get(route('profile.edit'))->assertStatus(200)->assertSee('Profil Saya');

    // 2. Pengaturan Akun (profile.settings)
    $this->actingAs($this->member)->get(route('profile.settings'))->assertStatus(200)->assertSee('Pengaturan Akun');
});

test('member can edit profile information', function () {
    $response = $this->actingAs($this->member)->patch(route('profile.update'), [
        'name' => 'Rian Permana Updated',
        'email' => 'rian.updated@librarygenz.com',
    ]);

    $response->assertRedirect(route('profile.edit'));
    $response->assertSessionHas('status', 'profile-updated');

    $this->assertDatabaseHas('users', [
        'id' => $this->member->id,
        'name' => 'Rian Permana Updated',
        'email' => 'rian.updated@librarygenz.com',
    ]);
});

test('member can change password in settings', function () {
    $response = $this->actingAs($this->member)->put(route('password.update'), [
        'current_password' => 'password',
        'password' => 'newpassword123',
        'password_confirmation' => 'newpassword123',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status', 'password-updated');

    // Re-retrieve member and check password
    $this->member->refresh();
    $this->assertTrue(Hash::check('newpassword123', $this->member->password));
});

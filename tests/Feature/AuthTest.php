<?php

use App\Models\User;

it('allows a visitor to register as a regular user', function () {
    $response = $this->post(route('register.store'), [
        'name' => 'Siswa Baru',
        'email' => 'siswa@example.test',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('home'));
    $this->assertAuthenticated();

    $user = User::where('email', 'siswa@example.test')->firstOrFail();
    expect($user->role)->toBe('user')
        ->and($user->status)->toBe('active');
});

it('authenticates an admin and redirects to the dashboard', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'admin@example.test',
        'username' => 'admin',
        'password' => 'password123',
    ]);

    $response = $this->post(route('login.store'), [
        'username' => $admin->username,
        'password' => 'password123',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

it('rejects invalid credentials', function () {
    $response = $this->post(route('login.store'), [
        'username' => 'tidakada',
        'password' => 'salahpassword',
    ]);

    $response->assertSessionHasErrors('username');
    $this->assertGuest();
});

it('logs out an authenticated user', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->post(route('logout'))
        ->assertRedirect(route('home'));

    $this->assertGuest();
});

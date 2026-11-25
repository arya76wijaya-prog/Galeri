<?php

use App\Models\Comment;
use App\Models\SchoolLocation;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('lets a user update their profile and avatar', function () {
    $user = User::factory()->create(['name' => 'Nama Lama']);

    $this->actingAs($user)
        ->put(route('profile.update'), [
            'name' => 'Nama Baru',
            'email' => $user->email,
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ])
        ->assertRedirect();

    $user->refresh();

    expect($user->name)->toBe('Nama Baru')
        ->and($user->avatar)->not->toBeNull();

    Storage::disk('public')->assertExists($user->avatar);
});

it('prevents an admin from changing their own role or status', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->patch(route('admin.users.update', $admin), [
            'name' => $admin->name,
            'email' => $admin->email,
            'role' => 'user',
            'status' => 'inactive',
        ])
        ->assertRedirect(route('admin.users.index'));

    $admin->refresh();

    expect($admin->role)->toBe('admin')
        ->and($admin->status)->toBe('active');
});

it('lets an admin create and update a school location', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.school-locations.store'), [
            'name' => 'Gedung Baru',
            'description' => 'Ruang kelas baru.',
            'latitude' => -6.21,
            'longitude' => 106.84,
            'status' => 'active',
            'image' => UploadedFile::fake()->image('gedung.jpg'),
        ])
        ->assertRedirect(route('admin.school-locations.index'));

    $location = SchoolLocation::where('name', 'Gedung Baru')->firstOrFail();

    expect($location->image_path)->not->toBeNull();
    Storage::disk('public')->assertExists($location->image_path);

    $this->actingAs($admin)
        ->patch(route('admin.school-locations.update', $location), [
            'name' => 'Gedung Baru',
            'latitude' => 200,
            'longitude' => 106.84,
            'status' => 'active',
        ])
        ->assertSessionHasErrors('latitude');
});

it('lets a user delete their own comment', function () {
    $user = User::factory()->create();
    $comment = Comment::factory()->create(['user_id' => $user->id]);

    $this->actingAs($user)
        ->delete(route('comments.destroy', $comment))
        ->assertRedirect();

    expect(Comment::count())->toBe(0);
});

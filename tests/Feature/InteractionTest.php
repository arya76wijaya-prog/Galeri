<?php

use App\Models\Comment;
use App\Models\Like;
use App\Models\Photo;
use App\Models\Report;
use App\Models\User;

it('lets an authenticated user like and unlike a photo', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();

    $this->actingAs($user)
        ->postJson(route('photos.like', $photo))
        ->assertOk()
        ->assertJson(['liked' => true, 'likesCount' => 1]);

    expect(Like::where('user_id', $user->id)->where('photo_id', $photo->id)->count())->toBe(1);

    $this->actingAs($user)
        ->deleteJson(route('photos.unlike', $photo))
        ->assertOk()
        ->assertJson(['liked' => false, 'likesCount' => 0]);

    expect(Like::count())->toBe(0);
});

it('does not create duplicate likes', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();

    $this->actingAs($user)->postJson(route('photos.like', $photo))->assertOk();
    $this->actingAs($user)->postJson(route('photos.like', $photo))->assertOk();

    expect(Like::count())->toBe(1);
});

it('requires authentication to like a photo', function () {
    $photo = Photo::factory()->create();

    $this->postJson(route('photos.like', $photo))->assertRedirect(route('login'));
});

it('stores comments as pending for moderator approval', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();

    $this->actingAs($user)
        ->post(route('comments.store', $photo), ['content' => 'Komentar dari siswa'])
        ->assertRedirect();

    expect(Comment::first()->status)->toBe('pending');
});

it('lets an admin approve a pending comment', function () {
    $admin = User::factory()->admin()->create();
    $comment = Comment::factory()->pending()->create();

    $this->actingAs($admin)
        ->patch(route('admin.comments.approve', $comment))
        ->assertRedirect();

    expect($comment->fresh()->status)->toBe('approved');
});

it('stores a photo report and prevents duplicates', function () {
    $user = User::factory()->create();
    $photo = Photo::factory()->create();
    $payload = ['reason' => 'blurry', 'description' => 'Foto kurang jelas.'];

    $this->actingAs($user)
        ->post(route('reports.store', $photo), $payload)
        ->assertRedirect();

    expect(Report::count())->toBe(1);

    $this->actingAs($user)
        ->post(route('reports.store', $photo), $payload)
        ->assertSessionHas('error');

    expect(Report::count())->toBe(1);
});


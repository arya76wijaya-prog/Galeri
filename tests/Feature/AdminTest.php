<?php

use App\Models\Album;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    Storage::fake('public');
});

it('denies non-admin users access to the admin dashboard', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});

it('redirects guests away from the admin dashboard', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

it('lets an admin create an album with a cover', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->post(route('admin.albums.store'), [
            'title' => 'Album Uji Coba',
            'description' => 'Deskripsi album.',
            'category' => 'Kegiatan',
            'status' => 'published',
            'event_date' => '2026-11-20',
            'cover_photo' => UploadedFile::fake()->image('cover.jpg'),
        ])
        ->assertRedirect(route('admin.albums.index'));

    $album = Album::where('title', 'Album Uji Coba')->firstOrFail();

    expect($album->status)->toBe('published')
        ->and($album->published_at)->not->toBeNull()
        ->and($album->cover_photo)->not->toBeNull();

    Storage::disk('public')->assertExists($album->cover_photo);
});

it('lets an admin upload multiple photos at once', function () {
    $admin = User::factory()->admin()->create();
    $album = Album::factory()->create();

    $this->actingAs($admin)
        ->post(route('admin.photos.bulk-store'), [
            'album_id' => $album->id,
            'caption' => 'Foto kegiatan',
            'photos' => [
                UploadedFile::fake()->image('satu.jpg'),
                UploadedFile::fake()->image('dua.jpg'),
            ],
        ])
        ->assertRedirect();

    expect(Photo::where('album_id', $album->id)->count())->toBe(2);
});

it('lets an admin resolve a report', function () {
    $admin = User::factory()->admin()->create();
    $report = Report::factory()->create();

    $this->actingAs($admin)
        ->patch(route('admin.reports.update', $report), ['status' => 'resolved'])
        ->assertRedirect(route('admin.reports.index'));

    expect($report->fresh()->status)->toBe('resolved')
        ->and($report->fresh()->reviewed_by)->toBe($admin->id)
        ->and($report->fresh()->reviewed_at)->not->toBeNull();
});

it('deletes the image file when an admin deletes a photo', function () {
    $admin = User::factory()->admin()->create();
    $photo = Photo::factory()->create(['image_path' => 'photos/hapus.jpg']);
    Storage::disk('public')->put('photos/hapus.jpg', 'dummy');

    $this->actingAs($admin)
        ->delete(route('admin.photos.destroy', $photo))
        ->assertRedirect();

    Storage::disk('public')->assertMissing('photos/hapus.jpg');
    expect(Photo::count())->toBe(0);
});

it('prevents a non-admin from approving comments', function () {
    $comment = Comment::factory()->pending()->create();

    $this->actingAs(User::factory()->create())
        ->patch(route('admin.comments.approve', $comment))
        ->assertForbidden();

    expect($comment->fresh()->status)->toBe('pending');
});

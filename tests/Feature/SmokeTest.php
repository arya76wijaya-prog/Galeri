<?php

use App\Models\Album;
use App\Models\Comment;
use App\Models\Photo;
use App\Models\Report;
use App\Models\SchoolLocation;
use App\Models\User;

it('renders all public pages', function () {
    $album = Album::factory()->create(['status' => 'published']);
    Photo::factory()->create(['album_id' => $album->id]);

    foreach (['/', '/about', '/gallery', '/login', '/register'] as $path) {
        $this->get($path)
            ->assertOk()
            ->assertSee('Galeri Sekolah');
    }

    $this->get(route('gallery.show', $album))
        ->assertOk()
        ->assertSee($album->title);

    $this->actingAs(User::factory()->create())
        ->get(route('profile.index'))
        ->assertOk()
        ->assertSee('Profil Saya');

    $this->actingAs(User::factory()->admin()->create())
        ->get(route('profile.index'))
        ->assertOk()
        ->assertSee('Profil Saya');
});

it('renders all admin pages', function () {
    $admin = User::factory()->admin()->create();
    $album = Album::factory()->create();
    $photo = Photo::factory()->create(['album_id' => $album->id]);
    $comment = Comment::factory()->create(['photo_id' => $photo->id]);
    $report = Report::factory()->create(['photo_id' => $photo->id]);
    $user = User::factory()->create();
    $location = SchoolLocation::factory()->create();

    $routes = [
        'admin.dashboard',
        'admin.albums.index',
        'admin.albums.create',
        'admin.albums.edit',
        'admin.photos.index',
        'admin.photos.create',
        'admin.photos.edit',
        'admin.comments.index',
        'admin.reports.index',
        'admin.reports.show',
        'admin.users.index',
        'admin.users.create',
        'admin.users.edit',
        'admin.school-locations.index',
        'admin.school-locations.create',
        'admin.school-locations.edit',
        'admin.settings.index',
    ];

    $parameters = [
        'admin.albums.edit' => $album,
        'admin.photos.edit' => $photo,
        'admin.reports.show' => $report,
        'admin.users.edit' => $user,
        'admin.school-locations.edit' => $location,
    ];

    foreach ($routes as $route) {
        $response = $this->actingAs($admin)
            ->get(route($route, $parameters[$route] ?? []))
            ->assertOk();

        expect($response->getContent())->not->toBeEmpty();

        $response->assertSee('Panel Administrator');
    }

    expect($comment)->not->toBeNull();
});

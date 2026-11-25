<?php

use App\Models\Album;

it('only lists published albums on the gallery page', function () {
    $published = Album::factory()->create([
        'title' => 'Album Publik',
        'status' => 'published',
    ]);
    $draft = Album::factory()->draft()->create(['title' => 'Album Draf']);

    $this->get(route('gallery.index'))
        ->assertOk()
        ->assertSee($published->title)
        ->assertDontSee($draft->title);
});

it('filters albums by search term and category', function () {
    Album::factory()->create([
        'title' => 'Kegiatan Pramuka',
        'category' => 'Ekstrakurikuler',
        'status' => 'published',
    ]);
    Album::factory()->create([
        'title' => 'Fasilitas Sekolah',
        'category' => 'Fasilitas',
        'status' => 'published',
    ]);

    $this->get(route('gallery.index', ['q' => 'Pramuka']))
        ->assertOk()
        ->assertSee('Kegiatan Pramuka')
        ->assertDontSee('Fasilitas Sekolah');

    $this->get(route('gallery.index', ['category' => 'Fasilitas']))
        ->assertOk()
        ->assertSee('Fasilitas Sekolah')
        ->assertDontSee('Kegiatan Pramuka');
});

it('does not expose a draft album detail page', function () {
    $album = Album::factory()->draft()->create();

    $this->get(route('gallery.show', $album))->assertNotFound();
});

it('shows a published album detail page', function () {
    $album = Album::factory()->create(['status' => 'published']);

    $this->get(route('gallery.show', $album))
        ->assertOk()
        ->assertSee($album->title);
});

<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Photo;
use App\Models\Report;
use App\Models\SchoolLocation;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class SampleContentSeeder extends Seeder
{
    private int $photoNumber = 1;

    public function run(): void
    {
        $admin = User::where('email', 'admin@galeri.test')->firstOrFail();
        $user = User::where('email', 'user@galeri.test')->firstOrFail();

        $albums = [
            [
                'title' => 'Hari Kemerdekaan 2026',
                'category' => 'Kegiatan',
                'description' => 'Dokumentasi perayaan Hari Kemerdekaan Republik Indonesia di sekolah, mulai dari upacara bendera hingga lomba antar kelas.',
                'event_date' => '2026-08-17',
                'status' => 'published',
                'captions' => ['Upacara bendera', 'Lomba tarik tambang', 'Pawai kreatif kelas', 'Penutupan acara'],
            ],
            [
                'title' => 'Ekstrakurikuler Pramuka',
                'category' => 'Ekstrakurikuler',
                'description' => 'Aktivitas latihan dasar kepemimpinan dan kegiatan berkemah siswa Pramuka sekolah.',
                'event_date' => '2026-09-05',
                'status' => 'published',
                'captions' => ['Latihan baris berbaris', 'Pemasangan tenda', 'Api unggun', 'Foto bersama'],
            ],
            [
                'title' => 'Fasilitas Sekolah',
                'category' => 'Fasilitas',
                'description' => 'Potret fasilitas pembelajaran yang tersedia untuk mendukung kegiatan belajar mengajar.',
                'event_date' => '2026-07-12',
                'status' => 'published',
                'captions' => ['Perpustakaan', 'Laboratorium komputer', 'Ruang kelas', 'Lapangan olahraga'],
            ],
            [
                'title' => 'Lomba Sains 2026',
                'category' => 'Prestasi',
                'description' => 'Album persiapan lomba sains tingkat kabupaten yang akan dirilis setelah pengumuman hasil.',
                'event_date' => '2026-11-28',
                'status' => 'draft',
                'captions' => ['Persiapan tim', 'Sesi pelatihan'],
            ],
        ];

        $createdPhotos = [];

        foreach ($albums as $data) {
            $album = Album::firstOrCreate(
                ['title' => $data['title']],
                [
                    'description' => $data['description'],
                    'category' => $data['category'],
                    'created_by' => $admin->id,
                    'status' => $data['status'],
                    'event_date' => $data['event_date'],
                    'published_at' => $data['status'] === 'published' ? now() : null,
                ]
            );

            if (! $album->cover_photo) {
                $album->cover_photo = $this->createPlaceholder(
                    "albums/album-{$album->id}/cover.svg",
                    $data['title']
                );
                $album->save();
            }

            if ($album->photos()->exists()) {
                $createdPhotos[] = $album->photos()->first();

                continue;
            }

            foreach ($data['captions'] as $caption) {
                $photo = Photo::create([
                    'album_id' => $album->id,
                    'image_path' => $this->createPlaceholder(
                        'photos/sample-'.$this->photoNumber.'.svg',
                        $caption
                    ),
                    'caption' => $caption,
                    'uploaded_by' => $admin->id,
                ]);

                $createdPhotos[] = $photo;
            }
        }

        if ($createdPhotos !== []) {
            Like::firstOrCreate([
                'user_id' => $user->id,
                'photo_id' => $createdPhotos[0]->id,
            ]);
            Like::firstOrCreate([
                'user_id' => $user->id,
                'photo_id' => $createdPhotos[1]->id ?? $createdPhotos[0]->id,
            ]);

            Comment::firstOrCreate([
                'user_id' => $user->id,
                'photo_id' => $createdPhotos[0]->id,
                'content' => 'Fotonya bagus sekali, terima kasih sudah didokumentasikan!',
            ], ['status' => 'approved']);

            Comment::firstOrCreate([
                'user_id' => $user->id,
                'photo_id' => $createdPhotos[1]->id ?? $createdPhotos[0]->id,
                'content' => 'Boleh ditambah foto dari sudut lain?',
            ], ['status' => 'pending']);

            Report::firstOrCreate([
                'user_id' => $user->id,
                'photo_id' => $createdPhotos[2]->id ?? $createdPhotos[0]->id,
                'reason' => 'blurry',
            ], [
                'description' => 'Beberapa foto terlihat agak buram.',
                'status' => 'pending',
            ]);
        }

        $locations = [
            ['Gedung A', 'Ruang kelas dan kantor guru.', -6.20890, 106.84520],
            ['Perpustakaan', 'Koleksi buku dan ruang baca siswa.', -6.20930, 106.84580],
            ['Laboratorium Komputer', 'Fasilitas praktik komputer dan jaringan.', -6.20840, 106.84610],
            ['Lapangan Olahraga', 'Area upacara dan kegiatan olahraga.', -6.20900, 106.84650],
            ['Kantin Sekolah', 'Area makan siswa dan guru.', -6.20820, 106.84550],
        ];

        foreach ($locations as [$name, $description, $latitude, $longitude]) {
            $location = SchoolLocation::firstOrCreate(
                ['name' => $name],
                [
                    'description' => $description,
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'status' => 'active',
                ]
            );

            if (! $location->image_path) {
                $location->image_path = $this->createPlaceholder(
                    'locations/'.strtolower(str_replace(' ', '-', $name)).'.svg',
                    $name
                );
                $location->save();
            }
        }
    }

    private function createPlaceholder(string $path, string $label): string
    {
        $safeLabel = htmlspecialchars($label, ENT_QUOTES, 'UTF-8');
        $svg = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="800" viewBox="0 0 1200 800">
  <defs><linearGradient id="g" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#0f766e"/><stop offset="1" stop-color="#134e4a"/></linearGradient></defs>
  <rect width="1200" height="800" fill="url(#g)"/>
  <circle cx="170" cy="150" r="260" fill="#ffffff" opacity="0.06"/>
  <circle cx="1050" cy="700" r="320" fill="#ffffff" opacity="0.05"/>
  <text x="600" y="380" text-anchor="middle" fill="#99f6e4" font-family="sans-serif" font-size="34">GALERI SEKOLAH</text>
  <text x="600" y="450" text-anchor="middle" fill="#ffffff" font-family="sans-serif" font-size="58" font-weight="bold">{$safeLabel}</text>
  <text x="600" y="510" text-anchor="middle" fill="#5eead4" font-family="sans-serif" font-size="26">Dokumentasi kegiatan sekolah</text>
</svg>
SVG;

        Storage::disk('public')->put($path, $svg);

        return $path;
    }
}

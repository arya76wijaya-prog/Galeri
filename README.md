# Galeri Sekolah

Website galeri sekolah berbasis **Laravel 13 + Blade + Tailwind CSS 4 + Vanilla JavaScript**, dengan **SQLite** untuk pengembangan lokal dan dukungan **MySQL** untuk produksi. Fitur utama: album & foto, upload banyak foto, like, komentar dengan moderasi, laporan foto, manajemen pengguna, profil, serta peta sekolah interaktif berbasis Leaflet.js dan OpenStreetMap.

## Kebutuhan

- PHP 8.3+ (ekstensi `pdo_mysql`, `pdo_sqlite`, `gd`, `fileinfo`)
- Composer
- Node.js 20+ dan npm
- MySQL 8 / MariaDB untuk produksi (SQLite sudah tersedia untuk lokal)
- Web server (Apache/Nginx), **Laravel Herd**, atau `php artisan serve`

## Instalasi lokal (SQLite)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite   # jika belum ada
php artisan migrate --seed
php artisan storage:link
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`.

> Jika menggunakan **Laravel Herd**, cukup buka folder project di Herd dan aplikasi akan tersedia secara otomatis.

## Instalasi dengan MySQL (produksi)

1. Buat database:

   ```sql
   CREATE DATABASE school_gallery CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

2. Salin konfigurasi contoh dan isi kredensial Anda:

   ```bash
   cp .env.mysql.example .env
   php artisan key:generate
   ```

3. Jalankan migrasi dan seeder:

   ```bash
   php artisan migrate --seed
   php artisan storage:link
   npm run build
   ```

> Mengubah koneksi database cukup dengan mengubah `DB_CONNECTION`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`. Migration ditulis agar kompatibel dengan MySQL maupun SQLite.

## Akun demo

Login menggunakan **username** (bukan email):

| Role  | Username | Password |
|-------|----------|----------|
| Admin | `admin`  | `password` |
| User  | `user`   | `password` |

## Fitur

- **Publik**: beranda, galeri album, pencarian & filter kategori, detail album, pratinjau foto, peta sekolah, halaman tentang.
- **User (login)**: like/unlike, komentar (menunggu moderasi), laporan foto, pengelolaan profil.
- **Admin**: dashboard statistik, CRUD album & foto, upload banyak foto, preview gambar, moderasi komentar, peninjauan laporan, manajemen pengguna, CRUD lokasi peta, pengaturan.

## Rute utama

| Method | Path | Keterangan |
|--------|------|------------|
| GET | `/`, `/gallery`, `/gallery/{slug}`, `/map`, `/about` | Halaman publik |
| GET/POST | `/login`, `/register` | Autentikasi (login pakai username) |
| POST | `/logout` | Logout |
| GET/PUT | `/profile` | Profil user |
| POST/DELETE | `/photos/{photo}/like` | Like/unlike |
| POST | `/photos/{photo}/comments` | Komentar |
| POST | `/photos/{photo}/reports` | Laporan |
| GET | `/admin/*` | Panel admin (middleware `auth` + `admin`) |

## Storage

File upload disimpan di `storage/app/public` dan diakses melalui `/storage` setelah menjalankan:

```bash
php artisan storage:link
```

Struktur folder:

```text
storage/app/public/
├── albums/album-{id}/
├── avatars/
├── photos/album-{id}/
└── locations/
```

Batas ukuran upload foto maksimal **99 MB** per file, format yang didukung: JPG, JPEG, PNG, dan WebP.

## Pengujian

```bash
php artisan test
```

Tes menggunakan SQLite in-memory dan `Storage::fake('public')`, sehingga tidak memengaruhi data lokal.

## Catatan keamanan

- Login menggunakan username (bukan alamat email).
- Role dan status pengguna diperiksa lewat middleware `admin` dan `active`.
- Semua upload divalidasi (jenis, ekstensi, ukuran maksimal 99 MB; avatar 2 MB).
- Komentar baru berstatus `pending` dan hanya tampil setelah disetujui admin.
- Laporan foto dibatasi satu kali per user per foto.
- Admin tidak dapat menonaktifkan atau menghapus akunnya sendiri.
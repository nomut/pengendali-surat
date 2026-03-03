# PKK Jogja

![Static Badge](https://img.shields.io/badge/Laravel%20-%20v12%20-%20%23f9322c) ![Static Badge](https://img.shields.io/badge/Inertia.js%20-%20v2%20-%20%236b46c1) ![Static Badge](<https://img.shields.io/badge/Vue.js%20-%20v3.5%20-%20rgb(66%20184%20131)>) ![Static Badge](<https://img.shields.io/badge/PrimeVue%20-%20v4%20-%20rgb(16%20185%20129)>) ![Static Badge](https://img.shields.io/badge/Tailwind%20CSS%20-%20v4%20-%20%230284c7)

Website profil dan sistem informasi PKK, dibangun menggunakan [Laravel](https://laravel.com/docs/master), [Inertia.js](https://inertiajs.com/), [PrimeVue](https://primevue.org/), dan [Tailwind CSS](https://tailwindcss.com/).

---

## Fitur Utama

- **CMS Halaman** — Kelola konten halaman (Beranda, Profil, Pokja, dll.)
- **Modul Kegiatan** — Publikasi berita/artikel kegiatan dengan Rich Text Editor & cover image
- **Modul Galeri** — Album foto kegiatan dengan multi-image upload
- **Manajemen Pengguna & Peran** — Sistem role-based access control
- **SSR (Server Side Rendering)** — Optimasi SEO dengan Inertia SSR

---

## Prasyarat

- PHP >= 8.2
- Composer
- Node.js >= 18
- pnpm (atau npm)
- MySQL / MariaDB

---

## Instalasi (Development)

```bash
# 1. Clone repository
git clone <repository-url>
cd pkk-jogja

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies
pnpm install

# 4. Setup environment
cp .env.example .env
php artisan key:generate

# 5. Konfigurasi database di file .env
# DB_DATABASE=pkk_jogja
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Migrasi database
php artisan migrate

# 7. Buat symlink storage
php artisan storage:link

# 8. Jalankan development server
pnpm dev                # Terminal 1 — Vite dev server
php artisan serve       # Terminal 2 — Laravel server
```

---

## Build Production

```bash
pnpm build
```

Perintah ini menghasilkan asset terkompilasi di `public/build/` dan SSR bundle di `bootstrap/ssr/`.

---

## Deploy ke Shared Hosting

### Cara 1: Ubah Document Root (Direkomendasikan ✅)

Cara paling mudah jika hosting mendukung pengubahan Document Root (tersedia di cPanel → **Domains** → **Document Root**).

1. Upload **seluruh proyek** ke server, misalnya ke `/home/username/pkk-jogja/`
2. Ubah **Document Root** domain Anda menjadi `/home/username/pkk-jogja/public`
3. Tidak perlu mengedit file apapun — selesai!

### Cara 2: Pisah Folder (Jika Tidak Bisa Ubah Document Root)

Struktur target di server:

```
/home/username/
├── public_html/          ← Document Root (diakses browser)
└── pkk-jogja/            ← Kode Laravel (di luar public_html)
```

**Langkah-langkah:**

1. Upload seluruh proyek ke `/home/username/pkk-jogja/`

2. **Pindahkan isi `public/`** ke `public_html/`:
   ```
   public_html/
   ├── build/           ← dari public/build
   ├── index.php        ← dari public/index.php
   ├── .htaccess        ← dari public/.htaccess
   ├── robots.txt
   └── ...
   ```

3. **Edit `public_html/index.php`**, ubah path autoload & bootstrap:
   ```php
   // Sebelumnya:
   require __DIR__.'/../vendor/autoload.php';
   $app = require_once __DIR__.'/../bootstrap/app.php';

   // Ubah menjadi:
   require __DIR__.'/../pkk-jogja/vendor/autoload.php';
   $app = require_once __DIR__.'/../pkk-jogja/bootstrap/app.php';
   ```

4. **Buat symlink storage** secara manual:
   ```bash
   ln -s /home/username/pkk-jogja/storage/app/public /home/username/public_html/storage
   ```

### Konfigurasi Server (Kedua Cara)

```bash
# Masuk ke folder proyek
cd ~/pkk-jogja

# Install dependencies (tanpa dev)
composer install --no-dev --optimize-autoloader

# Konfigurasi .env
cp .env.example .env
php artisan key:generate
# Edit .env sesuai kredensial database hosting

# Migrasi & optimasi
php artisan migrate --force
php artisan storage:link
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Konfigurasi `.env` untuk Production

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://domainanda.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=nama_database
DB_USERNAME=user_database
DB_PASSWORD=password_database
```

### Checklist Deploy

| # | Langkah | Perintah / Aksi |
|---|---------|-----------------|
| 1 | Build asset frontend | `pnpm build` (di lokal) |
| 2 | Upload kode ke server | FTP / Git / File Manager |
| 3 | Install PHP dependencies | `composer install --no-dev` |
| 4 | Konfigurasi `.env` | Sesuaikan database & APP_URL |
| 5 | Generate app key | `php artisan key:generate` |
| 6 | Jalankan migrasi | `php artisan migrate --force` |
| 7 | Buat symlink storage | `php artisan storage:link` |
| 8 | Cache konfigurasi | `php artisan config:cache` |
| 9 | Cache route | `php artisan route:cache` |
| 10 | Cache view | `php artisan view:cache` |

> [!TIP]
> Jika menggunakan **Docker** untuk development, jalankan perintah artisan melalui container:
> ```bash
> docker exec -it pkk-jogja-laravel-1 php artisan <command>
> ```

---

## Lisensi

Proyek ini bersifat privat.
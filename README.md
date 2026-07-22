# 📚 Skirpsi Sistem Monitoring — SD Perguruan Buddhi

Sistem monitoring akademik berbasis web untuk memantau nilai, raport, dan perkembangan siswa secara real-time.

Dibangun menggunakan **Laravel 12**, **Tailwind CSS v4**, dan **Vite**.

---

## ⚙️ Persyaratan Sistem

Pastikan perangkat Anda sudah terinstal:

| Kebutuhan | Versi Minimum |
|-----------|--------------|
| PHP | 8.2+ |
| Composer | 2.x |
| Node.js | 18+ |
| NPM | 9+ |
| SQLite | (sudah termasuk di PHP) |

> Rekomendasi: Gunakan **Laragon** (Windows) atau **Herd** untuk environment lokal yang mudah.

---

## 🚀 Langkah Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/MuradNi/Skirpsi-Sistem-Monitoring.git
cd Skirpsi-Sistem-Monitoring
```

---

### 2. Install PHP Dependencies (Vendor)

```bash
composer install
```

---

### 3. Salin File Environment

```bash
cp .env.example .env
```

> **Windows (PowerShell):**
> ```powershell
> copy .env.example .env
> ```

---

### 4. Generate Application Key

```bash
php artisan key:generate
```

---

### 5. Konfigurasi Database

Proyek ini menggunakan **SQLite** secara default. Buat file database-nya:

```bash
# Linux / Mac
touch database/database.sqlite

# Windows (PowerShell)
New-Item -Path "database/database.sqlite" -ItemType File
```

Pastikan isi `.env` seperti ini:

```env
DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

> **Jika ingin menggunakan MySQL**, ubah `.env` menjadi:
> ```env
> DB_CONNECTION=mysql
> DB_HOST=127.0.0.1
> DB_PORT=3306
> DB_DATABASE=skipsi_monitoring
> DB_USERNAME=root
> DB_PASSWORD=
> ```
> Lalu buat database-nya terlebih dahulu di MySQL.

---

### 6. Jalankan Migrasi Database

```bash
php artisan migrate
```

---

### 7. Jalankan Seeder (Data Dummy)

```bash
php artisan db:seed
```

Seeder akan membuat akun-akun berikut:

| Role | Email | Password |
|------|-------|----------|
| Admin | `admin@buddhi.sch.id` | `password` |
| Guru 1 | `guru1@buddhi.sch.id` | `password` |
| Guru 2 | `guru2@buddhi.sch.id` | `password` |
| Wali Kelas | `wali6a@buddhi.sch.id` | `password` |
| Orang Tua | `orangtua@buddhi.sch.id` | `password` |

---

### 8. Install Node Dependencies

```bash
npm install
```

---

### 9. Build Asset (CSS & JS)

**Untuk development** (dengan hot-reload):
```bash
npm run dev
```

**Untuk production** (build final):
```bash
npm run build
```

---

### 10. Jalankan Server

Buka terminal baru, jalankan:

```bash
php artisan serve
```

Akses aplikasi di browser: **[http://localhost:8000](http://localhost:8000)**

---

## ▶️ Menjalankan Semua Sekaligus (Dev Mode)

Gunakan perintah ini untuk menjalankan server, queue, log, dan vite secara bersamaan:

```bash
composer dev
```

---

## 🔄 Reset & Ulangi dari Awal

Jika ingin menghapus semua data dan seed ulang:

```bash
php artisan migrate:fresh --seed
```

---

## 📁 Struktur Proyek Penting

```
├── app/
│   ├── Http/
│   │   ├── Controllers/    # Logic controller
│   │   └── Middleware/     # Auth & Role middleware
│   └── Models/             # Eloquent models
├── database/
│   ├── migrations/         # Skema tabel database
│   └── seeders/            # Data dummy
├── resources/
│   ├── views/              # Template Blade
│   └── js/                 # Asset JavaScript
├── routes/
│   └── web.php             # Definisi routing
└── .env                    # Konfigurasi environment
```

---

## 🛠️ Perintah Artisan yang Sering Digunakan

```bash
# Lihat semua route
php artisan route:list

# Clear semua cache
php artisan optimize:clear

# Buat migration baru
php artisan make:migration nama_migration

# Buat controller baru
php artisan make:controller NamaController
```

---

## 📄 Lisensi

Proyek ini dibuat untuk keperluan **Skripsi** — SD Perguruan Buddhi.

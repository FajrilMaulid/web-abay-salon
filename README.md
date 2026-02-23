<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

<h1 align="center">💇 Web Booking Salon</h1>

<p align="center">
  Aplikasi web booking salon berbasis Laravel — memudahkan pelanggan membuat janji dan admin mengelola jadwal layanan.
</p>

---

## 📋 Persyaratan Sistem

Pastikan perangkat kamu sudah memiliki:

| Kebutuhan | Versi Minimum |
| --------- | ------------- |
| PHP       | ≥ 8.2         |
| Composer  | ≥ 2.x         |
| Node.js   | ≥ 18.x        |
| npm       | ≥ 9.x         |
| MySQL     | ≥ 8.0         |
| Git       | Latest        |

---

## 🚀 Panduan Instalasi

### 1. Clone Repository

```bash
git clone https://github.com/FajrilMaulid/web-abay-salon.git
cd web-abay-salon
```

### 2. Install Dependensi PHP

```bash
composer install
```

### 3. Install Dependensi JavaScript

```bash
npm install
```

### 4. Konfigurasi Environment

Salin file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

> **Windows (Command Prompt / PowerShell):**
>
> ```powershell
> copy .env.example .env
> ```

Kemudian buka file `.env` dan sesuaikan konfigurasi berikut:

```env
APP_NAME="Web Booking Salon"
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=web_booking_salon   # Nama database yang sudah dibuat
DB_USERNAME=root                # Username MySQL kamu
DB_PASSWORD=                    # Password MySQL kamu (kosongkan jika tidak ada)
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

Buat database baru di MySQL dengan nama yang sesuai dengan `DB_DATABASE` di `.env`:

```sql
CREATE DATABASE web_booking_salon;
```

Atau bisa menggunakan **phpMyAdmin** / **TablePlus** / **DBeaver**.

### 7. Jalankan Migrasi & Seeder

```bash
php artisan migrate --seed
```

> Jika ingin mereset dan mengisi ulang data:
>
> ```bash
> php artisan migrate:fresh --seed
> ```

### 8. Build Asset Frontend

```bash
npm run build
```

> Untuk mode development dengan hot-reload:
>
> ```bash
> npm run dev
> ```

### 9. Jalankan Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: **http://localhost:8000**

---

## ⚙️ Konfigurasi Tambahan (Opsional)

### Konfigurasi Email

Untuk mengaktifkan fitur notifikasi email, ubah konfigurasi `MAIL_*` di `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=emailkamu@gmail.com
MAIL_PASSWORD=app_password_kamu
MAIL_FROM_ADDRESS=emailkamu@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Storage Link

Jika aplikasi menggunakan penyimpanan file lokal (gambar profil, dll):

```bash
php artisan storage:link
```

---

## 🗂️ Struktur Peran (Default Seeder)

Setelah menjalankan seeder, akun default yang tersedia:

| Peran | Email           | Password |
| ----- | --------------- | -------- |
| Admin | admin@salon.com | password |

> ⚠️ **Segera ganti password default setelah login pertama!**

---

## 🛠️ Perintah Berguna

```bash
# Menjalankan server development
php artisan serve

# Build asset untuk production
npm run build

# Menjalankan migrasi ulang + seeder
php artisan migrate:fresh --seed

# Membersihkan cache
php artisan optimize:clear

# Melihat daftar route
php artisan route:list
```

---

## 🐛 Troubleshooting

**Error: `APP_KEY` tidak ditemukan**

```bash
php artisan key:generate
```

**Error: Koneksi database gagal**

- Pastikan MySQL sudah berjalan
- Periksa kembali `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`
- Pastikan database sudah dibuat

**Error: Permission denied pada `storage/` atau `bootstrap/cache/`**

```bash
# Linux / macOS
chmod -R 775 storage bootstrap/cache

# Windows: pastikan folder tidak dalam mode read-only
```

**Error: Vite manifest tidak ditemukan**

```bash
npm run build
```

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah [MIT License](https://opensource.org/licenses/MIT).

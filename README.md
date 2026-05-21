# Sistem Proposal Perusahaan - PT Karunia Mitra Bersama

Aplikasi berbasis Laravel untuk manajemen pengajuan proposal di PT Karunia Mitra Bersama. Proyek ini memfasilitasi pembuatan, peninjauan, dan penyetujuan proposal antara staff/finance dan manager.

## Panduan Instalasi & Menjalankan Proyek

Pastikan di lokal Anda sudah terinstall PHP (minimal versi 8.2), Composer, dan Node.js (untuk keperluan asset vite jika diperlukan), serta Database MySQL atau sejenisnya.

### 1. Clone & Setup Awal
Clone repositori ini atau masuk ke direktori proyek yang ada:
```bash
cd sistem_proposal_perusahaan
```

Install dependensi PHP menggunakan Composer:
```bash
composer install
```

Install dependensi Node.js untuk frontend (opsional namun disarankan jika terdapat perubahan asset):
```bash
npm install
```

### 2. Konfigurasi Environment
Duplikat file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Buka file `.env` dan atur konfigurasi koneksi database Anda (biasanya `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).

### 3. Generate Key & Migrasi Database
Generate APP_KEY Laravel:
```bash
php artisan key:generate
```

Jalankan migrasi database beserta seeder-nya untuk memasukkan data-data bawaan seperti Role (Manager, Finance), Divisi, dan User dummy:
```bash
php artisan migrate --seed
```

### 4. Menjalankan Server
Untuk melihat aplikasi, jalankan server bawaan Laravel:
```bash
php artisan serve
```

Jika Anda ingin mengkompilasi file statis (CSS/JS) secara langsung/hot-reload:
```bash
npm run dev
```

Anda bisa mengakses aplikasi web melalui `http://localhost:8000`.

---

## Dokumentasi API (RESTful)

Proyek ini juga mengekspos endpoint API. Autentikasi API menggunakan Laravel Sanctum (Token-based Authentication). Sebagian besar rute membutuhkan `Authorization` header berupa Bearer token.

**Base URL**: `http://localhost:8000/api`

### 1. Auth Endpoint

#### Login
Digunakan untuk mengautentikasi user dan mendapatkan akses token.
- **Endpoint:** `POST /auth/login`
- **Body Request:**
  ```json
  {
      "email": "user@example.com",
      "password": "password"
  }
  ```
- **Response Sukses:** Akan mengembalikan informasi akun beserta Bearer Token yang dapat digunakan pada endpoint-endpoint lainnya.

#### Mendapatkan Data User Login (Profile)
- **Endpoint:** `GET /auth/me`
- **Headers:** `Authorization: Bearer <token_anda>`
- **Response:** Menampilkan data object user yang sedang login (termasuk relasi divisi).

#### Logout
Mencabut hak akses (menghapus) token saat ini yang digunakan.
- **Endpoint:** `POST /auth/logout`
- **Headers:** `Authorization: Bearer <token_anda>`
- **Response:** Berhasil keluar.

---

### 2. Proposal Endpoint
Semua endpoint di bawah ini membutuhkan login.

- **Headers:** `Authorization: Bearer <token_anda>`

#### Mengambil Semua Proposal
- **Endpoint:** `GET /proposals`
- **Deskripsi:** Menampilkan daftar proposal yang sesuai dengan role dan divisi dari user yang melakukan request (contoh: Finance melihat proposalnya sendiri di divisinya, Manager melihat semua proposal di divisinya).

#### Membuat Proposal Baru
- **Endpoint:** `POST /proposals`
- **Body Request:**
  ```json
  {
      "title": "Pengadaan Laptop",
      "description": "Pengajuan pengadaan laptop untuk tim developer divisi terkait."
  }
  ```
- **Deskripsi:** Membuat pengajuan proposal baru. Nilai `user_id` dan `division_id` tidak perlu dikirim karena otomatis terambil dari token/user login. 

#### Menyetujui Proposal
- **Endpoint:** `PUT /proposals/{proposal}/approve`
- **Parameter:** `{proposal}` diganti dengan ID proposal (contoh: `/proposals/1/approve`).
- **Deskripsi:** Menyetujui (approve) sebuah proposal. Endpoint ini hanya bisa diakses oleh user dengan role **Manager**.

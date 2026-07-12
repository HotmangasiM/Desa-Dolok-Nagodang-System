Sistem Informasi Desa (Dolok Nagodang)
📌 Deskripsi / Description
🇮🇩 Indonesia

Sistem Informasi Desa adalah aplikasi berbasis web yang digunakan untuk membantu administrasi desa secara digital, meliputi:

Pendataan penduduk
Pelayanan surat elektronik (SKTM, domisili, dll)
Manajemen berita desa
Inventaris desa
Data aparat desa

Sistem Informasi Desa (Dolok Nagodang)
📌 Deskripsi / Description
🇮🇩 Indonesia

Sistem Informasi Desa adalah aplikasi berbasis web yang digunakan untuk membantu administrasi desa secara digital, meliputi:

Pendataan penduduk
Pelayanan surat elektronik (SKTM, domisili, dll)
Manajemen berita desa
Inventaris desa
Data aparat desa

Teknologi yang Digunakan / Tech Stack
Backend: Laravel
Database: MySQL
Container: Docker
DB Client: DBeaver
API Testing: Postman


⚙️ Setup Project
1. Clone Repository
git clone <repo-url>
cd desa-dolok-nagodang-app

2. Jalankan Docker
docker-compose up -d

. Setup Environment

Copy file .env:

cp .env.example .env

4. Install Dependency
docker exec -it desa_app composer install

5. Generate Key
docker exec -it desa_app php artisan key:generate

6. Run Migration
docker exec -it desa_app php artisan migrate
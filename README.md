````md
# ☕ CafePOS

Sistem Informasi Manajemen Café berbasis Laravel yang mendukung transaksi POS, monitoring food waste, sustainability reporting, dan integrasi REST API berbasis JWT Authentication.


## Fitur Utama

- 🔐 Multi-role System (Admin, Kasir, Customer)
- 🧾 Transaksi POS Café
- 📊 Dashboard Operasional
- 🍽️ Food Waste Monitoring
- 🌱 Sustainability Reporting
- 📦 Eco Packaging Tracking
- 📱 REST API & JWT Authentication
- 📖 Riwayat Transaksi Customer
- 🧑‍💼 Manajemen Menu & Kategori


## Teknologi yang Digunakan

| Teknologi | Keterangan |
| Laravel 10 | Backend Framework |
| PHP 8.1 | Bahasa Pemrograman |
| MySQL | Database |
| JWT Auth | API Authentication |
| Flutter | Mobile Integration |
| Blade | Template Engine |


## Role Sistem

### Admin
- Mengelola menu dan kategori
- Monitoring transaksi
- Monitoring food waste
- Melihat laporan operasional
- Mengelola pengguna

### Kasir
- Memproses transaksi POS
- Cetak struk
- Mengelola status transaksi
- Input food waste

### Customer
- Registrasi akun
- Melihat menu
- Melakukan pemesanan
- Melihat riwayat transaksi


## Instalasi Project

Clone repository:

```bash
git clone https://github.com/alidaneila/cafe.git
````

Masuk ke folder project:

```bash
cd cafe
```

Install dependency:

```bash
composer install
npm install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Migration database:

```bash
php artisan migrate --seed
```

Menjalankan server:

```bash
php artisan serve
```


## REST API

Endpoint utama REST API:

* `/api/auth/login`
* `/api/auth/register`
* `/api/menu`
* `/api/transaksi`
* `/api/laporan`



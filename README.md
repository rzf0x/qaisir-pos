# QAISIR - POS Laundry Kiloan untuk UMKM Indonesia

<p align="center">
  <strong>Kasir laundry simpel yang bikin owner tau uang masuk & omzet harian tanpa ribet.</strong>
</p>

---

## 🎯 Tentang QAISIR

QAISIR adalah aplikasi kasir (POS) yang dirancang khusus untuk laundry kiloan UMKM di Indonesia. Fokus utama aplikasi ini adalah:

- **Simpel** - Tidak ada fitur yang berlebihan
- **Cepat** - Input transaksi dalam hitungan detik
- **Jelas** - Lihat omzet harian dalam sekilas tanpa istilah akuntansi ribet

---

## ✨ Fitur Utama

### 1. 📊 Dashboard

- Lihat **Uang Masuk Hari Ini** dengan jelas
- **Jumlah Transaksi** hari ini
- **Tunai Diterima** hari ini
- Transaksi terbaru

### 2. ➕ Transaksi Cepat

- Pilih layanan (Cuci, Cuci + Setrika, dll)
- Input berat (kg)
- Pilih metode pembayaran (Tunai/QR)
- Total otomatis dihitung
- Simpan dalam < 1 detik

### 3. 📈 Laporan Usaha

- Laporan Hari Ini
- Laporan 7 Hari Terakhir
- Laporan Bulan Ini
- Ringkasan harian

### 4. 🧺 Kelola Layanan

- Tambah layanan baru
- Edit harga per kg
- Aktifkan/nonaktifkan layanan

### 5. 🔐 Autentikasi

- Login dengan email & password
- 7 hari masa uji coba gratis
- Sistem langganan bulanan

---

## 🛠️ Tech Stack

| Layer      | Teknologi       |
| ---------- | --------------- |
| Backend    | Laravel 11      |
| PHP        | 8.2+            |
| Database   | MySQL / MariaDB |
| Auth       | Laravel Breeze  |
| Frontend   | Blade Templates |
| Styling    | Tailwind CSS    |
| JavaScript | Alpine.js       |
| Design     | Mobile-first UI |

---

## 📦 Instalasi

### Prasyarat

- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL / MariaDB

### Langkah Instalasi

1. **Clone repository**

    ```bash
    git clone <repository-url>
    cd qaisir-pos
    ```

2. **Install dependencies**

    ```bash
    composer install
    npm install
    ```

3. **Setup environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Konfigurasi database** di file `.env`

    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=qaisir_pos
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5. **Jalankan migrasi**

    ```bash
    php artisan migrate
    ```

6. **Build assets**

    ```bash
    npm run build
    ```

7. **Jalankan server**

    ```bash
    php artisan serve
    ```

8. **Akses aplikasi**
   Buka browser dan akses: `http://127.0.0.1:8000`

---

## 🎮 Demo Account

Setelah menjalankan seeder, Anda dapat login dengan:

| Field    | Value             |
| -------- | ----------------- |
| Email    | `demo@qaisir.com` |
| Password | `password123`     |

Untuk membuat akun demo:

```bash
php artisan db:seed
```

---

## 📁 Struktur Project

```
qaisir-pos/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── DashboardController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── LaundryServiceController.php
│   │   │   ├── ReportController.php
│   │   │   └── SubscriptionController.php
│   │   └── Middleware/
│   │       └── CheckSubscription.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── LaundryService.php
│   │   ├── Transaction.php
│   │   ├── DailySummary.php
│   │   └── Subscription.php
│   ├── Services/
│   │   ├── TransactionService.php
│   │   ├── LaundryServiceService.php
│   │   └── SubscriptionService.php
│   └── Listeners/
│       └── SetupNewUser.php
├── database/
│   └── migrations/
│       ├── create_laundry_services_table.php
│       ├── create_transactions_table.php
│       ├── create_daily_summaries_table.php
│       └── create_subscriptions_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php
│       ├── dashboard.blade.php
│       ├── welcome.blade.php
│       ├── transactions/
│       │   ├── create.blade.php
│       │   ├── index.blade.php
│       │   └── success.blade.php
│       ├── services/
│       │   ├── index.blade.php
│       │   ├── create.blade.php
│       │   └── edit.blade.php
│       ├── reports/
│       │   └── index.blade.php
│       └── subscription/
│           ├── status.blade.php
│           └── expired.blade.php
└── routes/
    └── web.php
```

---

## 🗄️ Database Schema

### users

| Column   | Type   | Description       |
| -------- | ------ | ----------------- |
| id       | bigint | Primary key       |
| name     | string | Nama pengguna     |
| email    | string | Email (unique)    |
| password | string | Password (hashed) |

### laundry_services

| Column       | Type    | Description          |
| ------------ | ------- | -------------------- |
| id           | bigint  | Primary key          |
| user_id      | bigint  | Foreign key ke users |
| name         | string  | Nama layanan         |
| price_per_kg | decimal | Harga per kg         |
| is_active    | boolean | Status aktif         |

### transactions

| Column         | Type              | Description                 |
| -------------- | ----------------- | --------------------------- |
| id             | bigint            | Primary key                 |
| user_id        | bigint            | Foreign key ke users        |
| customer_name  | string (nullable) | Nama pelanggan              |
| service_name   | string            | Nama layanan saat transaksi |
| weight         | decimal           | Berat dalam kg              |
| price_per_kg   | decimal           | Harga per kg saat transaksi |
| total          | decimal           | Total harga                 |
| payment_method | enum              | 'cash' atau 'qr'            |
| notes          | text (nullable)   | Catatan                     |
| created_at     | timestamp         | Waktu transaksi             |

### daily_summaries

| Column             | Type    | Description            |
| ------------------ | ------- | ---------------------- |
| id                 | bigint  | Primary key            |
| user_id            | bigint  | Foreign key ke users   |
| date               | date    | Tanggal                |
| total_transactions | integer | Jumlah transaksi       |
| total_income       | decimal | Total pendapatan       |
| cash_income        | decimal | Pendapatan tunai       |
| qr_income          | decimal | Pendapatan QR/transfer |

### subscriptions

| Column        | Type      | Description                   |
| ------------- | --------- | ----------------------------- |
| id            | bigint    | Primary key                   |
| user_id       | bigint    | Foreign key ke users (unique) |
| trial_ends_at | timestamp | Tanggal akhir uji coba        |
| expires_at    | timestamp | Tanggal berakhir langganan    |
| status        | enum      | 'trial', 'active', 'expired'  |

---

## 💰 Model Bisnis

| Item              | Harga             |
| ----------------- | ----------------- |
| Uji Coba          | 7 hari GRATIS     |
| Langganan Bulanan | Rp 25.000 / bulan |

---

## 🚀 Alur Pengguna

1. **Register** → User mendaftar dengan email & password
2. **Auto Setup** → Sistem membuat:
    - Subscription trial 7 hari
    - 3 layanan default (Cuci Kering, Cuci Setrika, Setrika Saja)
3. **Dashboard** → User melihat ringkasan harian
4. **Transaksi** → User input transaksi laundry
5. **Laporan** → User lihat laporan usaha

---

## 📱 UX Design Principles

✅ Mobile-first layout
✅ Tombol besar, mudah diklik
✅ Maksimal 3 aksi per layar
✅ Angka & mata uang jelas (IDR)
✅ Bahasa Indonesia sederhana
✅ Tidak ada istilah akuntansi ribet
✅ Fast interaction (< 5 klik per transaksi)

---

## 🧪 Testing

```bash
php artisan test
```

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 👨‍💻 Author

Dibuat dengan ❤️ untuk UMKM Indonesia.

---

## 🆘 Support

Untuk bantuan atau pertanyaan, hubungi via WhatsApp atau email.

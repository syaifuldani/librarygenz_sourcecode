<div align="center">

# 📚 LibraryGenz

### Warm Editorial Library Management System

Sistem manajemen perpustakaan digital modern berbasis **Laravel 11** dengan arsitektur **multi-role access control**, workflow peminjaman terintegrasi, pengelolaan denda otomatis, serta dashboard analitik dinamis.

---

![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql)
![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-06B6D4?style=for-the-badge&logo=tailwindcss)
![Vite](https://img.shields.io/badge/Vite-Latest-646CFF?style=for-the-badge&logo=vite)

</div>

---

## ✨ Overview

**LibraryGenz** adalah sistem informasi perpustakaan digital yang dirancang untuk mempermudah pengelolaan operasional perpustakaan modern melalui pendekatan **role-based system**.

Sistem mendukung tiga jenis pengguna:

- **Administrator**
- **Librarian (Pustakawan)**
- **Member (Anggota)**

Dengan workflow terintegrasi mulai dari pengelolaan katalog, pengajuan peminjaman, verifikasi pustakawan, pengembalian buku, hingga perhitungan denda otomatis.

---

# 🎯 Tujuan Sistem

LibraryGenz dikembangkan untuk:

- Meningkatkan efisiensi pengelolaan perpustakaan
- Mengurangi proses manual
- Menyediakan monitoring aktivitas real-time
- Mengotomatisasi pengelolaan denda keterlambatan
- Memberikan pengalaman digital modern bagi pengguna perpustakaan

---

# 🚀 Fitur Utama

## 👑 Administrator

- Manajemen seluruh pengguna
- Tambah Admin / Librarian / Member
- Monitoring aktivitas sistem
- Konfigurasi pengaturan sistem
- Export laporan PDF
- Audit log
- Dashboard analitik

---

## 📖 Librarian

- Verifikasi pengajuan peminjaman
- Approve / Reject request
- Verifikasi pengembalian
- Pemrosesan denda
- Kelola katalog buku
- Monitoring overdue
- Dashboard operasional

---

## 👤 Member

- Registrasi akun
- Login multi-role
- Menjelajah katalog buku
- Ajukan peminjaman
- Melihat histori peminjaman
- Monitoring status denda
- Update profil

---

# 🛠️ Tech Stack

## Backend

- Laravel 11
- PHP 8.3
- Laravel Breeze
- Eloquent ORM

## Frontend

- Blade
- TailwindCSS
- Alpine.js
- Vite

## Database

- MySQL 8.0

## Development Environment

- Laragon
- HeidiSQL
- Antigravity IDE

---

# 🏗️ System Architecture

```plaintext
User Interface (Blade + Tailwind)
        ↓
Route Layer
        ↓
Controller Layer
        ↓
Service / Business Logic
        ↓
Eloquent ORM
        ↓
MySQL Database
```

---

# 🔐 Role Access Matrix

| Feature | Admin | Librarian | Member |
|--------|------|-----------|--------|
| Manage Users | ✅ | Limited | ❌ |
| Manage Books | ✅ | ✅ | ❌ |
| Borrow Books | ❌ | ❌ | ✅ |
| Approve Borrowing | ❌ | ✅ | ❌ |
| Process Returns | ❌ | ✅ | ❌ |
| Configure System | ✅ | Limited | ❌ |
| View Reports | ✅ | ✅ | ❌ |

---

# 📂 Project Structure

```plaintext
library_genz/
│
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── Services/
│
├── resources/
│   ├── views/
│   ├── css/
│   └── js/
│
├── routes/
│
├── database/
│   ├── migrations/
│   └── seeders/
│
└── public/
```

---

# ⚙️ Installation Guide

## 1. Clone Repository

```bash
git clone https://github.com/yourusername/librarygenz.git
cd librarygenz
```

---

## 2. Install Dependencies

```bash
composer install
npm install
```

---

## 3. Configure Environment

Copy file `.env`

```bash
cp .env.example .env
```

Generate app key

```bash
php artisan key:generate
```

---

## 4. Configure Database

Edit `.env`

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=librarygenz
DB_USERNAME=root
DB_PASSWORD=
```

---

## 5. Run Migration

```bash
php artisan migrate
```

---

## 6. Run Development Server

Backend:

```bash
php artisan serve
```

Frontend:

```bash
npm run dev
```

---

Access system:

```plaintext
http://127.0.0.1:8000
```

---

# 🧪 Testing

Run feature testing:

```bash
php artisan test
```

---

# 📊 Core Functional Modules

- Authentication & Authorization
- User Management
- Book Catalog Management
- Borrowing Workflow
- Return Verification
- Fine Automation
- Reporting System
- Audit Logging
- Notification System
- Dashboard Analytics

---

# 🎨 UI Design Philosophy

LibraryGenz menggunakan pendekatan visual:

- **Warm Editorial**
- **Modern Academic**
- **Minimal Professional**
- **Dark Navy + Coral Accent**

Color Palette:

| Color | Hex |
|------|-----|
| Primary Navy | `#172132` |
| Secondary Navy | `#223149` |
| Coral Accent | `#E85A3A` |
| Cream | `#F8F5EF` |

---

# 📸 Screenshots

## Landing Page
_Add screenshot here_

## Admin Dashboard
_Add screenshot here_

## Librarian Dashboard
_Add screenshot here_

## Member Dashboard
_Add screenshot here_

---

# 🔄 Workflow

```plaintext
Member submits borrow request
        ↓
Librarian reviews request
        ↓
Approve / Reject
        ↓
Book borrowed
        ↓
Return verification
        ↓
Fine calculation if overdue
        ↓
Activity logged
```

---

# 📈 Future Improvements

- Email notifications
- Barcode scanner integration
- QR-based borrowing
- Mobile responsive PWA
- Recommendation engine
- Analytics dashboard enhancement

---

# 👨‍💻 Developer

Developed by: Danz

---

# 📄 License

This project is developed for academic and educational purposes.

---

<div align="center">

### 📚 LibraryGenz  
Modern Library Management System

Built with ❤️ using Laravel

</div>
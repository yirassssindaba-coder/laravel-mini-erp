# 🧩 ERP Mini (Laravel) + Marketplace API Simulation

A lightweight and stable **Laravel-based Mini ERP** application designed to simulate core ERP workflows such as product management, inventory control, order processing, and marketplace integration using a safe mock approach.

---

## 🧠 Overview

ERP Mini (Laravel) + Marketplace API Simulation adalah aplikasi web responsif berbasis **Laravel** dengan **SQLite** yang mensimulasikan sistem ERP sederhana namun realistis seperti yang umum digunakan pada operasional bisnis. Proyek ini berfokus pada praktik Laravel yang rapi dan stabil melalui penggunaan migration, seeder, Form Request validation, serta alur CRUD yang jelas, tanpa kompleksitas berlebihan yang berisiko menimbulkan error. Modul utama mencakup **Products**, **Inventory (stok masuk/keluar)**, **Orders** dengan workflow status terstruktur, serta **Marketplace Sync** berbasis simulasi untuk menunjukkan pemahaman integrasi API secara aman.

Untuk menjaga kestabilan dan kemudahan pengujian, integrasi marketplace tidak menggunakan API eksternal, melainkan import order dari file JSON lokal dan pencatatan update status ke log lokal. Pendekatan ini menghindari risiko token, rate limit, dan kegagalan layanan pihak ketiga, namun tetap merepresentasikan pola integrasi sistem yang umum di dunia kerja. Dengan desain mobile-responsive dan validasi input yang ketat, proyek ini cocok sebagai portofolio **job-ready** untuk posisi magang maupun junior Laravel/Web Developer.

---

## 🎯 Project Goals

- Demonstrate Laravel fundamentals (CRUD, validation, migration, seeder)
- Simulate real ERP business flow
- Show API integration mindset using safe mock data
- Build a stable, low-risk, recruiter-friendly application

---

## 🧩 Main Modules

### Products
- CRUD product management
- SKU-based identification
- Basic validation and listing

### Inventory
- Stock In / Stock Out transactions
- Movement-based stock calculation
- Prevention of negative stock

### Orders
- Order creation with item snapshot
- Status workflow: `new → packed → shipped → done`
- Simple and readable order lifecycle

### Marketplace Sync (Mock)
- Import orders from local JSON file
- Simulated status push saved to local logs
- No external API dependency

---

## 🗂️ Database (SQLite)

Tables:
- `products`
- `inventory_movements`
- `orders`
- `order_items`
- `marketplace_push_logs`

All tables are created via Laravel migrations and populated with seeders.

---

## 📱 Mobile & UX

- Responsive, mobile-first layout
- Clean and simple UI
- Ready for PWA enhancement
- Clear validation feedback on forms

---

## 🧪 How to Use

1. Open **Dashboard** to view summary  
2. Create a **Product**  
3. Add **Stock In** to increase inventory  
4. Import mock orders from JSON  
5. Update order status and review marketplace logs  

---

## ✅ Testing Checklist

- Import mock orders → orders appear correctly  
- Update order status → log is created  
- Invalid input → validation error shown, data preserved  
- Stock out exceeding available stock → blocked  
- Empty database → UI shows empty state (no crash)  

---

## 🛡️ Stability & Design Principles

- Laravel migration & seeder for predictable setup
- Form Request validation on all inputs
- Simple queries, no queue/job usage
- Mock API integration to minimize risk

---

## 🏷️ Topics

`laravel` · `php` · `sqlite` · `erp` · `crud` · `inventory-management` · `order-management` · `api-simulation` · `portfolio-project` · `job-ready`

---

## 👤 Recruiter Notes

This project prioritizes **clarity, correctness, and stability** over excessive features. It reflects how junior developers are expected to build maintainable internal systems while understanding real business processes such as inventory tracking and order handling.

---

## 📄 License

This project is for educational and portfolio purposes.
s

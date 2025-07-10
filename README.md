# 📚 Digital Library — Web-Based Library Management System (PHP Native)

> A clean and functional digital library system built with PHP & MySQL, designed for schools, universities, or personal projects.

![Status](https://img.shields.io/badge/project-live-brightgreen)  
🔗 **Live Demo:** [http://dbs.free.nf/admin.php](http://dbs.free.nf/admin.php)
### 🔐 Login Page
<img width="1366" height="768" alt="Image" src="https://github.com/user-attachments/assets/883d304d-12ac-42ac-9d4d-2d06d2dde5ae" />

### 🧭 Dashboard Page
<img width="1366" height="768" alt="Image" src="https://github.com/user-attachments/assets/3008845c-e398-4569-9931-2b8514050de1" />

---

## 🧭 Overview

**Digital Library** is a web-based application for managing book data, members, borrow-return transactions, and admin authentication. This system is developed using **pure PHP (without frameworks)** and follows a modular project structure to ensure maintainability and extensibility.

This project is ideal for:
- Library digitization for schools or campuses
- Learning and practicing backend web development (CRUD, session, DB connection)
- Entry-level fullstack portfolio project

---

## ✨ Features

- ✅ Admin Login System (Session-based)
- ✅ Dashboard with real-time library data
- ✅ Book Management (CRUD)
- ✅ Member Management (CRUD)
- ✅ Borrow & Return Book System
- ✅ Dynamic Table Views
- ✅ Responsive Layout with Custom CSS
- ✅ Secure DB config via `.env`
- ✅ Ready for shared hosting (InfinityFree / 000webhost)

---

## 🛠️ Tech Stack

| Layer     | Tech                     |
|-----------|--------------------------|
| Frontend  | HTML, CSS, JavaScript    |
| Backend   | PHP Native               |
| Database  | MySQL                    |

---

## 🚀 Getting Started (Local Setup)
### 1. Clone Repository

git clone https://github.com/mmarseal/Digital-Library.git
cd Digital-Library 

2. Import Database
- Open phpMyAdmin
- Create database perpustakaan_db
- Import perpustakaan_db.sql

3. Create .env in Root
DB_HOST=localhost
DB_PORT=3306
DB_USER=root
DB_PASS=
DB_NAME=perpustakaan_db

4. Install Composer Dependency
composer install

5. Run on Localhost (via Laragon/XAMPP)
http://localhost/Digital-Library/login.php

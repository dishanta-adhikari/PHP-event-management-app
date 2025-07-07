# PHP Event Management System

A comprehensive event management platform built with PHP, MySQL, and Bootstrap. This system is designed for educational institutions to manage events, allowing students to browse and register for programs efficiently. It features user authentication, role-based dashboards, secure registration, and responsive UI.

---

## Features

### Core Functionality
- User Authentication – Secure login system with session handling  
- Role-Based Access – Admin, Club, and Student roles with separate dashboards  
- Program Management – Admins & Clubs can create, update, and delete events  
- Student Registration – Students can view and register for events  
- Duplicate Registration Prevention – Avoid multiple entries for the same event  

### Technical Features
- MVC Architecture – Clean code separation (Controllers, Views, Models)  
- Database Security – Prepared statements to prevent SQL injection  
- Responsive UI – Mobile-friendly interface with Bootstrap  
- File Uploads – Poster/image support for events  
- Session Management – Proper login sessions with access control  

---

## Prerequisites

- XAMPP (Apache, MySQL, PHP)  
- PHP 7.4 or higher  
- MySQL 5.7 or higher  
- Composer (for dependency management)  

---

## Installation Guide

1. Clone the Repository  
   ```bash
   git clone <repository-url>
   cd PHP-event-management-app
   ```

2. Move to XAMPP Directory  
   - Place the project folder inside the `htdocs` directory.

3. Database Setup  
   - Create a database in phpMyAdmin (e.g. `event_management`)  
   - Import the SQL file (if provided)  
   - Update database credentials in the config file  

4. Environment Configuration  
   ```bash
   cp .env.example .env
   ```
   Edit `.env` with:
   ```env
   DB_HOST=127.0.0.1
   DB_NAME=your_db
   DB_USER=root
   DB_PASS=
   APP_URL=http://localhost/PHP-event-management-app
   ```

5. Install Dependencies  
   ```bash
   composer install
   ```

6. Run the App  
   Visit in your browser:  
   ```
   http://localhost/PHP-event-management-app
   ```

---

## User Roles

### Admin  
- Manage all programs  
- View participants  
- Manage user accounts  

### Club  
- Create and manage club-specific events  
- View participant list  

###  Student  
- Browse all active events  
- Register for programs  
- View registration history  

---

## Security Highlights

- Prepared Statements to prevent SQL Injection  
- File Validation for safe image uploads  
- Session-Based Authentication  
- Input Validation (Client & Server-side)  
- XSS Protection via output escaping  

---

## License

This project is open-source and free to use under the MIT License.

---


✨ Made with love for better event coordination.

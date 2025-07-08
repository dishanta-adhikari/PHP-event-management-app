# Event Management System

A robust event management platform developed using PHP, MySQL, and Bootstrap. Tailored for educational institutions, it streamlines event organization, enabling students to easily browse and register for programs. The system includes secure authentication, role-based dashboards, protected registration, and a responsive user interface.

---

## Features

### Core Functionality
- User Authentication – Secure login system with session management  
- Role-Based Access – Separate dashboards for Admin, Club, and Student roles  
- Program Management – Admins and Clubs can create, update, and delete events  
- Student Registration – Students can view and register for available events  
- Duplicate Registration Prevention – Prevents multiple registrations for the same event  

### Technical Features
- MVC Architecture – Clean separation of Controllers, Views, and Models  
- Database Security – Uses prepared statements to guard against SQL injection  
- Responsive UI – Mobile-friendly design powered by Bootstrap  
- File Uploads – Supports poster/image uploads for events  
- Session Management – Ensures proper login sessions and access control  

---

## Prerequisites

- XAMPP (Apache, MySQL, PHP)  
- PHP 7.4 or newer  
- MySQL 5.7 or newer  
- Composer (for managing dependencies)  

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
   - Create a database in phpMyAdmin (e.g., `gcuems_db`)  
   - Import the provided SQL file  
   - Update database credentials in the configuration file  

4. Environment Configuration  
   ```bash
   cp .env.example .env
   ```
   Edit `.env` with:
   ```env
   DB_HOST=localhost
   DB_NAME=gcuems_db
   DB_USER=root
   DB_PASS=
   APP_URL=http://localhost/PHP-event-management-app
   ```

5. Install Dependencies  
   ```bash
   composer install
   ```

6. Run the App  
   Open in your browser:  
   ```
   http://localhost/PHP-event-management-app
   ```

---

## User Roles

### Admin  
- Manage all programs  
- View participant lists  
- Manage user accounts  

### Club  
- Create and manage club-specific events  
- View participant lists  

### Student  
- Browse all active events  
- Register for programs  
- View registration history  

---

## Security Highlights

- Prepared Statements to prevent SQL Injection  
- File Validation for secure image uploads  
- Session-Based Authentication  
- Input Validation (Client & Server-side)  
- XSS Protection through output escaping  

---

## License

This project is open-source and available under the MIT License.

---


Made with ❤️ to enhance coordination.

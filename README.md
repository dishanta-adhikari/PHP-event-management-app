# PHP Event Management System

A comprehensive event management platform built with PHP, MySQL, and Bootstrap. This application enables educational institutions to manage and organize various programs and events, allowing students to register for activities seamlessly.

## 🚀 Features

### Core Functionality
- **User Authentication System** - Secure login/register for different user types
- **Role-Based Access Control** - Admin, Club, and Student user roles
- **Program Management** - Create, edit, and manage events/programs
- **Student Registration** - Easy registration system for programs
- **Duplicate Prevention** - Prevents multiple registrations for the same event

### Technical Features
- **MVC Architecture** - Clean separation of Models, Views, and Controllers
- **Database Security** - Prepared statements to prevent SQL injection
- **Responsive Design** - Bootstrap-based UI that works on all devices
- **File Upload System** - Image uploads for program posters
- **Session Management** - Secure user session handling

## 📋 Prerequisites

- XAMPP (Apache + MySQL + PHP)
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Composer (for dependency management)

## 🛠️ Installation

1. **Clone the Repository**
   ```bash
   git clone <repository-url>
   cd PHP-event-management-app
   ```

2. **Setup XAMPP**
   - Start Apache and MySQL services
   - Place the project in `htdocs` directory

3. **Database Setup**
   - Create a new MySQL database
   - Import the database schema (if SQL file provided)
   - Update database credentials in configuration

4. **Environment Configuration**
   ```bash
   cp .env.example .env
   # Edit .env with your database credentials and APP_URL
   ```

5. **Install Dependencies**
   ```bash
   composer install
   ```

6. **Access the Application**
   ```
   http://localhost/PHP-event-management-app
   ```

## 👥 User Roles

### Admin
- Create and manage programs
- View all registrations
- Manage user accounts
- System configuration

### Club
- Create programs for their club
- Manage club-specific events
- View registrations for their programs

### Student
- Browse available programs
- Register for events
- View registration history

## 🔒 Security Features

- **SQL Injection Prevention** - All queries use prepared statements
- **Input Validation** - Server-side and client-side validation
- **Session Security** - Secure session management
- **File Upload Security** - Validated file uploads
- **XSS Protection** - Output escaping for user data

## 📁 Project Structure
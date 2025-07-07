# PHP Event Management App

A simple event management system built with PHP (MVC), MySQL, and Bootstrap.  
This app allows admins and clubs to create/manage programs and users to register for events.

## Features

- User authentication (login/register)
- Admin and club dashboards
- Program (event) creation and management
- User registration for programs
- Duplicate registration prevention
- MVC folder structure (Models, Views, Controllers)
- Uses prepared statements for security


## Setup

1. **Clone the repository**  
   Place it in your XAMPP `htdocs` directory.

2. **Create a MySQL database**  
   Import the provided SQL file (if available).

3. **Configure environment variables**  
   Copy `.env.example` to `.env` and set your DB credentials and `APP_URL`.

4. **Install dependencies**  
   ```
   composer install
   ```

5. **Run the app**  
   Start Apache and MySQL in XAMPP, then visit:  
   ```
   http://localhost/PHP-event-management-app
   ```

## Usage

- **Admin/Club:** Login to create and manage programs.
- **User:** Register for available programs/events.

## Security

- All database queries use prepared statements.
- User input is validated on both client and server sides.

## License

MIT

---
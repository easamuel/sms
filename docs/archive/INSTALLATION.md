# Laravel SMS Installation Guide

This is a Laravel 10 School Management System project. Follow these steps to complete the installation:

## Prerequisites

- PHP >= 8.1
- Composer
- MySQL/MariaDB
- Node.js and NPM (optional, for frontend assets)

## Installation Steps

### 1. Install Dependencies

```bash
composer install
```

### 2. Environment Configuration

The `.env` file has been created. Update it with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sms_system
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 3. Generate Application Key

```bash
php artisan key:generate
```

### 4. Create Database

Create a MySQL database named `sms_system` (or your preferred name) and update the `.env` file accordingly.

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Seed Database (Optional)

If you have seeders, run:

```bash
php artisan db:seed
```

Or for a specific seeder:

```bash
php artisan db:seed --class=SmsDemoDataSeeder
```

### 7. Create Storage Link

```bash
php artisan storage:link
```

### 8. Set Permissions (Linux/Mac)

```bash
chmod -R 775 storage bootstrap/cache
```

### 9. Start Development Server

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`

## Access Points

- Home: `http://localhost:8000/`
- School Management: `http://localhost:8000/school-management`
- SMS Student Portal: `http://localhost:8000/sms/student/dashboard`
- SMS Teacher Portal: `http://localhost:8000/sms/teacher/dashboard`
- SMS Admin Portal: `http://localhost:8000/sms/admin/dashboard`

## Notes

- The project uses session-based authentication for SMS (School Management System)
- Make sure your database is properly configured before running migrations
- Check the `routes/web.php` file for all available routes

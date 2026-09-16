# Database Setup Guide

## Current Issue
The application is trying to use database sessions, but the database `sms_system` doesn't exist yet.

## Quick Fix Applied
✅ Changed session driver from `database` to `file` - the app will now work without a database.

## To Set Up Database Later

### 1. Create Database
Create a MySQL database named `sms_system` (or update `.env` with your preferred name).

### 2. Update .env File
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sms_system
DB_USERNAME=root
DB_PASSWORD=your_password

SESSION_DRIVER=database  # Change back to database if you want database sessions
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Seed Database (Optional)
```bash
php artisan db:seed
```

### 5. Create Sessions Table (if using database sessions)
```bash
php artisan session:table
php artisan migrate
```

## Current Configuration
- **Session Driver**: `file` (works without database)
- **Cache Driver**: `database` (will need database for cache)
- **Queue Driver**: `database` (will need database for queues)

For now, the app should work with file-based sessions. You can set up the database when ready!

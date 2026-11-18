# Joram Rusiana Personal Portfolio

A PHP and MySQL portfolio with a public website and authenticated admin dashboard.

## Requirements

- PHP 8.0 or later with PDO MySQL enabled
- MySQL 5.7 or later
- Apache or another web server with PHP support

## Database setup

1. Create a MySQL database and database user.
2. Import `database/portfolio.sql`.
3. Set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` in the PHP hosting environment.
4. Create an administrator row in `admin_users` using a PHP `password_hash()` password hash.

## Administrator features

- Profile management
- Project CRUD and image uploads
- Skill CRUD
- Education CRUD
- Experience CRUD
- Achievement CRUD
- Contact message inbox
- Website settings

## Upload security

Images are restricted to verified JPG, PNG, and WEBP files, and project uploads are also limited to GIF. Files are renamed with random hexadecimal names and saved outside public script execution areas where `.htaccess` protection is supported.

## Development

The static HTML pages are retained as legacy assets. PHP pages provide the database-backed public site, and the admin area is available under `/admin/login.php`.

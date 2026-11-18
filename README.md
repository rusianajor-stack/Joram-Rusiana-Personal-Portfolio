# Joram Rusiana Personal Portfolio

A PHP and MySQL portfolio with a public website and authenticated admin dashboard.

## Requirements

- PHP 8.0 or later with PDO MySQL enabled
- MySQL 5.7 or later
- Apache or another web server with PHP support

## Database setup

1. Create a MySQL database and a database user with access to it.
2. Import `database/portfolio.sql` into that database.
3. Set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` in the PHP hosting environment. Do not commit credentials.
4. Create an administrator row in `admin_users` using a PHP `password_hash()` password hash.

### Existing installations

For installations created before the Education, Experience, Achievements, and website settings modules were added, import:

```text
database/migrations/2026-11-18-portfolio-modules.sql
```

The migration uses `CREATE TABLE IF NOT EXISTS` and does not replace existing data.

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

The existing HTML pages and assets are retained as legacy assets. PHP pages provide the database-backed public site, and the admin area is available under `/admin/login.php`.

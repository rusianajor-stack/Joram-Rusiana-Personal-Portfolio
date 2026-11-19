# Joram Rusiana Personal Portfolio

Dynamic PHP/MySQL personal portfolio with an authenticated administrator dashboard.

## Features

- Database-driven profile, skills, projects, education, experience, achievements, and contact messages
- Complete public portfolio pages and responsive light/dark interface
- Admin authentication with password hashing, session protection, inactivity logout, and login lockout
- CSRF protection, prepared statements, output escaping, server-side validation, and spam protection
- Secure JPG, PNG, WEBP, GIF, and PDF certificate/project/profile uploads
- Website title, accent color, and logo settings

## Requirements

- PHP 8.0 or later with PDO MySQL enabled
- MySQL 5.7 or later
- A web server configured to run PHP

## Database setup

1. Create a MySQL database and database user.
2. Import `database/portfolio.sql`.
3. Configure `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` using server environment variables, or copy `includes/config.local.php.example` to `includes/config.local.php` and enter the values locally. Do not commit `config.local.php`.

## InfinityFree setup

1. Upload the project files through the InfinityFree File Manager or FTP, retaining the existing folder structure.
2. Create a MySQL database from the InfinityFree control panel.
3. Copy `includes/config.local.php.example` to `includes/config.local.php` and use the InfinityFree database hostname, database name, username, and password.
4. Set `ADMIN_SETUP_KEY` to a unique private random string of at least 24 characters.
5. Import `database/portfolio.sql` with phpMyAdmin.
6. Open `/admin/setup.php`, enter the setup key, and create the first administrator account.
7. After setup succeeds, remove `ADMIN_SETUP_KEY` from `includes/config.local.php` and delete `admin/setup.php`.
8. Keep PHP execution disabled in `uploads/` using the included `.htaccess` file.
9. Point the hosting document root to the repository directory or upload this directory as the website root.
10. Sign in at `/admin/login.php`.

## Administrator setup

No password is included in the SQL export. After import, create the administrator from a local PHP/CLI environment:

```bash
php database/create_admin.php admin@example.com "replace-with-a-long-private-password"
```

Then sign in at `/admin/login.php`. Record the production password privately and do not commit or publish it.

## Security

- Never commit database credentials or administrator passwords.
- Use HTTPS for login and administration pages.
- Keep `includes/config.local.php` excluded from Git.
- Limit the administrator account and hosting permissions to trusted users.

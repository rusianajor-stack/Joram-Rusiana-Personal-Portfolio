# Joram Rusiana Personal Portfolio

This repository is being upgraded from the existing static portfolio into a PHP and MySQL website. The current milestone adds the database structure and a PDO connection that reads credentials from server environment variables.

## Requirements

- PHP 8.0 or later with PDO MySQL enabled
- MySQL 5.7 or later
- A web server configured to run PHP

## Database setup

1. Create a MySQL database and a database user with access to it.
2. Import `database/portfolio.sql` into that database.
3. Set `DB_HOST`, `DB_NAME`, `DB_USER`, and `DB_PASSWORD` in the PHP hosting environment. Do not commit credentials.
4. The connection is available from `includes/db.php` as `$pdo`.

No administrator account is included in the SQL file. An administrator should be created through a password-hashing setup step before the dashboard is enabled.

## Development

The existing HTML portfolio pages and assets are retained while the PHP features are added in small, meaningful development steps. The deployed site needs PHP/MySQL hosting to run the final version.

-- Add portfolio modules missing from installations created before 2026-11-18.
-- Safe for MySQL 5.7+ and MariaDB. Import once after database/portfolio.sql.

CREATE TABLE IF NOT EXISTS education (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    institution VARCHAR(180) NOT NULL,
    qualification VARCHAR(180) NOT NULL,
    details TEXT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS experience (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    organization VARCHAR(180) NOT NULL DEFAULT '',
    details TEXT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    organization VARCHAR(180) NOT NULL DEFAULT '',
    details TEXT NULL,
    image_path VARCHAR(255) NOT NULL DEFAULT '',
    achievement_date DATE NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS website_settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS login_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL,
    ip_address VARCHAR(45) NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX login_attempt_window (email, ip_address, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO website_settings (setting_key, setting_value)
VALUES
    ('site_title', 'Joram Rusiana — Personal Portfolio'),
    ('footer_text', '© 2026 Joram Rusiana. All Rights Reserved.'),
    ('resume_download_url', '')
ON DUPLICATE KEY UPDATE setting_key = setting_key;

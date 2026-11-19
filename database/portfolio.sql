CREATE TABLE IF NOT EXISTS admin_users (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    failed_attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    locked_until DATETIME NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS profile (
    id TINYINT UNSIGNED PRIMARY KEY,
    full_name VARCHAR(150) NOT NULL,
    headline VARCHAR(200) NOT NULL DEFAULT '',
    introduction TEXT NOT NULL,
    biography TEXT NOT NULL,
    email VARCHAR(190) NOT NULL DEFAULT '',
    phone VARCHAR(50) NOT NULL DEFAULT '',
    location VARCHAR(150) NOT NULL DEFAULT '',
    profile_image VARCHAR(255) NOT NULL DEFAULT '',
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS skills (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    category VARCHAR(120) NOT NULL DEFAULT '',
    description TEXT NOT NULL,
    level_label VARCHAR(50) NOT NULL DEFAULT '',
    level_percent TINYINT UNSIGNED NOT NULL DEFAULT 0,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS projects (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    description TEXT NOT NULL,
    technologies VARCHAR(500) NOT NULL DEFAULT '',
    image_path VARCHAR(255) NOT NULL DEFAULT '',
    project_url VARCHAR(500) NOT NULL DEFAULT '',
    is_visible TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS education (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    institution VARCHAR(180) NOT NULL,
    qualification VARCHAR(180) NOT NULL,
    details TEXT NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS experience (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    organization VARCHAR(180) NOT NULL DEFAULT '',
    details TEXT NOT NULL,
    start_date DATE NULL,
    end_date DATE NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS achievements (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    organization VARCHAR(180) NOT NULL DEFAULT '',
    details TEXT NOT NULL,
    image_path VARCHAR(255) NOT NULL DEFAULT '',
    achievement_date DATE NULL,
    sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_messages (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(120) NOT NULL,
    email VARCHAR(190) NOT NULL,
    subject VARCHAR(180) NOT NULL,
    message TEXT NOT NULL,
    is_read TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS website_settings (
    setting_key VARCHAR(100) PRIMARY KEY,
    setting_value TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS login_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(190) NOT NULL,
    ip_address VARCHAR(45) NOT NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX login_attempt_window (email, ip_address, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS contact_attempts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    attempted_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX contact_attempt_window (ip_address, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO profile (id, full_name, headline, introduction, biography)
VALUES (
    1,
    'Joram Rusiana',
    'BSIT Student',
    'I am interested in web development, animation, and technology. Welcome to my personal portfolio.',
    'I am a Bachelor of Science in Information Technology student at Negros Oriental State University. I enjoy learning new skills and working on creative digital projects.'
)
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO website_settings (setting_key, setting_value)
VALUES
('site_title', 'Joram Rusiana — Personal Portfolio'),
('accent_color', '#ff7a00'),
('site_logo', '')
ON DUPLICATE KEY UPDATE setting_key = setting_key;

INSERT INTO education (institution, qualification, details, start_date, end_date, sort_order) VALUES
('Negros Oriental State University – Bayawan–Sta. Catalina Campus', 'Bachelor of Science in Information Technology (BSIT)', 'Currently pursuing a Bachelor of Science in Information Technology.', '2024-08-01', NULL, 1),
('Basay National High School', 'Secondary Education', 'Completed secondary education.', '2018-06-01', '2024-04-30', 2);

INSERT INTO experience (title, organization, details, start_date, end_date, sort_order) VALUES
('ITS 300 — Web Development Coursework', 'Negros Oriental State University', 'Built portfolio and web development projects using HTML, CSS, JavaScript, PHP, and MySQL.', '2024-08-01', NULL, 1),
('Database Management Coursework', 'Negros Oriental State University', 'Practiced database design and SQL queries as part of the BSIT curriculum.', '2024-08-01', NULL, 2),
('Adobe Animate Workshops', 'Negros Oriental State University', 'Practiced squash-and-stretch, slow-in/slow-out, motion paths, and animation projects.', '2024-08-01', NULL, 3);

INSERT INTO skills (name, category, description, level_label, level_percent, sort_order) VALUES
('HTML & CSS', 'Web Development', 'Building structured, styled web pages with clean layouts and responsive designs.', 'Proficient', 70, 1),
('C++', 'Programming', 'Applied for high-performance programming, problem-solving, and efficient memory management.', 'Proficient', 70, 2),
('SQL / MySQL', 'Database', 'Organizing, querying, and handling data retrieval for databases.', 'Intermediate', 50, 3),
('Java', 'Programming', 'Fundamental knowledge of object-oriented programming concepts.', 'Basic', 35, 4),
('JavaScript', 'Web Development', 'Adding interactivity and dynamic behavior to web pages.', 'Beginner', 30, 5),
('Adobe Animate', 'Animation', 'Creating digital animations, interactive content, and multimedia advertisements.', 'Proficient', 70, 6),
('Git & GitHub', 'Tools', 'Version control and hosting projects.', 'Intermediate', 50, 7)
ON DUPLICATE KEY UPDATE name = name;

INSERT INTO projects (title, description, technologies, image_path, sort_order) VALUES
('Electronic Vehicular Incident Report System', 'A web-based system for reporting vehicular incidents, with photo uploads, location information, report verification, maps, and an admin dashboard.', 'HTML, CSS, JavaScript, MySQL', 'images/project-evirs.svg', 1),
('Animation Projects', 'Animation activities made with Adobe Animate, including Squash and Stretch and Slow In / Slow Out.', 'Adobe Animate, ActionScript', 'images/project-animation.svg', 2),
('Personal Website', 'A desktop-linked web application for managing barangay records, including document requests, blotter entries, announcements, and reports.', 'HTML, CSS', 'images/project-website.jpg', 3),
('FOKUS Cold Brew Energy', 'A short animated advertisement made in Adobe Animate, using motion tweens and timing to promote a sample product.', 'Adobe Animate, ActionScript', 'images/project-ad-animation.svg', 4);

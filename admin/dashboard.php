<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login();

$counts = [
    'Projects' => (int) $pdo->query('SELECT COUNT(*) FROM projects')->fetchColumn(),
    'Skills' => (int) $pdo->query('SELECT COUNT(*) FROM skills')->fetchColumn(),
    'Messages' => (int) $pdo->query('SELECT COUNT(*) FROM contact_messages')->fetchColumn(),
    'Experience' => (int) $pdo->query('SELECT COUNT(*) FROM experience')->fetchColumn(),
    'Education' => (int) $pdo->query('SELECT COUNT(*) FROM education')->fetchColumn(),
    'Achievements' => (int) $pdo->query('SELECT COUNT(*) FROM achievements')->fetchColumn(),
];

$unreadMessages = (int) $pdo->query('SELECT COUNT(*) FROM contact_messages WHERE is_read = 0')->fetchColumn();
$adminEmail = escape_html($_SESSION['admin_email'] ?? 'Administrator');
$token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
<header class="admin-header">
    <a class="admin-brand" href="dashboard.php">Portfolio Admin</a>
    <div class="admin-account">
        <span><?php echo $adminEmail; ?></span>
        <form method="post" action="logout.php">
            <input type="hidden" name="csrf_token" value="<?php echo escape_html($token); ?>">
            <button type="submit" class="admin-button admin-button-light">Log out</button>
        </form>
    </div>
</header>
<main class="admin-main">
    <div class="admin-page-title">
        <div>
            <p class="admin-eyebrow">Overview</p>
            <h1>Dashboard</h1>
            <p>Welcome back. Here is a summary of your portfolio content.</p>
        </div>
        <a class="admin-button" href="../index.php" target="_blank" rel="noopener noreferrer">View website</a>
    </div>
    <section class="admin-stats" aria-label="Portfolio statistics">
        <?php foreach ($counts as $label => $count): ?>
            <article class="admin-stat-card"><p><?php echo escape_html($label); ?></p><strong><?php echo $count; ?></strong></article>
        <?php endforeach; ?>
    </section>
    <section class="admin-notice">
        <div><h2>Messages to review</h2><p><?php echo $unreadMessages; ?> unread message<?php echo $unreadMessages === 1 ? '' : 's'; ?>.</p></div>
    </section>
    <nav class="admin-shortcuts" aria-label="Content management">
        <h2>Content management</h2>
        <div class="admin-shortcut-list">
            <a class="admin-button" href="profile.php">Manage profile</a>
            <a class="admin-button" href="projects.php">Manage projects</a>
            <a class="admin-button" href="skills.php">Manage skills</a>
            <a class="admin-button" href="education.php">Manage education</a>
            <a class="admin-button" href="experience.php">Manage experience</a>
            <a class="admin-button" href="achievements.php">Manage achievements</a>
            <a class="admin-button" href="messages.php">Manage messages</a>
            <a class="admin-button" href="settings.php">Website settings</a>
        </div>
    </nav>
</main>
</body>
</html>

<?php

require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';

require_login();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid($_POST['csrf_token'] ?? null)) {
        $error = 'Your form session has expired. Please try again.';
    } else {
        $allowed = [
            'site_title' => 200,
            'footer_text' => 500,
            'resume_download_url' => 500,
        ];

        try {
            $statement = $pdo->prepare('INSERT INTO website_settings (setting_key, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)');
            foreach ($allowed as $key => $limit) {
                $value = trim($_POST[$key] ?? '');
                if (strlen($value) > $limit) {
                    throw new RuntimeException("The {$key} setting is too long.");
                }
                if ($key === 'resume_download_url' && $value !== '' && !filter_var($value, FILTER_VALIDATE_URL)) {
                    throw new RuntimeException('Enter a valid resume download URL.');
                }
                $statement->execute([$key, $value]);
            }
            $success = 'Website settings updated.';
        } catch (RuntimeException $exception) {
            $error = $exception->getMessage();
        }
    }
}

$settings = [];
foreach ($pdo->query('SELECT setting_key, setting_value FROM website_settings') as $row) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
$token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Settings</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body class="admin-body">
<header class="admin-header"><a class="admin-brand" href="dashboard.php">Portfolio Admin</a><div class="admin-account"><a href="dashboard.php">Dashboard</a></div></header>
<main class="admin-main">
    <div class="admin-page-title"><div><p class="admin-eyebrow">Configuration</p><h1>Website Settings</h1></div></div>
    <?php if ($error !== ''): ?><p class="admin-error" role="alert"><?php echo escape_html($error); ?></p><?php endif; ?>
    <?php if ($success !== ''): ?><p class="admin-success" role="status"><?php echo escape_html($success); ?></p><?php endif; ?>

    <section class="admin-form-card">
        <form method="post">
            <input type="hidden" name="csrf_token" value="<?php echo escape_html($token); ?>">
            <label>Site title
                <input type="text" name="site_title" maxlength="200" value="<?php echo escape_html($settings['site_title'] ?? 'Joram Rusiana — Personal Portfolio'); ?>">
            </label>
            <label>Footer text
                <textarea name="footer_text" maxlength="500" rows="3"><?php echo escape_html($settings['footer_text'] ?? ''); ?></textarea>
            </label>
            <label>Resume download URL
                <input type="url" name="resume_download_url" maxlength="500" value="<?php echo escape_html($settings['resume_download_url'] ?? ''); ?>">
            </label>
            <button type="submit" class="admin-button">Save settings</button>
        </form>
    </section>
</main>
</body>
</html>

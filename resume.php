<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

try {
    $profileStatement = $pdo->prepare('SELECT full_name, headline, email, phone, location FROM profile WHERE id = 1');
    $profileStatement->execute();
    $profile = $profileStatement->fetch();

    $education = $pdo->query('SELECT * FROM education ORDER BY sort_order ASC, COALESCE(end_date, start_date) DESC, id DESC')->fetchAll();
    $experience = $pdo->query('SELECT * FROM experience ORDER BY sort_order ASC, COALESCE(end_date, start_date) DESC, id DESC')->fetchAll();
    $achievements = $pdo->query('SELECT * FROM achievements ORDER BY sort_order ASC, achievement_date DESC, id DESC')->fetchAll();

    $settingsStatement = $pdo->query("SELECT setting_key, setting_value FROM website_settings WHERE setting_key IN ('resume_download_url', 'footer_text', 'site_title')");
    $settings = [];
    foreach ($settingsStatement as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
} catch (PDOException $error) {
    error_log($error->getMessage());
    $profile = false;
    $education = [];
    $experience = [];
    $achievements = [];
    $settings = [];
}

if (!$profile) {
    $profile = ['full_name' => 'Joram Rusiana', 'headline' => 'BSIT Student', 'email' => 'rusianajor@gmail.com', 'phone' => '', 'location' => 'Negros Oriental, Philippines'];
}

function format_resume_date(?string $date): string
{
    if (!$date) {
        return '';
    }

    $timestamp = strtotime($date);
    return $timestamp ? date('F Y', $timestamp) : '';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Resume — <?php echo escape_html($profile['full_name']); ?></title>
<link rel="stylesheet" href="css/style.css">
<script>
  (function () {
    var savedTheme = localStorage.getItem('portfolio-theme');
    if (savedTheme === 'dark') document.documentElement.setAttribute('data-theme', 'dark');
  })();
</script>
</head>
<body>
<header>
  <div class="nav-inner wrap">
    <a href="index.php" class="logo"><?php echo escape_html($profile['full_name']); ?></a>
    <nav id="main-nav">
      <ul>
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="about.php" class="nav-link">About</a></li>
        <li><a href="skills.php" class="nav-link">Skills</a></li>
        <li><a href="projects.php" class="nav-link">Projects</a></li>
        <li><a href="resume.php" class="nav-link active">Resume</a></li>
        <li><a href="contact.php" class="nav-link">Contact</a></li>
      </ul>
    </nav>
    <div class="nav-controls">
      <button id="theme-toggle" aria-label="Toggle dark mode">Dark</button>
      <button id="nav-toggle" aria-label="Toggle menu" aria-expanded="false">Menu</button>
    </div>
  </div>
</header>
<main>
  <div class="wrap page-header">
    <h1>Resume</h1>
    <p><?php echo escape_html($profile['headline']); ?></p>
  </div>
  <section id="resume">
    <div class="wrap">
      <h2><?php echo escape_html($profile['full_name']); ?></h2>
      <?php if (!empty($profile['email'])): ?><p>Email: <a href="mailto:<?php echo escape_html($profile['email']); ?>"><?php echo escape_html($profile['email']); ?></a></p><?php endif; ?>
      <?php if (!empty($profile['phone'])): ?><p>Phone: <?php echo escape_html($profile['phone']); ?></p><?php endif; ?>
      <?php if (!empty($profile['location'])): ?><p>Location: <?php echo escape_html($profile['location']); ?></p><?php endif; ?>

      <?php if (!empty($settings['resume_download_url'])): ?>
        <p><a class="button" href="<?php echo escape_html($settings['resume_download_url']); ?>" target="_blank" rel="noopener noreferrer">Download Resume</a></p>
      <?php endif; ?>

      <?php if ($education): ?>
        <h2>Education</h2>
        <?php foreach ($education as $item): ?>
          <article class="resume-entry">
            <h3><?php echo escape_html($item['qualification']); ?></h3>
            <p><strong><?php echo escape_html($item['institution']); ?></strong></p>
            <?php if (!empty($item['start_date']) || !empty($item['end_date'])): ?>
              <p><?php echo escape_html(format_resume_date($item['start_date'])); ?> — <?php echo escape_html(format_resume_date($item['end_date']) ?: 'Present'); ?></p>
            <?php endif; ?>
            <?php if (!empty($item['details'])): ?><p><?php echo nl2br(escape_html($item['details'])); ?></p><?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if ($experience): ?>
        <h2>Experience</h2>
        <?php foreach ($experience as $item): ?>
          <article class="resume-entry">
            <h3><?php echo escape_html($item['title']); ?></h3>
            <?php if (!empty($item['organization'])): ?><p><strong><?php echo escape_html($item['organization']); ?></strong></p><?php endif; ?>
            <?php if (!empty($item['start_date']) || !empty($item['end_date'])): ?>
              <p><?php echo escape_html(format_resume_date($item['start_date'])); ?> — <?php echo escape_html(format_resume_date($item['end_date']) ?: 'Present'); ?></p>
            <?php endif; ?>
            <?php if (!empty($item['details'])): ?><p><?php echo nl2br(escape_html($item['details'])); ?></p><?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>

      <?php if ($achievements): ?>
        <h2>Achievements</h2>
        <?php foreach ($achievements as $item): ?>
          <article class="resume-entry">
            <h3><?php echo escape_html($item['title']); ?></h3>
            <?php if (!empty($item['organization'])): ?><p><strong><?php echo escape_html($item['organization']); ?></strong></p><?php endif; ?>
            <?php if (!empty($item['achievement_date'])): ?><p><?php echo escape_html(format_resume_date($item['achievement_date'])); ?></p><?php endif; ?>
            <?php if (!empty($item['details'])): ?><p><?php echo nl2br(escape_html($item['details'])); ?></p><?php endif; ?>
            <?php if (!empty($item['image_path'])): ?><p><img src="<?php echo escape_html($item['image_path']); ?>" alt="<?php echo escape_html($item['title']); ?>" style="max-width:240px;height:auto;"></p><?php endif; ?>
          </article>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </section>
</main>
<footer>
  <div class="wrap footer-inner">
    <p><?php echo escape_html($settings['footer_text'] ?? ('&copy; 2026 ' . $profile['full_name'] . '. All Rights Reserved.')); ?></p>
  </div>
</footer>
<button id="scroll-top-btn" aria-label="Scroll to top">&uarr;</button>
<script src="js/script.js"></script>
</body>
</html>

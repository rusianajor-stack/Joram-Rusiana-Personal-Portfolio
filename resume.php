<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

try {
    $profileStatement = $pdo->prepare('SELECT full_name, headline, email, phone, location FROM profile WHERE id = 1');
    $profileStatement->execute();
    $profile = $profileStatement->fetch();
} catch (PDOException $error) {
    error_log($error->getMessage());
    $profile = false;
}

if (!$profile) {
    $profile = ['full_name' => 'Joram Rusiana', 'headline' => 'BSIT Student', 'email' => 'rusianajor@gmail.com', 'phone' => '', 'location' => 'Negros Oriental, Philippines'];
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
    </div>
  </section>
</main>
<footer>
  <div class="wrap footer-inner">
    <p>&copy; 2026 <?php echo escape_html($profile['full_name']); ?>. All Rights Reserved.</p>
  </div>
</footer>
<button id="scroll-top-btn" aria-label="Scroll to top">&uarr;</button>
<script src="js/script.js"></script>
</body>
</html>

<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

try {
    $profileStatement = $pdo->prepare('SELECT * FROM profile WHERE id = 1');
    $profileStatement->execute();
    $profile = $profileStatement->fetch();
} catch (PDOException $error) {
    error_log($error->getMessage());
    $profile = false;
}

if (!$profile) {
    $profile = [
        'full_name' => 'Joram Rusiana',
        'headline' => 'BSIT Student',
        'introduction' => 'Welcome to my portfolio.',
        'biography' => 'I am a BSIT student passionate about web development.',
        'email' => 'rusianajor@gmail.com',
        'phone' => '',
        'location' => 'Negros Oriental, Philippines',
        'profile_image' => 'images/profile.jpg',
    ];
}

$profileImage = !empty($profile['profile_image']) ? $profile['profile_image'] : 'images/profile.jpg';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>About — <?php echo escape_html($profile['full_name']); ?></title>
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
        <li><a href="about.php" class="nav-link active">About</a></li>
        <li><a href="skills.php" class="nav-link">Skills</a></li>
        <li><a href="projects.php" class="nav-link">Projects</a></li>
        <li><a href="resume.php" class="nav-link">Resume</a></li>
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
    <h1>About Me</h1>
  </div>
  <section id="about">
    <div class="wrap about-grid">
      <div class="about-image">
        <img src="<?php echo escape_html($profileImage); ?>" alt="Portrait of <?php echo escape_html($profile['full_name']); ?>">
      </div>
      <div class="about-text">
        <h2><?php echo escape_html($profile['headline']); ?></h2>
        <p><?php echo nl2br(escape_html($profile['introduction'])); ?></p>
        <p><?php echo nl2br(escape_html($profile['biography'])); ?></p>
        <?php if (!empty($profile['location'])): ?><p><strong>Location:</strong> <?php echo escape_html($profile['location']); ?></p><?php endif; ?>
        <?php if (!empty($profile['email'])): ?><p><strong>Email:</strong> <a href="mailto:<?php echo escape_html($profile['email']); ?>"><?php echo escape_html($profile['email']); ?></a></p><?php endif; ?>
      </div>
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

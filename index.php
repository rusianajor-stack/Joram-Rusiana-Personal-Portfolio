<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

try {
    $statement = $pdo->prepare('SELECT * FROM profile WHERE id = 1');
    $statement->execute();
    $profile = $statement->fetch();
} catch (PDOException $error) {
    error_log($error->getMessage());
    $profile = false;
}

if (!$profile) {
    $profile = [
        'full_name' => 'Joram Rusiana',
        'headline' => 'BSIT Student & Aspiring Software Engineer',
        'introduction' => 'Welcome to my personal portfolio.',
        'biography' => 'I am a BSIT student passionate about building useful and accessible web applications.',
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
<title><?php echo escape_html($profile['full_name']); ?> — Personal Portfolio</title>
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
        <li><a href="index.php" class="nav-link active">Home</a></li>
        <li><a href="about.php" class="nav-link">About</a></li>
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
  <section class="hero">
    <div class="wrap hero-grid">
      <div class="hero-content">
        <p class="hero-eyebrow">Welcome to my portfolio</p>
        <h1><?php echo escape_html($profile['full_name']); ?></h1>
        <h2><span id="typing-role"></span></h2>
        <p><?php echo nl2br(escape_html($profile['introduction'])); ?></p>
        <div class="hero-actions">
          <a href="projects.php" class="btn">View My Projects</a>
          <a href="contact.php" class="btn">Contact Me</a>
        </div>
      </div>
      <div class="hero-image">
        <img src="<?php echo escape_html($profileImage); ?>" alt="Portrait of <?php echo escape_html($profile['full_name']); ?>">
      </div>
    </div>
  </section>
</main>
<footer>
  <div class="wrap footer-inner">
    <p>&copy; 2026 <?php echo escape_html($profile['full_name']); ?>. All Rights Reserved.</p>
    <ul class="social-links">
      <li><a href="contact.php">Facebook</a></li>
      <li><a href="contact.php">Instagram</a></li>
      <li><a href="contact.php">LinkedIn</a></li>
    </ul>
  </div>
</footer>
<button id="scroll-top-btn" aria-label="Scroll to top">&uarr;</button>
<script src="js/script.js"></script>
</body>
</html>

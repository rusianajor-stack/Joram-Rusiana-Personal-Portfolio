<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

try {
    $skills = $pdo->query(
        'SELECT name, category, description, level_label, level_percent
         FROM skills
         ORDER BY sort_order ASC, id DESC'
    )->fetchAll();
} catch (PDOException $error) {
    error_log($error->getMessage());
    $skills = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Skills — Joram Rusiana</title>
<link rel="stylesheet" href="css/style.css">
<script>
  (function () {
    var savedTheme = localStorage.getItem("portfolio-theme");
    if (savedTheme === "dark") document.documentElement.setAttribute("data-theme", "dark");
  })();
</script>
</head>
<body>
<header>
  <div class="nav-inner wrap">
    <a href="index.html" class="logo">Joram Rusiana</a>
    <nav id="main-nav">
      <ul>
        <li><a href="index.html" class="nav-link">Home</a></li>
        <li><a href="about.html" class="nav-link">About</a></li>
        <li><a href="skills.php" class="nav-link active">Skills</a></li>
        <li><a href="projects.php" class="nav-link">Projects</a></li>
        <li><a href="resume.html" class="nav-link">Resume</a></li>
        <li><a href="contact.html" class="nav-link">Contact</a></li>
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
    <h1>My Skills</h1>
    <p>A mix of technical and non-technical skills I've been building as a BSIT student.</p>
  </div>
  <section id="skills">
    <div class="wrap">
      <?php if (count($skills) === 0): ?>
        <p>No skills are currently available.</p>
      <?php else: ?>
        <div class="skills-grid">
          <?php foreach ($skills as $skill): ?>
            <article class="skill-card">
              <h3><?php echo escape_html($skill['name']); ?></h3>
              <?php if (!empty($skill['description'])): ?><p><?php echo nl2br(escape_html($skill['description'])); ?></p><?php endif; ?>
              <?php if (!empty($skill['level_label']) || (int) $skill['level_percent'] > 0): ?>
                <div class="skill-level-bar">
                  <div class="bar-label">
                    <span><?php echo escape_html($skill['level_label']); ?></span>
                    <span><?php echo (int) $skill['level_percent']; ?>%</span>
                  </div>
                  <div class="progress-track"><div class="progress-fill" style="width: <?php echo (int) $skill['level_percent']; ?>%;"></div></div>
                </div>
              <?php endif; ?>
            </article>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </section>
</main>
<footer>
  <div class="wrap footer-inner">
    <p>&copy; 2026 Joram Rusiana. All Rights Reserved.</p>
    <ul class="social-links">
      <li><a href="contact.html">Facebook</a></li>
      <li><a href="contact.html">Instagram</a></li>
      <li><a href="contact.html">LinkedIn</a></li>
    </ul>
  </div>
</footer>
<button id="scroll-top-btn" aria-label="Scroll to top">&uarr;</button>
<script src="js/script.js"></script>
</body>
</html>

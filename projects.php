<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

try {
    $projects = $pdo->query(
        'SELECT title, description, technologies, image_path, project_url
         FROM projects
         WHERE is_visible = 1
         ORDER BY sort_order ASC, id DESC'
    )->fetchAll();
} catch (PDOException $error) {
    error_log($error->getMessage());
    $projects = [];
}

function project_image(?string $path): string
{
    $path = trim($path ?? '');
    return $path !== '' ? $path : 'images/project-placeholder.svg';
}

function project_technologies(?string $technologies): array
{
    $items = array_map('trim', explode(',', $technologies ?? ''));
    return array_values(array_filter($items, static fn ($item) => $item !== ''));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Projects — Joram Rusiana</title>
<link rel="stylesheet" href="css/style.css">
<script>
  (function () {
    var savedTheme = localStorage.getItem("portfolio-theme");
    if (savedTheme === "dark") {
      document.documentElement.setAttribute("data-theme", "dark");
    }
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
        <li><a href="skills.html" class="nav-link">Skills</a></li>
        <li><a href="projects.php" class="nav-link active">Projects</a></li>
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
    <h1>My Projects</h1>
    <p>A few things I've built.</p>
  </div>

  <section id="projects">
    <div class="wrap">
      <?php if (count($projects) === 0): ?>
        <p>No projects are currently available.</p>
      <?php else: ?>
        <div class="projects-grid">
          <?php foreach ($projects as $project): ?>
            <article class="project-card">
              <figure>
                <img src="<?php echo escape_html(project_image($project['image_path'])); ?>"
                     alt="<?php echo escape_html($project['title']); ?> project">
                <figcaption>
                  <h3><?php echo escape_html($project['title']); ?></h3>
                  <p><?php echo nl2br(escape_html($project['description'])); ?></p>
                  <?php if (!empty($project['project_url'])): ?>
                    <p><a href="<?php echo escape_html($project['project_url']); ?>" target="_blank" rel="noopener noreferrer">View Project</a></p>
                  <?php endif; ?>
                  <?php $technologies = project_technologies($project['technologies']); ?>
                  <?php if (count($technologies) > 0): ?>
                    <ul class="tech-tags">
                      <?php foreach ($technologies as $technology): ?>
                        <li><?php echo escape_html($technology); ?></li>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </figcaption>
              </figure>
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

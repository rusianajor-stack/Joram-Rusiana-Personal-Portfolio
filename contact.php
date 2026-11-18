<?php

require_once __DIR__ . '/includes/security.php';
require_once __DIR__ . '/includes/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!csrf_is_valid($_POST['csrf_token'] ?? null)) {
        $error = 'Your form session has expired. Please try again.';
    } else {
        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (strlen($name) < 2 || strlen($name) > 120) {
            $error = 'Please enter a valid name.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 190) {
            $error = 'Please enter a valid email address.';
        } elseif (strlen($subject) > 180) {
            $error = 'The subject is too long.';
        } elseif (strlen($message) < 10 || strlen($message) > 5000) {
            $error = 'Please enter a message between 10 and 5000 characters.';
        } else {
            $statement = $pdo->prepare('INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)');
            $statement->execute([$name, $email, $subject !== '' ? $subject : 'No subject', $message]);
            $success = 'Thanks! Your message was sent successfully.';
        }
    }
}

$token = csrf_token();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Contact — Joram Rusiana</title>
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
    <a href="index.php" class="logo">Joram Rusiana</a>
    <nav id="main-nav">
      <ul>
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="about.php" class="nav-link">About</a></li>
        <li><a href="skills.php" class="nav-link">Skills</a></li>
        <li><a href="projects.php" class="nav-link">Projects</a></li>
        <li><a href="resume.php" class="nav-link">Resume</a></li>
        <li><a href="contact.php" class="nav-link active">Contact</a></li>
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
    <h1>Contact Me</h1>
    <p>Feel free to reach out — I'd love to hear from you.</p>
  </div>
  <section id="contact">
    <div class="wrap contact-grid">
      <div class="contact-info">
        <p><strong>Name:</strong> Joram Rusiana</p>
        <p><strong>Email:</strong> <a href="mailto:rusianajor@gmail.com">rusianajor@gmail.com</a></p>
        <p><strong>Location:</strong> Negros Oriental, Philippines</p>
      </div>
      <form id="contact-form" method="post" action="contact.php" novalidate>
        <input type="hidden" name="csrf_token" value="<?php echo escape_html($token); ?>">
        <?php if ($error !== ''): ?><div class="admin-error" role="alert"><?php echo escape_html($error); ?></div><?php endif; ?>
        <?php if ($success !== ''): ?><div id="form-success" class="admin-success show" role="status"><?php echo escape_html($success); ?></div><?php endif; ?>
        <div class="field"><label for="name">Name</label><input type="text" id="name" name="name" maxlength="120" minlength="2" required value="<?php echo escape_html($success === '' ? ($name ?? '') : ''); ?>"><span class="error-text" id="name-error"></span></div>
        <div class="field"><label for="email">Email</label><input type="email" id="email" name="email" maxlength="190" required value="<?php echo escape_html($success === '' ? ($email ?? '') : ''); ?>"><span class="error-text" id="email-error"></span></div>
        <div class="field"><label for="subject">Subject</label><input type="text" id="subject" name="subject" maxlength="180" value="<?php echo escape_html($success === '' ? ($subject ?? '') : ''); ?>"></div>
        <div class="field"><label for="message">Message</label><textarea id="message" name="message" maxlength="5000" minlength="10" required><?php echo escape_html($success === '' ? ($message ?? '') : ''); ?></textarea><span class="error-text" id="message-error"></span></div>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </section>
</main>
<footer>
  <div class="wrap footer-inner"><p>&copy; 2026 Joram Rusiana. All Rights Reserved.</p></div>
</footer>
<button id="scroll-top-btn" aria-label="Scroll to top">&uarr;</button>
<script src="js/script.js"></script>
</body>
</html>

<?php

require_once __DIR__ . '/security.php';

function require_login(): void
{
    if (empty($_SESSION['admin_id'])) {
        header('Location: /admin/login.php');
        exit;
    }
}

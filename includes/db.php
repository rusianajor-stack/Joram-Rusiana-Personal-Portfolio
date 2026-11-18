<?php

$host = getenv('DB_HOST');
$database = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

if (!$host || !$database || !$username) {
    throw new RuntimeException('Database settings are missing. Set DB_HOST, DB_NAME, DB_USER, and DB_PASSWORD.');
}

$dsn = "mysql:host={$host};dbname={$database};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $username, $password ?: '', $options);
} catch (PDOException $error) {
    error_log($error->getMessage());
    throw new RuntimeException('Unable to connect to the database. Check the server configuration.');
}

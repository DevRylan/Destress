<?php
$path = realpath(__DIR__ . '/../destress.db');

if (!$path) {
    die("Database file not found. Ensure that destress.db is in project root.");
}

try {
    $db = new PDO('sqlite:' . $path);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Generic error to prevent leaking
    die("Database connection failed.");
}

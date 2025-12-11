<?php
session_start();
require_once __DIR__ . '/../includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: dev_login.php");
    exit;
}

$userId = $_SESSION['user_id'];

// Read POST (form)
$name   = $_POST['name'] ?? null;
$age    = $_POST['age'] ?? null;
$gender = $_POST['gender'] ?? null;
$stress = $_POST['stress_level'] ?? null;

if (!$name || !$age || !$gender) {
    $_SESSION['error'] = "Missing fields";
    header("Location: profile.php");
    exit;
}

try {
    $stmt = $db->prepare("
        UPDATE Users
        SET username = ?, age = ?, gender = ?, avg_stress = ?
        WHERE userId = ?
    ");
    $stmt->execute([$name, $age, $gender, $stress, $userId]);

    // Redirect back to profile page after successful update
    header("Location: profile.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Database update failed";
    header("Location: profile.php");
    exit;
}

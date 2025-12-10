<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION["adminId"])) {
    echo json_encode(["status" => "not_logged_in"]);
    exit;
}

$conn = new PDO("sqlite:destress.db");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$q = $conn->query("SELECT userId, username, email, created_at FROM Users");
$users = $q->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "status" => "ok",
    "admin" => $_SESSION["adminUser"],
    "users" => $users
]);
exit;
?>

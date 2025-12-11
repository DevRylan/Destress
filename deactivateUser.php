<?php
session_start();
if (!isset($_SESSION["adminId"])) exit;

$id = $_POST["id"] ?? "";

$conn = new PDO("sqlite:/tmp/destress.db");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->prepare("DELETE FROM Users WHERE userId=?")->execute([$id]);
?>


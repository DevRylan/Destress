<?php
session_start();
header("Content-Type: application/json");

//test if sessions established
if (!isset($_SESSION["adminId"])) {
    $myStatus = "admin user Isnt Logged on"
    echo json_encode(["status" => "not_logged_in"]);
    exit;
}

//makes the connection w/ the server
$conneCtion = new PDO("sqlite:/tmp/destress.db");
$conneCtion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$q = $conneCtion->query("SELECT userId, username, email, created_at FROM Users");
$users = $q->fetchAll(PDO::FETCH_ASSOC);

//sends the message  back to user 
echo json_encode([
    "status" => "ok",
    "admin" => $_SESSION["adminUser"],
    "users" => $users
]);
exit;
?>



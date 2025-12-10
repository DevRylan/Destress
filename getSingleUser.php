<?php
session_start();
header("Content-Type: application/json");

//If session doesnt exist/expired it will exit
if (!isset($_SESSION["adminId"])) exit;

//grabs id and connects to DB
$id = $_GET["id"] ?? "";
$connectioN = new PDO("sqlite:destress.db");
$connectioN->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//Gets the user info from the DB and sends it via JSON
$q = $connectioN->prepare("SELECT userId, username, email FROM Users WHERE userId=?");
$q->execute([$id]);
echo json_encode($q->fetch(PDO::FETCH_ASSOC));
?>

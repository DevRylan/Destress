<?php
session_start();
//if sessiuon doesnt exist or has expired
if (!isset($_SESSION["adminId"])) exit;

//assigns all the login variables needed for query
$id = $_POST["id"] ?? "";
$user = $_POST["username"] ?? "";
$emaill = $_POST["email"] ?? "";

//makes connection to db
$conn = new PDO("sqlite:destress.db");
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

//prepares db statement
$conn->prepare("UPDATE Users SET username=?, email=? WHERE userId=?")
     ->execute([$user, $emaill, $id]);
?>

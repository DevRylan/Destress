<?php
$db = new PDO("sqlite:/tmp/destress.db");
$username = "admin";
$passwordHash = password_hash("admin", PASSWORD_DEFAULT);

$db->prepare("INSERT INTO Admins (username, password_hash) VALUES (?, ?)")
    ->execute([$username, $passwordHash]);

echo "Admin account created";


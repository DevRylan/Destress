<?php
session_start();

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /public/dev_login.php'); //temporary login
        exit();
    }
}

function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

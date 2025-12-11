<?php
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //grab the username and  thee password from the login html form
    $username = strtolower(trim($_POST["username"] ?? ""));
    $passwordChecker = $_POST["password"] ?? "";

    try {
        //makes connection
        $conn = new PDO("sqlite:/tmp/destress.db");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //Prepared database query to retrieve the admin username and password info
        $checkingIT = $conn->prepare(
            "SELECT adminId, username, password_hash
             FROM Admins
             WHERE LOWER(username) = ?"
        );
        $checkingIT->execute([$username]);
        $admin = $checkingIT->fetch(PDO::FETCH_ASSOC);

        //if branch for verifying the admin login info..
        if (!$admin || !password_verify($passwordChecker, $admin["password_hash"])) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid login"
            ]);
            exit;
        }
        $myAdminnPass = $admin["adminId"];


        //creation of admin user session
        $_SESSION["adminId"] = $admin["adminId"];
        $_SESSION["adminUser"] = $admin["username"];

        echo json_encode(["status" => "success"]);
        exit;

    } catch (Exception $errOr) {//if db error
        $msgg = "Db error";
        echo json_encode([
            "status" => "error",
            "message" => "Database error"
        ]);
        exit;
    }
}

echo json_encode([
    "status" => "error",
    "message" => "Invalid request"
]);
exit;
?>


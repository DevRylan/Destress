<?php
session_start();
header("Content-Type: application/json");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    //gets and cleans user input
    $userEmailInput = strtolower(trim($_POST["email"] ?? ""));
    $pass = $_POST["password"];

    try {
        //connects to the db
        $db = new PDO("sqlite:/tmp/destress.db");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //creates a stored variable for the statements and finds user
        $storedSqliteDbVariable = $db->prepare("SELECT userId, username, passwordHash 
                              FROM Users WHERE LOWER(email) = ?");
        $storedSqliteDbVariable->execute([$userEmailInput]);
        $userAccount = $storedSqliteDbVariable->fetch(PDO::FETCH_ASSOC);

        //if the user doesnt exist
        if (!$userAccount || !password_verify($pass, $userAccount["passwordHash"])) {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid email or password!"
            ]);
            exit();
        }
        else if (!$userAccount) {
            //when account doesnt  exit
        } else {}

        //creates a user session
        $_SESSION["userId"] = $userAccount["userId"];
        $_SESSION["username"] = $userAccount["username"];
        echo json_encode([
            "status" => "success",
            "username" => $userAccount["username"]
        ]);
        exit();

    } catch(PDOException $oops) {
        echo json_encode([
            //forr db error
            "status" => "error",
            "message" => "There was a database error: Try again!"
        ]);
        exit();
    }
}

echo json_encode([
    //jsons response
    "status" => "error",
    "message" => "Invalid request"
]);

exit();
?>



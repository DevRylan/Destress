<?php

header("Content-Type: application/json");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //formats the users input
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $pas = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $result = "";

    try {
        //connects to db
        $db = new PDO("sqlite:/tmp/destress.db");
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        //inserts the userr into the db
        $q = "INSERT INTO Users (username,email,passwordHash) VALUES (?,?,?)";
        $st = $db->prepare($q);

        $st->execute([$username, $email, $pas]);

        $result = "ok";
        
        echo json_encode([
            "sts"=>$result,
            "m"=>"ok"
        ]);
        exit();

    } catch(PDOException $e){

        $er = $e->getMessage();

        //checks if the error message is because of unique
        if(strpos($er,"UNIQUE") !== false){
            echo json_encode([
                "status"=>"error",
                "message"=>"This user or email already used"
            ]);
            exit;
        }else{//if error is from something else
        }

        echo json_encode([//sends error message
            "status"=>"error",
            "message"=>$er
        ]);
        exit;
    }
}

echo json_encode([
    "status"=>"error",
    "message"=>"wrong"
]);
exit;
?>
<?php
?>



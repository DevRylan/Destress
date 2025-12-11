<?php
session_start();

$action = $_GET['action'] ?? '';
//If no action is specified, redirect to homepage.html with query string preserved
if($action === ''){
    $queryString = $_SERVER['QUERY_STRING'] ?? '';
    $target = 'homepage.html';
    if(!empty ($queryString)){
        $target .= '?' . $queryString;
    }
    header('Location: ' . $target);
    exit;
}

header('Content-Type: application/json');

//make sure user is logged in and is not admin.
if(!isset($_SESSION['userId'])) {
    echo json_encode([
        'status' => 'not_logged_in',
        'message' => 'User not logged in'
    ]);
    exit;   
}
//connect to the database
try {
    $db = new PDO('sqlite:/tmp/destress.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_GET['action'] ?? '';

    switch($action){
        //save stress level
        case 'save_stress':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405); 
                echo json_encode(['error' => 'Use POST with JSON body']);
                break;
            }
            //Read raw JSON sent from javascript
            $rawInput = file_get_contents('php://input');
            $data = json_decode($rawInput, true);

            $stressLevel = $data['stress_level'] ?? null;

            //Validate the stress level and must be numeri and not null, and between 0 - 10
            if ($stressLevel === null || !is_numeric($stressLevel) || $stressLevel <0 || $stressLevel >10){
                http_response_code(400);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Invalid input'
                ]);
                break;
            }

            //logged in user id from session
            $userId = $_SESSION['userId'];

            //insert into database
            $stmt = $db->prepare("
                INSERT INTO StressLevels (userId, stress_level) 
                VALUES (?, ?)
            ");

            $stmt->execute([
                $userId, 
                (int)$stressLevel
            ]);

            echo json_encode(['status' => 'ok']);
            break;

        //get stress history for loggin in user
        case 'get_stress_history':
            $userId = $_SESSION['userId'];

            //retrieve all stress logs for this user.
            $stmt = $db->prepare("
                SELECT recorded_at,
                       CAST(stress_level AS INTEGER) AS stress_level
                FROM StressLevels 
                WHERE userId = ?
                ORDER BY recorded_at ASC
            ");
            $stmt->execute([$userId]);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo json_encode($results);
            break;
    }
} catch(Exception $e) {
    //If any database error occurs, respond with error message
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error, please try again later.'
    ]);
}
?>

<?php
header('Content-Type: application/json');

try {
    $db = new PDO('sqlite:/Applications/MAMP/htdocs/Destress_app/destress.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_GET['action'] ?? '';

    switch($action){

        case 'save_stress':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                http_response_code(405); 
                echo json_encode(['error' => 'Use POST with JSON body']);
                break;
            }

            $rawInput = file_get_contents('php://input');
            $data = json_decode($rawInput, true);

            $stressLevel = $data['stress_level'] ?? null;

            if ($stressLevel === null) {
                http_response_code(400);
                echo json_encode([
                    'error' => 'Invalid input',
                ]);
                break;
            }

            $userId = 1;

            $stmt = $db->prepare("
                INSERT INTO StressLevels (userId, stress_level) 
                VALUES (?, ?)
            ");

            $stmt->execute([
                $userId, 
                (int)$stressLevel
            ]);

            echo json_encode(['ok' => true]);
            break;

        case 'get_stress_history':
            $userId = 1;

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
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
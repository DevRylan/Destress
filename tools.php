<?php
session_start();
header("Content-Type: application/json");

if (!isset($_SESSION['user_id']) && !isset($_SESSION['userId'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit();
}

$userId = $_SESSION['user_id'] ?? $_SESSION['userId'];

try {
    $db = new PDO("sqlite:destress.db");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $action = $_GET['action'] ?? 'default';

    if ($action === 'log_visit') {
        $stmt = $db->prepare("INSERT INTO StressLevels (userId, stress_level) 
                              VALUES (?, ?);
        $stmt->execute([$userId, (int)$stressLevel
            ]);

        echo json_encode([
            "status" => "success",
            "message" => "Visit logged successfully"
        ]);

    } elseif ($action === 'get_tools') {
        $tools = [
            ["title" => "Breathing", "desc" => "Calm your mind with guided breathing exercises", "icon" => "images/icons/breathing.png", "data_tool" => "breathing"],
            ["title" => "Exercise", "desc" => "Move your body to release tension and boost mood", "icon" => "images/icons/exercise.png", "data_tool" => "exercise"],
            ["title" => "Meditation", "desc" => "Find peace with short mindfulness sessions", "icon" => "images/icons/meditation.png", "data_tool" => "meditation"],
            ["title" => "Journaling", "desc" => "Write down thoughts to process emotions", "icon" => "images/icons/journaling.png", "data_tool" => "journaling"]
        ];

        echo json_encode([
            "status" => "success",
            "tools" => $tools
        ]);

    } else {
    
        echo json_encode([
            "status" => "success",
            "message" => "Tools endpoint ready"
        ]);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Server error"
    ]);
}
exit();
?>

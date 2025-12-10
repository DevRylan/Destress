<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}


require_once 'db.php';
try {
    $stmt = $pdo->prepare("INSERT INTO stress_reports (user_id, stress_level, notes) VALUES (?, 3, 'Visited Stress Management Tools page')");
    $stmt->execute([$_SESSION['user_id']]);
} catch (Exception $e) {

}

$tools = [
    [
        'title' => 'Breathing',
        'desc'  => 'Calm your mind with guided breathing exercises',
        'icon'  => 'breathing.png'
    ],
    [
        'title' => 'Exercise',
        'desc'  => 'Move your body to release tension and boost mood',
        'icon'  => 'exercise.png'
    ],
    [
        'title' => 'Meditation',
        'desc'  => 'Find peace with short mindfulness sessions',
        'icon'  => 'meditation.png'
    ],
    [
        'title' => 'Journaling',
        'desc'  => 'Write down thoughts to process emotions',
        'icon'  => 'journaling.png'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stress Management Tools – Destress</title>
    <link rel="stylesheet" href="tools.css">
</head>
<body>
    <header>
        <div id="nav_button">
            <button id="menuBtn" aria-label="Open menu">
                <img src="images/menu_button.png" alt="Menu">
            </button>
        </div>
        <nav class="navBar" id="navBar">
            <ul>
                <li><a href="homepage.php">Homepage</a></li>
                <li><a href="profile.php">Profile</a></li>
                <li><a href="tools.php" class="active">Tools</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="hero">
            <img src="images/logo.png" alt="Destress Logo" class="page-logo">
            <h1>Stress Management Tools</h1>
            <p>Choose a tool to help you relax and feel better today.</p>
        </div>

        <section class="tools-grid">
            <?php foreach ($tools as $tool): ?>
                <div class="tool-card">
                    <img src="images/icons/<?= $tool['icon'] ?>" 
                         alt="<?= $tool['title'] ?>" class="tool-icon">
                    <h3><?= $tool['title'] ?></h3>
                    <p><?= $tool['desc'] ?></p>
                </div>
            <?php endforeach; ?>
        </section>

        <div class="more-tools">
            <button class="btn-large" onclick="alert('More tools coming soon!')">
                Click For Additional Tools
            </button>
        </div>
    </div>

    <script src="tools.js"></script>
</body>
</html>

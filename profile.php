<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
require_login();

// Get current user id
$uid = current_user_id();
// Get user table data
$stmt = $db->prepare("SELECT userId, username, profile_picture, age, gender, avg_stress, created_at FROM Users WHERE userId = ?");
$stmt->execute([$uid]);
$user = $stmt->fetch();

if (!$user) {
    die("User not found.");
}

// Get last 7 stress levels for user
$logsStmt = $db->prepare("
  SELECT levelId, userId, recorded_at, stress_level
  FROM StressLevels
  WHERE userId = ?
  ORDER BY recorded_at ASC
  LIMIT 7
");
$logsStmt->execute([$uid]);
$logs = $logsStmt->fetchAll();

// Create chart arrays
$labels = [];
$values = [];
foreach ($logs as $row) {
    $dt = date('M j', strtotime($row['recorded_at']));
    $labels[] = $dt;
    $values[] = (int)$row['stress_level'];
}

// If there's no logged data, add placeholder zero values for chart
if (empty($labels)) {
    $labels = ['Mon','Tues','Wed','Thur','Fri','Sat','Sun'];
    $values = [0,0,0,0,0,0,0];
}
?>

<?php include __DIR__ . '/../includes/header.php'; ?>


<main id="profile_layout">
  <!-- Profile -->
  <section class="profile_card">
    <h2 class="profile-header">Your Profile
      <img src="/assets/img/pen.png" class="edit-icon" alt="edit">
    </h2>

    <div class="profile_img">
      <?php
        $avatar = $user['profile_picture'] ? htmlspecialchars($user['profile_picture']) : '/assets/img/profileicon.jpeg';
      ?>
      <img src="<?= $avatar ?>" alt="profile icon">
    </div>

    <p class="profile-name"><strong><?= htmlspecialchars($user['username']) ?></strong></p>
    <!-- placeholders for profile data not in DB-->
    <p class="profile-age"><strong>Age:</strong> <?= htmlspecialchars($user['age'] ?? '-') ?></p>
    <p class="profile-gender"><strong>Gender:</strong> <?= htmlspecialchars($user['gender'] ?? '-') ?></p>
    <p class="profile-stress_levels"><strong>Average Stress Levels:</strong> <?= htmlspecialchars($user['avg_stress'] ?? '-') ?>/10</p>

  </section>

  <!-- Chart -->
  <section class="chart_section">
    <h2>Recent Stress Levels</h2>
    <div class="chart-container">
      <canvas id="stressChart" height="300"></canvas>
    </div>
  </section>

  <!-- Settings -->
  <section class="settings_section">
    <h2>Settings</h2>

            <div class="setting_item">
                <span>Mode</span>
                <label class="switch">
                    <input type="checkbox" checked>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="setting_item">
                <span>Notifications</span>
                <label class="switch">
                    <input type="checkbox">
                    <span class="slider"></span>
                </label>
            </div>

            <div class="setting_item">
                <span>Report a problem</span>
                </label>
            </div>

            <div class="setting_item">
                <span>Terms and Conditions</span>
                </label>
            </div>

            <div class="setting_item">
                <span>Logout</span>
                </label>
            </div>

            
            <div class="setting_item">
                <span>DELETE ACCOUNT</span>
                </label>
            </div>
            
  </section>

<!-- Profile edit popup -->
<div id="editModal" class="modal hidden">
  <div class="modal-content">

      <span id="modalClose" class="close">&times;</span>
      <h2>Edit Profile</h2>

      <form id="editForm" method="post" action="update_profile.php">
        <input type="hidden" name="userId" value="<?= $uid ?>">

        <label>Name:</label>
        <input type="text" name="name" id="editName" value="<?= htmlspecialchars($user['username']) ?>">

        <label>Age:</label>
        <input type="number" name="age" id="editAge" min="1" value="<?= htmlspecialchars($user['age'] ?? '') ?>">

        <label>Gender:</label>
        <select name="gender" id="editGender">
          <option value="M" <?= ($user['gender'] ?? '')=='M' ? 'selected' : '' ?>>M</option>
          <option value="F" <?= ($user['gender'] ?? '')=='F' ? 'selected' : '' ?>>F</option>
        </select>

        <label>Average Stress Level (1–10):</label>
        <input type="number" name="stress_level" id="editStress" min="1" max="10" value="<?= htmlspecialchars($user['avg_stress'] ?? '') ?>">

        <div class="modal-buttons">
          <button type="submit">Save</button>
          <button type="button" id="modalCancel">Cancel</button>
        </div>
      </form>

  </div>
</div>


</main>

<script>
  // Include server arrays into JS for Chart JS
  const chartLabels = <?= json_encode($labels) ?>;
  const chartValues = <?= json_encode($values) ?>;
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>

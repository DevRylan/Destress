<?php
//dev helper for local testing
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['user_id'] ?? 1);
    $_SESSION['user_id'] = $id;
    header('Location: profile.php');
    exit();
}
?>

<!doctype html>
<html>
<head><meta charset="utf-8">
    <title>Dev Login</title>
</head>

<body style="font-family:Arial,Helvetica,sans-serif;padding:20px">
<h2>Dev Login Helper</h2>
<p>This is simulating a logged in user for testing locally</p>
<form method="post">
  <label>User ID: <input name="user_id" value="1"></label>
  <button type="submit">Set session and then go to user profile</button>
</form>
</body>
</html>

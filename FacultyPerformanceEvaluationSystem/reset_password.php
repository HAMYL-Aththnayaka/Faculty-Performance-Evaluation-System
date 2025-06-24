<?php
session_start();
require_once "DB/connectionDB.php";
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017/");
$db = $client->FacultyEvaluationSystem;
$usersCollection = $db->users;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['error'] = "❌ All fields are required.";
    } elseif ($newPassword !== $confirmPassword) {
        $_SESSION['error'] = "❌ Passwords do not match.";
    } elseif (
        !preg_match('/[A-Z]/', $newPassword) ||         
        !preg_match('/\d/', $newPassword) ||            
        !preg_match('/[\W_]/', $newPassword)          
    ) {
        $_SESSION['error'] = "❌ Password must include at least one uppercase letter, one number, and one symbol.";
    } else {
        $user = $usersCollection->findOne(['email' => $email]);

        if ($user) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $usersCollection->updateOne(
                ['email' => $email],
                ['$set' => ['password' => $hashedPassword]]
            );
            $_SESSION['success'] = "✅ Password has been reset successfully!";
        } else {
            $_SESSION['error'] = "❌ Email not found. Please contact the admin.";
        }
    }

    header("Location: reset_password.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .reset-container {
      max-width: 400px;
      margin: 50px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      font-family: Arial, sans-serif;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    input {
      width: 95%;
      padding: 10px;
      margin: 10px 0;
      border-radius: 5px;
      border: 1px solid #ccc;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #006d3c;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background-color: #00a65a;
    }
    .message {
      text-align: center;
      margin: 10px 0;
      font-weight: bold;
    }
  </style>
</head>
<body>

<div class="reset-container">
  <h2>Reset Your Password</h2>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="message" style="color: red;"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <div class="message" style="color: green;"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>

  <form method="POST" action="reset_password.php">
    <input type="email" name="email" placeholder="Your registered email" required>
    <input type="password" name="password" placeholder="New password" required>
    <input type="password" name="confirm_password" placeholder="Confirm new password" required>
    <button type="submit">Reset Password</button>
  </form>

  <p style="text-align: center; margin-top: 10px;">
    <a href="login.php">← Back to Login</a>
  </p>
</div>

</body>
</html>

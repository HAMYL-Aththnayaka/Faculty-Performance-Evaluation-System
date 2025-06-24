<?php
require_once "DB/connectionDB.php";
use MongoDB\Client;

$client = new Client("mongodb://localhost:27017");
$db = $client->FacultyEvaluationSystem;
$collection = $db->users;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $original_email = $_POST["original_email"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $regno = $_POST["regno"];
    $newPassword = $_POST["new_password"];

    $updateData = [
        'email' => $email,
        'name' => $name,
        'regNo' => $regno
    ];

    // If new password is provided, hash and update
    if (!empty($newPassword)) {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateData['password'] = $hashedPassword;
    }

    $collection->updateOne(
        ['email' => $original_email],
        ['$set' => $updateData]
    );

    header("Location: manage_user.php");
    exit;
}

if (!isset($_GET["email"])) {
    echo "Email is missing.";
    exit;
}

$email = $_GET["email"];
$user = $collection->findOne(['email' => $email]);

if (!$user) {
    echo "User not found.";
    exit;
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .footercontainer {
            position: auto;
            bottom: 0;
            width: 100%;
        }
        input[type="password"] {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo">Admin Dashboard</div>
    <ul class="nav-links">
      <li><a href="dashboard_admin.php">Home</a></li>
      <li><a href="logout.php">Log out</a></li>
    </ul>
  </div>
</nav>

<div class="container">
    <h2>Edit User</h2>
    <form action="edit_user.php" method="post">
        <input type="hidden" name="original_email" value="<?= htmlspecialchars($user['email']) ?>">

        <label>Email:</label><br>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br><br>

        <label>Name:</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br><br>

        <label>Reg No:</label><br>
        <input type="text" name="regno" value="<?= htmlspecialchars($user['regNo']) ?>" required><br><br>

        <label>Reset Password (leave blank to keep unchanged):</label><br>
        <input type="password" name="new_password" placeholder="Enter new password"><br><br>

        <button type="submit">Update User</button>
        <a href="manage_user.php">Cancel</a>
    </form>
</div>

<footer>
    <div class="footercontainer">
        <p>
        <a href="index.php">Switch to User Mode</a><br><br>
        &copy; <?php echo date("Y"); ?> Faculty Evaluation System - University of Vavuniya<br>
        </p>
    </div>
</footer>

</body>
</html>

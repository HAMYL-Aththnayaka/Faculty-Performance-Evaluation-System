<?php
session_start();
require_once "DB/connectionDB.php";
use MongoDB\Client;


if (!isset($_SESSION['user_email'])) {
    header("Location: index.php");
    exit();
}

$email = $_SESSION['user_email'];
$name = $_SESSION['user_name'] ?? '';
$regno = $_SESSION['user_regno'] ?? '';

$client = new Client("mongodb://localhost:27017/");
$db = $client->FacultyEvaluationSystem;
$usersCollection = $db->users;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirmpassword'] ?? '';

    if (empty($newPassword) || empty($confirmPassword)) {
        $_SESSION['message'] = "❌ Both password fields are required.";
        $_SESSION['message_type'] = "error";
    } elseif ($newPassword !== $confirmPassword) {
        $_SESSION['message'] = "❌ Passwords do not match.";
        $_SESSION['message_type'] = "error";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        $result = $usersCollection->updateOne(
            ['email' => $email],
            ['$set' => ['password' => $hashedPassword]]
        );

        if ($result->getMatchedCount() === 0) {
            $_SESSION['message'] = "❌ User not found or update failed.";
            $_SESSION['message_type'] = "error";
        } else {
            $_SESSION['message'] = "✅ Password updated successfully!";
            $_SESSION['message_type'] = "success";
        }
    }

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Manage Profile</title>
    <link rel="stylesheet" href="style.css" />
    <style>
        .required-label::after {
            content: " *";
            color: red;
        }
        .message {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .success-message {
            color: green;
        }
        .error-message {
            color: red;
        }
        .container {
            max-width: 500px;
            margin: 30px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
        }
        input, button {
            width: 95%;
            padding: 10px;
            margin: 5px 0 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1em;
        }
        button {
            background-color: #004080;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }
        button:hover {
            background-color: #0066cc;
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <div class="nav-logo">Faculty Evaluation University of Vavuniya</div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="evaluation_form.php">Evaluations</a></li>
            <li><a href="feedback_form.php">Feedback</a></li>
        </ul>
    </div>
</nav>

<div class="container">
    <h2>Update Your Profile</h2>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="message <?= $_SESSION['message_type'] === 'error' ? 'error-message' : 'success-message' ?>">
            <?= $_SESSION['message'] ?>
        </div>
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>

    <form method="POST" action="profile.php">
        <label for="username">Full Name:</label>
        <input type="text" id="username" name="username" value="<?= htmlspecialchars($name) ?>" readonly />

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($email) ?>" readonly />

        <label for="regno">Registration Number:</label>
        <input type="text" id="regno" name="regno" value="<?= htmlspecialchars($regno) ?>" readonly />

        <label for="password" class="required-label">Reset Password</label>
        <input type="password" id="password" name="password" placeholder="Enter new password" />
        <input type="password" id="confirmpassword" name="confirmpassword" placeholder="Confirm new password" />

        <button type="submit">Update Password</button>
    </form>
</div>

<footer>
    <div class="footercontainer">
        <p>
            <a href="contact_us.php">Contact Us</a> | 
            <a href="dashboard_faculty.php">Home</a><br><br>
            &copy; <?= date("Y") ?> Faculty Evaluation System - University of Vavuniya
        </p>
    </div>
</footer>

</body>
</html>

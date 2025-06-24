<?php
session_start();
require_once "DB/connectionDB.php"; 
use MongoDB\Client;

$evaluationStatus = null;
$feedbackStatus = null;
$notices = [];

try {
    $client = new Client("mongodb://localhost:27017/");
    $db = $client->FacultyEvaluationSystem;
    $noticeCollection = $db->Notices;
    $notices = $noticeCollection->find([], ['sort' => ['created_at' => -1]])->toArray();
} catch (Exception $e) {
    $notices = [];
}

$userEmail = $_SESSION['user_email'] ?? null;

if ($userEmail) {
    try {
        $usersCollection = $db->users;
        $user = $usersCollection->findOne(['email' => $userEmail]);

        if (!$user) {
            $evaluationStatus = "User not found. Please log in again.";
        } else {
            // Set session variables after successfully fetching user
            $_SESSION['user_name'] = $user['name'] ?? '';
            $_SESSION['user_regno'] = $user['regNo'] ?? '';

            $evaluationsCollection = $db->Evaluations;
            $feedbackCollection = $db->feedbacks;

            $userEvaluation = $evaluationsCollection->findOne(['email' => $userEmail]);
            $userFeedback = $feedbackCollection->findOne(['email' => $userEmail]);

            $evaluationStatus = $userEvaluation
                ? "✅ Your evaluation has been submitted."
                : "⚠️ You haven’t submitted any evaluations yet.";

            $feedbackStatus = $userFeedback
                ? "✅ Your feedback has been submitted."
                : "⚠️ You haven’t submitted any feedback yet.";
        }
    } catch (Exception $e) {
        $evaluationStatus = "An error occurred: " . $e->getMessage();
    }
} else {
    $evaluationStatus = "Please log in to submit an evaluation or feedback.";
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo">Faculty Evaluation University of Vavuniya</div>
    <ul class="nav-links">
      <?php if (isset($_SESSION['user_email'])): ?>
        <li><a href="evaluation_form.php">Evaluations</a></li>
        <li><a href="feedback_form.php">Feedback</a></li>
        <li><a href="profile.php">Profile</a></li>
        <li><a href="logout.php">Logout</a></li>
      <?php else: ?>
        <li><a href="login.php">Login/Register</a></li>
      <?php endif; ?>
    </ul>
  </div>
</nav>

<div class="container">
  <p>Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'User') ?></p>

  <?php if ($evaluationStatus): ?>
    <div class="evaluation-status-box">
      <?= htmlspecialchars($evaluationStatus) ?>
    </div>
  <?php endif; ?>

  <?php if ($feedbackStatus): ?>
    <div class="evaluation-status-box">
      <?= htmlspecialchars($feedbackStatus) ?>
    </div>
  <?php endif; ?>

  <div class="notice-section">
    <h3>📢 Latest Notices</h3>
      <?php if (!empty($notices)) : ?>
        <?php foreach ($notices as $notice) : ?>
          <div class="notice">
            <p><strong><?= htmlspecialchars($notice['title'] ?? 'No Title') ?></strong></p>
            <p><?= nl2br(htmlspecialchars($notice['description'] ?? 'No Description')) ?></p>
            <?php if (isset($notice['created_at'])): ?>
              <small>🕒 Posted on <?= date("Y-m-d") ?></small>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <p>No notices available.</p>
      <?php endif; ?>
  </div>
</div>

<footer>
  <div class="footercontainer">
    <p>
      <a href="contact_us.php">Contact Us</a> | 
      <a href="login.php">Switch to Admin Mode</a><br><br>
      &copy; <?= date("Y") ?> Faculty Evaluation System - University of Vavuniya
    </p>
  </div>
</footer>

</body>
</html>

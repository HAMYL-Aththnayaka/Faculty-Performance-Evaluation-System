<?php 
session_start(); 
require_once "DB/connectionDB.php"; 
use MongoDB\Client;

$totalEvaluators = 0;
$totalFeedbacks = 0;
$totalNotices = 0;

try {
    $client = new Client("mongodb://localhost:27017/");
    $db = $client->FacultyEvaluationSystem;

    $usersCollection = $db->users;
    $feedbackCollection = $db->feedbacks;
    $noticeCollection = $db->Notices;

    $totalEvaluators = $usersCollection->countDocuments(['role' => 'evaluator']);
    $totalFeedbacks = count($feedbackCollection->distinct('email'));
    $totalNotices = $noticeCollection->countDocuments();

} catch (Exception $e) {
    $totalEvaluators = 0; 
    $totalFeedbacks = 0;
    $totalNotices = 0;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo">Admin Dashboard</div>
    <ul class="nav-links">
      <li><a href="index.php">Faculty Dashboard</a></li>
      <li><a href="logout.php">Log out</a></li>
    </ul>
  </div>
</nav>

<div class="admin-container">
  <p>Welcome, <?php echo $_SESSION['username'] ?? 'Admin'; ?></p>

  <div class="section">
    <h3>Quick Actions</h3>
    <ul>
      <li><a href="report.php">📄 View Reports</a></li>
      <li><a href="manage_user.php">👥 Manage Users</a></li>
      <li><a href="add_notice.php">📢 Post Notice</a></li>
      <li><a href="logout.php">🚪 Logout</a></li>
    </ul>
  </div>

  <div class="section">
    <h3>System Overview</h3>
    <div class="stat-container">
      <div class="stat-box box-blue">
        <h4>Total Evaluators</h4>
        <p><?= $totalEvaluators ?></p>
      </div>
      <div class="stat-box box-green">
        <h4>Total Feedbacks</h4>
        <p><?= $totalFeedbacks ?></p>
      </div>
      <div class="stat-box box-orange">
        <h4>System Notices</h4>
        <p><?= $totalNotices ?></p>
      </div>
    </div>
  </div>
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

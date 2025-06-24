<?php
session_start();
require_once "DB/connectionDB.php";
use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->FacultyEvaluationSystem;
    $collection = $db->feedbacks; 

    $feedbacks = $collection->find()->toArray();

    $groupedFeedbacks = [];
    foreach ($feedbacks as $fb) {
        $email = $fb['email'] ?? 'Unknown';
        $groupedFeedbacks[$email][] = $fb;
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Feedback Reports</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container {
      max-width: 1000px;
      margin: auto;
      margin-top: 40px;
      padding: 20px;
      justify-content: center;
      align-items: center;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }
    th {
      background-color: #f5f5f5;
    }
    .delete-btn {
      background-color: #d9534f;
      color: white;
      border: none;
      padding: 5px 10px;
      cursor: pointer;
      border-radius: 3px;
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
  <h2>Feedback Reports</h2>

  <?php if (!empty($groupedFeedbacks)): ?>
    <?php foreach ($groupedFeedbacks as $email => $feedbacks): ?>
      <h3><?= htmlspecialchars($email) ?></h3>
      <table>
        <thead>
          <tr>
            <th>Faculty</th>
            <th>Department</th>
            <th>Feedback</th>
            <th>Submitted At</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($feedbacks as $fb): ?>
            <tr>
              <td><?= htmlspecialchars($fb['faculty'] ?? 'N/A') ?></td>
              <td><?= htmlspecialchars($fb['department'] ?? 'N/A') ?></td>
              <td><?= nl2br(htmlspecialchars($fb['feedback_text'] ?? 'N/A')) ?></td>
              <td><?= htmlspecialchars($fb['submitted_at'] ?? 'N/A') ?></td>
              <td>
                <form method="post" action="delete_feedback.php" onsubmit="return confirm('Delete all feedbacks for this email?');">
                  <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
                  <button class="delete-btn" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  <?php else: ?>
    <p>No feedback submitted yet.</p>
  <?php endif; ?>
</div><br>

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

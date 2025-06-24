<?php
session_start();

require_once "DB/connectionDB.php";
use MongoDB\Client;

// Fetch existing notices
try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->FacultyEvaluationSystem;
    $collection = $db->Notices;

    $notices = $collection->find()->toArray();
} catch (Exception $e) {
    $notices = [];
    $fetchError = "Error fetching notices: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Notice</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo">Faculty Evaluation University of Vavuniya</div>
    <ul class="nav-links">
      <li><a href="dashboard_admin.php">Home</a></li>
    </ul>
  </div>
</nav>

<div class="container">

  <?php if (!empty($fetchError)): ?>
    <p style="color:red;"><?= htmlspecialchars($fetchError) ?></p>
  <?php endif; ?>

  <h2>Add New Notice</h2>
  <form action="DB/addNoticeAuthentication.php" method="POST">

      <label for="notice_title">Notice Title:</label>
      <input type="text" id="notice_title" name="notice_title" placeholder="Enter notice title" required />

      <label for="notice_desc">Notice Description:</label>
      <textarea id="notice_desc" name="notice_desc" rows="5" placeholder="Enter notice description" required style="width: 95%; padding: 10px; border-radius: 4px; border: 1px solid #ccc;"></textarea>

      <button type="submit">Add Notice</button>
  </form>

  <h2>Existing Notices</h2>
  <div class="notice-list">
    <?php if (!empty($notices)): ?>
      <?php foreach ($notices as $notice): ?>
        <div class="notice-item">
          <span class="notice-title"><?= htmlspecialchars($notice['title']) ?></span><br><br>
          <span><?= nl2br(htmlspecialchars($notice['description'])) ?></span>

          <form method="post" action="deleteNotice.php" style="display:inline;" onsubmit="return confirm('Delete this notice?');">
            <input type="hidden" name="id" value="<?= $notice['_id'] ?>">
            <button class="delete-btn" type="submit">Delete</button>
          </form>
        </div>
      <?php endforeach; ?>
    <?php else: ?>
      <p>No notices found.</p>
    <?php endif; ?>
  </div>
</div><br>

<footer>
  <div class="footercontainer">
    <p>
      <a href="contact_us.php"> Contact Us</a> | 
      <a href="dashboard_faculty.php">Switch to User Mode</a><br><br>
      &copy; <?php echo date("Y"); ?> Faculty Evaluation System - University of Vavuniya<br>
    </p>
  </div>
</footer>

</body>
</html>

<?php
session_start();
require_once "DB/connectionDB.php";
use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->FacultyEvaluationSystem;
    $collection = $db->users;

    $users = $collection->find();

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Users - Admin</title>
  <link rel="stylesheet" href="style.css">
  <style>
    .container { max-width: 900px; margin: auto; padding: 20px; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    th, td { border: 1px solid #ccc; padding: 10px; text-align: left; }
    th { background-color: #eee; }
    .actions button {
      margin-right: 5px;
      padding: 5px 10px;
      cursor: pointer;
    }
    nav {
      background-color: #004080;
      color: white;
      padding: 10px 20px;
      margin-bottom: 20px;
    }
    nav a {
      color: white;
      margin-right: 15px;
      text-decoration: none;
      font-weight: bold;
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
  <h2>Manage Users</h2>
  
  <?php if ($users->isDead()): ?>
    <p>No users found.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Email</th>
          <th>Name</th>
          <th>RegNo</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?= htmlspecialchars($user['email'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($user['name'] ?? 'N/A') ?></td>
            <td><?= htmlspecialchars($user['regNo'] ?? 'N/A') ?></td>
            <td class="actions">
              <form style="display:inline" action="edit_user.php" method="get">
                <input type="hidden" name="email" value="<?= htmlspecialchars($user['email']) ?>" />
                <button type="submit">Edit</button>
              </form>

              <form style="display:inline" action="delete_user.php" method="post" onsubmit="return confirm('Are you sure you want to delete this user?');">
                <input type="hidden" name="email" value="<?= $user['email'] ?>" />
                <button type="submit">Delete</button>
              </form>

            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
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

<?php
session_start();
require_once "DB/connectionDB.php";
use MongoDB\Client;

// Handle POST only once
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $client = new Client("mongodb://localhost:27017/");
        $db = $client->FacultyEvaluationSystem;
        $messageCollection = $db->Messages;

        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $messageText = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($subject) || empty($messageText)) {
            $_SESSION['error'] = "All fields are required.";
        } else {
            $messageCollection->insertOne([
                'name' => $name,
                'email' => $email,
                'subject' => $subject,
                'message' => $messageText,
                'submitted_at' => new MongoDB\BSON\UTCDateTime()
            ]);
            $_SESSION['success'] = "✅ Message sent successfully!";
        }

        // Redirect to clear POST and avoid form resubmission
        header("Location: contact_us.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = "❌ Error: " . $e->getMessage();
        header("Location: contact_us.php");
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Faculty Evaluation System</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    .contact-container {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 0 8px rgba(0,0,0,0.1);
      font-family: Arial, sans-serif;
    }
    h2 {
      color:rgb(255, 255, 255);
      text-align: center;
      margin-bottom: 20px;
    }
    form label {
      display: block;
      margin: 12px 0 6px;
      font-weight: bold;
      color: #003f25;
    }
    form input[type="text"],
    form input[type="email"],
    form textarea {
      width: 90%;
      padding: 10px;
      border-radius: 4px;
      border: 1px solid #ccc;
      font-size: 1em;
      resize: vertical;
    }
    form textarea {
      height: 120px;
    }
    form button {
      margin-top: 20px;
      width: 100%;
      background-color: #006d3c;
      color: white;
      border: none;
      padding: 12px;
      font-size: 1.1em;
      cursor: pointer;
      border-radius: 6px;
      transition: background-color 0.3s ease;
    }
    form button:hover {
      background-color: #09a466;
    }
  </style>
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo">Faculty Dashboard</div>
    <ul class="nav-links">
      <li><a href="login.php">Login/Register</a></li>
    </ul>
  </div>
</nav>


<div class="contact-container">
  <p style="text-align:center; font-size:1.1em; margin-bottom: 25px;">
    📧 Support Email: <a href="mailto:support@faculty-eval.com">support@faculty-eval.com</a>
  </p>

  <?php if (isset($_SESSION['error'])): ?>
  <p style="color: red; font-weight: bold;"><?= $_SESSION['error'] ?></p>
  <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['success'])): ?>
    <p style="color: green; font-weight: bold;"><?= $_SESSION['success'] ?></p>
    <?php unset($_SESSION['success']); ?>
  <?php endif; ?>


  <form action="contact_us.php" method="POST">
    <label for="name">Name *</label>
    <input type="text" id="name" name="name" placeholder="Your full name" required />

    <label for="email">Email *</label>
    <input type="email" id="email" name="email" placeholder="Your email address" required />

    <label for="subject">Subject *</label>
    <input type="text" id="subject" name="subject" placeholder="Subject of your message" required />

    <label for="message">Message *</label>
    <textarea id="message" name="message" placeholder="Write your message here..." required></textarea>

    <button type="submit">Send Message</button>
  </form>
</div>

<footer>
  <div class="footercontainer">
    <p>&copy; <?php echo date("Y"); ?> Faculty Evaluation System - University of Vavuniya</p>
  </div>
</footer>

</body>
</html>

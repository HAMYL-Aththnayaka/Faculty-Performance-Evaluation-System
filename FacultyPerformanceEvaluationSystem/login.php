<?php
require __DIR__ . '/DB/connectionDB.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Faculty Evaluation - Login</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="login-container">
      <h2>Login</h2>
      <form action="DB/loginAuthentication.php" method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
        <p style="text-align: center; margin-top: 10px;">
          <a href="reset_password.php">Forgot Password?</a>
        </p>

        <p>Haven't an account yet?<a href="registration.php"> Register</a></p>
      </form>

      <?php
      if (isset($_SESSION['error'])) {
          echo "<p style='color: red;'>" . $_SESSION['error'] . "</p>";
          unset($_SESSION['error']);
      }
      ?>

    </div>
  
    <footer>
    <div class="footercontainer">
      <p>
        <a href="contact_us.php"> Contact Us</a><br>
        &copy; <?php echo date("Y"); ?> Faculty Evaluation System - University of Vavuniya<br>
      </p>
    </div>
  </footer>
</body>
</html>

<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Registration</title>
  <link rel="stylesheet" href="style.css">
</head>
<style>
  .error-message {
    color: red;
    font-size: 0.9em;
  }
</style>
<body>
  <div class="register-container">
    <h2>User Registration</h2>
    <form action="DB/regitrationAuthentication.php" method="POST" onsubmit="return validateForm()">
      <input type="text" name="regNo" placeholder="Registration Number(2021ICT01)" required>
      <input type="text" name="name" placeholder="Full Name" required>
      <input type="email" name="email" placeholder="University Email (2021ictxx@stu.vau.ac.lk)" required>

      <input type="password" id="password" name="password" placeholder="Password" required>
      <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Confirm-Password" required>
      <span id="passwordError" class="error-message"></span><br>

      <label for="faculty">Faculty</label>
      <select name="faculty" id="faculty" required onchange="updateDepartments()">
        <option value="" disabled selected>Select Faculty</option>
        <option value="Applied Science">Faculty of Applied Science</option>
        <option value="Business Studies">Faculty of Business Studies</option>
        <option value="Technological Studies">Faculty of Technological Studies</option>
      </select><br><br>

      <label for="department">Department</label>
      <select name="department" id="department" required>
        <option value="" disabled selected>Select Department</option>
      </select><br><br>

      <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a>.</p>

    <?php
    if (isset($_SESSION['error'])) {
        echo "<p style='color: red;'>".$_SESSION['error']."</p>";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo "<p style='color: green;'>".$_SESSION['success']."</p>";
        unset($_SESSION['success']);
    }
    ?>
  </div>

  <footer>
    <div class="footercontainer">
      <p>
        <a href="contact_us.php"> Contact Us</a> | 
        <a href="dashboard_admin.php">Switch to Admin Mode</a><br><br>
        &copy; <?php echo date("Y"); ?> Faculty Evaluation System - University of Vavuniya<br>
      </p>
    </div>
  </footer>

  <script>
    const departments = {
      "Applied Science": ["Physical Science", "Bio Science"],
      "Business Studies": [
        "Business Economics", "English Language Teaching", "Finance and Accountancy",
        "Human Resource Management", "Management and Entrepreneurship",
        "Marketing Management", "Project Management"
      ],
      "Technological Studies": ["ICT"]
    };

    function updateDepartments() {
      const facultySelect = document.getElementById('faculty');
      const departmentSelect = document.getElementById('department');
      const selectedFaculty = facultySelect.value;

      departmentSelect.innerHTML = '<option value="" disabled selected>Select Department</option>';

      if (departments[selectedFaculty]) {
        departments[selectedFaculty].forEach(dept => {
          const option = document.createElement('option');
          option.value = dept;
          option.textContent = dept;
          departmentSelect.appendChild(option);
        });
      }
    }

    function validateForm() {
      const password = document.getElementById('password').value;
      const confirm = document.getElementById('confirmPassword').value;
      const errorSpan = document.getElementById('passwordError');

      const hasUppercase = /[A-Z]/.test(password);
      const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(password);
      const hasNumber = /\d/.test(password);

      if (!hasUppercase || !hasSymbol || !hasNumber) {
        errorSpan.textContent = "Password must include 1 uppercase letter, 1 symbol, and 1 number.";
        return false;
      }

      if (password !== confirm) {
        errorSpan.textContent = "Passwords do not match.";
        return false;
      }

      errorSpan.textContent = "";
      return true;
    }
  </script>
</body>
</html>

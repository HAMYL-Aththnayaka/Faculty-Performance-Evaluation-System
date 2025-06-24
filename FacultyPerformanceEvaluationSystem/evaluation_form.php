<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evaluation Form</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>

<nav class="navbar">
  <div class="nav-container">
    <div class="nav-logo">Faculty Evaluation University of Vavuniya</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="evaluation_form.php">Evaluations</a></li>
      <li><a href="feedback_form.php">Feedback</a></li>
      <li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <a href="logout.php">Logout</a>
        <?php else: ?>
          <a href="login.php">Login/Register</a>
        <?php endif; ?>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
  <h2>Evaluation Form</h2>

  <?php if (isset($_SESSION['success'])): ?>
    <p style="color:green;"><?php echo htmlspecialchars($_SESSION['success']); ?></p>
  <?php endif; ?>

  <form action="DB/evaluationAuthentication.php" method="POST">

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

    <label>Teaching (out of 10):</label>
    <input type="number" name="teaching" min="0" max="10" required><br>

    <label>Research (out of 10):</label>
    <input type="number" name="research" min="0" max="10" required><br>

    <label>Service (out of 10):</label>
    <input type="number" name="service" min="0" max="10" required><br>

    <label>Communication Skills (out of 10):</label>
    <input type="number" name="communication" min="0" max="10" required><br>

    <label>Use of Technology (out of 10):</label>
    <input type="number" name="technology" min="0" max="10" required><br><br>

    <button type="submit">Submit</button>
  </form>
</div>

<footer>
  <div class="footercontainer">
    <a href="contact_us.php">Contact Us</a><br>
    <p>&copy; <?php echo date("Y"); ?> Faculty Evaluation System - University of Vavuniya</p>
  </div>
</footer>

<script>
  const departments = {
    "Applied Science": [
      "Physical Science",
      "Bio Science"
    ],
    "Business Studies": [
      "Business Economics",
      "English Language Teaching",
      "Finance and Accountancy",
      "Human Resource Management",
      "Management and Entrepreneurship",
      "Marketing Management",
      "Project Management"
    ],
    "Technological Studies": [
      "ICT"
    ]
  };

  function updateDepartments() {
    const facultySelect = document.getElementById('faculty');
    const departmentSelect = document.getElementById('department');
    const selectedFaculty = facultySelect.value;

    // Clear previous options
    departmentSelect.innerHTML = '<option value="" disabled selected>Select Department</option>';

    if (selectedFaculty && departments[selectedFaculty]) {
      departments[selectedFaculty].forEach(dept => {
        const option = document.createElement('option');
        option.value = dept;
        option.textContent = dept;
        departmentSelect.appendChild(option);
      });
    }
  }
</script>

</body>
</html>

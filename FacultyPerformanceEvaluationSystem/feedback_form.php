<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Feedback Form</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <style>
    textarea {
      width: 100%;
      resize: vertical;
    }
    .word-count {
      font-size: 0.9em;
      color: gray;
      margin-top: 4px;
      margin-bottom: 10px;
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
    </ul>
  </div>
</nav>

<div class="container">
  <?php session_start(); ?>
<?php if (isset($_SESSION['feedback_success'])): ?>
  <div class="success-message" style="color:green; font-weight:bold; margin-bottom:15px;">
    <?= htmlspecialchars($_SESSION['feedback_success']) ?>
  </div>
  <?php unset($_SESSION['feedback_success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['feedback_error'])): ?>
  <div class="error-message" style="color:red; font-weight:bold; margin-bottom:15px;">
    <?= htmlspecialchars($_SESSION['feedback_error']) ?>
  </div>
  <?php unset($_SESSION['feedback_error']); ?>
<?php endif; ?>

  <h2>Student Feedback</h2>
  <form action="DB/feedbackValidation.php" method="POST">

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

    <label for="feedback">Your Feedback (Max 500 words):</label><br><br>
    <textarea id="feedback" name="feedback" rows="6" placeholder="Enter your feedback here..." required
      oninput="limitWords(this, 500)"></textarea>
    <div class="word-count" id="wordCount">0 / 500 words</div>

    <button type="submit">Submit Feedback</button>
  </form>
</div>

<footer>
  <div class="footercontainer">
    <a href="contact_us.php"> Contact Us</a><br>
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

  function limitWords(textarea, maxWords) {
    let words = textarea.value.match(/\b[-?(\w+)?]+\b/gi);
    let wordCount = words ? words.length : 0;

    if (wordCount > maxWords) {
      // Trim to maxWords
      textarea.value = words.slice(0, maxWords).join(" ");
      wordCount = maxWords;
    }

    document.getElementById('wordCount').textContent = wordCount + " / " + maxWords + " words";
  }
</script>

</body>
</html>

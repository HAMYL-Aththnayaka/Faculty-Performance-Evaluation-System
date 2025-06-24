<?php
session_start();
require_once "connectionDB.php"; 
use MongoDB\Client;

// Check if user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: ../login.php");
    exit();
}

$userEmail = $_SESSION['user_email'];

$faculty = $_POST['faculty'] ?? '';
$department = $_POST['department'] ?? '';
$feedbackText = $_POST['feedback'] ?? ''; // Match the form field name

// Basic validation
if (!$faculty || !$department || !$feedbackText) {
    $_SESSION['feedback_error'] = "All fields are required.";
    header("Location: ../feedback_form.php");
    exit();
}

// Count words in feedback (not characters)
$wordCount = str_word_count($feedbackText);
if ($wordCount > 500) {
    $_SESSION['feedback_error'] = "Feedback cannot exceed 500 words. You entered $wordCount words.";
    header("Location: ../feedback_form.php");
    exit();
}

try {
    $client = new Client("mongodb://localhost:27017/");
    $db = $client->FacultyEvaluationSystem;
    $feedbackCollection = $db->feedbacks;

    // Check if feedback already exists for this user
    $existing = $feedbackCollection->findOne(['email' => $userEmail]);
    if ($existing) {
        $_SESSION['feedback_error'] = "You have already submitted feedback.";
        header("Location: ../feedback_form.php");
        exit();
    }

    // Prepare the feedback document
    $feedbackDocument = [
        'email' => $userEmail,
        'faculty' => $faculty,
        'department' => $department,
        'feedback_text' => $feedbackText,
        'submitted_at' => date("Y-m-d H:i:s")
    ];

    $feedbackCollection->insertOne($feedbackDocument);

    $_SESSION['feedback_success'] = "Thank you! Your feedback has been submitted.";
    header("Location: ../feedback_form.php");
    exit();

} catch (Exception $e) {
    $_SESSION['feedback_error'] = "Error saving feedback: " . $e->getMessage();
    header("Location: ../feedback_form.php");
    exit();
}
?>

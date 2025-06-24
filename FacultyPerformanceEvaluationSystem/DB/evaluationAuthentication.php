<?php
session_start();
require_once "connectionDB.php"; 
use MongoDB\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['user_email'] ?? null;
    if (!$email) {
        die("User not authenticated.");
    }

    // Collect form data
    $faculty       = $_POST['faculty'] ?? null;
    $department    = $_POST['department'] ?? null;
    $teaching      = isset($_POST['teaching']) ? (int)$_POST['teaching'] : null;
    $research      = isset($_POST['research']) ? (int)$_POST['research'] : null;
    $service       = isset($_POST['service']) ? (int)$_POST['service'] : null;
    $communication = isset($_POST['communication']) ? (int)$_POST['communication'] : null;
    $technology    = isset($_POST['technology']) ? (int)$_POST['technology'] : null;

    // Validate required fields
    if (!$faculty || !$department || $teaching === null || $research === null || $service === null || $communication === null || $technology === null) {
        $_SESSION['success'] = "All fields are required.";
        header("Location: ../evaluation_form.php");
        exit;
    }

    try {
        $client = new Client("mongodb://localhost:27017/");
        $db = $client->FacultyEvaluationSystem;
        $collection = $db->Evaluations;

        $existingEvaluation = $collection->findOne(['email' => $email]);

        if ($existingEvaluation) {
            $_SESSION['success'] = "You have already submitted an evaluation. Multiple submissions are not allowed.";
            header("Location: ../evaluation_form.php");
            exit; 
        }

        // Insert new evaluation with faculty
        $insertResult = $collection->insertOne([
            'email' => $email,
            'faculty' => $faculty,
            'department' => $department,
            'teaching' => $teaching,
            'research' => $research,
            'service' => $service,
            'communication' => $communication,
            'technology' => $technology,
            'submitted_at' => date("Y-m-d H:i:s")
        ]);

        if ($insertResult->getInsertedCount() === 1) {
            $_SESSION['success'] = "Evaluation submitted successfully.";
            header("Location: ../index.php");
            exit;
        } else {
            die("Failed to save evaluation.");
        }
    } catch (Exception $e) {
        die("Error saving evaluation: " . $e->getMessage());
    }
} else {
    header("Location: ../evaluation_form.php");
    exit;
}

<?php
session_start();
require_once "connectionDB.php"; 
use MongoDB\Client;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['notice_title'] ?? '');
    $description = trim($_POST['notice_desc'] ?? '');

    // Basic validation
    if (!empty($title) && !empty($description)) {
        try {
            $client = new Client("mongodb://localhost:27017");
            $db = $client->FacultyEvaluationSystem; 
            $collection = $db->Notices;

            $notice = [
                'title' => htmlspecialchars($title),
                'description' => htmlspecialchars($description),
                'created_at' => date("Y-m-d H:i:s")
            ];

            $insertResult = $collection->insertOne($notice);

            if ($insertResult->getInsertedCount() === 1) {
                $_SESSION['success'] = "✅ Notice added successfully!";
                header("Location: ../dashboard_admin.php");
                exit;
            } else {
                $_SESSION['error'] = "❌ Failed to add the notice.";
                header("Location: ../add_notice.php");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "❗ Error: " . $e->getMessage();
            header("Location: ../add_notice.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "⚠️ Both title and description are required.";
        header("Location: ../add_notice.php");
        exit;
    }
} else {
    // If user tries to access the script directly
    header("Location: ../add_notice.php");
    exit;
}

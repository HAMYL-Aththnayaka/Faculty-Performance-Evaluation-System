<?php
require_once "DB/connectionDB.php";
use MongoDB\Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];

    if (empty($email)) {
        echo "Email is missing.";
        exit;
    }

    try {
        $client = new Client("mongodb://localhost:27017");
        $db = $client->FacultyEvaluationSystem;
        $collection = $db->users;

        $result = $collection->deleteOne(['email' => $email]);

        if ($result->getDeletedCount() > 0) {
            header("Location: manage_user.php");
            exit;
        } else {
            echo "User with this email not found.";
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}

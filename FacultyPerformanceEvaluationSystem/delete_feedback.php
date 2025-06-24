<?php
require_once "DB/connectionDB.php";
use MongoDB\Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (empty($_POST['email'])) {
        echo "Email is missing.";
        exit;
    }

    $email = $_POST['email'];

    $client = new Client("mongodb://localhost:27017");
    $db = $client->FacultyEvaluationSystem;
    $collection = $db->feedbacks;

    $collection->deleteMany(['email' => $email]);

    header("Location: report.php");
    exit;
}
 else {
    echo "Invalid request method.";
    exit;
}

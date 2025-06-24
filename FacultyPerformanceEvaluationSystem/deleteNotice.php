<?php
require_once "DB/connectionDB.php";
use MongoDB\Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        die("Notice ID is missing.");
    }

    $client = new Client("mongodb://localhost:27017");
    $db = $client->FacultyEvaluationSystem;
    $collection = $db->Notices;

    try {
        $objectId = new MongoDB\BSON\ObjectId($id);
    } catch (Exception $e) {
        die("Invalid notice ID.");
    }

    $result = $collection->deleteOne(['_id' => $objectId]);

    if ($result->getDeletedCount() > 0) {
        header("Location: add_notice.php");
        exit();
    } else {
        die("Notice not found or could not be deleted.");
    }
} else {
    die("Invalid request.");
}
?>

<?php
require __DIR__ . '/vendor/autoload.php'; 
use MongoDB\Client;

try {
    $client = new Client("mongodb://localhost:27017");
    $db = $client->FacultyEvaluationSystem;
    $collection = $db->UserProfile;
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}

<?php
require_once "connectionDB.php"; 
session_start();
use MongoDB\Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $regNo = $_POST["regNo"] ?? '';
    $name = $_POST["name"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';
    $confirmPassword = $_POST["confirmPassword"] ?? '';
    $faculty = $_POST["faculty"] ?? '';
    $department = $_POST["department"] ?? '';
    $role = $_POST["role"] ?? 'evaluator';

    if ($regNo && $name && $email && $password && $confirmPassword && $faculty && $department && $role) {

        if ($password !== $confirmPassword) {
            $_SESSION['error'] = "Passwords do not match.";
            header("Location: ../registration.php");
            exit;
        }

        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Use MongoDB and collection
            $client = new Client("mongodb://localhost:27017/");
            $db = $client->FacultyEvaluationSystem;
            $collection = $db->users;

            // Check for existing email
            $existingUser = $collection->findOne(['email' => $email]);
            if ($existingUser) {
                $_SESSION['error'] = "Email already registered.";
                header("Location: ../registration.php");
                exit;
            }

            // Insert new user
            $collection->insertOne([
                'regNo' => $regNo,
                'name' => $name,
                'email' => $email,
                'password' => $hashedPassword,
                'faculty' => $faculty,
                'department' => $department,
                'role' => $role,
                'registered_at' => date("Y-m-d H:i:s")

            ]);

            header("Location: ../login.php");
            exit;

        } catch (Exception $e) {
            echo "❌ Error: " . $e->getMessage();
        }

    } else {
        $_SESSION['error'] = "Please fill all fields.";
        header("Location: ../registration.php");
        exit;
    }
}
?>

<?php
require_once "connectionDB.php";

session_start();

use MongoDB\Client;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation
   if ($email && $password && filter_var($email, FILTER_VALIDATE_EMAIL)) {

        // Hardcoded admin login
        if ($email === 'admin@fas.vau.ac.lk' && $password === 'Admin@fas' || $email === 'admin@fbs.vau.ac.lk' && $password === 'Admin@fbs' || $email === 'admin@fots.vau.ac.lk' && $password === 'Admin@fots') {
            $_SESSION['user_id'] = 'hardcoded_admin'; 
            $_SESSION['user_name'] = 'Administrator';
            $_SESSION['user_email'] = $email;
            $_SESSION['user_role'] = 'admin';

            header("Location: ../dashboard_admin.php");
            exit;
        }

        try {
            $client = new Client("mongodb://localhost:27017");
            $db = $client->FacultyEvaluationSystem;
            $collection = $db->users;

            $user = $collection->findOne(['email' => $email]);

            if ($user && password_verify($password, $user['password'])) {
                // Set sessions only once
                $_SESSION['user_id'] = (string)$user['_id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = $user['role'];

                if ($user['role'] === 'admin') {
                    header("Location: ../dashboard_admin.php");
                    exit;
                } else {
                    header("Location: ../index.php");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Invalid email or password.";
                header("Location: ../login.php");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "An error occurred: " . $e->getMessage();
            header("Location: ../login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Please enter a valid email and password.";
        header("Location: ../login.php");
        exit;
    }
} else {
    header("Location: ../index.php");
    exit;
}

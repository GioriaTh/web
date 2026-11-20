<?php
// Include the database connection
include '../../includes/db_connect.php';

// Start the session
session_start();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute SQL query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check the password (hashed, or a legacy plain-text value that is upgraded on login)
        $valid = password_verify($password, $user['password_hash']);
        if (!$valid && hash_equals((string)$user['password_hash'], $password)) {
            $valid = true;
            $upd = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
            $upd->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
        }
        if ($valid) {
            // Successful login
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role']; // Save the user's role in the session
            $_SESSION['user_id'] = $user['id']; // Save user_id in the session
            
            // Redirect based on user role
            if ($user['role'] === 'administrator') {
                header("Location: ../admin/adminhome.php");
            } elseif ($user['role'] === 'rescuer') {
                header("Location: ../rescuer/rescuerhome.php");
            } elseif ($user['role'] === 'citizen') {  // Add condition for citizen
                header("Location: ../citizen/citizenhome.php");  // Redirect to citizen home
            } else {
                echo "Invalid user role.";
                exit;
            }
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "Username not found.";
    }
}

$conn = null; // Close the database connection
?>

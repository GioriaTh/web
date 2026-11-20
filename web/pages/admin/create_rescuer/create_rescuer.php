<?php
include '../../../includes/db_connect.php';
include '../../../includes/admin_access.php';

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Simple validation
    if (empty($username) || empty($password) || empty($name) || empty($phone)) {
        $response['error'] = 'All fields are required.';
    } elseif (strlen($password) < 6) {
        $response['error'] = 'Password must be at least 6 characters long.';
    } else {
        try {
            // Check if username already exists
            $stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE username = :username");
            $stmt->bindParam(':username', $username);
            $stmt->execute();

            if ($stmt->fetchColumn() > 0) {
                $response['error'] = 'Username already exists.';
            } else {
                // Insert new rescuer with hashed password
                $stmt = $conn->prepare("
                    INSERT INTO users (username, password_hash, role, name, phone)
                    VALUES (:username, :password, 'rescuer', :name, :phone)
                ");
                $stmt->bindParam(':username', $username);
                $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $passwordHash);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':phone', $phone);
                $stmt->execute();

                $response['success'] = 'Rescuer account created successfully.';
            }
        } catch (PDOException $e) {
            $response['error'] = 'Database error: ' . $e->getMessage();
        }
    }
}

// Send JSON response
header('Content-Type: application/json');
echo json_encode($response);
exit;
?>

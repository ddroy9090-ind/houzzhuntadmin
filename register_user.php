<?php
header('Content-Type: application/json');
error_reporting(0);
ini_set('display_errors', 0);

include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = trim($_POST['name']);
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']);
    $cpassword= trim($_POST['confirm_password']);
    $role     = $_POST['role'];

    if ($password !== $cpassword) {
        echo json_encode(["status" => "error", "message" => "Passwords do not match!"]);
        exit;
    }

    $profileImage = '';
    if (!empty($_FILES['profile_image']['name']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/users/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $tmpName = $_FILES['profile_image']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['profile_image']['name']);
        $destPath = $uploadDir . $fileName;
        if (move_uploaded_file($tmpName, $destPath)) {
            $profileImage = $destPath;
        }
    }

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO users (name, username, email, password, role, profile_image) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => $conn->error]);
        exit;
    }

    $stmt->bind_param("ssssss", $name, $username, $email, $hashed_password, $role, $profileImage);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "User registered successfully!"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
}
?>

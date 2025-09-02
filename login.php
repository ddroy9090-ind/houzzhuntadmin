<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Store in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            // Detect user currency based on IP
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            $geoData = @json_decode(file_get_contents("https://ipapi.co/{$ip}/json/"), true);
            $_SESSION['currency'] = $geoData['currency'] ?? 'AED';

            // Redirect to index.php (common dashboard)
            header("Location: index.php");
            exit;
        } else {
            echo "❌ Invalid password!";
        }
    } else {
        echo "❌ User not found!";
    }
}
?>
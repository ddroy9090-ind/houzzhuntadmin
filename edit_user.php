<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id       = $_POST['id'];
    $name     = $_POST['name'];
    $username = $_POST['username'];
    $email    = $_POST['email'];
    $role     = $_POST['role'];

    $profileSql = '';
    $params = [$name, $username, $email, $role];
    $types = "ssss";
    if (!empty($_FILES['profile_image']['name']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/users/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $tmp = $_FILES['profile_image']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['profile_image']['name']);
        $dest = $uploadDir . $fileName;
        if (move_uploaded_file($tmp, $dest)) {
            $profileSql = ", profile_image=?";
            $params[] = $dest;
            $types .= "s";
        }
    }
    $params[] = $id;
    $types .= "i";

    $sql = "UPDATE users SET name=?, username=?, email=?, role=?$profileSql WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param($types, ...$params);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }
}
?>

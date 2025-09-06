<?php
include 'includes/auth.php';
include 'config.php';

$current = $_SESSION['user_id'];
$res = $conn->query("SELECT id, name, profile_image, last_active FROM users WHERE id <> $current");
$users = [];
while ($row = $res->fetch_assoc()) {
    $online = false;
    if ($row['last_active']) {
        $online = (strtotime($row['last_active']) > time() - 300); // 5 minutes
    }
    $img = !empty($row['profile_image']) ? $row['profile_image'] : 'assets/images/users/avatar-1.jpg';
    $users[] = [
        'id' => $row['id'],
        'name' => $row['name'],
        'online' => $online,
        'last_active' => $row['last_active'],
        'profile_image' => $img
    ];
}
header('Content-Type: application/json');
echo json_encode($users);

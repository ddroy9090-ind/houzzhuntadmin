<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "houzzhunt_portal";

// $host = "localhost";
// $user = "u431421769_hhroot";
// $pass = "Reliant@1977";
// $db   = "u431421769_Channel_CMS";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


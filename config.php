<?php
// $host = "localhost";
// $user = "root";
// $pass = "";
// $db   = "houzzhunt_portal";

$host = "localhost";
$user = "u431421769_houzzhunt";
$pass = "Reliant@1977";
$db   = "u431421769_channelportal";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>


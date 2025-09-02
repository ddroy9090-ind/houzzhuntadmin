<?php
session_start();
if (isset($_POST['currency'])) {
    $_SESSION['currency'] = $_POST['currency'];
}
$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header('Location: ' . $redirect);
exit;
?>

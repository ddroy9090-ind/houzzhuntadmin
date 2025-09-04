<?php
session_start();

if (isset($_POST['currency'])) {
    $_SESSION['currency'] = $_POST['currency'];
}

// If the request comes from AJAX, return a simple response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    echo 'ok';
    return;
}

$redirect = $_SERVER['HTTP_REFERER'] ?? 'index.php';
header('Location: ' . $redirect);
exit;
?>

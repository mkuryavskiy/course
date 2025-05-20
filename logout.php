<?php
$host  = $_SERVER['HTTP_HOST'];
session_start();
session_unset();
if (isset($_COOKIE['auth'])) {
    unset($_COOKIE['auth']);
    setcookie('auth', '', time() - 3600, '/'); // empty value and old timestamp
}
session_destroy();
header("Location: https://$host/");
exit;
?>
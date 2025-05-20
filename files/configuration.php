<?php

// Настройки подключения к базе данных
define('hostname', 'localhost');
define('username', 'wiq_by');
define('password', 'letroom');
define('database', 'wiq_by');

// Улучшенное подключение к базе данных
try {
    $connect_root = new mysqli(hostname, username, password, database);
    if ($connect_root->connect_error) {
        throw new Exception("Ошибка подключения: " . $connect_root->connect_error);
    }
} catch (Exception $e) {
    error_log($e->getMessage());
    die("Не удалось подключиться к базе данных. Пожалуйста, попробуйте позже.");
}

// Установка кодировки
$connect_root->set_charset("utf8mb4");

// Использование подготовленного запроса для ускорения и безопасности
$stmt = $connect_root->prepare("SELECT liqpay_private, liqpay_public, liqpay_comission FROM `settings` LIMIT 1");

if ($stmt) {
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $liqpay_private = $row['liqpay_private'];
        $liqpay_public = $row['liqpay_public'];
        $liqpay_comission = $row['liqpay_comission'];
    } else {
        error_log("Не удалось получить настройки из базы данных.");
        die("Произошла ошибка при получении настроек.");
    }
    $stmt->close();
} else {
    error_log("Ошибка подготовки запроса: " . $connect_root->error);
    die("Произошла ошибка при работе с базой данных.");
}

?>
<?php
//require('files/layer.php');
require_once('files/functions.php');

if (isset($_GET['liqpay_create'])) {
    $sum = explode(' ', $_GET['amount']);
    $sum = floatval($sum[0]); // Преобразуем сумму в число
    $user = $_GET['user'];
    $date = time();

    $minAmount = 2.5; // Устанавливаем минимальную сумму на сервере

    // Проверка минимальной суммы на сервере
    if ($sum < $minAmount) {
        echo "Минимальная сумма: $minAmount";
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO `deposits`(`DepositUserID`, `DepositVerification`, `DepositAmount`, `DepositType`, `DepositRefunded`, `DepositDate`, `DepositStatus`) VALUES (:user, "0", :sum, "LiqPay", "No", :dt, "Created")');
    $stmt->execute([':user' => $user, ':sum' => $sum, ':dt' => $date]);

    $stmt = $pdo->prepare('SELECT * FROM `deposits` WHERE `DepositUserID` = :user ORDER BY `DepositID` DESC LIMIT 1');
    $stmt->execute([':user' => $user]);
    $row = $stmt->fetch();

    $order = $row['DepositID'];
    $sum = $sum + ($sum * ($liqpay_comission / 100));
    $sum = number_format($sum, 2, '.', '');

    header("Location: https://bioaqua-ukraine.com.ua/pay_get.php?sum=$sum&user=$user&order=$order");
    exit();
}

if (isset($_POST['change_settings'])) {
    $user->IsAdmin();

    $public = $_POST['public'];
    $private = $_POST['private'];
    $comission = $_POST['comission'];

    $stmt = $pdo->prepare('UPDATE `settings` SET `liqpay_private` = :private, `liqpay_public` = :public, `liqpay_comission` = :comission');
    $stmt->execute([':private' => $private, ':public' => $public, ':comission' => $comission]);
    $row = $stmt->fetch();

    echo 'Настройки успешно сохранены';
}
?>

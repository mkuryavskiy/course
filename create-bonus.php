<?php
require_once('files/functions.php');
require_once(dirname(__FILE__) . '/autoload.php');

const BOT_NAME = 'wiqbonus';
const BOT_URL = 'https://t.me/wiqbonus_bot';

function createUniqueCode($pdo, $length = 6) {
    $characters = '0123456789';
    do {
        $code = '';
        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[random_int(0, strlen($characters) - 1)];
        }
        $stmt = $pdo->prepare('SELECT 1 FROM users_bonus WHERE code = ?');
        $stmt->execute([$code]);
    } while ($stmt->fetch());
    return $code;
}

function getBonusMessage($amount, $code) {
    return "<span>Ваш бонус на сегодня: {$amount} $<br> Для получения бонуса введите код <span style=\"font-weight: bold;\">{$code}</span> в телеграм боте <a style=\"text-decoration: none; color: black;\" target=\"_blank\" href=\"" . BOT_URL . "\">@" . BOT_NAME . "_bot</a></span>
    <div class=\"text-center\">
    <a style=\"text-decoration: none; margin-bottom: 15px;\" href=\"tg://resolve?domain=wiqbonus_bot\" class=\"text-center btn btn-default btn-sm\">
    <i class=\"fab fa-telegram-plane\"></i> Перейти в БОТ</a>
    </div>";
}

try {
    if (!isset($_POST['g-recaptcha-response'])) {
        throw new Exception('Captcha response not provided');
    }

    $stmt = $pdo->prepare('SELECT * FROM users_bonus WHERE id_user = ? AND dt = CURRENT_DATE');
    $stmt->execute([$UserID]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $user['sended']) {
        echo json_encode(['msg' => 'Вы уже получали бонус сегодня, приходите завтра']);
        exit;
    }

    if ($user && $user['amount'] && $user['code']) {
        echo json_encode(['result' => 'ok', 'msg' => getBonusMessage($user['amount'], $user['code'])]);
        exit;
    }

    $newBonus = [
        'code' => createUniqueCode($pdo),
        'amount' => number_format(mt_rand(1, 4) / 100, 2)
    ];

    $sql = $user 
        ? 'UPDATE users_bonus SET sended = 0, amount = :amount, code = :code WHERE id_user = :id_user'
        : 'INSERT INTO users_bonus (id_user, dt, amount, code, sended) VALUES (:id_user, CURRENT_DATE, :amount, :code, 0)';
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':id_user' => $UserID,
        ':amount' => $newBonus['amount'],
        ':code' => $newBonus['code']
    ]);

    echo json_encode(['result' => 'ok', 'msg' => getBonusMessage($newBonus['amount'], $newBonus['code'])]);
} catch (Exception $e) {
    error_log($e->getMessage());
    echo json_encode(['result' => 'error', 'msg' => 'An error occurred. Please try again later.']);
}
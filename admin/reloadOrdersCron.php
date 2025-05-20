<?php

require_once('files/functions.php');
global $layer;
global $pdo;
global $orders;

// Функция для обновления статуса заказа
function updateOrderStatus($pdo, $orders, $OrderID, $status, $remain, $MoneyWasReturned) {
    if ($status == 'Refunded' || $status == 'Canceled') {
        $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :status, OrderCharge = 0 WHERE OrderID = :OrderID');
        $stmt->execute(array(':status' => $status, ':OrderID' => $OrderID));
        
        $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :UserBalance WHERE UserID = :UserID');
        $stmt->execute(array(':UserBalance' => $orders->GetOrderCharge($OrderID), ':UserID' => $orders->GetOrderUserID($OrderID)));
    } elseif ($status == 'Partial' && !$MoneyWasReturned) {
        $charge = $orders->GetPrice1($orders->GetOrderServiceID($OrderID), 1 / 100);
        $payp = $remain * $charge;

        $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :UserBalance WHERE UserID = :UserID');
        $stmt->execute(array(':UserBalance' => $payp, ':UserID' => $orders->GetOrderUserID($OrderID)));

        $stmt = $pdo->prepare('UPDATE orders SET MoneyWasReturned = 1 WHERE OrderID = :OrderID');
        $stmt->execute(array(':OrderID' => $OrderID));
    }

    if ($status == 'Completed') {
        $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Completed", OrderRemain = 0 WHERE OrderID = :OrderID');
        $stmt->execute(array(':OrderID' => $OrderID));
    } else {
        $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :status WHERE OrderID = :OrderID');
        $stmt->execute(array(':status' => $status, ':OrderID' => $OrderID));
    }
}

// Функция для обновления остатка заказа
function updateOrderRemain($pdo, $orders, $OrderID, $status) {
    $OrderRemains = $orders->CheckOrderRemains($OrderID);

    if ($status == 'Completed' && $OrderRemains != 0) {
        $stmt = $pdo->prepare('UPDATE orders SET `OrderRemain` = 0 WHERE OrderID = :OrderID');
        $stmt->execute(array(':OrderID' => $OrderID));
    } elseif (!in_array($status, array('Refunded', 'Canceled', 'Partial', 'Mistake', 'Deleted', 'MistakeCanceled', 'Completed'))) {
        $stmt = $pdo->prepare('UPDATE orders SET `OrderRemain` = :OrderRemain WHERE OrderID = :OrderID');
        $stmt->execute(array(':OrderRemain' => $OrderRemains, ':OrderID' => $OrderID));
    }
}

// Основной код для обработки заказов
$result = $pdo->prepare("SELECT * FROM `orders` WHERE `OrderStatus` IN ('Processing', 'Pending', 'In progress', 'API') ORDER BY `OrderID` DESC");
$result->execute();
$ordersList = $result->fetchAll();

foreach ($ordersList as $Order_) {
    $OrderID = $Order_[0];
    $status = $Order_[7];
    $orderStatus = $Order_[7];
    $remain = $Order_[12];
    $quantity = $Order_[3];
    $userId = $Order_[2];
    $MoneyWasReturned = $Order_[16];
    $OrderAPIID = $Order_[6];

    if (!empty($OrderAPIID) && $OrderAPIID != 0) {
        $order = $orders->CheckOrder($OrderID);
        $resp = json_decode($order);

        if (isset($resp) && property_exists($resp, 'status')) {
            $status = $resp->status;
        }

        updateOrderStatus($pdo, $orders, $OrderID, $status, $remain, $MoneyWasReturned);
    }

    updateOrderRemain($pdo, $orders, $OrderID, $status);
}

?>

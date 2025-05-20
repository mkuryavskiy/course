<?php

require_once('files/functions.php');
global $layer;

global $pdo;
$result = $pdo->prepare("SELECT * FROM `orders` WHERE `OrderStatus` IN ('Processing', 'Pending', 'In progress', 'API', 'Mistake') ORDER BY `OrderID` DESC");
$result->execute();
$result = $result->fetchAll();
$sql = "";
global $orders;

foreach ($result as $key => $Order_) {
    $status = $Order_[7];
    $orderStatus = $Order_[7];
    $remain = $Order_[12];
    $quantity = $Order_[3];
    $OrderID = $Order_[0];
    $userId = $Order_[2];
    $MoneyWasReturned = $Order_[16];
    $OrderAPIID = $Order_[6];

    if (!empty($Order_[6]) && $Order_[6] != 0) {
        $order = $orders->CheckOrder($OrderID);
        $resp  = json_decode($order);

        if (isset($resp) && property_exists($resp, 'status')) {
            $status = $resp->status;
        }

        if ($status == 'Refunded') {
            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Refunded" WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderID' => $Order_['OrderID']
            ));
            $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :UserBalance WHERE UserID = :UserID');
            $stmt->execute(array(
                ':UserBalance' => $Order_['OrderCharge'],
                ':UserID' => $Order_['OrderUserID']
            ));
            $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderCharge' => 0,
                ':OrderID' => $Order_['OrderID']
            ));
        } elseif ($status == 'Canceled') {
            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Canceled" WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderID' => $Order_['OrderID']
            ));
            $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :UserBalance WHERE UserID = :UserID');
            $stmt->execute(array(
                ':UserBalance' => $Order_['OrderCharge'],
                ':UserID' => $Order_['OrderUserID']
            ));
            $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderCharge' => 0,
                ':OrderID' => $Order_['OrderID']
            ));
        } elseif($status == 'Partial') {
            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Partial" WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderID' => $Order_['OrderID']
            ));

            if(!$MoneyWasReturned) {
                // Вычисляем точную цену за единицу без деления на 100
                $unitPrice = $Order_['OrderCharge'] / $Order_['OrderQuantity'];
                $refundAmount = $remain * $unitPrice;

                $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :UserBalance WHERE UserID = :UserID');
                $stmt->execute(array(
                    ':UserBalance' => $refundAmount,
                    ':UserID' => $Order_['OrderUserID']
                ));

                $stmt = $pdo->prepare('UPDATE orders SET MoneyWasReturned = 1 WHERE OrderID = :OrderID');
                $stmt->execute(array(
                    ':OrderID' => $OrderID
                ));
            }
        } elseif ($status == 'Mistake') {
            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Mistake" WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderID' => $Order_['OrderID']
            ));
            $link = $Order_['OrderLink'];
            $quantity = $Order_['OrderQuantity'];
            $URL = str_replace('[QUANTITY]', $quantity, $Order_['ServiceAPI']);
            $URL = str_replace('[LINK]', $link, $URL);

            $layer->SendCurl($URL);
        } elseif ($status == 'MistakeCanceled') {
            // Do nothing for MistakeCanceled
        } elseif ($status == 'Completed') {
            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Completed", OrderRemain = 0 WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderID' => $Order_['OrderID']
            ));
        } else {
            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
            $stmt->execute(array(
                ':OrderStatus' => $status,
                ':OrderID' => $Order_['OrderID']
            ));
        }
    } elseif($status == 'Mistake') {
        $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = "Mistake" WHERE OrderID = :OrderID');
        $stmt->execute(array(
            ':OrderID' => $Order_['OrderID']
        ));

        $result = $pdo->prepare("SELECT * FROM `services` WHERE `ServiceID`=".$Order_['OrderServiceID']);
        $result->execute();
        $ServiceAPI = $result->fetch();
        $ServiceAPI = $ServiceAPI['ServiceAPI'];

        $link = $Order_['OrderLink'];
        $quantity = $Order_['OrderQuantity'];
        $URL = str_replace('[QUANTITY]', $quantity, $ServiceAPI);
        $URL = str_replace('[LINK]', $link, $URL);

        $return = $layer->SendCurl($URL);
        $resp = json_decode($return);

        if(isset($resp) && property_exists($resp, 'order')) {
            $order_id = $resp->order;
            $result = $pdo->prepare("UPDATE `orders` SET `OrderAPIID`=".$order_id." WHERE `OrderID`=".$Order_['OrderID']);
            $result->execute();
        }
    }

    // Additional check to ensure OrderRemain is 0 for completed orders
    if ($status == 'Completed') {
        $stmt = $pdo->prepare('UPDATE orders SET OrderRemain = 0 WHERE OrderID = :OrderID');
        $stmt->execute(array(
            ':OrderID' => $OrderID
        ));
    } elseif(!empty($status) && !in_array($status, array('Mistake','Deleted','Refunded','Canceled','Completed'))) {
        $orders->CheckOrderStartCount($Order_[0]);
        $OrderRemains = $orders->CheckOrderRemains($Order_[0]);

        if (!in_array($orderStatus, array('Refunded','Canceled','Partial'))) {
            $sql .= "UPDATE orders SET `OrderRemain` = $OrderRemains WHERE OrderID = ".$Order_[0].";";
        }
    }

    $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
    $stmt->execute(array(
        ':OrderID' => $OrderID
    ));
    $checkOrder = $stmt->fetch();
}

if(!empty($sql)) {
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

// Final check to ensure all completed orders have OrderRemain set to 0
$stmt = $pdo->prepare('UPDATE orders SET OrderRemain = 0 WHERE OrderStatus = "Completed" AND OrderRemain != 0');
$stmt->execute();
?>
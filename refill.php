<?php

require_once('files/functions.php');

global $orders;

$order_id = (int)$_POST['order_id'];

$stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :order_id AND OrderUserID = :user_id');
$stmt->execute([':order_id' => $order_id, ':user_id' => (int)$_SESSION['auth']]);

$result = [];

if ($stmt->rowCount() > 0) {
    $order = $stmt->fetch();

    $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
    $stmt->execute([':ServiceID' => $order['OrderServiceID']]);
    
    if ($stmt->rowCount() == 1) {
        $service = $stmt->fetch();        
        
        $URL = str_replace('[OrderID]', $order['OrderAPIID'], $service['ServiceOrderAPI']);
        $return = $layer->SendCurl($URL);
        $resp = json_decode($return);

        if (!empty($service['ServiceAPI']) && isset($resp) && property_exists($resp, 'start_count')) {
            $URL = str_replace('[OrderID]', $order['OrderAPIID'], $service['ServiceOrderAPI']);
            $URL = str_replace('status', 'refill', $URL);

            $return = $layer->SendCurl($URL);
            $resp = json_decode($return);

            if (isset($resp->status) && $resp->status === 'ok') {
                $result['success'] = true;
            } elseif (isset($resp) && property_exists($resp, 'error')) {
                $result['error'] = 'Refill not allowed';
                // Handle error logging and notification here
            }
        } else {
            $result['error'] = 'Refill not allowed';
        }
    } else {
        $result['error'] = 'Refill not allowed';
    }
} else {
    $result['error'] = 'Заказ не найден';
}

echo json_encode($result);
die();

<?php

include('files/layer.php');
global $layer;

$result = $pdo->prepare("SELECT * FROM `orders` WHERE `OrderStatus`='Mistake' ");
$result->execute();
$result = $result->fetchAll();

foreach ($result as $key => $Order_) {

    $result = $pdo->prepare("SELECT * FROM `services` WHERE `ServiceID`=" . $Order_['OrderServiceID']);
    $result->execute();
    $ServiceAPI = $result->fetch();
    $ServiceAPI = $ServiceAPI['ServiceAPI'];
    $link = $Order_['OrderLink'];
    $quantity = $Order_['OrderQuantity'];
    $URL = str_replace('[QUANTITY]', $quantity, $ServiceAPI);
    $URL = str_replace('[LINK]', $link, $URL);

    $return = $layer->SendCurl($URL);
    $resp = json_decode($return);
    echo "\n0\n";
    print_r($resp, true);
    if (isset($resp) && property_exists($resp, 'order')) {
        echo "\n1\n";
        $order_id = $resp->order;
        $result = $pdo->prepare("UPDATE `orders` SET `OrderAPIID`=" . $order_id . " WHERE `OrderID`=" . $Order_['OrderID']);
        $result->execute();
    } elseif (isset($resp) && property_exists($resp, 'error')) {
        echo "\n2\n";
    }
}

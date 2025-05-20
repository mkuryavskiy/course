<?php
require_once('../functions.php');
include('../configuration.php');

$table = 'orders';
$primaryKey = 'OrderID';

$columns = array(
    array( 'db' => 'OrderID', 'dt' => 0 ),
    array(
        'db' => 'OrderServiceID',
        'dt' => 1,
        'formatter' => function( $d, $row ) {
            global $layer;

            $lang = (isset($_GET['lang']) && !empty($_GET['lang'])) ? substr($_GET['lang'], 0 ,3) : 'ru';

            return "[".$d."] ".$layer->GetData('services',($lang == "ru") ? 'ServiceName' : 'ServiceName'.mb_strtoupper($lang), 'ServiceID', $d);
        }
    ),
    array(
        'db' => 'OrderCharge',
        'dt' => 2,
        'formatter' => function( $d, $row ) {
            global $currency;
            global $orders;

            switch ($row['OrderStatus']) {
                case 'Partial':
                    // Вычисляем точную цену за единицу без использования GetPrice1
                    $unitPrice = $row['OrderCharge'] / $row['OrderQuantity'];
                    // Сумма, которая была списана (за доставленные товары)
                    $chargedAmount = ($row['OrderQuantity'] - $row['OrderRemain']) * $unitPrice;
                    return $chargedAmount . $currency;
                case 'Canceled':
                    return '0' . $currency;
                default:
                    // Это будет работать для всех остальных статусов, включая 'In progress'
                    return $d . $currency;
            }
        }
    ),
    array( 'db' => 'OrderQuantity', 'dt' => 3 ),
    array( 'db' => 'OrderLink', 'dt' => 4 ),
    array(
        'db' => 'OrderDate',
        'dt' => 5,
        'formatter' => function( $d, $row ) {
            return date('d.m.Y H:i:s', $d);
        }
    ),
    array(
        'db' => 'OrderRemain',
        'dt' => 6,
        'formatter' => function( $d, $row ) {
            if ($row['OrderStatus'] == 'Canceled') {
                $OrderRemains = 0;
            } else {
                if(is_null($d)){
                    $OrderRemains = $row['OrderQuantity'];
                }else{
                    $OrderRemains = $d;
                }
            }
            return $OrderRemains;
        }
    ),
    array(
        'db' => 'OrderStartCount',
        'dt' => 7,
        'formatter' => function( $d, $row ) {
            if ($row['OrderStatus'] == 'Canceled') {
                $OrderStartCount = 0;
            } else {
                $OrderStartCount = $d;
                if($OrderStartCount == ''){
                    $OrderStartCount = 0;
                }
            }
            return $OrderStartCount;
        }
    ),
    array(
        'db' => 'OrderID',
        'dt' => 8,
        'formatter' => function( $d, $row ) {
            global $orders;

            $current = $orders->serializeStatus($row['OrderStatus'], $row['OrderRemain'], $row['OrderQuantity']);
            $OrderStatus = $orders->CheckOrderStatus($d);

            if ($current != $OrderStatus)
                return $current . '<span style="display:none;">'.$row['OrderStatus'].'</span>';
            else
                return $OrderStatus . '<span style="display:none;">'.$row['OrderStatus'].'</span>';
        }
    ),
    array(
        'db' => 'OrderStatus',
        'dt' => 9,
        'formatter' => function( $d, $row ) {
            global $orders;
            global $layer;

            if ($row['OrderStatus'] == 'Canceled'){
                return '';
            }

            $refill_duration = 0;
            $refill = $layer->GetData('services', 'refill', 'ServiceID', $row['OrderServiceID']);
            if($refill==1){
                $refill_duration = $layer->GetData('services', 'refill_duration', 'ServiceID', $row['OrderServiceID']);
            }
            $timeDiff = time() - $row['OrderDate'];
            $refill_duration = ($timeDiff < ($refill_duration * 24 * 60 * 60)) ? 1 : 0;
            $cancel = $layer->GetData('services', 'cancel', 'ServiceID', $row['OrderServiceID']);

            $OrderAction = $orders->CheckOrderAction($d, $refill, $cancel, $row['OrderID'], $refill_duration);
            return $OrderAction;
        }
    )
);

$sql_details = array(
    'user' => username,
    'pass' => password,
    'db'   => database,
    'host' => hostname
);

require("ssp.class.php");
$result = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, "OrderUserID = '$UserID'" );

echo json_encode($result);
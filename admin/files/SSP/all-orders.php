<?php
 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
ini_set('log_errors', 'On');
ini_set('error_log', 'php_errors.log');
require_once('../../../files/functions.php');
 
// DB table to use
$table = 'orders';
 
// Table's primary key
$primaryKey = 'OrderID';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes


$columns = array(
    array( 'db' => 'OrderID', 'dt' => 0 ),
    array(
        'db'        => 'OrderServiceID',
        'dt'        => 1,
        'formatter' => function( $d, $row ) {
            global $layer;
            
            $ServiceName = $layer->GetData('services', 'ServiceName', 'ServiceID', $d);
            return '[' . $d . '] ' . $ServiceName;
        }
    ),
    array(
        'db'        => 'OrderUserID',
        'dt'        => 2,
        'formatter' => function( $d, $row ) {
            global $layer;
            
            $UserName = $layer->GetData('users', 'UserName', 'UserID', $d);
            return $UserName;
        }
    ),
    array(
        'db'        => 'OrderCharge',
        'dt'        => 3,
        'formatter' => function( $d, $row ) {
            global $currency;
            global $orders;

            $status = $orders->GetOrderStatus($row['OrderID']);

            switch ($status) {
                case 'Partial':
                    // Calculate exact price per unit directly from order data
                    $unitPrice = $row['OrderCharge'] / $row['OrderQuantity'];
                    // Calculate amount charged for delivered items only
                    $chargedAmount = ($row['OrderQuantity'] - $row['OrderRemain']) * $unitPrice;
                    return $chargedAmount . $currency;
                case 'In progress':
                    $payp = $row['OrderQuantity'] * ($row['OrderCharge'] / $row['OrderQuantity']);
                    return $payp . $currency;
                case 'Canceled':
                    return '0' . $currency;
                default:
                    return $d . $currency;
            }
        }
    ),
    array( 'db' => 'OrderQuantity', 'dt' => 4 ),
    array( 'db' => 'OrderLink', 'dt' => 5 ),
    array(
        'db'        => 'OrderDate',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            return date('d.m.Y H:i:s', $d);
        }
    ),
    array(
        'db'        => 'OrderRemain',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {
            global $orders;

            $status = $orders->GetOrderStatus($row['OrderID']);

            if ($status == 'Canceled') {
                $OrderRemains = 0;
            } else {
                //$OrderRemains = $orders->CheckOrderRemains($row['OrderID']);
                $OrderRemains = $row['OrderRemain'];
            }

            return $OrderRemains;
        }
    ),
    array(
        'db'        => 'OrderID',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
            global $orders;

            $status = $orders->GetOrderStatus($row['OrderID']);

            if ($status == 'Canceled') {
                $OrderStartCount = 0;
            } else {
                $OrderStartCount = $orders->CheckOrderStartCount($row['OrderID']);
            }
            return (int)$OrderStartCount;
        }
    ),
    array(
        'db'        => 'OrderID',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            global $orders;
            
            // текущий статус
            //$current = $orders->serializeStatusAdmin($row['OrderStatus'], $row['OrderRemain'], $row['OrderQuantity']);

            // обновляем
            $OrderStatus = $orders->CheckOrderStatusAdmin($d);

            // если новый отличается то надо текущий
            // if ($current != $OrderStatus)
            //     $OrderStatus = $current;

            $html = '<select onChange="updateOrderStatusAdmin('.$d.', this.value)" class="form-control">';
            $html .= '<option value="'.$OrderStatus.'" selected>'.$OrderStatus.'</option>';
            $html .= '<option disabled>---</option>';
            $html .= '<option value="Completed">Завершен</option>';
            $html .= '<option value="Processing">Принят</option>';
            $html .= '<option value="Pending">Запускается</option>';
            $html .= '<option value="Canceled">Отменен</option>';
            $html .= '<option value="Refunded">Возвращено</option>';
            $html .= '<option value="Deleted">Удален</option>';
            $html .= '<option value="Mistake">Ошибка</option>';
            $html .= '<option value="In progress">Выполняется</option>';
            $html .= '<option disabled>---</option>';
            $html .= '<option value="Delete Order">Удалить заказ</option>';
            $html .= '<option disabled>---</option>';
            $html .= '<option value="API">Повторная отправка API</option>';
            $html .= '<option value="CancelOrder">Отменить заказ API</option>';
            $html .= '<option value="MoneyBack">Вернуть средства</option>';
            $html .= '</select>';
            
            return $html;
        }
    ),
    array(
        'db'        => 'OrderID',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
            global $pdo;
            
            $stmt = $pdo->prepare('SELECT OrderType FROM orders WHERE OrderID = :OrderID');
            $stmt->execute(array(':OrderID' => $d));
            
            if($stmt->rowCount() == 1) {
                $OrderType = $stmt->fetch();
                return $OrderType['OrderType'];
            } else {
                return 'Panel';
            }
        }
    )
   
);
// SQL server connection information
$sql_details = array(
    'user' => username,
    'pass' => password,
    'db'   => database,
    'host' => hostname
);
 
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */
 
require( 'ssp.class.php' );
 
echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
);
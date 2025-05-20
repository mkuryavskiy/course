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
			
			return $currency.$d;
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
        'db'        => 'OrderID',
        'dt'        => 7,
        'formatter' => function( $d, $row ) {
			global $orders;
			
			$OrderRemains = $orders->CheckOrderRemains($d);
			return $OrderRemains;
        }
    ),
	array(
        'db'        => 'OrderID',
        'dt'        => 8,
        'formatter' => function( $d, $row ) {
			global $orders;
			
			$OrderStartCount = $orders->CheckOrderStartCount($d);
			return $OrderStartCount;
        }
    ),
	array(
        'db'        => 'OrderID',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
			global $orders;
			
			$OrderStatus = strip_tags($orders->CheckOrderStatus($d));
			$html = '<select onChange="updateOrderStatusAdmin('.$d.', this.value)" class="form-control">';
			$html .= '<option value="'.$OrderStatus.'" selected>'.$OrderStatus.'</option>';
			$html .= '<option disabled>---</option>';
			$html .= '<option value="Completed">Завершен</option>';
			$html .= '<option value="Processing">В работе</option>';
			$html .= '<option value="Pending">Ожидание</option>';
			$html .= '<option value="Canceled">Отменен</option>';
			$html .= '<option value="Refunded">Возвращено</option>';
			$html .= '<option value="Deleted">Удален</option>';
			$html .= '<option disabled>---</option>';
			$html .= '<option value="Delete Order">Delete Order</option>';
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
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, "OrderStatus = 'Processing' OR OrderStatus = 'In progress' OR OrderStatus = 'Pending'")
);
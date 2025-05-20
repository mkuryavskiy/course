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
$table = 'users';
 
// Table's primary key
$primaryKey = 'UserID';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes


$columns = array(
    array( 'db' => 'UserID', 'dt' => 0 ),
    array( 'db' => 'UserName', 'dt' => 1 ),
    array( 'db' => 'UserEmail', 'dt' => 2 ),
    array( 'db' => 'UserGroup', 'dt' => 3 ),
    array( 'db' => 'UserAPI', 'dt' => 4 ),
    array(
        'db'        => 'UserBalance',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            global $currency;
            return $currency . number_format($d, 3, '.', '');
        }
    ),
    array(
        'db'        => 'UserDate',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            return date('d.m.Y', $d);
        }
    ),
    array( 'db' => 'UserIPAddress', 'dt' => 7 ),
    array( 'db' => 'UserTelegram', 'dt' => 8 ),
    array(
        'db'        => 'UserID',
        'dt'        => 9,
        'formatter' => function( $d, $row ) {
            return '<a class="btn btn-primary btn-lg" onClick="UserEdit('.$d.')">Редактировать</a>';
        }
    ),
    array(
        'db'        => 'UserID',
        'dt'        => 10,
        'formatter' => function( $d, $row ) {
            return '<a class="btn btn-danger btn-lg" onClick="UserDelete('.$d.')">Удалить</a>';
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
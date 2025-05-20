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
$table = 'categories';
 
// Table's primary key
$primaryKey = 'CategoryID';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes


$columns = array(
    array( 'db' => 'CategoryID', 'dt' => 0 ),
    array( 'db' => 'CategoryName', 'dt' => 1 ),
    array( 'db' => 'CategoryDescription', 'dt' => 2 ),
    array( 'db' => 'CategoryActive', 'dt' => 3 ),
	array(
        'db'        => 'CategoryDate',
        'dt'        => 4,
        'formatter' => function( $d, $row ) {
			return date('d.m.Y', $d);
        }
    ),
	array(
        'db'        => 'CategoryID',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
			return '<a class="btn btn-primary btn-lg" onClick="CategoryEdit('.$d.');">Редактировать</a>';
        }
    ),


    array( 'db' => 'sort', 'dt' => 100 )
	
  
   
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


$request = $_GET;
$request['order'] = [0 => [
    'column' => '100',
    'dir' => 'desc',
]];

$request['columns']['100'] = [
    'data' => 100,
    'name' => '',
    'searchable' => false,
    'orderable' => true,
];
 
echo json_encode(
    SSP::simple( $request, $sql_details, $table, $primaryKey, $columns)
);
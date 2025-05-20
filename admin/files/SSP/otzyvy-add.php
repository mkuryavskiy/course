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
$table = 'comments_added';
 
// Table's primary key
$primaryKey = 'CommentsID';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

$columns = array(
    array( 'db' => 'CommentsID', 'dt' => 0 ),
    array( 'db' => 'comments_title', 'dt' => 1 ),
	array( 'db'        => 'comments_name','dt' => 2),
    array( 'db'        => 'comments_date','dt' => 3),
    array( 'db'        => 'comments_answer','dt' => 4),
	array(
        'db'        => 'CommentsID',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
			return '<a class="btn btn-primary btn-lg" onClick="OtzyvAddEdit('.$d.');">Редактировать</a>';
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
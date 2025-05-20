<?php
 
 require_once('../functions.php');
 
// DB table to use
$table = 'refer_out';
 
// Table's primary key
$primaryKey = 'id';
 

$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'operDate', 'dt' => 1 ),
    array( 'db' => 'outSum', 'dt' => 2 ),
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
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, "idUser = '".$UserID."'")
);
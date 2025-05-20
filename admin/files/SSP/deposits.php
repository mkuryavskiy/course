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
$table = 'deposits';

// Table's primary key
$primaryKey = 'DepositID';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes


$columns = array(
	array('db' => 'DepositID', 'dt' => 0),
	array(
			'db' => 'DepositUserID',
			'dt' => 1,
			'formatter' => function($d, $row) {
					global $layer;
					$DepositUserName = $layer->GetData('users', 'UserName', 'UserID', $d);
					return $DepositUserName;
			}
	),
	array(
			'db' => 'DepositStatus',
			'dt' => 2,
			'formatter' => function($d, $row) {
					switch ($d) {
							case 'Success': return "Успішно"; break;
							case 'Created': return "Створено"; break;
							case 'Pending': return "В очікуванні"; break;
							case 'Processing': return "В процесі"; break;
							case 'Canceled': return "Відмінено"; break;
							default: return $d;
					}
			}
	),
	array(
    'db' => 'DepositAmount',
    'dt' => 3,
    'formatter' => function($d, $row) use ($currency) {
        $amount = (float)$d; // Faqat asl qiymatni olish
        return $currency . number_format($amount, 2); // Komissiyasiz natija
    }
),
	array('db' => 'DepositType', 'dt' => 4),
	array(
			'db' => 'DepositID',
			'dt' => 5,
			'formatter' => function($d, $row) {
					global $layer;
					$CurrentRefunded = $layer->GetData('deposits', 'DepositRefunded', 'DepositID', $d);
					return '
							<select class="form-control" onChange="DepositUpdate('.$d.', this.value);">
									<option selected value="'.$CurrentRefunded.'">'.$CurrentRefunded.'</option>
									<option disabled>---</option>
									<option value="Yes">Так</option>
									<option value="No">Ні</option>
							</select>
					';
			}
	),
	array(
			'db' => 'DepositDate',
			'dt' => 6,
			'formatter' => function($d, $row) {
					return date('d.m.Y H:i:s', $d);
			}
	),
	array(
			'db' => 'DepositID',
			'dt' => 7,
			'formatter' => function($d, $row) {
					return '<a class="btn btn-primary btn-lg" onClick="DepositDelete('.$d.');">Видалити</a>';
			}
	),
	// commission maydonini qo'shamiz, lekin uni ko'rsatmaymiz
	array('db' => 'commission', 'dt' => null) // yashirin ustun sifatida qo'shiladi
);

// SQL server connection information
$sql_details = array(
	'user' => username,
	'pass' => password,
	'db'   => database,
	'host' => hostname
);

require('ssp.class.php');

echo json_encode(
	SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)
);

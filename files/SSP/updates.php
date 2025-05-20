<?php
require_once('../../files/functions.php');
require('ssp.class.php');

$lang = isset($_GET["lang"]) ? strtoupper($_GET["lang"]) : "";
$langSuffix = ($lang && $lang !== "RU") ? $lang : "";

$columns = [
    [
        'db' => 'date',
        'dt' => 0,
        'formatter' => function($d) { return date('d.m.Y H:i', $d); }
    ],
    [
        'db' => 'service' . $langSuffix,
        'dt' => 1,
        'formatter' => function($d) use ($layer, $langSuffix) {
            $ServiceId = $layer->GetData('services', 'ServiceID', 'ServiceName' . $langSuffix, $d);
            $ServiceId = is_array($ServiceId) ? $ServiceId[0] : $ServiceId;
            return "[$ServiceId] $d";
        }
    ],
    ['db' => 'changes' . $langSuffix, 'dt' => 2],
];

echo json_encode(SSP::simple(
    $_GET,
    ['user' => username, 'pass' => password, 'db' => database, 'host' => hostname],
    'updates',
    'id',
    $columns
));
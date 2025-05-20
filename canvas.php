<?php
require_once 'files/functions.php';

$dates = [];
for ($i = 13; $i >= 0; $i--) {
    $dates[] = (new DateTime("-$i days"))->format('d.m.Y');
}

$data = [
    'status' => true,
    'data' => [
        'labels' => $dates,
        'data_count' => [],
        'data_sum' => []
    ]
];

echo json_encode($data);

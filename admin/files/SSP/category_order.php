<?php

require_once('../../../files/functions.php');

$current = (int)$_REQUEST['target'];
$prev = (int)$_REQUEST['prev'];
$next = (int)$_REQUEST['next'];

$stmt = $pdo->prepare('SELECT CategoryID, `sort` FROM categories ORDER BY `sort` DESC');
$stmt->execute();

$result = [];

while($row = $stmt->fetch()) {
    $result[(int)$row['CategoryID']] = $row['sort'];
}

unset($result[$current]);

$final = [];
$plus = 0;

if ($prev !== 0) {
    foreach($result as $id => $sort) {
        $final[$id] = $sort - $plus;
        if ((int)$id === $prev) {
            $plus++;
            $final[$current] = $sort - $plus;
        }
    }
} else {
    foreach($result as $id => $sort) {
        if ((int)$id === $next) {
            $final[$current] = $sort;
            $plus++;
        }
        $final[$id] = $sort - $plus;
    }
}

$stmt = $pdo->prepare('UPDATE categories SET `sort` = :sort WHERE `CategoryID` = :id');

foreach($final as $id => $sort) {
    $stmt->execute([':sort' => $sort, ':id' => $id]);
}

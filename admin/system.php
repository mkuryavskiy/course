<?php
require_once('../files/functions.php');

$user->IsAdmin();

$updSql = $pdo->prepare("UPDATE news SET NEWSDate = :date WHERE NEWSID = :id");

$sql = $pdo->prepare("SELECT * FROM news");
$sql->execute();
while ($row = $sql->fetch()) {
    $arr = explode('.', $row['NEWSDate']);
    $newDate = $arr[1] . '.' . $arr[0] . '.' . $arr[2];

    //$updSql->execute([':date' => $newDate, ':id' => $row['NEWSID']]);

}

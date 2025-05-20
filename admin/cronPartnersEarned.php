<?php

require_once(__DIR__ . '/../files/functions.php');

$sql = $pdo->prepare('UPDATE settings SET PartnersEarned = PartnersEarned + 10');
$sql->execute();

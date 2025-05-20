<?php

require_once('files/functions.php');

/** Разбанить пользователей */
$query = $pdo->prepare("DELETE FROM `users_banned` WHERE `UserBannedExpireDate` <= :now");
$query->execute([':now' => time()]);
$query = $query->fetch();

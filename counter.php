<?php
require_once("files/configuration.php");

$tb = "counter_plus";
$id = 1;

// Получение и обновление счетчиков одним запросом
$sql = "UPDATE $tb SET 
        count_one = LEAST(count_one + FLOOR(1 + RAND() * 7), 4294967295),
        count_two = CASE 
            WHEN count_two + FLOOR(89 + RAND() * 55) > 23089 THEN 11250
            ELSE count_two + FLOOR(89 + RAND() * 55)
        END,
        count_three = LEAST(count_three + FLOOR(142 + RAND() * 29), 4294967295)
        WHERE id = $id";

if (!mysqli_query($connect_root, $sql)) {
    die("Ошибка обновления данных: " . mysqli_error($connect_root));
}

echo "Счетчики успешно обновлены.";
?>
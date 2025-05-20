<?php

require_once(__DIR__ . '/../files/functions.php');

// Constants
const FILE_MEMORY_CRON = __DIR__ . '/logs/last_updated.txt';
const LOG_FILE = __DIR__ . '/logs/cron_speed.log';
const ORDER_TIME_THRESHOLD = 10860;
const ORDER_QUANTITY_THRESHOLD = 100;
const ORDER_PROGRESS_THRESHOLD = 100;
const UPDATE_INTERVAL = 4 * 24 * 60 * 60; // 4 days in seconds

// Helper functions
function writeLogLocalCS($msg) {
    $msg = '[' . date('Y-m-d H:i:s') . '] ' . $msg . "\n";
    file_put_contents(LOG_FILE, $msg, FILE_APPEND);
}

function updateServiceDescription($description, $isGreen, $greenText, $redText) {
    $pattern = '/<span class="speed_string"><font[^>]*><img[^>]*>[^<]*<\/font><\/span>/is';
    $greenString = '<span class="speed_string"><font color="#389038"><img src="/img/icons/green-circle.png" width="13px">' . $greenText . '</font></span>';
    $redString = '<span class="speed_string"><font color="#cf3030"><img src="/img/icons/red-circle.png" width="13px">' . $redText . '</font></span>';
    
    if ($isGreen) {
        $description = preg_replace($pattern, $greenString, $description);
        $description = str_replace('<span class="speed_string_2" style="display: none;">', '<span class="speed_string_2">', $description);
        $description = str_replace('<span class="speed_string_3">', '<span class="speed_string_3" style="display: none;">', $description);
    } else {
        $description = preg_replace($pattern, $redString, $description);
        $description = str_replace('<span class="speed_string_3" style="display: none;">', '<span class="speed_string_3">', $description);
        $description = str_replace('<span class="speed_string_2">', '<span class="speed_string_2" style="display: none;">', $description);
    }
    
    return $description;
}

// Main script
writeLogLocalCS(' ----- CRON START -----');

$statusLog = is_file(FILE_MEMORY_CRON) ? json_decode(file_get_contents(FILE_MEMORY_CRON), true) : [];
$lastUpdateTime = $statusLog['last_update_time'] ?? 0;
$currentTime = time();

$pdo->beginTransaction();

try {
    $sqlServiceUpdate = $pdo->prepare('UPDATE services SET ServiceDescription = :descr, ServiceDescriptionEN = :descrEN, ServiceDescriptionUA = :descrUA WHERE ServiceID = :id');
    $sqlOrder = $pdo->prepare('SELECT * FROM orders WHERE OrderServiceID = :service AND NOT OrderStatus IN ("Canceled", "Refunded", "Mistake") AND OrderQuantity >= :quantity AND OrderDate < :timer ORDER BY OrderID DESC LIMIT 1');
    $sql = $pdo->prepare('SELECT * FROM services');
    
    $sql->execute();
    while ($service = $sql->fetch()) {
        // Check if 4 days have passed to update all services to green
        if ($currentTime - $lastUpdateTime >= UPDATE_INTERVAL) {
            $descr = updateServiceDescription($service['ServiceDescription'], true, ' Быстрый запуск', ' Наблюдаются задержки запуска');
            $descrEN = updateServiceDescription($service['ServiceDescriptionEN'], true, ' Fast start', ' Start delay are possible');
            $descrUA = updateServiceDescription($service['ServiceDescriptionUA'], true, ' Швидкий запуск', ' Спостерігаються затримки запуску');
            
            if ($sqlServiceUpdate->execute([':descr' => $descr, ':descrEN' => $descrEN, ':descrUA' => $descrUA, ':id' => $service['ServiceID']])) {
                writeLogLocalCS("Service {$service['ServiceID']} updated to green status.");
            } else {
                writeLogLocalCS("Failed to update service {$service['ServiceID']}: " . var_export($sqlServiceUpdate->errorInfo(), true));
            }
        } else {
            $sqlOrder->execute([
                ':service' => $service['ServiceID'],
                ':quantity' => ORDER_QUANTITY_THRESHOLD,
                ':timer' => $currentTime - ORDER_TIME_THRESHOLD
            ]);
            
            if ($order = $sqlOrder->fetch()) {
                if (!isset($statusLog[$service['ServiceID']]) || $statusLog[$service['ServiceID']] !== $order['OrderID']) {
                    $statusLog[$service['ServiceID']] = $order['OrderID'];
                    $startCount = (int)$order['OrderQuantity'];
                    $remainCount = (int)$order['OrderRemain'];
                    
                    writeLogLocalCS("Order {$order['OrderID']}, start = $startCount, remain = $remainCount");
                    
                    $isGreen = ($startCount - $remainCount) >= ORDER_PROGRESS_THRESHOLD;
                    $color = $isGreen ? 'GREEN' : 'RED';
                    
                    $descr = updateServiceDescription($service['ServiceDescription'], $isGreen, ' Быстрый запуск', ' Наблюдаются задержки запуска');
                    $descrEN = updateServiceDescription($service['ServiceDescriptionEN'], $isGreen, ' Fast start', ' Start delay are possible');
                    $descrUA = updateServiceDescription($service['ServiceDescriptionUA'], $isGreen, ' Швидкий запуск', ' Спостерігаються затримки запуску');
                    
                    if ($sqlServiceUpdate->execute([':descr' => $descr, ':descrEN' => $descrEN, ':descrUA' => $descrUA, ':id' => $service['ServiceID']])) {
                        writeLogLocalCS("Update service {$service['ServiceID']} success - $color");
                    } else {
                        writeLogLocalCS("Update service {$service['ServiceID']} fail: " . var_export($sqlServiceUpdate->errorInfo(), true));
                    }
                }
            }
        }
    }
    
    // Update last update time if 4 days have passed
    if ($currentTime - $lastUpdateTime >= UPDATE_INTERVAL) {
        $statusLog['last_update_time'] = $currentTime;
    }

    $pdo->commit();
    file_put_contents(FILE_MEMORY_CRON, json_encode($statusLog));
} catch (Exception $e) {
    $pdo->rollBack();
    writeLogLocalCS("Transaction failed: " . $e->getMessage());
}

writeLogLocalCS(' ----- CRON END -----');

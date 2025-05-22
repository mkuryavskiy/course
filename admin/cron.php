<?php
require_once('../files/functions.php');

$user->IsAdmin();
$sql = $pdo->prepare("SELECT * FROM orders WHERE OrderStatus = 'Mistake'");
$sql->execute();
while ($row = $sql->fetch()) {
    $quantity = $row['OrderQuantity'];
	$link = $row['OrderLink'];
	if($row['OrderAPIID']==0){
		// логируем данные
        $log = "\n\n".date('d.m.Y  h:m'). "cron admin\n". print_r($row,true). "\n\n";
        file_put_contents("log.txt", $log, FILE_APPEND | LOCK_EX);
			
		$stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
		$stmt->execute(array(':ServiceID' => $row['OrderServiceID']));
		if($stmt->rowCount() == 1) {
			$row2 = $stmt->fetch();	
				
			$order_id = 0;
			if(!empty($row2['ServiceAPI'])) {
			
				$URL = str_replace('[QUANTITY]', $quantity, $row2['ServiceAPI']);
				$URL = str_replace('[LINK]', $link, $URL);
				//if(isset($additional) && !empty($additional))
				//	$URL = str_replace('[ADDON]', $additional, $URL);
				$return = $layer->SendCurl($URL);
				$resp = json_decode($return);
					
				if(isset($resp) && property_exists($resp, 'order')){
					$order_id = $resp->order;
				}elseif(isset($resp) && property_exists($resp, 'error')){
					// логируем данные
                    $log = "\n\n".date('d.m.Y  h:m'). "cron admin\n". print_r($resp->error,true). "\n\n";
                    file_put_contents("log.txt", $log, FILE_APPEND | LOCK_EX);
						
					$stmt = $pdo->prepare('SELECT NotificationEmail FROM settings');
					$stmt->execute();
					$AdmMAil = $stmt->fetch();
						
					$to = $AdmMAil[0];
					$sendfrom   = "info@".$_SERVER['SERVER_NAME'];
					$headers  = "From: " . strip_tags($sendfrom) . "\r\n";
					$headers .= "Reply-To: " . strip_tags($sendfrom) . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html;charset=utf-8 \r\n";
                    $subject = '=?utf-8?B?'.base64_encode('Помилка АПИ').'?=';
					$message = print_r($resp->error,true).'<br>
					'.$URL;
					$send = mail($to, $subject, $message, $headers);
				}
			}
				
			if($order_id > 0){
				$stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus, OrderAPIID = :OrderAPIID WHERE OrderID = :OrderID');
				$stmt->execute(array(':OrderStatus' => $OrderStatus, 'OrderAPIID' => $order_id, ':OrderID' => $OrderID));
			}	
		}
	}
}
?>
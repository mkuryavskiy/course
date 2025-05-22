<?php

require '../SMTP-Mailer/PHPMailer.php';
require '../SMTP-Mailer/SMTP.php';
require '../SMTP-Mailer/Exception.php';

require_once('../files/functions.php');

$user->IsAdmin();

function sendMail($name, $email, $text, $headers, $title) {
    // Формування самого листа
    $title = $title;
    $body = "
    <h2>$title</h2>
    <b>Ім'я:</b> $name<br>
    <b>Пошта:</b> $email<br><br>
    <b>Повідомлення:</b><br>$text<br>
    <b>Заголовки:</b><br>$headers<br>
    ";

    // Налаштування PHPMailer
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        $mail->isSMTP();   
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth   = true;
        // $mail->SMTPDebug = 4;
        $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

        // Налаштування вашої пошти
        $mail->Host       = 'mail.wiq.by'; // SMTP сервер вашої пошти
        $mail->Username   = 'noreply@wiq.by'; // Логін на пошті
        $mail->Password   = '126125gg'; // Пароль на пошті
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;
        $mail->setFrom('noreply@wiq.by', 'noreply@wiq.by'); // Адрес самої пошти та ім'я відправника
        $mail->addAddress($email);  
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body = $body;  
        // $mail->send();  

        // Перевіряємо відправленість повідомлення
        if ($mail->send()) {$result = "success";} 
        else {$result = "error";}

    } catch (Exception $e) {
        $result = "error";
        $status = "Повідомлення не було відправлено. Причина помилки: {$mail->ErrorInfo}";
    }
}

function GetAction($action) {
    if(isset($_POST['action']) && $_POST['action'] == $action) {
        return true;
    } else {
        return false;
    }
}

function TakeData($Type, $Value, $Email = false, $URL = false) {
    global $pdo;
    if(GetAction($Type)) {
        if(!empty($Value)) {
            if($Email == true) {
                if (!filter_var($Value, FILTER_VALIDATE_EMAIL) === false) {
                    $stmt = $pdo->prepare('UPDATE settings SET '.$Type.' = :Value LIMIT 1');
                    $stmt->execute(array(':Value' => $Value));
                } else {
                    echo 'Невірна адреса електронної пошти.';
                }
            } else if($URL == true) {
                if (!filter_var($Value, FILTER_VALIDATE_URL) === false) {
                    $stmt = $pdo->prepare('UPDATE settings SET '.$Type.' = :Value LIMIT 1');
                    $stmt->execute(array(':Value' => $Value));
                } else {
                    echo 'Неприпустимий URL-адреса.';
                }
            } else if ($Type !== 'UpdateOrderStatus'){
                if(!empty($Value) && is_string($Value)) {
                    $stmt = $pdo->prepare('UPDATE settings SET ' . $Type . ' = :Value LIMIT 1');
                    $stmt->execute(array(':Value' => $Value));
                    echo "Дані успішно збережено";
                } else {
                    echo 'Заповніть поле правильно.';
                }
            }
        } else {
            $stmt = $pdo->prepare('UPDATE settings SET '.$Type.' = "" LIMIT 1');
            $stmt->execute();
        }
    }
}

$fields = array();
foreach($_POST as $key => $value) {
    array_push($fields, $value);
}

if(isset($fields[1])) {
    if (strpos($fields[0], 'Email') !== false) {
        TakeData($fields[0], $fields[1], true);
    } else if(strpos($fields[0], 'URL') !== false) {
        TakeData($fields[0], $fields[1], false, true);
    } else {
        TakeData($fields[0], $fields[1], false);
    }
}

if(GetAction('UpdateIPLock')) {
    $stmt = $pdo->prepare('UPDATE settings SET IPLock = :IPLock LIMIT 1');
    if($settings['IPLock'] == 'No') {
        $stmt->execute(array(':IPLock' => 'Yes'));
        echo 'ON';
    } else {
        $stmt->execute(array(':IPLock' => 'No'));
        echo 'OFF';
    }
}

if(GetAction('UpdateMaintenanceMode')) {
    $stmt = $pdo->prepare('UPDATE settings SET RestrictRegistrations = :RestrictRegistrations LIMIT 1');
    if($settings['RestrictRegistrations'] == 'No') {
        $stmt->execute(array(':RestrictRegistrations' => 'Yes'));
        echo 'ON';
    } else {
        $stmt->execute(array(':RestrictRegistrations' => 'No'));
        echo 'OFF';
    }
}

if(GetAction('UpdateOrderStatus')) {
    try {
        $OrderID = $layer->safe('order-id');
        $OrderStatus = $layer->safe('order-status');

        $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
        $stmt->execute(array(':OrderID' => $OrderID));

        $row = $stmt->fetch();
        $quantity = $row['OrderQuantity'];
        $link = $row['OrderLink'];
        $userId = $row['OrderUserID'];
        $orderCharge = $row['OrderCharge'];

        if ($stmt->rowCount() == 1) {
            if ($OrderStatus == 'Delete Order') {
                $stmt = $pdo->prepare('DELETE FROM orders WHERE OrderID = :OrderID');
                $stmt->execute(array(':OrderID' => $OrderID));
            } 
            elseif ($OrderStatus == 'MoneyBack') {		
                $stmts = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :refund WHERE UserID = :UserID');
                $stmts->execute([':refund' => $orderCharge,':UserID' => $userId]);
				
                $stmt = $pdo->prepare('UPDATE orders SET subscriber = :OrderStatus WHERE OrderID = :OrderID');
                $stmt->execute(array(
                                ':OrderStatus' => 'MoneyBack',
                                ':OrderID'     => $OrderID
                            ));

                $stmtst = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
                $stmtst->execute([':OrderCharge' => 0, ':OrderID' => $order['OrderID']]);
            }	
            elseif ($OrderStatus == 'Canceled') {
                $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus, OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
                $stmt->execute(array(
                                ':OrderStatus' => 'Canceled',
                                ':OrderCharge' => 0,
                                ':OrderID'     => $OrderID
                            ));

                $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :UserBalance WHERE UserID = :UserID');
                $stmt->execute(array(
                    ':UserBalance' => $orderCharge,
                    ':UserID' => $userId
                ));
            }
            elseif ($OrderStatus == 'CancelOrder') {
                $ready = false;
                $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
                $stmt->execute(array(':ServiceID' => $row['OrderServiceID']));
                if ($stmt->rowCount() == 1) {
                    $service = $stmt->fetch();
					
                    if (!empty($service['ServiceOrderAPI'])) {
                        $URL = str_replace('=status', '=cancel', $service['ServiceOrderAPI']);
                        $URL = str_replace('[OrderID]', $row['OrderAPIID'], $URL);

                        $return = $layer->SendCurl($URL);
                        $resp = json_decode($return);

                        if (empty($resp) || (isset($resp) && property_exists($resp, 'error'))) {
                            echo json_encode(['status' => false, 'message' => 'Помилка скасування АПІ']);
                            die();
                        }
                        else if (isset($resp) && (property_exists($resp, 'order') || property_exists($resp, 'cancel'))) {
                            $ready = true;
                        }
                    }
                }
				
                if ($ready) {
                    $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                    $stmt->execute(array(
                                    ':OrderStatus' => 'Canceled',
                                    ':OrderID'     => $OrderID
                                ));
                }
                else {
                    echo json_encode([
                                 'status' => false,
                                 'message' => 'Помилка скасування замовлення через API, спробуйте пізніше.'
                             ]);					
                }
            }
            elseif ($OrderStatus == 'API' && empty($row['OrderAPIID'])) {
                $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
                $stmt->execute(array(':ServiceID' => $row['OrderServiceID']));
                if ($stmt->rowCount() == 1) {
                    $aRowService = $stmt->fetch();

                    $order_id = 0;
                    if (!empty($aRowService['ServiceAPI'])) {
                        $URL = str_replace('[QUANTITY]', $quantity, $aRowService['ServiceAPI']);
                        $URL = str_replace('[LINK]', $link, $URL);
                        $return = $layer->SendCurl($URL);
                        $resp = json_decode($return);

                        if (isset($resp) && property_exists($resp, 'order')) {
                            $order_id = $resp->order;
                        } elseif (isset($resp) && (property_exists($resp, 'error') || property_exists($resp, 'Error'))) {
                            $respError =  $resp->error ? $resp->error : $resp->Error;
                            if (empty($respError))
                                $respError = 'Невідома помилка при відправці даних в API Сервіс';

                            $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                            $stmt->execute([
                                               ':OrderStatus' => 'Mistake',
                                               ':OrderID'     => $OrderID
                                           ]);

                            die(json_encode([
                                'status' => false,
                                'message' => $respError
                            ]));
                        }
                    } 

                    if (!empty($order_id)) {
                        $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus, OrderAPIID = :OrderAPIID WHERE OrderID = :OrderID');
                        $stmt->execute([
                                           ':OrderStatus' => $OrderStatus,
                                           'OrderAPIID'   => $order_id,
                                           ':OrderID'     => $OrderID
                                       ]);
                    }
                    else {
                        die(json_encode([
                            'status' => false,
                            'message' => 'Не отримано ID замовлення від АПІ сервісу!'
                        ]));
                    }
                }
            }
            else {
                $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                $stmt->execute(array(
                                ':OrderStatus' => $OrderStatus,
                                ':OrderID'     => $OrderID
                            ));

                if ($OrderStatus == 'Completed') {
                    $stmt = $pdo->prepare('UPDATE orders SET `OrderRemain` = :OrderRemains WHERE OrderID = :OrderID');
                    $stmt->execute(array(
                            ':OrderRemains' => 0,
                            ':OrderID' => $OrderID
                    ));
                }
                elseif ($OrderStatus == 'Partial') {
                    $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
                    $stmt->execute([
                        ':OrderCharge' => 0, 
                        ':OrderID' => $OrderID
                    ]);
                }
            }
        } else {
            echo json_encode([
                                 'status' => false,
                                 'message' => 'Замовлення не існує.'
                             ]);
        }
    } catch (Throwable $e) {
        echo json_encode(['status' => false, 'message' => 'Внутрішня помилка']);
        die();
    }
    echo json_encode(['status' => true, 'message' => 'Статус успішно змінено']);
}
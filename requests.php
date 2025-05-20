<?php
global $pdo, $layer;
require 'SMTP-Mailer/PHPMailer.php';
require 'SMTP-Mailer/SMTP.php';
require 'SMTP-Mailer/Exception.php';

require_once('files/functions.php');
require_once('cancel/func.php'); // Функции для отмены заказа.

function sendMail($name, $email, $text, $title) {
    $mail = new PHPMailer\PHPMailer\PHPMailer();
    try {
        // Налаштування SMTP
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->SMTPAuth = true;
        $mail->Host = 'mail.wiq.by'; 
        $mail->Username = 'noreply@wiq.by';
        $mail->Password   = '126125gg'; // Пароль на почте
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->setFrom('noreply@wiq.by', 'WIQ.BY');
        $mail->addAddress($email);

        // Контент листа
        $mail->isHTML(true);
        $mail->Subject = $title;
        $mail->Body = "<div>$text</div>";

        // Надсилання
        $result = $mail->send() ? "success" : "error";
        
    } catch (Exception $e) {
        $result = "error";
        $status = "Не вдалося надіслати повідомлення: {$mail->ErrorInfo}";
    }
    return $result;
}


function GetAction($action) {
    if(isset($_POST['action']) && $_POST['action'] == $action) {
        return true;
    } else {
        return false;
    }
}

if(GetAction('cancel')) {
    $userId = (int)$_SESSION['auth'];
    $order_id = (int)$layer->safe('order_id');
    $result = [];

    $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :order_id AND OrderUserID = :user_id');
    $stmt->execute([':order_id' => $order_id, ':user_id' => $userId]);

    file_put_contents(__DIR__ . "/errors/user-request-cancel.txt", "\r\n ---------------". $userId, FILE_APPEND | LOCK_EX);
    file_put_contents(__DIR__ . "/errors/user-request-cancel.txt", "\r\n user ". $userId, FILE_APPEND | LOCK_EX);

    if ($stmt->rowCount() > 0) {
        $order = $stmt->fetch();
        $userId = $order['OrderUserID'];

        // информация о сервисе, через который надо отправить повторно
        $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
        $stmt->execute(array(':ServiceID' => $order['OrderServiceID']));
        // статус отмены
        $ready = false;

        if ($stmt->rowCount() == 1) {
            $service = $stmt->fetch();

            if (!empty($service['ServiceOrderAPI'])) {
            //if (!empty($service['ServiceAPI'])) {
                // $URL = str_replace('[QUANTITY]', '-' . $order['OrderQuantity'], $service['ServiceOrderAPI']);
                // $URL = str_replace('[LINK]', $order['OrderLink'], $URL);
                $URL = str_replace('=status', '=cancel', $service['ServiceOrderAPI']);
                $URL = str_replace('[OrderID]', $order['OrderAPIID'], $URL);

                file_put_contents(__DIR__ . "/errors/user-request-cancel.txt", "\r\n $URL ", FILE_APPEND | LOCK_EX);

                //if(isset($additional) && !empty($additional))
                //  $URL = str_replace('[ADDON]', $additional, $URL);

                // Отменяем заказ.
                // Определяем сервис с которым работаем.
                $pattern = '/https:\/\/([\w.-]+)\//';
                preg_match($pattern, $URL, $matches);
                // Данные для авторизации
/*                $username = 'resmer';
                $password = '12345678';
                $domain =  $matches[1];*/

                if (!empty($matches)) {
                    $domain =  $matches[1];  // 1xpanel.com /
                    $username = 'wiq-provider';
                    $password = 'letmainer';

/*                    if ($domain == '1xpanel.com') {
                    // Данные для авторизации
                    $username = 'resmer';
                    $password = '12345678';
                } elseif ($domain == 'bulkmedya.org') {
                    $username = 'vercas';
                    $password = 'mg12345jk';
                    }*/

                $result_data = cancelOrder($order['OrderAPIID'],$domain);
                if ($result_data === 'success') { // Успешно отменили.
                    $return = 'Успешно отменили заказ';
                } elseif ($result_data === 'error') { // Ошибка отмены.
                    $return = 'Ошибка отмены error';
                }
                elseif ($result_data === 'noauth') {
                    $result_data = authOrder($order['OrderAPIID'], $domain, $username, $password);
                    // Нужный ордер найден на странице, можно пробовать отменить.// Необходимо авторизоваться.
                    if ($result_data === true) {
                        // Отменяем.
                        $result_data = cancelOrder($order['OrderAPIID'], $domain);
                        if ($result_data === 'success') { // Успешно отменили.
                            $return = 'После попытки авторизации: успешно отменили заказ';
                        } elseif ($result_data === 'error') { // Ошибка отмены.
                            $return = 'После попытки авторизации: Ошибка отмены';
                        } elseif ($result_data === 'noauth') {
                            $return = 'После попытки авторизации: noauth';
                        }else {
                            $return = 'После попытки авторизации: неизвестная ошибка отмены заказа';
                        }

                    } else {
                        $return = 'Ошибка отмены после попытки авторизации';
                    }
                }else {
                    $return = 'Неизвестная ошибка отмены заказа';
                }
                }

                file_put_contents(__DIR__ . "/errors/user-request-cancel.txt", "\r\n $return ", FILE_APPEND | LOCK_EX);
            }
        }

        $stmtt = $pdo->prepare('SELECT * FROM orders WHERE OrderStatus = "Canceled" AND OrderID = :OrderID');
        $stmtt->execute([':OrderID' => $order['OrderID']]);

        if ($stmtt->rowCount() == 1) {
            $ready = false;
            $result['error'] = 'Данный заказ уже был отменён';
        }

    // делаем возврат в апи кроне reloadOrdersCron
        if ($ready) {
            file_put_contents(__DIR__ . "/errors/user-request-cancel.txt", "\r\n"."order refound " . $order['OrderID'], FILE_APPEND | LOCK_EX);
        }
        else {
            $result['error'] = 'Ошибка отмены!';
        }

    } else {
        $result['error'] = 'Заказ не найден';
    }

    echo json_encode($result);
}

if (GetAction('discount-check')) {
    $user->IsLogged();
    $result = [];
    
    // Підготовка запиту для отримання користувача
    $stmtt = $pdo->prepare('SELECT * FROM users WHERE UserID = :UserID');
    $stmtt->execute([':UserID' => (int)$_SESSION['auth']]);
    
    if ($stmtt->rowCount() == 1) {
        $user = $stmtt->fetch(PDO::FETCH_ASSOC);
        
        // Перевірка на виконання умов
        if ($totalPayments >= 500 || $user['UserBalance'] >= 100) {
            $stmts = $pdo->prepare('UPDATE users SET UserGroup = "reseller" WHERE UserID = :UserID');
            $stmts->execute([':UserID' => (int)$_SESSION['auth']]);
            
            // Повідомлення про успішне досягнення рівня реселлера
            $result['error'] = '<a style="background: rgb(114, 189, 53); color: #fff; font-weight: bold; padding: 4px 6px; font-size: 12px; text-decoration: none; border-radius: 3px;">' . Language('_congratulations_reseller') . '</a>';
        } else {
            // Повідомлення про невиконання умов
            $result['error'] = Language('_conditions_not_met');
        }
    } else {
        // Повідомлення про невірного користувача
        $result['error'] = Language('_user_not_found');
    }

    echo json_encode($result);
}


if(GetAction('set-news-viewed')) {
    $user->IsLogged();

    $result = ['result' => true, 'next' => 0];
    $update_id = (int)$layer->safe('news-id');

    $viewed = $_COOKIE['news_view_list'];
    $viewed = explode(',', $viewed);
    $viewed = array_map(function($v){return (int)$v;} ,$viewed);

    $viewed[] = $update_id;

    setcookie('news_view_list', implode(',', $viewed), time() + 864000);

    $stmt = $pdo->prepare('SELECT NEWSID FROM news WHERE NEWSID > :update_id LIMIT 1');
    $stmt->execute([':update_id' => $update_id]);

    if ($stmt->rowCount() > 0) {
        $data = $stmt->fetch();
        $result['next'] = (int)$data['NEWSID'];
    //}    
} else { // Если нет следующей новости, отправляем данные текущей новости
        $stmt = $pdo->prepare('SELECT NEWSID FROM news WHERE NEWSID = :update_id LIMIT 1');
        $data = $stmt->fetch();
        $result['next'] = (int)$data['NEWSID'];
}

    echo json_encode($result);
}

if(GetAction('select-service')) {
    $user->IsLogged();

    $service_id = $layer->safe('service-id');
    $service_type = $layer->GetData('services', 'ServiceType', 'ServiceID', $service_id);

    if($service_type == 'hashtag') {
        echo 'hashtag';
    } else if($service_type == 'comments') {
        echo 'comments';
    } else if($service_type == 'mentions') {
        echo 'mentions';
    }
}

if(GetAction('generate-new-api')) {
    $user->IsLogged();

    $api = md5($UserName.time().'$hash$');

    $stmt = $pdo->prepare('UPDATE users SET UserAPI = :UserAPI WHERE UserID = :UserID');
    $stmt->execute(array(':UserAPI' => $api, ':UserID' => $UserID));

    echo $api;
}

if(GetAction('outdraw-ref')) {
    $result = [
        'status' => true,
        'data'   => '',
    ];
    if (!isset($_SESSION['auth'])) {
        $result['status'] = false;
        $result['data'] = 'Вы не залогинены';
    } else {
        switch ($_POST['type']) {
            case 'UserBalance':
                $sum = (float)$_POST['amount'];
                $opRes = $layer->ReferrWithdraw($UserID, $sum);
                if ($opRes !== true) {
                    $result['status'] = false;
                    $result['data'] = $opRes;
                }
                break;
            case 'Qiwi':
            case 'Card':
            case 'Payeer':
            default:
                $result['status'] = false;
                $result['data'] = 'Недостаточно средств для совершения платежа';
                break;
        }
    }

    echo json_encode($result);
}

if(GetAction('get-user-balance')) {
    $user->IsLogged();

    echo $UserBalance;
}

if(GetAction('get-services')) {
    $user->IsLogged();
    $category_id = $layer->safe('category-id');
    $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceCategoryID = :ServiceCategoryID AND ServiceActive = "Yes" ORDER BY sort DESC');
    $stmt->execute(array(':ServiceCategoryID' => $category_id));
    $html = '';
    foreach($stmt->fetchAll() as $row) {
        if($UserGroup == 'reseller'){
            $price = $row['ServiceResellerPrice'];
        } else $price = $row['ServicePrice'];
        $ServiceNameEN = (isset($_COOKIE['lang']) && $_COOKIE['lang'] == "ru") ? $row['ServiceName'] : $row['ServiceName'. mb_strtoupper($_COOKIE['lang'])];
      
        $html .= '<option value="'.$row['ServiceID'].'">'.'ID:['.$row['ServiceID'].'] '.$ServiceNameEN.' - '.$price.' $</option>';
    }
    echo $html;
}

if(GetAction('get-price')) {
    $user->IsLogged();

    $price = $orders->GetPrice($_POST['service-id'], $_POST['quantity']);
    echo $price;
}

if(GetAction('get-min-quantity')) {
    $user->IsLogged();

    $service_id = $layer->safe('service-id');
    $quantity = $layer->GetData('services', 'ServiceMinQuantity', 'ServiceID', $service_id);

    echo $quantity;
}

if(GetAction('get-max-quantity')) {
    $user->IsLogged();

    $service_id = $layer->safe('service-id');
    $quantity = $layer->GetData('services', 'ServiceMaxQuantity', 'ServiceID', $service_id);

    echo $quantity;
}

if(GetAction('get-description')) {
    $user->IsLogged();

    $service_id = $layer->safe('service-id');
    if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "en"){
        $description = $layer->GetData('services', 'ServiceDescriptionEN', 'ServiceID', $service_id);
    }else{
        $description = $layer->GetData('services', 'ServiceDescription', 'ServiceID', $service_id);
    }
	
if(isset($_COOKIE['lang']) && $_COOKIE['lang'] == "ua"){ $description = $layer->GetData('services', 'ServiceDescriptionUA', 'ServiceID', $service_id);  }


    echo $description;
}

if(GetAction('get-link-quantity')) {
    $user->IsLogged();

    $service_id = $layer->safe('service-id');
    $link = $_POST['link'];

    if(!empty($link)) {
        $link = $layer->safe('link');
        $return = $orders->GetQuantityPerLink($service_id, $link);
        echo $return;
    } else {
        echo 0;
    }
}

if(GetAction('login')) {
    $username = $layer->safe('username');
    $password = $layer->safe('password');

    $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName AND UserPassword = :UserPassword');
    $stmt->execute(array(':UserName' => $username, ':UserPassword' => md5($password)));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        if($settings['IPLock'] == 'Yes') {
            if($row['UserIPAddress'] != $ip) {
                echo 'Ваш IP-адрес регистрации не соответствует вашему текущему.';
                echo 'Если вы считаете, что это проблема, не стесняйтесь обращаться в нашу службу поддержки.';
                exit();
            }
        }

        $stmt = $pdo->prepare('SELECT * FROM users_banned WHERE UserBannedID = :UserBannedID');
        $stmt->execute(array(':UserBannedID' => $row['UserID']));
        if($stmt->rowCount() == 1) {
            $ban_row = $stmt->fetch();

            if(time() > $ban_row['UserBannedExpireDate'] && $ban_row['UserBannedExpireDate'] != 0) {
                $stmt = $pdo->prepare('DELETE FROM users_banned WHERE UserBannedID = :UserBannedID');
                $stmt->execute(array(':UserBannedID' => $row['UserID']));
            } else {
                if($ban_row['UserBannedExpireDate'] == 0)
                    $time = 'Never';
                else
                    $time = date('d.m.Y h:I:s', $ban_row['UserBannedExpireDate']);

                echo 'Вы заблокированы!<br>';
                echo 'Причина: '.$ban_row['UserBannedReason'].'<br>';
                echo 'Разблокировка: '.date('d.m.Y h:I:s', $ban_row['UserBannedDate']).'<br>';
                echo 'Осталось: '.$time.'<br>';

                exit();
            }
        }

        $stmt = $pdo->prepare('INSERT INTO logs (LogUserID, LogDate) VALUES (:LogUserID, :LogDate)');
        $stmt->execute(array(':LogUserID' => $row['UserID'], ':LogDate' => time()));

        $_SESSION['auth'] = $row['UserID'];
        $layer->redirect('new-order.php');

    } else {
        echo 'Неверная информация для входа.';
    }
}

if(GetAction('restore')) {
    if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
        $email = $_POST['email'];

        $stmt = $pdo->prepare('SELECT * FROM users WHERE UserEmail = :UserEmail');
        $stmt->execute(array(':UserEmail' => $email));

        if($stmt->rowCount() == 1) {
            $row = $stmt->fetch();

            $np = $layer->GenerateRandomString(6);
            $stmt = $pdo->prepare('UPDATE users SET UserPassword = :UserPassword WHERE UserID = :UserID');
            $stmt->execute(array(':UserPassword' => md5($np), ':UserID' => $row['UserID']));
            echo '<div class="text-success">Новый пароль выслан на ваш почтовый адрес</div>';

            $msg = "<h2>Восстановление пароля учетной записи</h2>";
            $msg .= "Ваш логин: ".$row['UserName']."\n <br>";
            $msg .= "Пароль вашей учетной записи был сброшен \n <br>";
            $msg .= "Ваш новый временный пароль: $np \n <br>";
            $msg .= "<a style='color: #333; font-weight: bold; text-decoration: none;'> ВНИМАНИЕ! После успешного входа на сайт обязательно смените пароль на новый \n </a>";
	        $msg .= '<br><br><br><br><br><a href="http://wiq.by" target="_blank">WIQ.BY';
            $msg = wordwrap($msg,70);

            $subject = '=?utf-8?B?'.base64_encode('Восстановление пароля учетной записи').'?=';

            // send email
            sendMail('Команда WIQ', $email, $msg, 'Восстановление пароля учетной записи');
        } else {
            echo 'Пользователь с этими учетными данными не существует.';
        }
    }
}

if(GetAction('update-password')) {
    $user->IsLogged();

    if($UserName == 'demo') {
        echo 'Демо-счету не разрешено изменять пароль по умолчанию.';
    } else {
        $current_password = $layer->safe('current-password');
        $new_password = $layer->safe('new-password');
        $repeat_new_password = $layer->safe('repeat-new-password');

        $stmt = $pdo->prepare('SELECT * FROM users WHERE UserID = :UserID AND UserPassword = :UserPassword');
        $stmt->execute(array(':UserID' => $UserID, ':UserPassword' => md5($current_password)));

        if($stmt->rowCount() == 1) {
            if($new_password == $repeat_new_password) {
                if(strlen($new_password) >= 4 && strlen($new_password) <= 32) {
                    if($current_password != $new_password) {
                        $stmt = $pdo->prepare('UPDATE users SET UserPassword = :UserPassword WHERE UserID = :UserID');
                        $stmt->execute(array(':UserPassword' => md5($new_password), ':UserID' => $UserID));
                        echo '<div class="text-success">Пароль успешно изменен.</div>';
                    } else {
                        echo 'Ваш новый пароль похож на текущий. Пожалуйста, попробуйте другой.';
                    }
                } else {
                    echo 'Длина пароля должна быть от 4 до 32 символов.';
                }
            } else {
                echo 'Повторный пароль не соответствует вашему новому паролю.';
            }
        } else {
            echo 'Текущий пароль недействителен.';
        }
    }
}


if (GetAction('new-order')) {
    $user->IsLogged();

    if ($UserName == 'demo') {
        echo 'Демонстрационная учетная запись не разрешается заказывать.';
    } else {
        $service_id = $layer->safe('service');
        $link = $layer->safe('link');
        $quantity = $layer->safe('quantity');

        if (isset($_POST['comments'])) {
            $additional = $_POST['comments'];
            $additional = str_replace("\n", ",", $additional);
        } else if (isset($_POST['hashtag'])) {
            $additional = $_POST['hashtag'];
        } else if (isset($_POST['mentions_username'])) {
            $additional = $_POST['mentions_username'];
        }

        $charge = $orders->GetPrice($service_id, $quantity);
        $service_price = $orders->GetPrice1($service_id, 1);
        $max_quantity = $layer->GetData('services', 'ServiceMaxQuantity', 'ServiceID', $service_id);
        $is_free = $layer->GetData('services', 'is_free', 'ServiceID', $service_id);

        if (ctype_digit($service_id) && ctype_digit($quantity)) {
            $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
            $stmt->execute(array(':ServiceID' => $service_id));
            $stmt2 = $pdo->prepare('SELECT * FROM orders WHERE OrderServiceID = :OrderServiceID AND OrderUserID = :OrderUserID');
            $stmt2->execute(array(':OrderServiceID' => $service_id, ':OrderUserID' => $UserID));

            if ($stmt->rowCount() == 1) {
                $row = $stmt->fetch();
                if ($UserBalance >= $charge) {
                    if ((($is_free == 1 || $service_price == 0) && ($stmt2->rowCount() == 0)) || ($service_price > 0)) {
                        if ($quantity >= $row['ServiceMinQuantity'] && $quantity <= $row['ServiceMaxQuantity']) {
                            $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderLink = :OrderLink AND OrderServiceID = :OrderServiceID');
                            $stmt->execute(array(':OrderLink' => $link, ':OrderServiceID' => $service_id));

                            if ($stmt->rowCount() > 0) {
                                if ($stmt->rowCount() == 1) {
                                    $query_row = $stmt->fetch();
                                    $qu_am = $query_row['OrderQuantity'];
                                } else {
                                    $qu_am = 0;
                                    foreach ($stmt->fetchAll() as $qu_row) {
                                        $qu_am += $qu_row['OrderQuantity'];
                                    }
                                }
                                $total = $qu_am + $quantity;
                                $total_more = $max_quantity - $qu_am;
                                if ($total_more < 0) {
                                    $total_more = 0;
                                }
                            }
                            $order_id = 0;
                            $start_count = 0;

                            $link = trim($layer->safe('link')); // Удаление лишних пробелов в начале и в конце строки

                            if (!empty($row['ServiceAPI'])) {
                                $URL = str_replace('[QUANTITY]', $quantity, $row['ServiceAPI']);
                                $URL = str_replace('[LINK]', urlencode($link), $URL); // Кодирование ссылки перед отправкой

                                if (isset($additional) && !empty($additional))
                                    $URL = str_replace('[ADDON]', urlencode($additional), $URL);

                                $return = $layer->SendCurl($URL);
                                $resp = json_decode($return);

                                if (isset($resp) && property_exists($resp, 'order')) {
                                    $order_id = $resp->order;
                                } elseif (isset($resp) && property_exists($resp, 'error')) {
                                    // Handle error if necessary
                                }
                            }
                            if ($is_free != 1) {
                                $NewBalance = $UserBalance - $charge;
                            } else {
                                $NewBalance = $UserBalance;
                            }

                            if ($row['ServiceType'] != 'default') {
                                if ($order_id > 0) {
                                    $stmt = $pdo->prepare('INSERT INTO orders (OrderServiceID, OrderUserID, OrderQuantity, OrderLink, OrderCharge, OrderAPIID, OrderAdditional, OrderDate, OrderRemain, ServiceOrderAPI)
                                    VALUES (:OrderServiceID, :OrderUserID, :OrderQuantity, :OrderLink, :OrderCharge, :OrderAPIID, :OrderAdditional, :OrderDate, :OrderRemain, :ServiceOrderAPI)');

                                    $stmt->execute(array(':OrderServiceID' => $service_id, ':OrderUserID' => $UserID, ':OrderQuantity' => $quantity, ':OrderLink' => $link,
                                        ':OrderCharge' => $charge, ':OrderAPIID' => $order_id, ':OrderAdditional' => $additional, ':OrderDate' => time(), ':OrderRemain' => $quantity, 'ServiceOrderAPI' => $row['ServiceOrderAPI']));
                                } else {
                                    $stmt = $pdo->prepare('INSERT INTO orders (OrderServiceID, OrderUserID, OrderQuantity, OrderLink, OrderCharge, OrderAPIID, OrderAdditional, OrderDate, OrderStatus, OrderRemain)
                                    VALUES (:OrderServiceID, :OrderUserID, :OrderQuantity, :OrderLink, :OrderCharge, :OrderAPIID, :OrderAdditional, :OrderDate, :OrderStatus, :OrderRemain)');

                                    $stmt->execute(array(':OrderServiceID' => $service_id, ':OrderUserID' => $UserID, ':OrderQuantity' => $quantity, ':OrderLink' => $link,
                                        ':OrderCharge' => $charge, ':OrderAPIID' => $order_id, ':OrderAdditional' => $additional, ':OrderDate' => time(), ':OrderStatus' => 'Mistake', ':OrderRemain' => $quantity));
                                }
                            } else {
                                if ($order_id > 0) {
                                    $stmt = $pdo->prepare('INSERT INTO orders (OrderServiceID, OrderUserID, OrderQuantity, OrderLink, OrderCharge, OrderAPIID, OrderDate, OrderRemain, ServiceOrderAPI)
                                    VALUES (:OrderServiceID, :OrderUserID, :OrderQuantity, :OrderLink, :OrderCharge, :OrderAPIID, :OrderDate, :OrderRemain, :ServiceOrderAPI)');

                                    $stmt->execute(array(':OrderServiceID' => $service_id, ':OrderUserID' => $UserID, ':OrderQuantity' => $quantity, ':OrderLink' => $link,
                                        ':OrderCharge' => $charge, ':OrderAPIID' => $order_id, ':OrderDate' => time(), ':OrderRemain' => $quantity, 'ServiceOrderAPI' => $row['ServiceOrderAPI']));
                                } else {
                                    $stmt = $pdo->prepare('INSERT INTO orders (OrderServiceID, OrderUserID, OrderQuantity, OrderLink, OrderCharge, OrderAPIID, OrderDate, OrderStatus, OrderRemain)
                                    VALUES (:OrderServiceID, :OrderUserID, :OrderQuantity, :OrderLink, :OrderCharge, :OrderAPIID, :OrderDate, :OrderStatus, :OrderRemain)');

                                    $stmt->execute(array(':OrderServiceID' => $service_id, ':OrderUserID' => $UserID, ':OrderQuantity' => $quantity, ':OrderLink' => $link,
                                        ':OrderCharge' => $charge, ':OrderAPIID' => $order_id, ':OrderDate' => time(), ':OrderStatus' => 'Mistake', ':OrderRemain' => $quantity));
                                }
                            }
							$stmt = $pdo->prepare('UPDATE users SET UserBalance = :UserBalance WHERE UserID = :UserID');
							$stmt->execute(array(':UserBalance' => $NewBalance, ':UserID' => $UserID));

							$stmtt = $pdo->prepare('UPDATE number_of_orders SET quantity = quantity + :quantity WHERE id = :id');
							$stmtt->execute(array(':quantity' => 1, ':id' => 1));
							echo '
							<script type="text/javascript">
	                            reloadService();
	                            removeQuantity();
	                        </script>
							<div class="text-success" style="font-weight: bold; font-size: 15px;">' . Language('_order_accepted') . '</div>';
                        } else {
                            echo Language('_service_limits') . ' ' . $row['ServiceMinQuantity'] . ', ' . Language('_maximum_quantity') . ' ' . $row['ServiceMaxQuantity'] . '.';
                        }
                    } else {
                        echo Language('_free_service_limit');
                    }
                } else {
                    echo Language('_insufficient_balance') . ' <a href="deposit.php">' . Language('top_up_balance') . '</a>.';
                }
            } else {
                echo Language('_service_not_exist');
            }
        } else {
            echo Language('_fill_all_fields');
        }
    }
}

if(GetAction('lock')) {
    if(isset($_SESSION['lock-screen'])) {
        $username = $_SESSION['lock-screen'];
        $password = $layer->safe('password');

        $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName AND UserPassword = :UserPassword');
        $stmt->execute(array(':UserName' => $username, ':UserPassword' => md5($password)));

        if($stmt->rowCount() == 1) {
            $row = $stmt->fetch();

            $stmt = $pdo->prepare('SELECT * FROM users_banned WHERE UserBannedID = :UserBannedID');
            $stmt->execute(array(':UserBannedID' => $row['UserID']));
            if($stmt->rowCount() == 1) {
                $ban_row = $stmt->fetch();

                if(time() > $ban_row['UserBannedExpireDate'] && $ban_row['UserBannedExpireDate'] != 0) {
                    $stmt = $pdo->prepare('DELETE FROM users_banned WHERE UserBannedID = :UserBannedID');
                    $stmt->execute(array(':UserBannedID' => $row['UserID']));
                } else {
                    if($ban_row['UserBannedExpireDate'] == 0)
                        $time = 'Never';
                    else
                        $time = date('d.m.Y h:I:s', $ban_row['UserBannedExpireDate']);

                    echo 'Вы заблокированы!<br>';
                    echo 'Причина: '.$ban_row['UserBannedReason'].'<br>';
                    echo 'До: '.date('d.m.Y h:I:s', $ban_row['UserBannedDate']).'<br>';
                    echo 'Осталось: '.$time.'<br>';

                    exit();
                }
            }
            unset($_SESSION['lock-screen']);

            $_SESSION['auth'] = $row['UserID'];
            $layer->redirect('index.php');
        } else {
            echo 'Неверный пароль.';
        }
    }
}

if (GetAction('register')) {
    if ($settings['RestrictRegistrations'] !== 'No') {
        echo Language('_registrations_disabled') . '</div>';
        return;
    }

    if (isset($_SESSION['auth'])) {
        $layer->redirect('new-order.php');
        return;
    }

    // Захищені дані
    $username = $layer->safe('username');
    $email = $layer->safe('email');
    $telegram = $layer->safe('telegram');
    $password = $layer->safe('password');
    $re_password = $layer->safe('re_password');

    // Перевірки
    if ($password !== $re_password) {
        echo Language('_passwords_do_not_match') . '</div>';
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo Language('_invalid_email') . '</div>';
        return;
    }

    if (strlen($email) < 4 || strlen($email) > 48) {
        echo Language('_email_length_invalid') . '</div>';
        return;
    }

    if (strlen($username) < 4 || strlen($username) > 32) {
        echo Language('_username_length_invalid') . '</div>';
        return;
    }

    if (strlen($password) < 4 || strlen($password) > 32) {
        echo Language('_password_length_invalid') . '</div>';
        return;
    }

    // Перевірка на існування користувача
    $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName OR UserEmail = :UserEmail');
    $stmt->execute([':UserName' => $username, ':UserEmail' => $email]);

    if ($stmt->rowCount() > 0) {
        echo Language('_user_already_exists') . '</div>';
        return;
    }

    // Хешування пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $api = md5($layer->GenerateRandomString(15));

    // Вставка користувача
    $stmt = $pdo->prepare('INSERT INTO users (UserName, UserPassword, UserEmail, UserAPI, UserDate, UserIPAddress, UserTelegram)
                           VALUES (:UserName, :UserPassword, :UserEmail, :UserAPI, :UserDate, :UserIPAddress, :UserTelegram)');
    $stmt->execute([
        ':UserName' => $username,
        ':UserPassword' => $hashedPassword,
        ':UserEmail' => $email,
        ':UserAPI' => $api,
        ':UserDate' => time(),
        ':UserIPAddress' => $ip,
        ':UserTelegram' => $telegram
    ]);

    $_SESSION['auth'] = $pdo->lastInsertId();

    // Якщо є реферер
    if (isset($_POST['referr']) && ctype_digit($_POST['referr'])) {
        $stmt = $pdo->prepare('SELECT UserID FROM users WHERE UserID = :UserID');
        $stmt->execute([':UserID' => $_POST['referr']]);

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            $stmt = $pdo->prepare('INSERT INTO referrs (ReferrUserID, ReferrReferralUserID, ReferrDate)
                                   VALUES (:ReferrUserID, :ReferrReferralUserID, :ReferrDate)');
            $stmt->execute([
                ':ReferrUserID' => $row['UserID'],
                ':ReferrReferralUserID' => $_SESSION['auth'],
                ':ReferrDate' => time()
            ]);
        }
    }

    $layer->redirect('new-order.php');
}


if(GetAction('get_bonus')) {
    $result = [
        'result' => true,
        'bonus' => 0,
        'message' => '',
    ];

    $stmt = $pdo->prepare('SELECT * FROM users_bonus WHERE id_user = :id_user AND dt = :dt');
    $stmt->execute([':id_user' => $UserID, ':dt' => date('Y-m-d')]);

    if ($row = $stmt->fetch()) {
        $result['result'] = false;
        $result['message'] = 'Вы уже получали бонус!';
    } else {
        $bonus = (float)('0.0' . mt_rand(1,4));
        $stmt = $pdo->prepare('INSERT INTO users_bonus (id_user, dt, amount) VALUES (:id_user, :dt, :amount)');
        if ($stmt->execute([':id_user' => $UserID, ':dt' => date('Y-m-d'), ':amount' => $bonus])) {
            $stmt = $pdo->prepare('UPDATE users SET UserBalance = UserBalance + :amount WHERE UserID = :id_user');
            $stmt->execute([':id_user' => $UserID, ':amount' => $bonus]);
        }

        $result['bonus'] = $bonus;
    }

    echo json_encode($result);
    die();
}

if(GetAction('sava_talegram')) {
    $telegram = $_POST['telegram'];

    if (empty($telegram)) {
        echo 0;
        exit();
    }

    $stmt = $pdo->prepare('UPDATE users SET UserTelegram = :telegram WHERE UserID = :id_user');

    if ($stmt->execute([':id_user' => $UserID, ':telegram' => $telegram])) {
        echo 1;
        exit();
    } else {
        echo 0;
        exit();
    }

}


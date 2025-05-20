<?php
include('layer.php');
include('smm-layer.php');

$url = $_SERVER['SERVER_NAME'];
$file_name = $layer->file_name();
$url       = $layer->url();
$ip        = $layer->GetIP();

if (isset($_SESSION['auth'])) {
    $UserID = $_SESSION['auth'];
    $stmt   = $pdo->prepare('SELECT * FROM users WHERE UserID = :UserID');
    $stmt->execute([':UserID' => $UserID]);
    if ($stmt->rowCount() == 1) {
        $UserName        = $layer->GetData('users', 'UserName', 'UserID', $UserID);
        $UserEmail       = $layer->GetData('users', 'UserEmail', 'UserID', $UserID);
        $UserGroup       = $layer->GetData('users', 'UserGroup', 'UserID', $UserID);
        $UserBalance     = $layer->GetData('users', 'UserBalance', 'UserID', $UserID);
        $UserBalance     = round($UserBalance, 3);
        $UserDate        = $layer->GetData('users', 'UserDate', 'UserID', $UserID);
        $UserIPAddress   = $layer->GetData('users', 'UserIPAddress', 'UserID', $UserID);
        $UserAPI         = $layer->GetData('users', 'UserAPI', 'UserID', $UserID);
        $UserTelegram    = $layer->GetData('users', 'UserTelegram', 'UserID', $UserID);
    } else {
        $layer->redirect('logout.php');
    }

    $totalPayments = 0;

    $stmt = $pdo->prepare("SELECT * FROM `deposits` WHERE `DepositUserID` = :id_user AND `DepositStatus` = 'Success'");
    $stmt->execute([':id_user' => $UserID]);
    foreach ($stmt->fetchAll() as $row) {
        $totalPayments += $row['DepositAmount'];
    }
}

function getDepositAmountWithCommission($amount, $depositType) {
	global $pdo;

	// Agar deposit turi Payeer bo'lsa, komissiyani deposits jadvalidan olish
	if ($depositType === 'Payeer') {
			$stmt = $pdo->prepare("SELECT commission FROM deposits WHERE DepositAmount = :amount AND DepositType = :type LIMIT 1");
			$stmt->execute([':amount' => $amount, ':type' => $depositType]);
			$commission = (float)$stmt->fetchColumn();

			if ($commission > 0) {
					$commission_amount = $commission >= 1 
							? $amount * ($commission / 100) 
							: $commission;
					return number_format($amount - $commission_amount, 2); // Sof summa
			}
	}
	// Boshqa turlar uchun komissiyasiz summa
	return number_format($amount, 2);
}

function GetTitlePage()
{
    $url = $_SERVER['REQUEST_URI'];
    $url = explode('?', $url);
    $url = explode('/', $url[0]);
    $url = '/'.end($url);
    $title = "";

    switch ($url) {
        case "/all-orders":
           $title = Language('_all-orders', 'functions.php');
            break;
        case "/settings":
           $title = Language('_settings', 'functions.php');
            break;
        case "/login":
            $title = Language('_login', 'functions.php');
            break;
        case "/discount":
            $title = Language('_discount', 'functions.php');
            break;
        case "/referr-documentation":
            $title = Language('_referr-documentation', 'functions.php');
            break;
        case "/franchise":
            $title = Language('_franchise', 'functions.php');
            break;
        case "/how-it-works":
            $title = Language('_how-it-works', 'functions.php');
            break;
        case "/api-documentation":
            $title = Language('_api-documentation', 'functions.php');
            break;
        case "/new-order":
            $title = Language('_new-order', 'functions.php');
            break;
        case "/list":
            $title = Language('_list', 'functions.php');
            break;
        case "/bonus":
            $title = Language('_bonus', 'functions.php');
            break;
        case "/news":
            $title = Language('_news', 'functions.php');
            break;
        case "/updates":
            $title = Language('_updates', 'functions.php');
            break;
        case "/support":
            $title = Language('_support', 'functions.php');
            break;
        case "/deposit":
            $title = Language('_deposit', 'functions.php');
            break;
        case "/services":
            $title = Language('_services', 'functions.php');
            break;
        case "/tasks":
            $title = Language('_tasks', 'functions.php');
            break;
        case "/tasks_ref":
            $title = Language('_tasks_ref', 'functions.php');
            break;
        case "/bot-stat":
            $title = Language('_bot-stat', 'functions.php');
            break;
        case "/otzyvy":
            $title = Language('_otzyvy', 'functions.php');
            break;
        case "/":
            $title = Language('_index', 'functions.php');
            break;
        default:
            $title = "Накрутка Инстаграм подписчиков и лайков бесплатно";
            break;
    }
    return ($title . " | WIQ.BY");
}

class User
{
    function IsLogged()
    {
        global $layer;
        if (!isset($_SESSION['auth']) && !isset($_SESSION['lock-screen'])) {
            $layer->redirect('index.php');
        } else if (isset($_SESSION['lock-screen'])) {
            $layer->redirect('lock.php');
        } else {
            $this->IsBanned($_SESSION['auth']);
        }
    }

    function IsBanned($UserID)
    {
        global $pdo;
        global $layer;
        global $UserID;
        $stmt = $pdo->prepare('SELECT * FROM users_banned WHERE UserBannedID = :UserBannedID');
        $stmt->execute(array(
            ':UserBannedID' => $UserID
        ));
        if ($stmt->rowCount() == 1) {
            $ban_row = $stmt->fetch();
            if (time() > $ban_row['UserBannedExpireDate'] && $ban_row['UserBannedExpireDate'] != 0) {
                $stmt = $pdo->prepare('DELETE FROM users_banned WHERE UserBannedID = :UserBannedID');
                $stmt->execute(array(
                    ':UserBannedID' => $UserID
                ));
            } else {
                session_destroy();
                $layer->redirect('index.php');
            }
        }
    }

    function IsAdmin()
    {
        global $pdo;
        global $layer;
        global $UserID;
        $stmt = $pdo->prepare('SELECT UserGroup FROM users WHERE UserID = :UserID');
        $stmt->execute(array(
            ':UserID' => $UserID
        ));
        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch();
            if ($row['UserGroup'] != 'administrator') {
                $layer->redirect('../index.php');
            }
        } else {
            session_destroy();
            $layer->redirect('../index.php');
        }
    }

    function hasOperations()
    {
        global $pdo;
        global $UserID;

        $stmt = $pdo->prepare('SELECT COUNT(*) AS `cnt` FROM refer_out WHERE idUser = :UserID');
        $stmt->execute(array(
            ':UserID' => $UserID
        ));
        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            $result = ((int)$row['cnt'] > 0);
        } else {
            $result = false;
        }

        return $result;
    }
}
$user = new User();

class Orders
{
function CheckOrder($OrderID)
{
    global $layer;
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
    $stmt->execute(array(
        ':OrderID' => $OrderID
    ));
    if ($stmt->rowCount() == 1) {
        $row               = $stmt->fetch();
        $ServiceOrderCheck = $layer->GetData('services', 'ServiceOrderAPI', 'ServiceID', $row['OrderServiceID']);

        if (empty($ServiceOrderCheck) || ($ServiceOrderCheck !== $row['ServiceOrderAPI'] && !empty($row['ServiceOrderAPI']))) {
            $ServiceOrderCheck = $row['ServiceOrderAPI'];
        }

        $CompleteURL       = str_replace('[OrderID]', $row['OrderAPIID'], $ServiceOrderCheck);
        $OrderCheck        = $layer->SendCurl($CompleteURL);

        return $OrderCheck;
    } else {
        return false;
    }
}


    function GetOrderStatus($OrderID)
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
        $stmt->execute(array(
            ':OrderID' => $OrderID
        ));
        if ($stmt->rowCount() == 1) {
            $row    = $stmt->fetch();
            $status = $row['OrderStatus'];
        } else {
            $status = 'Canceled';
        }

        return $status;
    }

function CheckOrderStatus($OrderID)
{
    global $layer;
    global $pdo;

    $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
    $stmt->execute(array(
        ':OrderID' => $OrderID
    ));

    if ($stmt->rowCount() == 1) {
        $row    = $stmt->fetch();
        $status = $dispStatus = $row['OrderStatus'];
        $remain = $row['OrderRemain'];
        $quantity = $row['OrderQuantity'];
        $userId = $row['OrderUserID'];

        if (in_array($status, array('Refunded', 'Canceled', 'Partial', 'Completed'))) {
            return $this->serializeStatus($status, $remain, $quantity);
        }

        if (!empty($row['OrderAPIID'])) {
            $order = $this->CheckOrder($OrderID);
            $resp  = json_decode($order);

            $status = '';
            if (isset($resp) && property_exists($resp, 'status')) {
                $status = $resp->status;
            }

            if ($status == 'Canceled' || $status == 'Refunded' || $status == 'Partial') {
                $stmt = $pdo->prepare('SELECT OrderCharge FROM orders WHERE OrderID = :OrderID');
                $stmt->execute([':OrderID' => $OrderID]);
                $query = $stmt->fetch();

                if (!empty($query['OrderCharge'])) {
                    $stmt = $pdo->prepare('SELECT UserBalance FROM users WHERE UserID = :UserID');
                    $stmt->execute([':UserID' => $userId]);
                    $query = $stmt->fetch();

                    $pdo->beginTransaction();

                    $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge, OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                    $stmt->execute([
                        ':OrderCharge' => 0,
                        ':OrderStatus' => $status,
                        ':OrderID' => $OrderID
                    ]);

                    $stmt = $pdo->prepare('UPDATE users SET UserBalance = :UserBalance WHERE UserID = :UserID');
                    $stmt->execute([
                        ':UserBalance' => $row['OrderCharge'] + $query['UserBalance'],
                        ':UserID' => $userId
                    ]);

                    $pdo->commit();
                }

                if ($status == 'Partial') {
                    $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
                    $stmt->execute([
                        ':OrderCharge' => 0,
                        ':OrderID' => $OrderID
                    ]);
                }
            } elseif ($status == 'Mistake') {
                $stmt = $pdo->prepare('SELECT UserBalance FROM users WHERE UserID = :UserID');
                $stmt->execute(array(':UserID' => $row['OrderUserID']));

                $query = $stmt->fetch();
                $rt = $row['OrderServiceID'];
                $charge = $this->GetPrice1($rt, 1 / 100);

                $stmt = $pdo->prepare('UPDATE users SET UserBalance = :UserBalance WHERE UserID = :UserID');
                $stmt->execute([
                    ':UserBalance' => $row['OrderRemain'] * $row['OrderCharge'] / $row['OrderQuantity'] + $query['UserBalance'],
                    ':UserID' => $row['OrderUserID']
                ]);

                $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge WHERE OrderID = :OrderID');
                $stmt->execute([
                    ':OrderCharge' => 0,
                    ':OrderID' => $OrderID
                ]);
            } elseif (!empty($status)) {
                $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                $stmt->execute(array(
                    ':OrderStatus' => $status,
                    ':OrderID' => $row['OrderID']
                ));

                if ($status == 'Completed') {
                    $stmt = $pdo->prepare('UPDATE orders SET `OrderRemain` = :OrderRemains WHERE OrderID = :OrderID');
                    $stmt->execute(array(
                        ':OrderRemains' => 0,
                        ':OrderID' => $row['OrderID']
                    ));
                }
            }
        }

        if (empty($status)) {
            $status = $dispStatus;
        }
        return $this->serializeStatus($status, $remain, $quantity);
    } else {
        return 'Отменен';
    }
}


function CheckOrderStatusAdmin($OrderID)
{
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
    $stmt->execute(array(
        ':OrderID' => $OrderID
    ));
    if ($stmt->rowCount() == 1) {
        $row    = $stmt->fetch();

        // только для админа
        $status = $row['subscriber'];
        if (!empty($status) && $status == 'MoneyBack') {
            return 'Возвращено'; // Refunded
        }

        $status = $dispStatus = $row['OrderStatus'];
        $remain = $row['OrderRemain'];
        $quantity = $row['OrderQuantity'];
        $userId = $row['OrderUserID'];

        if (in_array($status, array('Refunded', 'Canceled', 'Partial', 'Completed'))) {
            return $this->serializeStatusAdmin($status, $remain, $quantity);
        }

        if (!empty($row['OrderAPIID'])) {
            $order = $this->CheckOrder($OrderID);
            $resp  = json_decode($order);

            $status = '';
            if (isset($resp) && property_exists($resp, 'status')) {
                $status = $resp->status;
            }

            if ($status == 'Canceled' || $status == 'Refunded' || $status == 'Partial') {
                $stmt = $pdo->prepare('SELECT OrderCharge FROM orders WHERE OrderID = :OrderID');
                $stmt->execute([':OrderID' => $OrderID]);
                $query = $stmt->fetch();

                if (!empty($query['OrderCharge'])) {
                    $stmt = $pdo->prepare('SELECT UserBalance FROM users WHERE UserID = :UserID');
                    $stmt->execute([':UserID' => $userId]);
                    $query = $stmt->fetch();

                    $pdo->beginTransaction();

                    $stmt = $pdo->prepare('UPDATE orders SET OrderCharge = :OrderCharge, OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                    $stmt->execute([
                        ':OrderCharge' => 0,
                        ':OrderStatus' => $status,
                        ':OrderID' => $OrderID
                    ]);

                    $stmt = $pdo->prepare('UPDATE users SET UserBalance = :UserBalance WHERE UserID = :UserID');
                    $stmt->execute([
                        ':UserBalance' => $row['OrderCharge'] + $query['UserBalance'],
                        ':UserID' => $userId
                    ]);

                    $pdo->commit();
                }
            } elseif (!empty($status)) {
                $stmt = $pdo->prepare('UPDATE orders SET OrderStatus = :OrderStatus WHERE OrderID = :OrderID');
                $stmt->execute(array(
                    ':OrderStatus' => $status,
                    ':OrderID' => $row['OrderID']
                ));
            }
        }

        if (empty($status)) {
            $status = $dispStatus;
        }
        return $this->serializeStatusAdmin($status, $remain, $quantity);
    } else {
        return 'Отменен';
    }
}

    function serializeStatus($status, $remains, $quantity)
    {
        $url = $_SERVER['REQUEST_URI'];
        switch ($status) {
            case "Completed": {
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_completed', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_completed', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            case "Processing": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_processing', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_processing', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    //$label = "В работе";
                    break;
                }
            case "Pending": {
                    $procent = 0;
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_pending', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_pending', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    //$label = "В ожидании";
                    break;
                }
            case "Partial": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_partial', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_partial', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            case "Canceled": {
                    $procent = 100;
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_canceled', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width:' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_canceled', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            case "Refunded": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_refunded', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_refunded', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            case "Deleted": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_deleted', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_deleted', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            case "Mistake": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_mistake', 'functions.php').'<br><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_mistake', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }

                    break;
                }
            case "In progress": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = Language('_in_progress', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    } else {
                        $label = Language('_in_progress', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            case "API": {
                    $procent = 100 - ($remains / ($quantity / 100));
                    if (strpos($url, 'admin') > 0) {
                        $label = "Отправка по API";
                    } else {
                        $label = Language('_pending', 'functions.php').'<br><div class="progress"><div class="progress-bar" role="progressbar" style="width: ' . $procent . '%" aria-valuenow="' . $procent . '" aria-valuemin="0" aria-valuemax="100"></div></div>';
                    }
                    break;
                }
            default: {
                    $label = "Неизвестен";
                }
        }

        return $label;
    }

    function serializeStatusAdmin($status, $remains, $quantity)
    {
        $url = $_SERVER['REQUEST_URI'];
        switch ($status) {
            case "Completed": {
                    $label = 'Завершен';
                    break;
                }
            case "Processing": {
                    $label = 'Принят';
                    break;
                }
            case "Pending": {
                    $label = 'Запускается';
                    break;
                }
            case "Partial": {
                    $label = 'Прерван';
                    break;
                }
            case "Canceled": {
                    $label = 'Отменен';
                    break;
                }
            case "Refunded": {
                    $label = 'Прерван';
                    break;
                }
            case "Deleted": {
                    $label = 'Удален';
                    break;
                }
            case "Mistake": {
                    $label = 'Ошибка';
                    break;
                }
            case "In progress": {
                    $label = 'Выполняется';
                    break;
                }
            case "API": {
                    $label = "Отправка по API";
                    break;
                }
            default: {
                    $label = "Неизвестен";
                }
        }

        return $label;
    }

    function CheckOrderAction($status, $refill, $cancel, $orderId, $refill_duration)
    {
        if ($status == 'Completed' && $refill == 1) {
            return '<button type="button" class="btn btn-default" onclick="[].forEach.call(document.querySelectorAll(\'button\'), function(el){el.setAttribute(\'disabled\', \'disabled\');}); order_refill(\'' . $orderId . '\', \'' . $refill_duration . '\');">Refill</button>';
        }

        elseif (in_array($status, array('Active', 'In progress', 'Pending', 'Mistake')) && $cancel == 1) {
            return '<button type="button" value=\'' . $orderId . '\' class="btn btn-default" onclick="[].forEach.call(document.querySelectorAll(\'button\'), function(el){
                let allInputs = document.querySelectorAll(\'button\');
                    for(let x = 0; x < allInputs.length; x++) {
                    if(allInputs[x].value == \'' . $orderId . '\') {
                        allInputs[x].setAttribute(\'disabled\', \'disabled\')
                    }
        }
        });order_cancel(\'' . $orderId . '\');">Отменить</button>'.
'<span style="display:none;">'."$status, $refill, $cancel, $orderId, $refill_duration".'</span>';
        } else {
            return '';
        }
    }

    function CheckOrderRemains($OrderID)
    {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
        $stmt->execute(array(
            ':OrderID' => $OrderID
        ));
        if ($stmt->rowCount() == 1) {
            $row     = $stmt->fetch();
            $remains = 0;
            if (!empty($row['OrderAPIID']) && $row['OrderAPIID'] != 0) {
                $order = $this->CheckOrder($OrderID);
                $resp  = json_decode($order);
                if (isset($resp) && property_exists($resp, 'remains')) {
                    $remains = $resp->remains;
                }
            }
            return $remains;
        } else {
            return 0;
        }
    }

    function CheckOrderStartCount($OrderID)
    {
        global $pdo;
        global $layer;
        $stmt = $pdo->prepare('SELECT * FROM orders WHERE OrderID = :OrderID');
        $stmt->execute(array(
            ':OrderID' => $OrderID
        ));
        if ($stmt->rowCount() == 1) {
            $row             = $stmt->fetch();
            $start_count     = (int)$row['OrderStartCount'];
            $ServiceOrderAPI = $layer->GetData('services', 'ServiceOrderAPI', 'ServiceID', $row['OrderServiceID']);

            if (empty($ServiceOrderAPI) || ($ServiceOrderAPI !== $row['ServiceOrderAPI'] && !empty($row['ServiceOrderAPI']))) {
                $ServiceOrderAPI = $row['ServiceOrderAPI'];
            }

            if (empty($row['OrderStartCount']) && !empty($ServiceOrderAPI)) {
                $URL    = str_replace('[OrderID]', $row['OrderAPIID'], $ServiceOrderAPI);
                $return = $layer->SendCurl($URL);
                $resp   = json_decode($return);
                if (isset($resp) && property_exists($resp, 'start_count'))
                    $start_count = $resp->start_count;
                $start_count = (int)$start_count;
                if ($start_count > 0) {
                    $stmt = $pdo->prepare('UPDATE orders SET OrderStartCount = :OrderStartCount WHERE OrderID = :OrderID');
                    $stmt->execute(array(
                        ':OrderStartCount' => $start_count,
                        ':OrderID' => $OrderID
                    ));
                }
            }
            return $start_count;
        } else {
            return 0;
        }
    }

    public function DeclarePrice($ProductPrice, $ProductDefaultQuantity, $ProductQuantity)
    {
        $ProductValue = $ProductPrice / $ProductDefaultQuantity;
        return $ProductValue * $ProductQuantity;
    }

    function GetPrice($service_id, $quantity)
    {
        global $layer;
        global $pdo;
        global $UserID;
        global $UserGroup;
        $service_id = $layer->safe($service_id, 'none');
        $quantity   = $layer->safe($quantity, 'none');
        if (ctype_digit($service_id) && ctype_digit($quantity)) {
            $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
            $stmt->execute(array(
                ':ServiceID' => $service_id
            ));
            if ($stmt->rowCount() == 1) {
                $row   = $stmt->fetch();
                if (!empty($row['ServiceResellerPrice']) && $UserGroup == 'reseller') {
                    $total = $this->DeclarePrice($row['ServiceResellerPrice'], /*$row['ServiceMinQuantity']*/ 1000, $quantity);
                } else {
                    $total = $this->DeclarePrice($row['ServicePrice'], /*$row['ServiceMinQuantity']*/ 1000, $quantity);
                }
                return $total;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    function GetPrice1($service_id, $quantity)
    {
        global $layer;
        global $pdo;
        global $UserID;
        global $UserGroup;
        $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
        $stmt->execute(array(
            ':ServiceID' => $service_id
        ));
        if ($stmt->rowCount() == 1) {
            $row   = $stmt->fetch();
            if (!empty($row['ServiceResellerPrice']) && $UserGroup == 'reseller') {
                $total = $this->DeclarePrice($row['ServiceResellerPrice'], $row['ServiceMinQuantity'], $quantity);
            } else {
                $total = $this->DeclarePrice($row['ServicePrice'], $row['ServiceMinQuantity'], $quantity);
            }
            return $total;
        } else {
            return 0;
        }
    }

    function GetQuantityPerLink($service_id, $link)
    {
        global $layer;
        global $pdo;
        $service_id   = $layer->safe($service_id, 'none');
        $link         = $layer->safe($link, 'none');
        $max_quantity = $layer->GetData('services', 'ServiceMaxQuantity', 'ServiceID', $service_id);
        $stmt         = $pdo->prepare('SELECT * FROM orders WHERE OrderServiceID = :OrderServiceID AND OrderLink = :OrderLink');
        $stmt->execute(array(
            ':OrderServiceID' => $service_id,
            ':OrderLink' => $link
        ));
        if ($stmt->rowCount() == 0) {
            return $max_quantity;
        } else {
            $total = 0;
            foreach ($stmt->fetchAll() as $order_row) {
                $total += $order_row['OrderQuantity'];
            }
            if ($total != $max_quantity) {
                return $max_quantity - $total;
            } else {
                return 0;
            }
        }
    }
}
$orders = new Orders();

function logSave($data, $log='log') {
    $file = $log.'.txt';
    $str = date("H:i:s d/m/y") . PHP_EOL;
    $str .= is_array($data) ? print_r($data,true) : $data . PHP_EOL;
    file_put_contents($file, $str, FILE_APPEND | LOCK_EX);
}

### Перевод страници на разные языки
# Проверяем указан ли язык в URL
function checkedGetLang(string|null $lang): string {

    if(isset($_GET['lang']) && !empty($_GET['lang'])) {

        if(!empty($lang) && $_GET['lang'] != $lang) return $lang;

        return substr($_GET['lang'], 0 ,3);
    } elseif(!empty($lang)) return $lang;

    return 'ru';
}

# Проверяем указан ли язык в куках
function checkedCookieLang(string|null $lang): string {
    if (isset($_COOKIE['lang'])) {
        if (! empty($lang) && $_COOKIE['lang'] != $lang) {
            return $lang;
        }

        return substr($_COOKIE['lang'], 0, 3);
    } elseif(! empty($lang)) {
        return $lang;
    }

    return 'ru';
}

# Функыия перевода на разные языки из парка + файл(/ru/index.php)
/*
 * $key - Принемает ключ массива, который находиться в файле с перевода
 * $file_name - Имя файла с переводом (Можно не указывать если совпадает с сылкой на странице)
 * $lang - Указываем язык для перевода ('ru' по умолчанию)
 * $dir - Директория где лежат папки с языками (language/[ru|en]/*)
 */
function Language(string $key, string|null $file_name = NUll, string|null $lang = NULL, string $dir = 'language'): string  {

    # Берем язык из URL или Cookies
    // $lang = checkedGetLang($lang);
    $lang = checkedCookieLang($lang);

    # Полный путь к директории
    $dir = $_SERVER['DOCUMENT_ROOT']."/".$dir;

    if(is_dir($dir.'/'.$lang)) $result = require $dir.'/'.(empty($file_name) ? $lang.$_SERVER['SCRIPT_NAME'] : $lang.'/'.$file_name);
    else $result = require $dir.'/'.(empty($file_name) ? 'en'.$_SERVER['SCRIPT_NAME'] : 'en'.'/'.$file_name);

    return isset($result[$key]) ? $result[$key] : $result['_key'];
}

function Languages(string $key, string|null $file_name = NUll, string|null $lang = NULL, string $dir = 'language'): string  {

    return $dir.'/'.(empty($file_name) ? $lang.$_SERVER['SCRIPT_NAME'] : $lang.'/'.$file_name);

    # Берем язык из URL или Cookies
    // $lang = checkedGetLang($lang);
    $lang = checkedCookieLang($lang);

    # Полный путь к директории
    $dir = $_SERVER['DOCUMENT_ROOT']."/".$dir;

    if(is_dir($dir.'/'.$lang)) $result = require $dir.'/'.(empty($file_name) ? $lang.$_SERVER['SCRIPT_NAME'] : $lang.'/'.$file_name);
    else $result = require $dir.'/'.(empty($file_name) ? 'en'.$_SERVER['SCRIPT_NAME'] : 'en'.'/'.$file_name);

    return isset($result[$key]) ? $result[$key] : $result['_key'];
}

function getPayeerSettings() {
	global $pdo;
	$stmt = $pdo->query("SELECT merchant_id, secret_key, commission, bonus FROM merchant LIMIT 1"); // ✅ Bonusni ham olish
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updatePayeerSettings($merchant_id, $secret_key, $commission, $bonus) { // ✅ Bonusni parametr sifatida qabul qilish
	global $pdo;

	// Check if entry exists
	$stmt = $pdo->query("SELECT COUNT(*) FROM merchant");
	$exists = $stmt->fetchColumn();

	if ($exists) {
			// Update existing row
			$stmt = $pdo->prepare("UPDATE merchant SET merchant_id = ?, secret_key = ?, commission = ?, bonus = ? LIMIT 1"); // ✅ Bonusni yangilash
			return $stmt->execute([$merchant_id, $secret_key, $commission, $bonus]);
	} else {
			// Insert new row (only one row allowed)
			$stmt = $pdo->prepare("INSERT INTO merchant (merchant_id, secret_key, commission, bonus) VALUES (?, ?, ?, ?)"); // ✅ Bonusni kiritish
			return $stmt->execute([$merchant_id, $secret_key, $commission, $bonus]);
	}
}



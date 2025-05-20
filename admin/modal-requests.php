<?php
require_once('../files/functions.php');

$user->IsAdmin();

function GetAction($action) {
    if(isset($_POST['action']) && $_POST['action'] == $action) {
        return true;
    } else {
        return false;
    }
}


/*
    Categories
*/

if(GetAction('get-category-details')) {
    $CategoryID = $layer->safe('CategoryID');

    $stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryID = :CategoryID');
    $stmt->execute(array(':CategoryID' => $CategoryID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    } else {
        echo "TEST";
    }
}

if(GetAction('save-category')) {
    $CategoryID = $layer->safe('EditCategoryID');
   // $CategoryName = $layer->safe('EditCategoryName');
    $CategoryName = $_POST['EditCategoryName'];
    $CategoryDescription = $layer->safe('EditCategoryDescription');
    $CategoryDescription = $_POST['EditCategoryDescription'];
    $CategoryActive = $layer->safe('EditCategoryActive');

    $stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryID = :CategoryID');
    $stmt->execute(array(':CategoryID' => $CategoryID));

    if(isset($_POST['EditCategoryNameEN']) && isset($_POST['EditCategoryDescriptionEN'])) {
        $CategoryNameEN = $_POST['EditCategoryNameEN'];
        $CategoryDescriptionEN = $_POST['EditCategoryDescriptionEN'];
    } else {
        echo 'Не заполнены поля на английском';
        exit();
    }

    if(isset($_POST['EditCategoryNameUA']) && isset($_POST['EditCategoryDescriptionUA'])) {
        $CategoryNameUA = $_POST['EditCategoryNameUA'];
        $CategoryDescriptionUA = $_POST['EditCategoryDescriptionUA'];
    } else {
        echo 'Не заполнены поля на украинском';
        exit();
    }

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('UPDATE categories SET CategoryName = :CategoryName, CategoryNameUA = :CategoryNameUA, CategoryNameEN = :CategoryNameEN, CategoryDescription = :CategoryDescription, CategoryDescriptionUA = :CategoryDescriptionUA, CategoryDescriptionEN = :CategoryDescriptionEN, CategoryActive = :CategoryActive WHERE CategoryID = :CategoryID');
        $stmt->execute(array(
            ':CategoryName'          => $CategoryName,
            ':CategoryNameUA'        => $CategoryNameUA,
            ':CategoryNameEN'        => $CategoryNameEN,
            ':CategoryDescription'   => $CategoryDescription,
            ':CategoryDescriptionUA' => $CategoryDescriptionUA,
            ':CategoryDescriptionEN' => $CategoryDescriptionEN,
            ':CategoryActive'        => $CategoryActive,
            ':CategoryID'            => $CategoryID
        ));
        echo "Категория успешно отредактирована!";
    } else {
        echo 'Category does not exists.';
    }
}

if(GetAction('delete-category')) {
    $CategoryID = $layer->safe('EditCategoryID');

    $stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryID = :CategoryID');
    $stmt->execute(array(':CategoryID' => $CategoryID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM categories WHERE CategoryID = :CategoryID');
        $stmt->execute(array(':CategoryID' => $CategoryID));
    } else {
        echo 'Категории не существует.';
    }
}

if(GetAction('create-category')) {
    $CategoryName = $layer->safe('CategoryName');
    $CategoryDescription = $layer->safe('CategoryDescription');
    $CategoryActive = $layer->safe('CategoryActive');

    if(isset($_POST['CategoryNameEN']) && isset($_POST['CategoryDescriptionEN'])) {
        $CategoryNameEN = $_POST['CategoryNameEN'];
        $CategoryDescriptionEN = $_POST['CategoryDescriptionEN'];
    } else {
        echo 'Не заполнены поля на английском';
        exit();
    }

    if(isset($_POST['CategoryNameUA']) && isset($_POST['CategoryDescriptionUA'])) {
        $CategoryNameUA = $_POST['CategoryNameUA'];
        $CategoryDescriptionUA = $_POST['CategoryDescriptionUA'];
    } else {
        echo 'Не заполнены поля на украинском';
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO categories (CategoryName, CategoryNameUA, CategoryNameEN, CategoryDescription, CategoryDescriptionUA, CategoryDescriptionEN, CategoryActive, CategoryDate) VALUES (:CategoryName, :CategoryNameUA, :CategoryNameEN, :CategoryDescription, :CategoryDescriptionUA, :CategoryDescriptionEN, :CategoryActive, :CategoryDate)');
    $stmt->execute(array(
        ':CategoryName'          => $CategoryName,
        ':CategoryNameUA'        => $CategoryNameUA,
        ':CategoryNameEN'        => $CategoryNameEN,
        ':CategoryDescription'   => $CategoryDescription,
        ':CategoryDescriptionUA' => $CategoryDescriptionUA,
        ':CategoryDescriptionEN' => $CategoryDescriptionEN,
        ':CategoryActive'        => $CategoryActive,
        ':CategoryDate'          => time()
    ));
    echo "Категория успешно создана";
}

/*
    Services
*/

if(GetAction('create-service')) {
    // echo "Услуга успешно создана";
    // exit();
    $ServiceName = $layer->safe('ServiceName');
    $ServiceDescription = $layer->safe('ServiceDescription');
    $ServiceDescription = $_POST['ServiceDescription']; // <----------------------------------------------
    $ServiceCategoryID = $layer->safe('ServiceCategoryID');

    if(isset($_POST['ServiceAPI'])) {
        if(!filter_var($_POST['ServiceAPI'], FILTER_VALIDATE_URL) === false) {
            $ServiceAPI = $layer->safe('ServiceAPI');
        } else {
            echo 'Invalid service API URL.';
            exit();
        }
    } else {
        $ServiceAPI = '';
    }
    if(isset($_POST['ServiceOrderAPI'])) {
        if(!filter_var($_POST['ServiceOrderAPI'], FILTER_VALIDATE_URL) === false) {
            $ServiceOrderAPI = $layer->safe('ServiceOrderAPI');
        } else {
            echo 'Недопустимый URL-адрес API-адреса заказа.';
            exit();
        }
    } else {
        $ServiceOrderAPI = '';
    }

    $ServiceType = $layer->safe('ServiceType');
    $ServicePrice = $layer->safe('ServicePrice');
    $ServiceMinQuantity = $layer->safe('ServiceMinQuantity');
    $ServiceMaxQuantity = $layer->safe('ServiceMaxQuantity');
    $ServiceResellerPrice = $layer->safe('ServiceResellerPrice');
    $ServiceActive = $layer->safe('ServiceActive');

    $ServiceCancel = $layer->safe('ServiceCancel') == "Yes" ? 1 : 0;
    $ServiceRefill = $layer->safe('ServiceRefill') == "Yes" ? 1 : 0;
    $ServiceRefillDuration = $layer->safe('ServiceRefillDuration');


    if(isset($_POST['ServiceNameEN']) && isset($_POST['ServiceDescriptionEN'])) {
        $ServiceNameEN = $_POST['ServiceNameEN'];
        $ServiceDescriptionEN = $_POST['ServiceDescriptionEN'];
    } else {
        echo 'Не заполнены поля на английском';
        exit();
    }

    if(isset($_POST['ServiceNameUA']) && isset($_POST['ServiceDescriptionUA'])) {
        $ServiceNameUA = $_POST['ServiceNameUA'];
        $ServiceDescriptionUA = $_POST['ServiceDescriptionUA'];
    } else {
        echo 'Не заполнены поля на украинском';
        exit();
    }

    if($ServiceMinQuantity < $ServiceMaxQuantity) {
        $stmt = $pdo->prepare('INSERT INTO services (ServiceName, ServiceNameUA, ServiceNameEN, ServiceDescriptionEN, ServiceDescription, ServiceDescriptionUA, ServiceCategoryID, ServiceAPI, ServiceOrderAPI, ServiceType, ServicePrice,
        ServiceMinQuantity, ServiceMaxQuantity, ServiceResellerPrice, ServiceActive, ServiceDate, refill, refill_duration, cancel)
        VALUES (:ServiceName, :ServiceNameUA, :ServiceNameEN, :ServiceDescriptionEN, :ServiceDescription, :ServiceDescriptionUA,  :ServiceCategoryID, :ServiceAPI, :ServiceOrderAPI, :ServiceType, :ServicePrice, :ServiceMinQuantity, :ServiceMaxQuantity, :ServiceResellerPrice, :ServiceActive, :ServiceDate, :refill, :refill_duration, :cancel)');

        $stmt->execute(array(
            ':ServiceName'          => $ServiceName,
            ':ServiceNameUA'        => $ServiceNameUA,
            ':ServiceNameEN'        => $ServiceNameEN,
            ':ServiceDescription'   => $ServiceDescription,
            ':ServiceDescriptionUA' => $ServiceDescriptionUA,
            ':ServiceDescriptionEN' => $ServiceDescriptionEN,
            ':ServiceCategoryID'    => $ServiceCategoryID,
            ':ServiceAPI'           => $ServiceAPI,
            ':ServiceOrderAPI'      => $ServiceOrderAPI,
            ':ServiceType'          => $ServiceType,
            ':ServicePrice'         => $ServicePrice,
            ':ServiceMinQuantity'   => $ServiceMinQuantity,
            ':ServiceMaxQuantity'   => $ServiceMaxQuantity,
            ':ServiceResellerPrice' => $ServiceResellerPrice,
            ':ServiceActive'        => $ServiceActive,
            ':ServiceDate'          => time(),
            ':refill'               => $ServiceRefill,
            ':refill_duration'      => $ServiceRefillDuration,
            ':cancel'               => $ServiceCancel
        ));
        echo "Услуга успешно создана";
    } else {
        echo 'Минимальный уровень обслуживания не может превышать максимальное количество.';
    }
}

if(GetAction('get-service-details')) {
    $ServiceID = $layer->safe('ServiceID');

    $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
    $stmt->execute(array(':ServiceID' => $ServiceID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();

        $ServiceCategoryName = $layer->GetData('categories', 'CategoryName', 'CategoryID', $row['ServiceCategoryID']);
        $row['ServiceCategoryName'] = $ServiceCategoryName;
        echo json_encode($row);
    }
}

if(GetAction('save-service')) {
    $ServiceID = $layer->safe('EditServiceID');

    $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID LIMIT 1');
    $stmt->execute([':ServiceID' => $ServiceID]);
    if($stmt->rowCount() == 1) {
        $ServiceOData = $stmt->fetch();
    }

    //$ServiceName = $layer->safe('EditServiceName');
	$ServiceName =  $_POST['EditServiceName'];
    $ServiceDescription = $layer->safe('EditServiceDescription');
    $ServiceDescription = $_POST['EditServiceDescription'];
    $ServiceCategoryID = $layer->safe('EditServiceCategoryID');

    if(isset($_POST['EditServiceAPI']) && !empty($_POST['EditServiceAPI'])) {
        if(!filter_var($_POST['EditServiceAPI'], FILTER_VALIDATE_URL) === false) {
            $ServiceAPI = $layer->safe('EditServiceAPI');
        } else {
            echo 'Недопустимый URL-адрес API-службы.';
            exit();
        }
    } else {
        $ServiceAPI = '';
    }

    if(isset($_POST['EditServiceOrderAPI']) && !empty($_POST['EditServiceOrderAPI'])) {
        if(!filter_var($_POST['EditServiceOrderAPI'], FILTER_VALIDATE_URL) === false) {
            $ServiceOrderAPI = $layer->safe('EditServiceOrderAPI');
        } else {
            echo 'Недопустимый URL-адрес API-адреса заказа.';
            exit();
        }
    } else {
        $ServiceOrderAPI = '';
    }

    // Проверка совпадения первых 50 символов между ServiceAPI и ServiceOrderAPI
    if(substr($ServiceAPI, 0, 50) !== substr($ServiceOrderAPI, 0, 50)) {
        echo 'Не совпадают URL';
        return;
    }

    $ServiceType = $layer->safe('EditServiceType');
    $ServicePrice = $layer->safe('EditServicePrice');
    $ServiceMinQuantity = $layer->safe('EditServiceMinQuantity');
    $ServiceMaxQuantity = $layer->safe('EditServiceMaxQuantity');
    $ServiceResellerPrice = $layer->safe('EditServiceResellerPrice');
    $ServiceActive = $layer->safe('EditServiceActive');

    $ServiceCancel = $layer->safe('EditServiceCancel') == "Yes" ? 1 : 0;
    $ServiceRefill = $layer->safe('EditServiceRefill') == "Yes" ? 1 : 0;
    $ServiceRefillDuration = $layer->safe('EditServiceRefillDuration');

    if(isset($_POST['EditServiceNameEN']) && isset($_POST['EditServiceDescriptionEN'])) {
        $EditServiceNameEN = $_POST['EditServiceNameEN'];
        $EditServiceDescriptionEN = $_POST['EditServiceDescriptionEN'];
    } else {
        echo 'Не заполнены поля на английском';
        exit();
    }

    if(isset($_POST['EditServiceNameUA']) && isset($_POST['EditServiceDescriptionUA'])) {
        $EditServiceNameUA = $_POST['EditServiceNameUA'];
        $EditServiceDescriptionUA = $_POST['EditServiceDescriptionUA'];
    } else {
        echo 'Не заполнены поля на украинском';
        exit();
    }

    if($ServiceMinQuantity < $ServiceMaxQuantity) {
        $stmt = $pdo->prepare('UPDATE services SET ServiceName = :ServiceName, ServiceNameUA = :ServiceNameUA, ServiceNameEN = :ServiceNameEN, ServiceDescription = :ServiceDescription, ServiceDescriptionUA = :ServiceDescriptionUA, ServiceDescriptionEN = :ServiceDescriptionEN, ServiceCategoryID = :ServiceCategoryID,
        ServiceAPI = :ServiceAPI, ServiceOrderAPI = :ServiceOrderAPI, ServiceType = :ServiceType, ServicePrice = :ServicePrice, ServiceMinQuantity = :ServiceMinQuantity,
        ServiceMaxQuantity = :ServiceMaxQuantity, ServiceResellerPrice = :ServiceResellerPrice, ServiceActive = :ServiceActive, refill = :refill, refill_duration = :refill_duration, cancel = :cancel WHERE ServiceID = :ServiceID');

        $stmt->execute(array(
            ':ServiceName'          => $ServiceName,
            ':ServiceNameUA'        => $EditServiceNameUA,
            ':ServiceNameEN'        => $EditServiceNameEN,
            ':ServiceDescription'   => $ServiceDescription,
            ':ServiceDescriptionUA' => $EditServiceDescriptionUA,
            ':ServiceDescriptionEN' => $EditServiceDescriptionEN,
            ':ServiceCategoryID'    => $ServiceCategoryID,
            ':ServiceAPI'           => $ServiceAPI,
            ':ServiceOrderAPI'      => $ServiceOrderAPI,
            ':ServiceType'          => $ServiceType,
            ':ServicePrice'         => $ServicePrice,
            ':ServiceMinQuantity'   => $ServiceMinQuantity,
            ':ServiceMaxQuantity'   => $ServiceMaxQuantity,
            ':ServiceResellerPrice' => $ServiceResellerPrice,
            ':ServiceActive'        => $ServiceActive,
            ':refill'               => $ServiceRefill,
            ':refill_duration'      => $ServiceRefillDuration,
            ':cancel'               => $ServiceCancel,
            ':ServiceID'            => $ServiceID
        ));

        if(isset($ServiceOData)) {
            $SELog = [];
            $SELogUA= [];
            $SELogEN = [];
            if($ServiceOData['ServiceActive'] != $ServiceActive) {
                $SELog[] = ($ServiceActive == 'Yes') ? 'Услуга включена' : 'Услуга выключена';
                $SELogUA[] = ($ServiceActive == 'Yes') ? 'Послуга увімкнена' : 'Послуга вимкнена';
                $SELogEN[] = ($ServiceActive == 'Yes') ? 'Service is enabled' : 'Service is disabled';
            }
            if($ServiceOData['ServicePrice'] != $ServicePrice) {
                $SELog[] = ($ServiceOData['ServicePrice'] < $ServicePrice) ? 'Цена возросла с '.$ServiceOData['ServicePrice'].' $ до '.$ServicePrice.' $' : 'Цена уменьшилась с '.$ServiceOData['ServicePrice'].' $ до '.$ServicePrice.' $';
                $SELogUA[] = ($ServiceOData['ServicePrice'] < $ServicePrice) ? 'Ціна зросла з '.$ServiceOData['ServicePrice'].' $ до '.$ServicePrice.' $' : 'Ціна зменшилася з '.$ServiceOData['ServicePrice'].' $ до '.$ServicePrice.' $';
                $SELogEN[] = ($ServiceOData['ServicePrice'] < $ServicePrice) ? 'Price has increased from '.$ServiceOData['ServicePrice'].' $ to '.$ServicePrice.' $' : 'Price has decreased from '.$ServiceOData['ServicePrice'].' $ to '.$ServicePrice.' $';
            }
            if($ServiceOData['ServiceResellerPrice'] != $ServiceResellerPrice) {
                $SELog[] = ($ServiceOData['ServiceResellerPrice'] < $ServiceResellerPrice) ? 'Цена для реселлеров возросла с '.$ServiceOData['ServiceResellerPrice'].' $ до '.$ServiceResellerPrice.' $' : 'Цена для реселлеров уменьшилась с '.$ServiceOData['ServiceResellerPrice'].' $ до '.$ServiceResellerPrice.' $';
                $SELogUA[] = ($ServiceOData['ServiceResellerPrice'] < $ServiceResellerPrice) ? 'Ціна для реселерів зросла з '.$ServiceOData['ServiceResellerPrice'].' $ до '.$ServiceResellerPrice.' $' : 'Ціна для реселерів зменшилася з '.$ServiceOData['ServiceResellerPrice'].' $ до '.$ServiceResellerPrice.' $';
                $SELogEN[] = ($ServiceOData['ServiceResellerPrice'] < $ServiceResellerPrice) ? 'Resselers\'s price has increased from '.$ServiceOData['ServiceResellerPrice'].' $ to '.$ServiceResellerPrice.' $' : 'Resseler\'s price has decreased from '.$ServiceOData['ServiceResellerPrice'].' $ to '.$ServiceResellerPrice.' $';
            }
            if($ServiceOData['ServiceMinQuantity'] != $ServiceMinQuantity) {
                $SELog[] = ($ServiceOData['ServiceMinQuantity'] < $ServiceMinQuantity) ? 'Минимальное количество возросло с '.$ServiceOData['ServiceMinQuantity'].' до '.$ServiceMinQuantity : 'Минимальное количество уменьшилось с '.$ServiceOData['ServiceMinQuantity'].' до '.$ServiceMinQuantity;
                $SELogUA[] = ($ServiceOData['ServiceMinQuantity'] < $ServiceMinQuantity) ? 'Мінімальна кількість зросла з '.$ServiceOData['ServiceMinQuantity'].' до '.$ServiceMinQuantity : 'Мінімальна кількість зменшилася з '.$ServiceOData['ServiceMinQuantity'].' до '.$ServiceMinQuantity;
                $SELogEN[] = ($ServiceOData['ServiceMinQuantity'] < $ServiceMinQuantity) ? 'Min amount has increased from '.$ServiceOData['ServiceMinQuantity'].' to '.$ServiceMinQuantity : 'Min amount has decreased from '.$ServiceOData['ServiceMinQuantity'].' to '.$ServiceMinQuantity;
            }
            if($ServiceOData['ServiceMaxQuantity'] != $ServiceMaxQuantity) {
                $SELog[] = ($ServiceOData['ServiceMaxQuantity'] < $ServiceMaxQuantity) ? 'Максимальное количество возросло с '.$ServiceOData['ServiceMaxQuantity'].' до '.$ServiceMaxQuantity : 'Максимальное количество уменьшилось с '.$ServiceOData['ServiceMaxQuantity'].' до '.$ServiceMaxQuantity;
                $SELogUA[] = ($ServiceOData['ServiceMaxQuantity'] < $ServiceMaxQuantity) ? 'Максимальна кількість зросла з '.$ServiceOData['ServiceMaxQuantity'].' до '.$ServiceMaxQuantity : 'Максимальна кількість зменшилася з '.$ServiceOData['ServiceMaxQuantity'].' до '.$ServiceMaxQuantity;
                $SELogEN[] = ($ServiceOData['ServiceMaxQuantity'] < $ServiceMaxQuantity) ? 'Max amount has increased from '.$ServiceOData['ServiceMaxQuantity'].' to '.$ServiceMaxQuantity : 'Max amount has decreased from '.$ServiceOData['ServiceMaxQuantity'].' to '.$ServiceMaxQuantity;
            }

            if(!empty($SELog)) {
                for($i = 0; $i < count($SELog); $i++) {
                    $SELogItem = $SELog[$i];
                    $SELogItemEN = $SELogEN[$i];
                    $SELogItemUA = $SELogUA[$i];
                    $stmt = $pdo->prepare('INSERT INTO updates (service, changes, serviceEN, changesEN, serviceUA, changesUA, date) VALUES (:service, :changes, :serviceEN, :changesEN, :serviceUA, :changesUA, :date)');
                    $stmt->execute(array(
                        ':service'   => $ServiceName,
                        ':changes'   => $SELogItem,
                        ':serviceEN' => $EditServiceNameEN,
                        ':changesEN' => $SELogItemEN,
                        ':serviceUA' => $EditServiceNameUA,
                        ':changesUA' => $SELogItemUA,
                        ':date'      => time()
                    ));
                }
            }
        }

        echo "Услуга успешно отредактирована";
    } else {
        echo 'Минимальный уровень обслуживания не может превышать максимальное количество.';
    }
}

if(GetAction('delete-service')) {
    $ServiceID = $layer->safe('EditServiceID');

    $stmt = $pdo->prepare('SELECT * FROM services WHERE ServiceID = :ServiceID');
    $stmt->execute(array(':ServiceID' => $ServiceID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM services WHERE ServiceID = :ServiceID');
        $stmt->execute(array(':ServiceID' => $ServiceID));
    } else {
        echo 'Служба не существует.';
    }
}


if(GetAction('get-user-details')) {
    $UserID = $layer->safe('UserID');

    $stmt = $pdo->prepare('SELECT * FROM users WHERE UserID = :UserID');
    $stmt->execute(array(':UserID' => $UserID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    }
}

if(GetAction('save-user')) {
    $UserID = $layer->safe('EditUserID');
    $UserName = $layer->safe('EditUserName');
    $UserEmail = $layer->safe('EditUserEmail');
    $UserGroup = $layer->safe('EditUserGroup');
    $UserAPI = $layer->safe('EditUserAPI');
    $UserBalance = $layer->safe('EditUserBalance');
    $UserTelegram = $layer->safe('EditUserTelegram');

    if(!filter_var($UserEmail, FILTER_VALIDATE_EMAIL) === false) {
        $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName OR UserEmail = :UserEmail');
        $stmt->execute(array(':UserName' => $UserName, ':UserEmail' => $UserEmail));

        $UserCheckRow = $stmt->fetch();
        if($stmt->rowCount() == 0 || $stmt->rowCount() == 1) {
            $stmt = $pdo->prepare('UPDATE users SET UserName = :UserName, UserEmail = :UserEmail, UserGroup = :UserGroup, UserAPI = :UserAPI, UserBalance = :UserBalance,
            UserTelegram = :UserTelegram WHERE UserID = :UserID');

            $stmt->execute(array(
                ':UserName'      => $UserName,
                ':UserEmail'     => $UserEmail,
                ':UserGroup'     => $UserGroup,
                ':UserAPI'       => $UserAPI,
                ':UserBalance'   => $UserBalance,
                ':UserTelegram'  => $UserTelegram,
                ':UserID'        => $UserID
            ));
            echo 'Сохранено.';
        } else {
            echo 'Сохранено!!';
        }
    } else {
        echo 'Неверный адрес электронной почты.';
    }
}

if(GetAction('ban-user')) {
    $UserID = $layer->safe('EditUserID');
    $ExpireDate = strtotime($layer->safe('EditUserBanExpireDate'));
    $Reason = $layer->safe('EditUserBanReason');
    if($ExpireDate > time()) {
        $stmt = $pdo->prepare('SELECT UserBannedID FROM users_banned WHERE UserBannedID = :UserBannedID');
        $stmt->execute(array(':UserBannedID' => $UserID));

        if($stmt->rowCount() == 0) {
            $stmt = $pdo->prepare('INSERT INTO users_banned (UserBannedID, UserBannedDate, UserBannedExpireDate, UserBannedReason) VALUES
            (:UserBannedID, :UserBannedDate, :UserBannedExpireDate, :UserBannedReason)');

            $stmt->execute(array(
                ':UserBannedID'         => $UserID,
                ':UserBannedDate'       => time(),
                ':UserBannedExpireDate' => $ExpireDate,
                ':UserBannedReason'     => $Reason
            ));
            echo 'Пользователь отправлен в бан.';
        } else {
            echo 'Пользователь уже заблокирован.';
        }
    } else {
        echo 'Срок действия не может быть до этого момента.';
    }
}

if(GetAction('unban-user')) {
    $UserID = $layer->safe('UserID');

    $stmt = $pdo->prepare('SELECT * FROM users_banned WHERE UserBannedID = :UserBannedID');
    $stmt->execute(array(':UserBannedID' => $UserID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM users_banned WHERE UserBannedID = :UserBannedID');
        $stmt->execute(array(':UserBannedID' => $UserID));
    } else {
        echo 'Пользователь не существует или он не запрещен.';
    }
}

if(GetAction('create-user')) {
    $username = $layer->safe('UserName');
    $email = $layer->safe('UserEmail');
    $password = $layer->safe('UserPassword');
    $re_password = $layer->safe('UserRetypePassword');

    if($password == $re_password) {
        if(!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            if(strlen($email) >= 4 && strlen($email) <= 48) {
                if(strlen($username) >= 4 && strlen($username) <= 32) {
                    if(strlen($password) >= 4 && strlen($password) <= 32) {
                        if($username != $password) {
                            $stmt = $pdo->prepare('SELECT * FROM users WHERE UserName = :UserName OR UserEmail = :UserEmail');
                            $stmt->execute(array(':UserName' => $username, ':UserEmail' => $email));

                            if($stmt->rowCount() == 0) {
                                $password = md5($password);
                                $group = $layer->safe('UserGroup');
                                $api = $layer->safe('UserAPI');
                                $balance = $layer->safe('UserBalance');

                                $stmt = $pdo->prepare('INSERT INTO users (UserName, UserPassword, UserEmail, UserGroup, UserAPI, UserBalance, UserDate, UserIPAddress)
                                VALUES (:UserName, :UserPassword, :UserEmail, :UserGroup, :UserAPI, :UserBalance, :UserDate, :UserIPAddress)');

                                $stmt->execute(array(
                                    ':UserName'      => $username,
                                    ':UserPassword'  => $password,
                                    ':UserEmail'     => $email,
                                    ':UserGroup'     => $group,
                                    ':UserAPI'       => $api,
                                    ':UserBalance'   => $balance,
                                    ':UserDate'      => time(),
                                    ':UserIPAddress' => $ip
                                ));
                                echo 'Пользователь создан.';

                            } else {
                                echo 'Учетная запись с этим именем пользователя / адресом электронной почты уже зарегистрирована.';
                            }
                        } else {
                            echo 'Пароль не может совпадать с именем пользователя.';
                        }
                    } else {
                        echo 'Длина пароля должна быть между 32 символами.';
                    }
                } else {
                    echo 'Длина имени пользователя должна быть от 4 до 32 символов.';
                }
            } else {
                echo 'Длина электронной почты должна составлять от 4 до 48 символов.';
            }
        } else {
            echo 'Недействительный адрес электронной почты. Предоставьте рабочий.';
        }
    } else {
        echo 'Ваш повторно введенный пароль не соответствует первому.';
    }
}

if(GetAction('delete-user')) {
    $UserID = $layer->safe('UserID');

    $stmt = $pdo->prepare('SELECT UserID FROM users WHERE UserID = :UserID');
    $stmt->execute(array(':UserID' => $UserID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM `logs`WHERE LogUserID = :UserID');
        $stmt->execute(array(':UserID' => $UserID));

        $stmt = $pdo->prepare('DELETE FROM `deposits`WHERE DepositUserID = :UserID');
        $stmt->execute(array(':UserID' => $UserID));

        $stmt = $pdo->prepare('DELETE FROM `orders`WHERE OrderUserID = :UserID');
        $stmt->execute(array(':UserID' => $UserID));

        $stmt = $pdo->prepare('DELETE FROM `referrs`WHERE ReferrUserID = :UserID OR ReferrReferralUserID = :UserID');
        $stmt->execute(array(':UserID' => $UserID));

        $stmt = $pdo->prepare('DELETE FROM `users_banned`WHERE UserBannedID = :UserID');
        $stmt->execute(array(':UserID' => $UserID));

        $stmt = $pdo->prepare('DELETE FROM users WHERE UserID = :UserID');

        if(!$stmt->execute(array(':UserID' => $UserID))) {
            echo 'Ошибка удаления!';
        } else {
            echo 'OK ';
        }

    } else {
        echo 'Пользователь не существует.';
    }
}

// News

if(GetAction('add-news')) {
    $NewsTitle = $layer->safe('NewTitle');
    $NewsContent = $_POST['NewContent'];

    if(isset($_POST['NewIcon']) && !empty($_POST['NewIcon'])) {
        $NewsIcon = $layer->safe('NewIcon');
    } else {
        $NewsIcon = '';
    }

    $stmt = $pdo->prepare('INSERT INTO news (NewTitle, NewContent, NewUserID, NewIcon, NewDate) VALUES (:NewTitle, :NewContent, :NewUserID, :NewIcon, :NewDate)');
    $stmt->execute(array(
        ':NewTitle'   => $NewsTitle,
        ':NewContent' => $NewsContent,
        ':NewUserID'  => $UserID,
        ':NewIcon'    => $NewsIcon,
        ':NewDate'    => time()
    ));
}

if(GetAction('get-news-details')) {
    $NewsID = $layer->safe('NewsID');

    $stmt = $pdo->prepare('SELECT * FROM news WHERE NewID = :NewID');
    $stmt->execute(array(':NewID' => $NewsID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    }
}

if(GetAction('save-news')) {
    $NewID = $layer->safe('EditNewID');
    $NewsTitle = $layer->safe('EditNewTitle');
    $NewsContent = $_POST['EditNewContent'];

    if(isset($_POST['EditNewIcon']) && !empty($_POST['EditNewIcon'])) {
        $NewsIcon = $layer->safe('EditNewIcon');
    } else {
        $NewsIcon = '';
    }

    $stmt = $pdo->prepare('UPDATE news SET NewTitle = :NewTitle, NewContent = :NewContent, NewIcon = :NewIcon WHERE NewID = :NewID');
    $stmt->execute(array(
        ':NewTitle'   => $NewsTitle,
        ':NewContent' => $NewsContent,
        ':NewIcon'    => $NewsIcon,
        ':NewID'      => $NewID
    ));
}

if(GetAction('delete-news')) {
    $NewID = $layer->safe('EditNewID');

    $stmt = $pdo->prepare('SELECT NewID FROM news WHERE NewID = :NewID');
    $stmt->execute(array(':NewID' => $NewID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM news WHERE NewID = :NewID');
        $stmt->execute(array(':NewID' => $NewID));
    } else {
        echo 'Новости не существует.';
    }
}

// Deposits

if(GetAction('delete-deposit')) {
    $DepositID = $layer->safe('DepositID');

    $stmt = $pdo->prepare('SELECT DepositID FROM deposits WHERE DepositID = :DepositID');
    $stmt->execute(array(':DepositID' => $DepositID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM deposits WHERE DepositID = :DepositID');
        $stmt->execute(array(':DepositID' => $DepositID));
    } else {
        echo 'Депозита не существует.';
    }
}

if(GetAction('update-deposit')) {
    $DepositID = $layer->safe('DepositID');
    $DepositRefunded = $layer->safe('DepositRefunded');

    $stmt = $pdo->prepare('SELECT DepositID, DepositUserID, DepositAmount, DepositRefunded FROM deposits WHERE DepositID = :DepositID');
    $stmt->execute(array(':DepositID' => $DepositID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();

        $stmt = $pdo->prepare('UPDATE deposits SET DepositRefunded = :DepositRefunded WHERE DepositID = :DepositID');
        $stmt->execute(array(':DepositRefunded' => $DepositRefunded, ':DepositID' => $DepositID));

        $stmt = $pdo->prepare('SELECT UserBalance FROM users WHERE UserID = :UserID');
        $stmt->execute(array(':UserID' => $row['DepositUserID']));

        $query = $stmt->fetch();

        if($DepositRefunded == 'Yes') {
            if($row['DepositRefunded'] == 'No') {
                $stmt = $pdo->prepare('UPDATE users SET UserBalance = :UserBalance WHERE UserID = :UserID');
                $stmt->execute(array(
                    ':UserBalance' => $query['UserBalance'] - $row['DepositAmount'],
                    ':UserID'      => $row['DepositUserID']
                ));
            }
        } else {
            if($row['DepositRefunded'] == 'Yes') {
                $stmt = $pdo->prepare('UPDATE users SET UserBalance = :UserBalance WHERE UserID = :UserID');
                $stmt->execute(array(
                    ':UserBalance' => $query['UserBalance'] + $row['DepositAmount'],
                    ':UserID'      => $row['DepositUserID']
                ));
            }
        }
    } else {
        echo 'Депозита не существует.';
    }
}

// NEWS <-----
if(GetAction('add-News')) {
    $NEWSQuestion = $layer->safe('NEWSQuestion');
    $NEWSQuestion = $_POST['NEWSQuestion'];
    $NEWSAnswer = $layer->safe('NEWSAnswer');
    $NEWSAnswer = $_POST['NEWSAnswer'];
    $specshow = isset($_POST['specshow']) ? 1 : 0;


    $date = date('d.m.Y');

    if(isset($_POST['NEWSQuestionEN']) && isset($_POST['NEWSAnswerEN'])) {
        $NEWSQuestionEN = $_POST['NEWSQuestionEN'];
        $NEWSAnswerEN = $_POST['NEWSAnswerEN'];
    } else {
        echo 'Не заполнены поля на английском';
        exit();
    }

    if(isset($_POST['NEWSQuestionUA']) && isset($_POST['NEWSAnswerUA'])) {
        $NEWSQuestionUA = $_POST['NEWSQuestionUA'];
        $NEWSAnswerUA = $_POST['NEWSAnswerUA'];
    } else {
        echo 'Не заполнены поля на украинском';
        exit();
    }

    $stmt = $pdo->prepare('INSERT INTO news (NEWSQuestion, NEWSAnswer, NEWSQuestionEN, NEWSAnswerEN, NEWSQuestionUA, NEWSAnswerUA, NEWSDate, specshow) VALUES (:NEWSQuestion, :NEWSAnswer, :NEWSQuestionEN, :NEWSAnswerEN, :NEWSQuestionUA, :NEWSAnswerUA, :NEWSDate, :specshow)');
    $stmt->execute([
        ':NEWSQuestion'   => $NEWSQuestion,
        ':NEWSAnswer'     => $NEWSAnswer,
        ':NEWSQuestionEN' => $NEWSQuestionEN,
        ':NEWSAnswerEN'   => $NEWSAnswerEN,
        ':NEWSQuestionUA' => $NEWSQuestionUA,
        ':NEWSAnswerUA'   => $NEWSAnswerUA,
        ':NEWSDate'       => $date,
        ':specshow'       => $specshow,
    ]);
    echo "Новость успешно добавлена";
}

if(GetAction('get-News-details')) {
    $NEWSID = $layer->safe('NEWSID');

    $stmt = $pdo->prepare('SELECT * FROM news WHERE NEWSID = :NEWSID');
    $stmt->execute(array(':NEWSID' => $NEWSID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    } else {
        echo 'Новости не существует';
    }
}
if(GetAction('save-News')) {
    $NEWSID = $layer->safe('EditNEWSID');

    $date = date('d.m.Y');

    $stmt = $pdo->prepare('SELECT NEWSID FROM news WHERE NEWSID = :NEWSID');
    $stmt->execute(array(':NEWSID' => $NEWSID));

    if($stmt->rowCount() == 1) {
        $NEWSQuestion = $layer->safe('EditNEWSQuestion');
        $NEWSQuestion = $_POST['EditNEWSQuestion'];
        $NEWSAnswer = $layer->safe('EditNEWSAnswer');
        $NEWSAnswer = $_POST['EditNEWSAnswer'];
        $specshow = isset($_POST['editspecshow']) ? 1 : 0;


        if(isset($_POST['EditNEWSQuestionEN']) && isset($_POST['EditNEWSAnswerEN'])) {
            $NEWSQuestionEN = $_POST['EditNEWSQuestionEN'];
            $NEWSAnswerEN = $_POST['EditNEWSAnswerEN'];
        } else {
            echo 'Не заполнены поля на английском!';
            exit();
        }

        if(isset($_POST['EditNEWSQuestionUA']) && isset($_POST['EditNEWSAnswerUA'])) {
            $NEWSQuestionUA = $_POST['EditNEWSQuestionUA'];
            $NEWSAnswerUA = $_POST['EditNEWSAnswerUA'];
        } else {
            echo 'Не заполнены поля на украинском!';
            exit();
        }

        $stmt = $pdo->prepare('UPDATE news
                                  SET NEWSQuestion = :NEWSQuestion,
                                      NEWSQuestionEN = :NEWSQuestionEN,
                                      NEWSQuestionUA = :NEWSQuestionUA,
                                      NEWSAnswer = :NEWSAnswer,
                                      NEWSAnswerEN = :NEWSAnswerEN,
                                      NEWSAnswerUA = :NEWSAnswerUA,
                                      NEWSDate = :NEWSDate,
                                      specshow = :specshow
                                WHERE NEWSID = :NEWSID');
        $qres = $stmt->execute([
            ':NEWSID'         => $NEWSID,
            ':NEWSDate'       => $date,
            ':NEWSQuestion'   => $NEWSQuestion,
            ':NEWSAnswer'     => $NEWSAnswer,
            ':NEWSQuestionEN' => $NEWSQuestionEN,
            ':NEWSAnswerEN'   => $NEWSAnswerEN,
            ':NEWSQuestionUA' => $NEWSQuestionUA,
            ':NEWSAnswerUA'   => $NEWSAnswerUA,
            ':specshow'       => $specshow,
        ]);
        if($qres) {
            echo 'Новость успешно сохранена ';
        } else {
            echo 'Ошибка сохранения новости! ';
        }
    } else {
        echo 'Новости не существует';
    }
}
if(GetAction('delete-News')) {
    $NEWSID = $layer->safe('EditNEWSID');

    $stmt = $pdo->prepare('SELECT NEWSID FROM news WHERE NEWSID = :NEWSID');
    $stmt->execute(array(':NEWSID' => $NEWSID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM news WHERE NEWSID = :NEWSID');
        $stmt->execute(array(':NEWSID' => $NEWSID));
    } else {
        echo 'Новости не существует';
    }
}
// NEWS <-------


// Добавление и редактирование отзывов в базе comments_not_added

if(GetAction('add-otzyv')) {
    $comments_name = $layer->safe('comments-name');
    $comments_title = $layer->safe('comments-title');
    $comments_answer = $layer->safe('comments-answer');
    $comments_answer = $_POST['comments-answer'];

    $dates = date('d.m.Y H:i');

    $stmt = $pdo->prepare('INSERT INTO comments_not_added (comments_name, comments_title, comments_answer, comments_date) VALUES (:comments_name, :comments_title, :comments_answer, :comments_date)');
    $stmt->execute(array(
        ':comments_name'   => $comments_name,
        ':comments_title'  => $comments_title,
        ':comments_answer' => $comments_answer,
        ':comments_date'   => $dates
    ));
    echo "Отзыв успешно добавлен";
}


if(GetAction('get-otzyv-details')) {
    $CommentsID = $layer->safe('CommentsID');

    $stmt = $pdo->prepare('SELECT * FROM comments_not_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    } else {
        echo 'Отзыва не существует';
    }
}


if(GetAction('save-otzyv')) {
    $CommentsID = $layer->safe('edit-comments-id');


    $stmt = $pdo->prepare('SELECT CommentsID FROM comments_not_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    $dates = date('d.m.Y H:i');
    if($stmt->rowCount() == 1) {

        $commentsTitle = $layer->safe('edit-comments-title');
        $commentsName = $layer->safe('edit-comments-name');
        $commentsAnswer = $layer->safe('edit-comments-active');
        $comments_answer = $_POST['edit-comments-active'];

        $stmt = $pdo->prepare('UPDATE comments_not_added SET comments_title = :comments_title, comments_name = :comments_name, comments_answer = :comments_answer WHERE CommentsID = :CommentsID');
        $stmt->execute(array(
            ':comments_title'  => $commentsTitle,
            ':comments_name'   => $commentsName,
            ':comments_answer' => $comments_answer,
            ':CommentsID'      => $CommentsID
        ));
        echo "Отзыв успешно сохранен";
    } else {
        echo 'Отзыва не существует';
    }
}


if(GetAction('delete-otzyv')) {
    $CommentsID = $layer->safe('edit-comments-id');

    $stmt = $pdo->prepare('SELECT CommentsID FROM comments_not_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM comments_not_added WHERE CommentsID = :CommentsID');
        $stmt->execute(array(':CommentsID' => $CommentsID));
    } else {
        echo 'Отзыва не существует';
    }
}


// Добавление и редактирование отзывов в базе comments_not_added


// Добавление отзыва в ДР базу данных comments_added

if(GetAction('added-otzyv')) {
    $comments_name = $layer->safe('edit-comments-name');
    $comments_title = $layer->safe('edit-comments-title');
    $comments_answer = $layer->safe('edit-comments-answer');
    // $comments_active = $layer->safe('edit-comments-active');
    $comments_active = $_POST['edit-comments-active'];

    $dates = date('d.m.Y H:i');

    $stmt = $pdo->prepare('INSERT INTO comments_added (comments_name, comments_title, comments_answer, comments_date) VALUES (:comments_name, :comments_title, :comments_answer, :comments_date)');
    $stmt->execute(array(
        ':comments_name'   => $comments_name,
        ':comments_title'  => $comments_title,
        ':comments_answer' => $comments_active,
        ':comments_date'   => $dates
    ));
    echo "Отзыв успешно добавлен на страницу отзывов";

    $CommentsID = $layer->safe('edit-comments-id');

    $stmt = $pdo->prepare('SELECT CommentsID FROM comments_not_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM comments_not_added WHERE CommentsID = :CommentsID');
        $stmt->execute(array(':CommentsID' => $CommentsID));
    } else {
        echo 'Отзыва не существует';
    }
}
// Добавление отзыва в ДР базу данных comments_added


// Редактирование добавленных отзывов в базе comments_added

if(GetAction('get-otzyvAdd-details')) {
    $CommentsID = $layer->safe('CommentsID');

    $stmt = $pdo->prepare('SELECT * FROM comments_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    } else {
        echo 'Отзыва не существует';
    }
}


if(GetAction('save-otzyvAdd')) {
    $CommentsID = $layer->safe('edit-commentsAdd-id');


    $stmt = $pdo->prepare('SELECT CommentsID FROM comments_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    $dates = date('d.m.Y H:i');
    if($stmt->rowCount() == 1) {

        $comments_title = $layer->safe('edit-commentsAdd-title');
        $comments_name = $layer->safe('edit-commentsAdd-name');
        $commentsAnswer = $layer->safe('edit-commentsAdd-answer');
        // $comments_active = $layer->safe('edit-comments-active');
        $comments_active = $_POST['edit-commentsAdd-active'];

        $stmt = $pdo->prepare('UPDATE comments_added SET comments_title = :comments_title, comments_name = :comments_name, comments_answer = :comments_answer WHERE CommentsID = :CommentsID');
        $stmt->execute(array(
            ':comments_title'  => $comments_title,
            ':comments_name'   => $comments_name,
            ':comments_answer' => $comments_active,
            ':CommentsID'      => $CommentsID
        ));
        echo "Отзыв успешно сохранен";
    } else {
        echo 'Отзыва не существует';
    }
}


if(GetAction('delete-otzyvAdd')) {
    $CommentsID = $layer->safe('edit-commentsAdd-id');

    $stmt = $pdo->prepare('SELECT CommentsID FROM comments_added WHERE CommentsID = :CommentsID');
    $stmt->execute(array(':CommentsID' => $CommentsID));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM comments_added WHERE CommentsID = :CommentsID');
        $stmt->execute(array(':CommentsID' => $CommentsID));
    } else {
        echo 'Отзыва не существует';
    }
}
// Редактирование добавленных отзывов в базе comments_added


if(GetAction('add-update')) {
    $service = $layer->safe('update-create-service');
    $changes = $layer->safe('update-create-changes');
    $serviceEN = $layer->safe('update-create-serviceEN');
    $changesEN = $layer->safe('update-create-changesEN');
    $serviceUA = $layer->safe('update-create-serviceUA');
    $changesUA = $layer->safe('update-create-changesUA');

    $stmt = $pdo->prepare('INSERT INTO updates (service, changes, serviceEN, changesEN, serviceUA, changesUA, date) VALUES (:service, :changes, :serviceEN, :changesEN, :serviceUA, :changesUA, :date)');
    $stmt->execute(array(
        ':service'   => $service,
        ':changes'   => $changes,
        ':serviceEN' => $serviceEN,
        ':changesEN' => $changesEN,
        ':serviceUA' => $serviceUA,
        ':changesUA' => $changesUA,
        ':date'      => time()
    ));
    echo "Обновление успешно добавлено";
}

if(GetAction('get-update-details')) {
    $id = $layer->safe('id');

    $stmt = $pdo->prepare('SELECT * FROM updates WHERE id = :id');
    $stmt->execute(array(':id' => $id));

    if($stmt->rowCount() == 1) {
        $row = $stmt->fetch();
        echo json_encode($row);
    } else {
        echo 'Обновление не существует';
    }
}

if(GetAction('save-update')) {
    $id = $layer->safe('update-edit-id');

    $stmt = $pdo->prepare('SELECT id FROM updates WHERE id = :id');
    $stmt->execute(array(':id' => $id));

    if($stmt->rowCount() == 1) {
        $service = $layer->safe('update-edit-service');
        $changes = $layer->safe('update-edit-changes');
        $serviceEN = $layer->safe('update-edit-serviceEN');
        $changesEN = $layer->safe('update-edit-changesEN');
        $serviceUA = $layer->safe('update-edit-serviceUA');
        $changesUA = $layer->safe('update-edit-changesUA');

        $stmt = $pdo->prepare('UPDATE updates SET service = :service, changes = :changes, serviceEN = :serviceEN, changesEN = :changesEN, serviceUA = :serviceUA, changesUA = :changesUA WHERE id = :id');
        $stmt->execute(array(
            ':service'   => $service,
            ':changes'   => $changes,
            ':serviceEN' => $serviceEN,
            ':changesEN' => $changesEN,
            ':serviceUA' => $serviceUA,
            ':changesUA' => $changesUA,
            ':id'        => $id
        ));
        echo "Обновление успешно сохранено";
    } else {
        echo 'Обновление не существует';
    }
}

if(GetAction('delete-update')) {
    $id = $layer->safe('update-edit-id');

    $stmt = $pdo->prepare('SELECT id FROM updates WHERE id = :id');
    $stmt->execute(array(':id' => $id));

    if($stmt->rowCount() == 1) {
        $stmt = $pdo->prepare('DELETE FROM updates WHERE id = :id');
        $stmt->execute(array(':id' => $id));
    } else {
        echo 'Обновление не существует';
    }
}

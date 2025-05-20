<?php

// Авторизация 1xpanel.com.
function authOrder($orderId, $domain, $username, $password): bool

{
    $ch = curl_init(); // Создание новой cURL-сессии
    curl_setopt($ch, CURLOPT_URL, "https://$domain/"); // Установка URL, на который нужно выполнить запрос
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Установка параметра, чтобы результат запроса был возвращен как строка
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0'); // Установка пользовательского агента
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Включение поддержки HTTPS
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // Установка таймаута соединения в секундах
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); // Установка таймаута загрузки в секундах
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); //  Следовать за редиректами
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
        'Connection: keep-alive',
        "Referer: https://$domain/"
    ]); // Установка параметров Accept, Accept-Language, Accept-Encoding, Connection и Referer

// Включение сохранения и использования куки
    curl_setopt($ch, CURLOPT_COOKIEJAR, __DIR__ . '/cookies.txt'); //
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');

    $response = curl_exec($ch); // Выполнение запроса и сохранение ответа
    //file_put_contents(__DIR__ . "/cancel/authOrder-get-$orderId.txt", $response);
/*// Проверка на наличие ошибок
    if (curl_errno($ch)) {
        echo 'Ошибка: ' . curl_error($ch);
    }*/

    $regex = '/<input type="hidden" name="_csrf" value="([^"]+)">/'; // Получаем CSRF-токен

    if (preg_match($regex, $response, $matches)) {
        $csrf = $matches[1];
     } else {
        return "Ошибка авторизации не удалось найти CSRF-токен";
    }


// URL и данные для отправки POST-запроса
    $data = array(
        'LoginForm[username]' => $username,
        'LoginForm[password]' => $password,
        '_csrf' => $csrf,
        'LoginForm[remember]' => 1
    );

    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
        'Connection: keep-alive',
        'Content-Type: application/x-www-form-urlencoded',
        "Referer: https://$domain/"
    ]); // Установка параметров Accept, Accept-Language, Accept-Encoding, Connection и Referer

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

// Включение сохранения и использования куки
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt'); // '/../cancel/cookies.txt');

    $response = curl_exec($ch);
    //file_put_contents(__DIR__ . "/cancel/authOrder-post-$orderId.txt", $response);

    // Переходим на страницу заказа, для проверки.
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_URL, "https://$domain/orders");
    // Установка параметров Accept, Accept-Language, Accept-Encoding, Connection и Referer
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,*/*;q=0.8',
        'Connection: keep-alive',
        "Referer: https://$domain/"
    ]);

    $response = curl_exec($ch);
    //file_put_contents(__DIR__ . "/cancel/authOrder-get2-$orderId.txt", $response);
//    $pattern = "/data-order_id=\"{$orderId}\"/";
    $pattern = "/$orderId/";
    preg_match($pattern, $response, $matches);

    curl_close($ch);
// Если есть id
    if (!empty($matches)) {
        return true;
    } else {
        return false;
    }
}

function cancelOrder($orderId, $domain)

{
    /*
Шлем запрос на отмену.
Если ответ нужный, то все ок.
    Если ответ ошибочный, то
    Открываем ордер.
    Ищем заказ.
    Если нашли, то уже авторизованы.

    Если нет, то авторизовываемся.
    Получаем _csrf.
    Формируем запрос на авторизацию
    Авторизовываемся.

    Пробуем выполнить действие.
    Проверяем результат.

    */
// Отменяем заказ.
    $ch = curl_init(); // Создание новой cURL-сессии
    curl_setopt($ch, CURLOPT_URL, "https://$domain/orders/$orderId/cancel");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Установка параметра, чтобы результат запроса был возвращен
    // как строка
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/117.0'); // Установка пользовательского агента
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // Включение поддержки HTTPS
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60); // Установка таймаута соединения в секундах
    curl_setopt($ch, CURLOPT_TIMEOUT, 100); // Установка таймаута загрузки в секундах

// Установка параметров Accept, Accept-Language, Accept-Encoding, Connection и Referer
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: */*',
        'Connection: keep-alive',
        'X-Requested-With: XMLHttpRequest',
        "Referer: https://$domain/orders"
    ]);

// Включение сохранения и использования куки
    curl_setopt($ch, CURLOPT_COOKIEFILE, __DIR__ . '/cookies.txt');
    $response = curl_exec($ch); // Выполнение запроса и сохранение ответа
    //file_put_contents(__DIR__ . "/cancel/cancelOrder-get-$orderId.txt", $response);

// Проверка на наличие ошибок
/*    if (curl_errno($ch)) {
        echo 'Ошибка: ' . curl_error($ch);
    }*/

    $data = json_decode($response, true); // Преобразование JSON в ассоциативный массив
    curl_close($ch);
    if (!empty($data['status']) && $data['status'] === 'success') {
        return 'success';
    }elseif (!empty($data['status']) && $data['status'] === 'error') {
        return 'error';
}
    else { // можно добавить проверку на {"status":"error","error":"Error"}
        return 'noauth';
    }
}
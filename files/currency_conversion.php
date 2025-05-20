<?php
// currency_conversion.php

$cache_file = 'files/currency_cache.json';
$cache_time = 86400; // 1 день в секундах

if (file_exists($cache_file) && (time() - filemtime($cache_file) < $cache_time)) {
    $get_curs = json_decode(file_get_contents($cache_file), true);
} else {
    $get_curs = @json_decode(@file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'), true);
    if ($get_curs) {
        file_put_contents($cache_file, json_encode($get_curs));
    }
}

$usd_value = $get_curs["Valute"]["USD"]["Value"];
$lang = $_GET["lang"] ?? 'default';
$rates = [
    'default' => [$usd_value, '₽'],
    'en' => [$usd_value / $get_curs["Valute"]["EUR"]["Value"], '€'],
    'ua' => [$usd_value / ($get_curs["Valute"]["UAH"]["Value"] / $get_curs["Valute"]["UAH"]["Nominal"]), '₴']
];
[$rate, $currency] = $rates[$lang] ?? $rates['default'];
$rate = number_format($rate, 2, '.', ' ');
?>

<?php
	require_once('files/header.php');
	
	$user->IsLogged();
?>
</nav><section class="page-section">
<div class="row col-lg-12 col-center ">
<div class="container relative">
<h1 class="section-title font-alt mb-40 mb-sm-40">Запросы и ответы API</h1>
<div class="row">
 <div class="col-md-6 mb-40">
<table class="table table-bordered">
<tbody>
<tr>
<td width="30%">HTTP метод</td>
<td width="70%"><code>GET/POST</code></td>
</tr>
<tr>
<td>URL API</td>
<td><code>https://wiq.by/api/</code></td>
</tr>
<tr>
<td>Формат ответа</td>
<td><code>JSON</code></td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<pre><code>Мы есть в PerfectPanel. 
        Просто введите в поиск wiq.by и продавайте наши услуги!</code></pre>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-20">
<h4 class="uppercase mb-30">Создание заказа</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>action</td>
<td>create или add</td>
</tr>
<tr>
<td>service</td>
<td>
ID услуги
, указанный в <a href="https://wiq.by/list.php">прайсе</a>
</td>
</tr>
<tr>
<td>quantity</td>
<td>Количество накрутки</td>
</tr>
<tr>
<td>link</td>
<td>Ссылка, куда необходимо сделать накрутку</td>
</tr>
<tr>
<td>posts</td>
<td>Количество будущих публикаций (для авто лайков/просмотров)</td>
</tr>
<tr>
<td>list</td>
<td>Список собственных комментариев, разделитель \r\n</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-20">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "order": "142"
}</code></pre>
</div>
</div>
Пример запроса:
<code>https://wiq.by/api/?key=<?php echo $UserAPI; ?>&amp;action=create&amp;service=3&amp;quantity=200&amp;link=https://www.instagram.com/timatiofficial/</code>
<hr class="mb-60 mb-xs-30">
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Проверка статуса заказа</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
 <td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>action</td>
<td>status</td>
</tr>
<tr>
<td>order</td>
<td>
ID заказа
, указанный в <a href="https://wiq.by/all-orders">списке ваших заказов</a>. <br>
Если заказ сформирован не через ваш ключ, то вы не сможете отслеживать его.
</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "status": "Processing",
    "link": "https://www.instagram.com/timatiofficial/",
    "quantity": "200",
    "start_count": "1400",
    "remains": "160",
    "charge": "5"
}</code></pre>
</div>
</div>
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Массовая проверка статусов</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>action</td>
<td>status</td>
</tr>
<tr>
<td>order</td>
<td>
ID заказов через запятую (Не более 100 за раз)
, указанный в <a href="https://wiq.by/api-orders.php">списке ваших заказов</a>. <br>
Если заказ сформирован не через ваш ключ, то вы не сможете отслеживать его.
</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
  "101456340":{
     "charge":"0.15",
     "remains":"0",
     "status":"Completed",
     "start_count":"150",
     "currency":"USD"
  },
  "100450291":{
     "charge":"2",
     "remains":"100",
     "status":"In progress",
     "start_count":"16790",
     "currency":"USD"
  }
}</code></pre>
</div>
</div>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;action=status&amp;order=1,2,3,4,5,6,7,8</code>
<hr class="mb-60 mb-xs-30">
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Отмена заказа</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
 </tr>
<tr>
<td>action</td>
<td>cancel</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "id": 5914537,
    "cancel": "ok"
}</code></pre>
</div>
</div>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;action=cancel&amp;order=5914537</code><br>
<div class="alert">Доступно для услуг: 2, 3, 4, 8, 9, 10, 12, 13, 14, 15, 16, 17, 20, 23, 24, 25, 26, 31, 32, 33, 34, 35, 36, 40, 41, 44, 45, 46, 48, 49, 51, 53, 60, 62, 67, 68, 69, 70, 72, 73, 74, 75, 76, 77, 82, 83, 84, 92, 93, 94, 95, 96, 97, 99, 104, 105, 112, 113, 115, 116, 117, 118, 119, 121, 122, 123, 124, 125, 129, 130, 131, 132, 136, 137, 139, 177, 178, 190, 191, 222, 223, 224, 251, 252, 253, 254, 259, 260, 263, 264, 305, 306, 308, 342, 344, 350, 351, 352, 387, 403, 404, 405, 407, 408, 409, 411, 414, 415, 416, 417, 418, 419, 420, 421, 422, 500, 550, 2013, 2014, 2134</div>
<hr class="mb-60 mb-xs-30">
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Восстановелние отписок (Refill)</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>action</td>
<td>refill</td>
</tr>
<tr>
<td>order</td>
<td>99999</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "status": "ok"
}</code></pre>
</div>
</div>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;action=refill&amp;order=9999</code>
<hr class="mb-60 mb-xs-30">
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Проверка баланса</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>action</td>
<td>balance</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "balance": "9999"
}</code></pre>
</div>
</div>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;action=balance</code>
<hr class="mb-60 mb-xs-30">
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Список услуг</h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>action</td>
<td>services</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>[
    {
        "ID": "9999",
        "name": "Лайки",
        "description": "Быстрый старт. Все профили с аватарками и публикациями. Вместе с лайками приходит отхват.",
        "cost": "25",
        "min": "10",
        "max": "5000",
        "refil": true
    }
]</code></pre>
</div>
</div>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;action=services</code>
<hr id="bots" class="mb-60 mb-xs-30">
<div class="row" id="cat1">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Получение задания <span class="label label-primary">beta</span></h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>appkey</td>
<td>JKnb32hyub</td>
</tr>
<tr>
<td>action</td>
<td>task_start</td>
</tr>
<tr>
<td>provider</td>
<td>[insta | twitter]</td>
</tr>
<tr>
<td>type</td>
<td>[like_post | follow_profile]</td>
</tr>
<tr>
<td>cat</td>
<td>Категория задания</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "id": 2342342,
    "url": "https:\/\/instagram.com\/asdfasdfas",
    "provider": "insta",
    "type": "follow_profile",
    "cost": 0.34
}</code></pre>
</div>
</div>
<b>Категория: 1 [hold]</b><br>
1000 подписок: 0.28 $<br>
1000 лайков: 0.10 $<br>
Заданий / действий (Подписки): <br>[АКТИВНЫХ: 1139 / 843711]<br> [ЗА ДЕНЬ:1354 / 645003] <br>
Заданий / действий (Лайки): <br>[АКТИВНЫХ: 66 / 233001]<br> [ЗА ДЕНЬ:12714 / 4892827] <br>
<pre><code>Требования к аккаунтам исполнителей:
— ПУБЛИЧНЫЙ ПРОФИЛЬ
— АВАТАРКА
— ИМЯ НА РУССКОМ ЯЗЫКЕ (ПРИМЕР: НИКИТА ИЛИ ЭВЕЛИНА)
— МИНИМУМ 10 ПОДПИСЧИКОВ
— МИНИМУМ 6 ПОСТОВ
— ЕСТЕСТВЕННОЕ НАПОЛНЕНИЕ
Аккаунт должен представлять “живого” человека, тематические аккаунты запрещены (магазины, собачки, котики и т.д.). Генерированные лица запрещены. В том числе, заполненные поля анкеты должны соответствовать данным “живого” человека (правильно: “Владимир Иванов”; неправильно: “Рулон Обоев”).</code></pre><br>
<b>Категория: 2 [hold]</b> <b style="color:red;"></b><br>
1000 подписок: 29 рублей<br>
1000 лайков: 10 - 15 рублей<br>
Заданий / действий (Подписки): <br>[АКТИВНЫХ: 0 / 0]<br> [ЗА ДЕНЬ:0 / 0] <br>
Заданий / действий (Лайки): <br>[АКТИВНЫХ: 0 / 0]<br> [ЗА ДЕНЬ:0 / 0] <br>
<pre><code>Требования к аккаунтам исполнителей:
— ПУБЛИЧНЫЙ ПРОФИЛЬ
— АВАТАРКА
— МИНИМУМ 1 ПОСТ
Аккаунт должен представлять “живого” человека, тематические аккаунты запрещены (магазины, собачки, котики и т.д.). Генерированные лица запрещены.</code></pre><br>
<b>Категория: 3 [no hold]</b> <br>
1000 подписок: 0.10 $<br>
1000 лайков: 0.019$ <br>
Заданий / действий (Подписки): <br>[АКТИВНЫХ: 38 / 368259]<br> [ЗА ДЕНЬ:102405 / 11350872] <br>
Заданий / действий (Лайки): <br>[АКТИВНЫХ: 380 / 2366009]<br> [ЗА ДЕНЬ:13 / 130] <br>
<pre><code>Требования к аккаунтам исполнителей:
— ПУБЛИЧНЫЙ ПРОФИЛЬ
— АВАТАРКА</code></pre><br>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;appkey=JKnb32hyub&amp;action=task_start&amp;provider=insta&amp;type=like_post&amp;login=(Логин аккаунта с которого берете задание)</code><br>

<hr class="mb-60 mb-xs-30">
<div class="row">
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Проверка выполнения задания <span class="label label-primary">beta</span></h4>
<table class="table table-bordered">
<tbody>
<tr>
<td width="20%">key</td>
<td width="80%">Ваш ключ API: <code><?php echo $UserAPI; ?></code></td>
</tr>
<tr>
<td>appkey</td>
<td>Ключ приложения</td>
</tr>
<tr>
<td>action</td>
<td>task_check</td>
</tr>
<tr>
<td>id</td>
<td>2342342</td>
</tr>
</tbody>
</table>
</div>
<div class="col-md-6 mb-40">
<h4 class="uppercase mb-30">Пример ответа</h4>
<pre><code>{
    "status": true
}</code></pre>
</div>
</div>
Пример запроса:
<code><?php echo $url; ?>api/?key=<?php echo $UserAPI; ?>&amp;appkey=JKnb32hyub&amp;action=task_check&amp;id=(ID задания полученное при запросе task_start)&amp;login=(Логин аккаунта с которого выполнялось задание)</code><br>
</div>
</div>
	</section>
<?php
	require_once('files/footer.php');
?>

<script>

</script>
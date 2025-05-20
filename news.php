<?php
require_once('files/header.php');

$per_page = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Подготовленный запрос для получения общего количества новостей
$total_count_q = $pdo->prepare("SELECT COUNT(`NEWSID`) AS `total_count` FROM `news`");
$total_count_q->execute();
$total_count = $total_count_q->fetchColumn();
$total_pages = ceil($total_count / $per_page);

$page = max(1, min($page, $total_pages)); 
$offset = ($page - 1) * $per_page;

// Подготовленный запрос для получения новостей с ограничением и смещением
$news_wiq = $pdo->prepare("SELECT * FROM `news` ORDER BY `NEWSID` DESC LIMIT :offset, :per_page");
$news_wiq->bindValue(':offset', $offset, PDO::PARAM_INT);
$news_wiq->bindValue(':per_page', $per_page, PDO::PARAM_INT);
$news_wiq->execute();

$news_exist = $news_wiq->rowCount() > 0 ? true : false;
$lang = isset($_GET['lang']) ? strtoupper($_GET['lang']) : '';

// Определяем заголовок в зависимости от языка
$headings = [
    'EN' => 'News',
    'RU' => 'Новости сервиса',
    'UA' => 'Новини сервісу'
];

$telegram_text = [
    'EN' => 'Telegram channel',
    'RU' => 'Telegram канал',
    'UA' => 'Telegram канал'
];
?>
<div class="main-news">
    <div class="container">
        <div class="flex_news_service">
            <h1 class="section-title font-alt" style="margin-bottom: 20px">
                <?= $headings[$lang] ?? 'Новости'; // Используем языковой заголовок, или дефолтный ?>
            </h1>
        </div>

        <div class="flex_button_telegram">
            <a href="https://t.me/wiqnews" class="button_telegram">
                <i class="fab fa-telegram-plane"></i> <?= $telegram_text[$lang] ?? 'Telegram канал'; ?>
            </a>
        </div>

        <?php if ($news_exist): ?>
            <?php while ($new = $news_wiq->fetch(PDO::FETCH_ASSOC)): ?>
                <div class="news_grid">
                    <div class="news_content">
                        <div class="news_data_p">
                            <div class="news_data_div">
                                <a href='/news?id=<?= $new['NEWSID']; ?>'><?= $new['NEWSDate']; ?></a>
                            </div>
                        </div>
                        <div class="news_content_span">
                            <span><?= $new['NEWSAnswer' . $lang] ?? 'Нет данных'; ?></span>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>

            <nav class="nav_navigation_page">
                <?php if ($page > 1): ?>
                    <a class="navigation_page" href="/news.php?page=<?= $page - 1; ?>">← <?= $lang === 'EN' ? 'previous page' : 'предыдущая страница'; ?></a>
                <?php endif; ?>
                <?php if ($page < $total_pages): ?>
                    <a class="navigation_page" href="/news.php?page=<?= $page + 1; ?>"><?= $lang === 'EN' ? 'next page' : 'следующая страница'; ?> →</a>
                <?php endif; ?>
            </nav>
        <?php else: ?>
            <p>Новостей нет</p>
        <?php endif; ?>
    </div>
</div>
<style type="text/css">
.container {
        max-width: 1200px;
        margin: 0 auto;
        box-sizing: content-box;
    }
    .flex_news_service {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 100px;
    }
    .flex_news_service h1 {
        font-weight: 400;
        text-transform: uppercase;
        text-align: center;
        font-family: 'Exo', sans-serif;
        letter-spacing: 0.5em;
        line-height: 1.4;
        font-size: 18px;
        margin-top: 20px;
        margin-bottom: 20px;
        color: inherit;
        display: block;
    }
    .button_telegram {
        font-family: 'Exo', sans-serif;
    }
    .flex_button_telegram a {
        font-family: 'Exo', sans-serif;
        text-decoration: none;
        margin-bottom: 15px;
        padding: 5px 10px;
        font-size: 12px;
        line-height: 1.5;
        border-radius: 3px;
        color: #333;
        background-color: #fff;
        border-color: #CCC;
        display: inline-block;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        user-select: none;
        background-image: none;
        border: 1px solid #CCC;
        -webkit-tap-highlight-color: transparent;
        -webkit-font-smoothing: antialiased;    
    }
    .flex_button_telegram a:hover {
        color: #333;
        background-color: #e6e6e6;
        border-color: #adadad;;
    }
    .flex_button_telegram {
        display: flex;
        justify-content: center;
        align-items: center;
    }
/* news */
    .news_grid {
        display: grid;
        grid-template-columns: 1fr;
        grid-auto-rows: minmax(10px, auto);
        grid-gap: 20px;
        box-shadow: 0px 0px 16px 0px rgb(86 77 77 / 21%);
        border: 1px solid #ddd;
        border-radius: 4px;
        background-color: #fff;
        margin-bottom: 20px;
    }
    .news_content {
        border-color: #ddd;
        margin-bottom: 10px;
        border-radius: 4px;
    }
    .news_data_p {
        display: flex;
        justify-content: center;
        align-items: center;
        color: #333;
        background-color: #f5f5f5;
        border-bottom: 1px solid #ddd;
        border-top-left-radius: 4px;
        border-top-right-radius: 4px;
        padding: 0;
    }

    .news_data_div {
        padding: 10px 15px;
    }

    .news_content div {
    }
    .news_data_div a {
        text-decoration: none;
        padding: 0.3em 0.6em 0.3em;
        border-radius: 0.25em;
        background-color: #777;
        color: #fff;
        font-size: 9px;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        font-family: "Exo", sans-serif;
        cursor: pointer;
    }
    .news_content_span {
    }
    .news_content_span span {
        padding: 15px 15px 5px 15px;
        display: block;
        color: #333;
        background-color: #fff;
        font-size: 12px;
        font-family: "Exo", sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    .nav_navigation_page {
        margin-bottom: 50px;

    }
    .navigation_page {
        font-size: 12px;
        color: #333;
        padding: 10px;
        font-family: "Exo", arial, sans-serif;
    }
    .navigation_page:hover {
        color: #888;
    }
</style>
<?php
    require_once('files/footer.php');
 ?>


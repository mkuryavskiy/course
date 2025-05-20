<?php
include('functions.php');

$defaultLang = 'ua';
$availableLangs = ['ua'];

// Переключение локали
$lang      = isset($_COOKIE['lang']) ? htmlspecialchars($_COOKIE['lang']) : $defaultLang;
$urlParts  = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

if (isset($_POST['switchLocale'])) {
    $langIndex = array_search($_POST['switchLocale'], $availableLangs);

    if ($langIndex !== false) {
        $lang = $availableLangs[$langIndex];
    }

    setcookie('lang', $lang, [
        'expires' => strtotime('+30 days'),
        'path' => '/',
        'domain' => '',
        'secure' => true,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    if ($urlParts[0] !== '' && in_array($urlParts[0], $availableLangs) !== false) {
        $urlParts[0] = $lang;
    } else {
        array_unshift($urlParts, $lang);
    }

    // По умолчанию язык не нужен в URL
    if ($lang === $defaultLang || $urlParts[0] === $defaultLang) {
        unset($urlParts[0]);
    }

    $redirectAfterUrl = '/' . implode('/', $urlParts);
    $redirectAfterUrl .= (count($urlParts) === 1 && $urlParts[0] === $lang) ? '/' : '';

    header("Location: " . $redirectAfterUrl, true, 302);
    exit();
}

if ($urlParts === [] || $urlParts[0] === '') {
    // Обработать главную страницу без языка
    if ($urlParts[0] === '' && $lang !== $defaultLang) {
        array_unshift($urlParts, $lang);
        $redirectUrl = '/' . implode('/', $urlParts);

        header('Location: ' . $redirectUrl, true, 302);
        exit();
    }
} elseif ($urlParts[0] === $defaultLang) {
    // Удалить дефолтный язык из URL
    unset($urlParts[0]);
    $redirectUrl = '/' . implode('/', $urlParts);

    header('Location: ' . $redirectUrl, true, 302);
    exit();
} elseif ($urlParts[0] !== $lang) {
    // Заменить неправильный язык
    if (in_array($urlParts[0], $availableLangs) !== false) {
        $urlParts[0] = $lang;
    } else {
        array_unshift($urlParts, $lang);
    }

    if ($urlParts[0] === $defaultLang) {
        unset($urlParts[0]);
    }

    $redirectUrl = '/' . implode('/', $urlParts);

    // Только язык в URL, добавим слэш
    if (count($urlParts) === 1 && in_array($urlParts[0], $availableLangs) !== false && $redirectUrl != rtrim($_SERVER['REQUEST_URI'], '/')) {
        $redirectUrl .= '/';
    }

    if ($redirectUrl != $_SERVER['REQUEST_URI']) {
        header('Location: ' . $redirectUrl, true, 302);
        exit();
    }
} elseif (count($urlParts) === 1 && $urlParts[0] === $lang) {
    if (mb_substr($_SERVER['REQUEST_URI'], -1, 1) !== '/') {
        $redirectUrl = '/' . implode('/', $urlParts) . '/';

        header('Location: ' . $redirectUrl, true, 302);
        exit();
    }
}
// Локаль для URL
$localeURL = $lang === $defaultLang ? '/' : '/' . $lang . '/';
$isLoggedIn = !empty($_SESSION['auth']);
$userData = $isLoggedIn ? $pdo->query("SELECT UserName, UserGroup, UserBalance FROM users WHERE UserID = {$_SESSION['auth']}")->fetch(PDO::FETCH_ASSOC) : null;
?>

<!DOCTYPE html>
<html lang="<?=htmlspecialchars($lang)?>">
<head>
    <title><?php echo htmlspecialchars(GetTitlePage()); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($settings['WebsiteQuote']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($settings['WebsiteQuote']); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9, maximum-scale=0.9" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <link rel="shortcut icon" href="<?= htmlspecialchars($uri) ?>favicon.png">
    <!-- CSS -->
    <link rel="stylesheet" href="/theme/css/bootstrap.min.css">
    <link rel="stylesheet" href="/theme/css/style.css">
    <link rel="stylesheet" href="/theme/css/style-responsive.css">
    <link rel="stylesheet" href="/theme/css/animate.min.css">
    <link rel="stylesheet" href="/theme/css/vertical-rhythm.min.css">
    <?php if ($needDataTables) : ?>
        <link rel="stylesheet" href="/theme/css/datatables.min.css">
    <?php endif; ?>
    <style>
        .main-nav .inner-nav .mn-sub-multi li a i {
            width: 19px;
            text-transform: uppercase !important;
        }

        .mn-sub-multi li a {
            text-transform: uppercase !important;
        }

        .full-wrapper { height:55px; }

        .langFlag { background-color:transparent;padding:0;border:none;margin-top:11px; }

        @media only screen and (max-width: 1024px) { .langFlag { background-color:transparent;padding:0;border:none;margin:0 10px;float:left;height: 38px} }
    </style>
</head>
<body class="appear-animate">
<div class="page" id="top">
    <nav class="main-nav small-height">
        <div class="full-wrapper relative clearfix">
            <div class="nav-logo-wrap local-scroll">
                <a href="<?= $localeURL ?>" class="logo">
                    <img src="/theme/img/logo.webp" style="min-width: 130px;" alt="Logo">
                </a>
            </div>
            <div class="mobile-nav small-height" style="color: #eee !important; background-color: transparent; box-shadow: none;">
                <i class="fa fa-bars"></i>
            </div>
            <div class="inner-nav desktop-nav">
                <ul class="clearlist ul_nonMP">
                    <?php if (!$isLoggedIn) : ?>
                        <li><a href="<?= $localeURL ?>index"> <i class="fab fa-instagram"></i> <?=htmlspecialchars(Language('_home', 'header.php'))?> </a></li>
                        <li><a href="<?= $localeURL ?>login"><i class="fa fa-sign-in"></i> <?=htmlspecialchars(Language('_login', 'header.php'))?> </a></li>
                        <li><a href="<?= $localeURL ?>list"><i class="far fa-gem"></i> <?=htmlspecialchars(Language('_list', 'header.php'))?> </a></li>
                        <li><a href="<?= $localeURL ?>how-it-works"><i class="far fa-question-circle"></i> <?=htmlspecialchars(Language('_faq', 'header.php'))?> </a></li>
                        <li><a href="<?= $localeURL ?>news"><i class="fal fa-newspaper"></i> <?=htmlspecialchars(Language('_news', 'header.php'))?> </a></li>
                        <li><a href="<?= $localeURL ?>blog"><i class="fal fa-book"></i> <?=htmlspecialchars(Language('_blog', 'header.php'))?> </a></li>
                        <li><a href="<?= $localeURL ?>tasks" style="color: orange !important; font-weight: bold;"> <i class="fas fa-coins"></i> <?=htmlspecialchars(Language('_tasks', 'header.php'))?> </a></li>
                    <?php else : ?>
                        <li>
                            <a class="mn-has-sub copy-api">
                                <?php
                                $uuvcN = 0;
                                if (strpos($_SERVER['PHP_SELF'], 'news') === false) {
                                    $stmtN = $pdo->prepare('SELECT update_id FROM updates_news WHERE `user_id` = :user_id ORDER BY `update_id` DESC LIMIT 1');
                                    $stmtN->execute([':user_id' => $_SESSION['auth']]);

                                    if ($stmtN->rowCount() == 1) {
                                        $uuvid_rN = $stmtN->fetch();
                                        $uuvidN = $uuvid_rN['update_id'];
                                    } else {
                                        $uuvidN = 0;
                                        $stmtN = $pdo->prepare('INSERT INTO updates_news (user_id, update_id) VALUES (:user_id, 0)');
                                        $stmtN->execute([':user_id' => $_SESSION['auth']]);
                                    }

                                    $stmtN = $pdo->prepare('SELECT COUNT(NEWSID) as `cnt` FROM news WHERE NEWSID > :uuvidN');
                                    $stmtN->execute([':uuvidN' => $uuvidN]);
                                    if ($stmtN->rowCount() > 0) {
                                        $uuvc_rN = $stmtN->fetch();
                                        $uuvcN = $uuvc_rN['cnt'];
                                    }
                                } else {
                                    $stmtN = $pdo->prepare('SELECT NEWSID FROM news ORDER BY NEWSID DESC LIMIT 1');
                                    $stmtN->execute();
                                    $uuvc_rN = $stmtN->fetch();
                                    $news_id = $uuvc_rN['NEWSID'];

                                    $stmtN = $pdo->prepare('INSERT INTO updates_news (user_id, update_id) VALUES(:user_id, :update_id) ON DUPLICATE KEY UPDATE update_id=:update_id');
                                    $stmtN->execute([':user_id' => $_SESSION['auth'], ":update_id" => $news_id]);
                                }
                                ?>

                                <?php if ($uuvcN > 0) : ?>
                                    <span class="badge" style="background-color: #777;" onclick="window.location.href='<?= $localeURL ?>news'">1</span>
                                <?php endif; ?>

                                <i class="far fa-user"></i> <?= htmlspecialchars($userData['UserName']); ?> <span class="caret"></span>
                            </a>
                            <ul class="mn-sub mn-has-multi">
                                <li class="mn-sub-multi">
                                    <ul>
                                        <li>
                                            <?php if ($userData['UserGroup'] == 'administrator') {
                                                echo '<a style="text-align:center; background: #383838; text-transform: none !important;"> Status: <span class="label label-primary">Admin</span></a>';
                                                echo '<a href="' . htmlspecialchars($uri) . 'admin" style="text-align:center; background: #383838; text-transform: none !important;">'.htmlspecialchars(Language('_control_panel', 'header.php')).'</a>';
                                            } elseif ($userData['UserGroup'] == 'reseller') {
                                                echo '<a style="text-align:center; background: #383838; text-transform: none !important;"> Status: <span class="label label-primary">Reseller</span></a>';
                                            } else
                                                echo '<a style="text-align:center; background: #383838; text-transform: none !important;"> Status: <span class="label label-primary">User</span></a>';
                                            ?>
                                            <a href="<?= $localeURL ?>tasks" style="font-weight: bold; color: orange !important; text-transform: uppercase"><i class="fas fa-coins"></i> <?=htmlspecialchars(Language('_tasks', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>news"><i class="fal fa-newspaper"></i>
                                                <?=htmlspecialchars(Language('_news', 'header.php'))?>

                                                <?php if ($uuvcN > 0) :  ?>
                                                    <span class="badge" style="background-color: #777;">1</span>
                                                <?php endif; ?>
                                            </a>

                                            <a href="<?= $localeURL ?>blog"><i class="fal fa-book"></i> <?=htmlspecialchars(Language('_blog', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>settings"><i class="fas fa-cogs"></i> <?=htmlspecialchars(Language('_settings', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>discount"><style="text-transform: uppercase !important;"><i class="fas fa-percent"></i> <?=htmlspecialchars(Language('_discount', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>referr-documentation"><i class="fas fa-handshake"></i> <?=htmlspecialchars(Language('_affiliate', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>franchise"><i style="font-weight: 600;" class="fal fa-hands-usd"></i> <?=htmlspecialchars(Language('_franchise', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>how-it-works"><i class="far fa-question-circle"></i> <?=htmlspecialchars(Language('_faq', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>api-documentation"><i class="fas fa-code"></i> <?=htmlspecialchars(Language('_API', 'header.php'))?></a>
                                            <a href="<?= $localeURL ?>logout"><i class="fas fa-sign-out-alt"></i> <?=htmlspecialchars(Language('_logout', 'header.php'))?></a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="<?= $localeURL ?>new-order">
                                <i class="fas fa-cart-plus"></i>
                                <?=htmlspecialchars(Language('_add_order', 'header.php'))?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $localeURL ?>all-orders"><class="mn-has-su copy-api">
                                <i class="fas fa-list"></i>
                                <?=htmlspecialchars(Language('_orders', 'header.php'))?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= $localeURL ?>list">
                                <i class="far fa-gem"></i>
                                <?=htmlspecialchars(Language('_services', 'header.php'))?>
                            </a>
                        </li>
                        <?php
                        $uuvc = 0;
                        $stmt = $pdo->prepare('SELECT update_id FROM updates_uv LIMIT 1');
                        $stmt->execute();
                        if ($stmt->rowCount() == 1) {
                            $uuvid_r = $stmt->fetch();
                            $uuvid = $uuvid_r['update_id'];
                            $stmt = $pdo->prepare('SELECT COUNT(id) FROM updates WHERE id > :uuvid LIMIT 1');
                            $stmt->execute([':uuvid' => $uuvid]);
                            if ($stmt->rowCount() == 1) {
                                $uuvc_r = $stmt->fetch();
                                $uuvc = $uuvc_r['COUNT(id)'];
                            }
                        }
                        ?>
                        <li>
                            <a href="<?= $localeURL ?>updates">
                                <i style="font-weight: 400;" class="fal fa-sync-alt"></i>
                                <?=htmlspecialchars(Language('_updates', 'header.php'))?>
                                <?php if ($uuvc > 0): ?>
                                    <span class="badge" style="background-color: #777;">1</span>
                                <?php endif; ?>
                            </a>
                        </li>

                        <?php
                        $stmt = $pdo->prepare('SELECT id FROM tickets WHERE author_id = :author_id AND last_msg_view_author = :last_msg_view_author');
                        $stmt->execute([':author_id' => $_SESSION['auth'], ':last_msg_view_author' => '0']);
                        $msg_count = $stmt->rowCount();
                        ?>

                        <li>
                            <a href="<?= $localeURL ?>support">
                                <i style="font-weight: 600;" class="fal fa-headset"></i>
                                <?=htmlspecialchars(Language('_support', 'header.php'))?>
                                <?php if ($msg_count > 0): ?>
                                    <span class="badge" style="background-color: #f0ad4e;">
                                        <i class="far fa-envelope"></i><?= htmlspecialchars(min($msg_count, 1)); ?>
                                    </span>
                                <?php endif; ?>
                            </a>

                        </li>
                        <li>
                        <a href="deposit"><i class="fas fa-database" style="color: gold;"></i> <b><i style="font-weight: 800;" class="fal fa-dollar-sign"></i><?php echo htmlspecialchars($userData['UserBalance']); ?></b></a>
                        </li>
                    <?php endif; ?>
                             <li>
                                <form method="POST" action="#">
                                <?php if ($lang == "ua"): ?>
                                    <input type="hidden" name="switchLocale" value="en">
                                    <button type="submit" class="langFlag"><img src="/theme/img/countries/ua.png" alt="UA"></button>
                                <?php elseif ($lang == "en"): ?>
                                    <input type="hidden" name="switchLocale" value="ru">
                                    <button type="submit" class="langFlag"><img src="/theme/img/countries/en.png" alt="EN"></button>
                                <?php else: ?>
                                    <input type="hidden" name="switchLocale" value="ua">
                                    <button type="submit" class="langFlag"><img src="/theme/img/countries/ru.png" alt="RU"></button>
                                <?php endif; ?>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</body>
</html>

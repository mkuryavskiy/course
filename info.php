<?php
require_once('files/header.php');

// Получение значения параметра "name" из строки запроса
$name = $_GET['kak'] ?? $_GET['skopirovat'] ?? $_GET['ssylku'] ?? $_GET['instagram'] ?? 'Default';
?>
<nav>
    <section class="page-section">
        <div class="row col-lg-12 col-center">
            <div class="container relative">
    <h1 class="section-title font-alt mb-70 mb-sm-40">
        <?= Language('_how_to_copy_instagram_link') ?>
    </h1>
    <div class="row">
        <div class="text">
            <p>
                <?= Language('_intro_paragraph') ?>
            </p>
            <h2><?= Language('_how_to_copy_link_pc') ?></h2>
            <p>
                <?= Language('_pc_copy_instructions') ?>
                <br><br>
                <img src="/theme/img/link1.webp">
            </p>
            <h2><?= Language('_how_to_copy_link_app') ?></h2>
            <p>
                <?= Language('_app_copy_instructions') ?>
                <br><br>
                <img src="/theme/img/link2.webp">
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</nav>

<?php
require_once('files/footer.php');
?>

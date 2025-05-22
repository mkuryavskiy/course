<?php
// Функция для безопасного вывода языковых строк
function safe_language($key, $file) {
    return htmlspecialchars(Language($key, $file), ENT_QUOTES, 'UTF-8');
}

// Функция для безопасного вывода URL
function safe_url($url) {
    return htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
}
?>

<footer class="page-section bg-black footer" style="padding: 50px 0 15px 0 !important; height: 255px;">
    <div class="container">
        <div class="local-scroll mb-20 wow fadeInUp" data-wow-duration="1.5s">
            <img src="/theme/img/logo.webp" width="100" height="100" alt="Logo">
        </div>
        <div class="footer-text">
            <div class="footer-copy font-alt">
                <a href="index"><?= safe_language('_smm', 'footer.php') ?></a><br>
                <a href="nakrutka-telegram"><?= safe_language('_telegram', 'footer.php') ?></a>
            </div>
                <div class="font-alt" style="color:white;">
                    <i class="fa fa-envelope" aria-hidden="true"></i> support@wiq.by
                </div>
                <div class="footer-made">
                    <img src="/theme/img/footer/visa.png" width="50" height="30">
                    <img src="/theme/img/footer/payoneer.png" width="50" height="30">
                    <img src="/theme/img/footer/sms.png" width="50" height="30">
                    <img src="/theme/img/footer/pci.png" width="50" height="30">
                </div>
            </div>
        </div>
    </div>
    <div id="m_service"></div>
    <?php if (isset($uuvcN) && $uuvcN > 0): ?>
    <a href="/news.php" class="js_news_hide">
        <div id="beamerSelector" class="beamer_defaultBeamerSelector bottom-right beamer_beamerSelector">
            <div id="beamerIcon" class="beamer_icon active" style="background-color: rgb(37, 170, 225);">1</div>
        </div>
    </a>
    <?php endif; ?>
</footer>

<?php
$scripts = [
    '/theme/js/jquery-1.11.2.min.js',
    '/theme/js/jquery.easing.1.3.js',
    '/theme/js/bootstrap.min.js',
    '/theme/js/jquery.scrollTo.min.js',
    '/theme/js/jquery.localScroll.min.js',
    '/theme/js/jquery.viewport.mini.js',
    '/theme/js/jquery.appear.js',
    '/theme/js/jquery.sticky.js',
    '/theme/js/jquery.parallax-1.1.3.js',
    '/theme/js/jquery.fitvids.js',
    '/theme/js/owl.carousel.min.js',
    '/theme/js/isotope.pkgd.min.js',
    '/theme/js/imagesloaded.pkgd.min.js',
    '/theme/js/jquery.magnific-popup.min.js',
    '/theme/js/wow.min.js',
    '/theme/js/all.js',
    '/theme/js/contact-form.js',
    '/theme/js/main.js',
    '/theme/js/main_functions.js'
];

foreach ($scripts as $script) {
    echo '<script src="' . safe_url($script) . '?v=' . filemtime($_SERVER['DOCUMENT_ROOT'] . $script) . '"></script>' . PHP_EOL;
}

if (!empty($needDataTables)): 
    echo '<script src="' . safe_url('/theme/js/datatables.min.js') . '?v=' . filemtime($_SERVER['DOCUMENT_ROOT'] . '/theme/js/datatables.min.js') . '"></script>' . PHP_EOL;
endif;
?>
</body>
</html>

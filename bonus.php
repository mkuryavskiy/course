<?php
$needCaptcha = true;

require_once('files/header.php');

$user->IsLogged();

if (!isset($bonus)) {
    $bonus = 0;
}

if (!isset($UserBalance)) {
    $UserBalance = 0;
}
?>

<section class="page-section">
    <div class="row col-md-12 col-center">
        <div class="container relative">
            <h1 class="section-title font-alt">Щоденний бонус</h1>
            <div class="row">
                <div class="col-md-12" style="font-size: 18px;">
                    <p class="text-center"><img src="/theme/img/bonus/filled-star.png" width="250px"></p>
                    <p class="text-center" style='font-weight: bold'>
                        Заходь сюди щодня та отримуй щоденний бонус від 0,01 до 0,04 $ на свій рекламний баланс
                    </p>
                    <?php if ($bonus == 0) : ?>
                        <div class="js-process-hide" style="width: 100%; text-align: center;">
                            <div style="display: flex; justify-content: center;">
                                <div id="recaptcha1"></div>
                            </div>
                            <div class="text-danger" id="recaptchaError1"></div>
                        </div>
                        <br>
                        <p id="answ" class="text-center">
                            <button id="btn_get_bonus" type="button" class="btn btn-default btn-lg"><i class="far fa-hands-usd"></i> Отримати бонус</button>
                        </p>
                    <?php else : ?>
                        <p id="answ" class="text-center">
                            Ваш бонус сьогодні становив: <?= htmlspecialchars($bonus) ?>&nbsp;$
                        </p>
                    <?php endif; ?>
                <div id="social-icons" style="text-align: center; margin-top: 20px; font-size: 0;">
                    <a href="https://vk.com/share.php?url=https%3A%2F%2Fwiq.by%2Fbonus&amp;title=Щоденний%20бонус%20%7C%20WIQ.BY&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="ВКонтакте" style="display: inline-block; margin: 0; padding: 0;">
                        <img src="/theme/img/bonus/vk.svg" alt="VK" width="29" height="29" style="display: block;">
                    </a>
                    <a href="https://t.me/share/url?url=https%3A%2F%2Fwiq.by%2Fbonus&amp;text=Щоденний%20бонус%20%7C%20WIQ.BY&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="Telegram" style="display: inline-block; margin: 0; padding: 0;">
                        <img src="/theme/img/bonus/telegram.svg" alt="Telegram" width="29" height="29" style="display: block;">
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=Щоденний%20бонус%20%7C%20WIQ.BY&amp;url=https%3A%2F%2Fwiq.by%2Fbonus&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="X" style="display: inline-block; margin: 0; padding: 0;">
                        <img src="/theme/img/bonus/x.svg" alt="X" width="29" height="29" style="display: block;">
                    </a>
                    <a href="https://api.whatsapp.com/send?text=Щоденний%20бонус%20%7C%20WIQ.BY%20https%3A%2F%2Fwiq.by%2Fbonus&amp;utm_source=share2" rel="nofollow noopener" target="_blank" title="WhatsApp" style="display: inline-block; margin: 0; padding: 0;">
                        <img src="/theme/img/bonus/whatsapp.svg" alt="WhatsApp" width="29" height="29" style="display: block;">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
</section>

<div id="repost" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title">Поділись з друзями!</h4>
            </div>
            <div class="modal-body">
                <div id="social-icons" style="text-align: center; font-size: 0;">
                    <!-- Соціальні кнопки ті ж самі, лише текст змінено -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Продовжити</button>
            </div>
        </div>
    </div>
</div>

<?php
require_once('files/footer.php');
?>

<script type="text/javascript">
var UserBalance = <?= json_encode($UserBalance) ?>;

function handleBonusRequest() {
    if (grecaptcha.getResponse() == "") {
        alert("Поставте галочку 'Я не робот'!");
        return;
    }
    if (UserBalance <= 0) {
        $('#answ').html("Щоб отримати бонус, потрібно поповнити баланс.");
        return;
    }
    
    $('.js-process-hide, #btn_get_bonus').hide();
    $('#answ').html('<i class="fas fa-sync fa-spin fa-3x fa-fw"></i><span class="sr-only">Завантаження...</span><br>Збираємо бонус, зачекайте...');
    
    setTimeout(sendBonusRequest, <?= mt_rand(3000, 10000); ?>);
}

function sendBonusRequest() {
    $.ajax({
        type: "POST",
        url: "https://wiq.by/create-bonus.php",
        data: {
            'ok': '1',
            'g-recaptcha-response': grecaptcha.getResponse()
        },
        success: function(data) {
            const msg = JSON.parse(data).msg;
            $('#answ').html(msg);
            $("#repost").modal('show');
        },
        error: function() {
            $('#answ').html("Сталася помилка при отриманні бонусу. Спробуйте ще раз.");
        }
    });
}
</script>

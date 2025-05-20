<?php
$needCaptcha = true;

require_once('files/header.php');

if (isset($_SESSION['auth']) || isset($_COOKIE['auth'])) {
    $layer->redirect('index.php'); 
}
?>
<section class="page-section">
    <div class="container relative">
        <div class="align-center mb-40 mb-xxs-30">
            <ul class="nav nav-tabs tpl-minimal-tabs">
                <li class="active">
                    <a href="#mini-one" data-toggle="tab">
                        <i class="far fa-key"></i>
                        <?= Language('_login') ?>
                    </a>
                </li>
                <li>
                    <a href="#mini-two" data-toggle="tab">
                        <i class="far fa-user-plus"></i>
                        <?= Language('_register') ?>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content tpl-minimal-tabs-cont section-text">
            <div class="tab-pane fade in active" id="mini-one">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form class="form contact-form" id="login" onsubmit="event.preventDefault(); login();" method="POST">
                            <div class="clearfix">
                                <div class="form-group">
                                    <input type="text" name="username" id="username" class="input-md round form-control def-text" placeholder="<?= Language('_username') ?>" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="input-md round form-control def-text" placeholder="<?= Language('_password') ?>" required>
                                </div>
                                <div id="recaptcha1"></div>
                                <?php
                                $secret = '6LfyYREhAAAAAKIe7d5ofgtfSYEMP6Kn5dgaCbiP';
                                require_once(dirname(__FILE__) . '/autoload.php');

                                if (isset($_POST['g-recaptcha-response'])) {
                                    $recaptcha = new \ReCaptcha\ReCaptcha($secret);

                                    $resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['HTTP_HOST']);
                                    if ($resp->isSuccess()) {
                                        // дії, якщо код captcha пройшов перевірку
                                        //...
                                    } else {
                                        $errors = $resp->getErrorCodes();
                                        $data['error-captcha'] = $errors;
                                        $data['msg'] = 'Код капчі не пройшов перевірку на сервері';
                                        $data['result'] = 'error';
                                    }
                                } else {
                                    $data['result'] = 'error';
                                }
                                ?>
                            </div>
                            <div class="clearfix">
                                <div class="cf-left-col">
                                    <div class="form-tip pt-20">
                                        <a href="recover-password"><?= Language('_forgot_password') ?></a>
                                    </div>
                                </div>
                                <div class="cf-right-col">
                                    <div class="align-right pt-10">
                                        <button class="submit_btn btn btn-mod btn-medium btn-round" id="login-btn"><?= Language('_login_btn') ?></button>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix">
                                <?= Language('_social_login') ?>
                                <br>
                                <div id="uLogin" data-ulogin="display=panel;theme=flat;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=twitter,google,yandex,livejournal,openid,lastfm,linkedin,liveid,soundcloud,steam,flickr,uid,youtube,webmoney,foursquare,tumblr,googleplus,vimeo,wargaming;redirect_uri=https%3A%2F%2Fwiq.by%2Fsocial.php;mobilebuttons=0;" data-ulogin-inited="1655931533340">
                                    <div class="ulogin-buttons-container" style="margin: 0; padding: 0; outline: none; border: none; border-radius: 0; cursor: default; float: none; position: relative; display: inline-block; width: 210px; height: 25px; left: 0; top: 0; box-sizing: content-box; max-width: 100%; vertical-align: top; line-height: 0;">
                                        <div class="ulogin-button-vkontakte" data-uloginbutton="vkontakte" role="button" title="VK" style="margin: 0px 10px 10px 0px; padding: 0px; outline: none; border: none; border-radius: 0px; cursor: pointer; float: left; position: relative; display: inherit; width: 32px; height: 32px; left: 0px; top: 0px; box-sizing: content-box; background: url(&quot;https://ulogin.ru/version/3.0/img/providers-32-flat.png?version=img.3.0.1&quot;) 0px -36px / 32px no-repeat;"></div>
                                        <div class="ulogin-button-odnoklassniki" data-uloginbutton="odnoklassniki" role="button" title="Odnoklassniki" style="margin: 0px 10px 10px 0px; padding: 0px; outline: none; border: none; border-radius: 0px; cursor: pointer; float: left; position: relative; display: inherit; width: 32px; height: 32px; left: 0px; top: 0px; box-sizing: content-box; background: url(&quot;https://ulogin.ru/version/3.0/img/providers-32-flat.png?version=img.3.0.1&quot;) 0px -70px / 32px no-repeat;"></div>
                                        <div class="ulogin-button-mailru" data-uloginbutton="mailru" role="button" title="Mail.ru" style="margin: 0px 10px 10px 0px; padding: 0px; outline: none; border: none; border-radius: 0px; cursor: pointer; float: left; position: relative; display: inherit; width: 32px; height: 32px; left: 0px; top: 0px; box-sizing: content-box; background: url(&quot;https://ulogin.ru/version/3.0/img/providers-32-flat.png?version=img.3.0.1&quot;) 0px -104px / 32px no-repeat;"></div>
                                        <div class="ulogin-button-facebook" data-uloginbutton="facebook" role="button" title="Facebook" style="margin: 0px 10px 10px 0px; padding: 0px; outline: none; border: none; border-radius: 0px; cursor: pointer; float: left; position: relative; display: inherit; width: 32px; height: 32px; left: 0px; top: 0px; box-sizing: content-box; background: url(&quot;https://ulogin.ru/version/3.0/img/providers-32-flat.png?version=img.3.0.1&quot;) 0px -138px / 32px no-repeat;"></div>
                                        <div class="ulogin-dropdown-button" style="margin: 0px 10px 10px 0px; padding: 0px; outline: none; border: none; border-radius: 0px; cursor: pointer; float: none; position: relative; display: inline-block; width: 32px; height: 32px; left: 0px; top: 0px; box-sizing: content-box; background: url(&quot;https://ulogin.ru/version/3.0/img/providers-32-flat.png?version=img.3.0.1&quot;) 0px -2px / 32px no-repeat; vertical-align: baseline;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-danger" id="recaptchaError1"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="mini-two">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4">
                        <form method="POST" id="register" onsubmit="event.preventDefault(); register();">
                            <div class="clearfix">
                                <?php
                                if (isset($_GET['referr']) && ctype_digit($_GET['referr'])) {
                                    $stmt = $pdo->prepare('SELECT UserID FROM users WHERE UserID = :UserID');
                                    $stmt->execute(array(':UserID' => $_GET['referr']));

                                    if ($stmt->rowCount() == 1) {
                                        echo '<input type="hidden" id="referr" name="referr" value="' . htmlspecialchars($_GET['referr']) . '">';
                                    }
                                }
                                ?>
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="input-md round form-control def-text" placeholder="<?= Language('_email') ?>" pattern=".{3,64}" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="telegram" id="telegram" class="input-md round form-control def-text" placeholder="<?= Language('_telegram') ?>" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <input type="text" name="username" id="username-reg" class="input-md round form-control def-text" placeholder="<?= Language('_username') ?>" pattern=".{4,32}" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password-reg" class="input-md round form-control def-text" placeholder="<?= Language('_password') ?>" pattern=".{4,32}" autocomplete="off" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="re_password" id="re_password" class="input-md round form-control def-text" placeholder="<?= Language('_re_password') ?>" pattern=".{4,32}" autocomplete="off" required>
                                </div>
                                <div id="recaptcha2"></div>
                            </div>
                            <div class="pt-10">
                                <button class="submit_btn btn btn-mod btn-medium btn-round btn-full" id="reg-btn"><?= Language('_register_btn') ?></button>
                            </div>
                            <div class="text-danger" id="recaptchaError2"></div>
                        </form>
                        <div style="font-size: 10px;">
                            <?= Language('_agree_privacy_policy') ?> 
                            <a href="/pages/privacy_policy" target="_blank"><?= Language('_privacy_policy') ?></a>
                        </div>
                    </div>
                </div>
            </div>
            <br>
        </div>
        <center>
            <code class="text-primary bg-light"><i class="fa fa-info-circle" aria-hidden="true"></i> <?= Language('_no_instagram_login') ?></code>
        </center>
    </div>
</section>
<?php
require_once('files/footer.php');
?>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>
<script type="text/javascript">
    var onloadCallback = function() {
        var mysitekey = '6LfyYREhAAAAAH11z8NHRcipo4sK_nb9i2155CJX';
        ['recaptcha1', 'recaptcha2'].forEach(function(id) {
            if (document.getElementById(id)) {
                grecaptcha.render(id, {'sitekey': mysitekey});
            }
        });
    };
</script>


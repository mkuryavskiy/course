<?php
$needCaptcha = true;
require_once('files/header.php');

$per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Fetch the total count of comments
$total_count_q = $pdo->query("SELECT COUNT(`CommentsID`) AS `total_count` FROM `comments_added`");
$total_count = $total_count_q->fetchColumn();

$total_pages = ceil($total_count / $per_page);
$page = max(1, min($page, $total_pages));
$offset = ($page - 1) * $per_page;

// Fetch comments with pagination
$comments_added = $pdo->prepare("SELECT * FROM `comments_added` ORDER BY `CommentsID` DESC LIMIT :offset, :per_page");
$comments_added->bindValue(':offset', $offset, PDO::PARAM_INT);
$comments_added->bindValue(':per_page', $per_page, PDO::PARAM_INT);
$comments_added->execute();
$news_exist = $comments_added->rowCount() > 0;
?>
<section class="page-section">
    <div class="row col-lg-12 col-center">
        <div class="container relative">
            <h1 class="section-title font-alt mb-10">Відгуки WIQ.BY</h1>
            <div class="text-center mb-10">
                <a href="javascript:scroll(0,10000);" class="btn btn-default btn-default-2 btn-sm" id="btn-display-none" style="text-decoration: none;" href="#add" role="button">
                    <i class="far fa-pencil"></i> Додати відгук
                </a>
            </div>
            <div style="text-align: center;" id="errorMess"></div>
            <div id="alert-success" style="display: none;" class="text-center alert alert-success"></div>
            <?php if ($news_exist): ?>
                <?php while ($comm = $comments_added->fetch()): ?>
                    <div class="comments">
                        <div class="panel panel-default" style="box-shadow: 0px 0px 16px 0px rgba(86, 77, 77, 0.21);">
                            <div class="panel-heading text-center">
                                <?= htmlspecialchars_decode($comm['comments_answer']) ?>
                            </div>
                            <div class="panel-body content" style="font-size: 15px;">
                                <?= htmlspecialchars($comm['comments_title']) ?>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-12 col-lg-6 content" style="font-weight: bold">
                                        <i class="far fa-user"></i> <?= htmlspecialchars($comm['comments_name']) ?>
                                    </div>
                                    <div class="col-12 col-lg-6 text-right">
                                        <span class="label label-default"> <?= htmlspecialchars($comm['comments_date']) ?> </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <p>Новостей нет...</p>
            <?php endif; ?>
            <center class="href_a">
                <?php if ($news_exist): ?>
                    <?php if ($page > 1): ?>
                        <a href="?page=1">&lt;&lt;</a>
                        <a href="?page=<?= $page - 1 ?>">&lt;</a>
                    <?php endif; ?>
                    <?php for ($i = max(1, $page - 2); $i <= min($page + 2, $total_pages); $i++): ?>
                        <a href="?page=<?= $i ?>"<?= $i == $page ? ' class="active_a"' : '' ?>><?= $i ?></a> |
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?>">&gt;</a>
                        <a href="?page=<?= $total_pages ?>">&gt;&gt;</a>
                    <?php endif; ?>
                <?php endif; ?>
            </center>
            <div class="panel review_panel center-block col-md-8" id="add-comments-modal">
                <div class="panel-body">
                    <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] == ''): ?>
                        <form role="form" id="add-otzyvPage">
                            <input id="comments-name" name="comments-name" type="text" class="form-control" placeholder="Ваше ім'я" style="width:200px;"><br>
                            <span style="font-size: 12px;">Мінімум 30 символів!</span>
                            <textarea id="comments-title" name="comments-title" class="form-control review_textarea" rows="2" placeholder="Додайте Ваш відгук"></textarea>
                            <div style="display: none;" class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Ансвер</label>
                                        <input value="<span class='fa fa-star checked'></span> <span class='fa fa-star checked'></span> <span class='fa fa-star checked'></span> <span class='fa fa-star checked'></span> <span class='fa fa-star'></span>" type="text" id="comments-answer" name="comments-answer" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mar-top clearfix"><br>
                                <div id="recaptcha1"></div>
                                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                                <button id="button_data" type="button" class="btn btn-sm btn-primary js-send-otzyv"><i class="fa fa-pencil fa-fw"></i> Додати</button>
                            </div>
                        </form>
                    <?php else: ?>
                        <form role="form" id="add-otzyvPage">
                            <span style="font-size: 12px;">Минимальная длина отзыва 30 символов!</span>
                            <textarea id="comments-title" name="comments-title" class="form-control review_textarea" rows="2" placeholder="Добавьте Ваш отзыв"></textarea>
                            <div style="display: none;" class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Ансвер</label>
                                        <input value="<span class='fa fa-star checked'></span> <span class='fa fa-star checked'></span> <span class='fa fa-star checked'></span> <span class='fa fa-star checked'></span> <span class='fa fa-star'></span>" type="text" id="comments-answer" name="comments-answer" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="mar-top clearfix"><br>
                                <div id="recaptcha1"></div>
                                <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                                <button id="button_data" type="button" class="btn btn-sm btn-primary js-send-otzyv"><i class="fa fa-pencil fa-fw"></i> Додати</button>
                            </div>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .alert-success {
        -webkit-text-size-adjust: 100%;
        font-family: "Exo", arial, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
        -webkit-tap-highlight-color: transparent;
        text-align: center;
        background-color: #dff0d8;
        margin: 0 auto 10px;
        padding: 14px 20px;
        box-sizing: border-box;
        border: 1px solid #ddd;
        border-radius: 5px !important;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        color: #777;
    }
    .href_a a {
        color: #111;
        text-decoration: underline;
        font-size: 12px;
        font-family: "Exo", arial, sans-serif;
        line-height: 1.6;
        -webkit-font-smoothing: antialiased;
    }

    .active_a {
        font-weight: 700;
        color: #333;
        cursor: text;
        text-decoration: none;
        pointer-events: none; 
    }

	.page-section {
	-webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    -webkit-tap-highlight-color: transparent;
    width: 100%;
    display: block;
    position: relative;
    overflow: hidden;
    color: #333;
    background-repeat: no-repeat;
    background-position: center center;
    background-size: cover;
    box-sizing: border-box;
    padding: 100px 0 50px 0;
	}
    .review_panel {
        background-color: #f9f9f9;
        float: none !important;
        margin-top: 30px;
    }
    .review_panel .review_textarea {
        height: 100px;
    }
    .checked {
        color: orange;
    }
    .panel  {
    -webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    margin-bottom: 20px;
    background-color: #fff;
    border: 1px solid transparent;
    border-radius: 4px;
    border-color: #ddd;
    box-shadow: 0px 0px 16px 0px rgba(86, 77, 77, 0.21);
}
	.panel-heading {
	-webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    text-align: center;
    padding: 10px 15px;
    border-bottom: 1px solid transparent;
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    color: #333;
    background-color: #f5f5f5;
    border-color: #ddd;
	}
	.panel-body {
    -webkit-text-size-adjust: 100%;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    padding: 15px;
    font-size: 15px;
}
	.panel-footer {
    -webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    padding: 10px 15px;
    background-color: #f5f5f5;
    border-top: 1px solid #ddd;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
}
.col-12 {
	-webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    position: relative;
    min-height: 1px;
    float: left;
    width: 100%;
    font-weight: bold;
}
.comments {
    -webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
}
.row col-lg-12 col-center {
	-webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    float: none;
    margin: 0 auto;
}
.review_panel {
	-webkit-text-size-adjust: 100%;
    font-size: 12px;
    font-family: "Exo", arial, sans-serif;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
    color: #333;
    box-sizing: border-box;
    -webkit-tap-highlight-color: transparent;
    position: relative;
    min-height: 1px;
    padding-right: 15px;
    padding-left: 15px;
    margin-bottom: 20px;
    border: 1px solid transparent;
    border-radius: 4px;
    box-shadow: 0 1px 1px rgba(0,0,0,.05);
    display: block;
    margin-right: auto;
    margin-left: auto;
    background-color: #f9f9f9;
    float: none !important;
    margin-top: 30px;
}
    #errorMess {
        display: flex;
        justify-content: space-between;
        align-items: center;
        opacity: 0;
        visibility: hidden;
    }

    @media (min-width: 1200px) {
      .col-lg-6 {
    width: 50%;
    }  
    
    }
</style>
<?php
require_once('files/footer.php'); 
?>

<script type="text/javascript">
    let sucBlock = document.querySelector('#alert-success');
    let btnDisplayNone = document.querySelector('#btn-display-none');

    function TakeFormData(FormID, FormAction, Message, Clear = false, Timeout = 0) {
        let formData = $(FormID).serialize();
        let dataString = formData + '&action=' + FormAction;

        let keysGET = grecaptcha.getResponse();
        let processed = true;

        <?php if (!isset($_SESSION['auth']) || $_SESSION['auth'] == '') { ?>
        let nameCom = $("#comments-name").val().trim();
        if (nameCom.length < 3) {
            btnDisplayNone.style.display = "none";
            sucBlock.textContent = "Введите имя";
            sucBlock.style.background = "#fcf8e3";
            sucBlock.style.display = "block";
            scroll(0, 0);
            processed = false;
        }
        <?php } ?>

        let titleCom = $("#comments-title").val().trim();
        if (titleCom.length < 30) {
            btnDisplayNone.style.display = "none";
            sucBlock.textContent = "Минимальная длина отзыва 30 символов!";
            sucBlock.style.background = "#fcf8e3";
            sucBlock.style.display = "block";
            scroll(0, 0);
            processed = false;
        }

        if (keysGET.length < 500) {
            processed = false;
            btnDisplayNone.style.display = "none";
            sucBlock.textContent = "НЕ ПРОЙДЕНА ПРОВЕРКА CAPTCHA";
            sucBlock.style.background = "#fcf8e3";
            sucBlock.style.display = "block";
            scroll(0, 0);
        }

        if (processed) {
            $.ajax({
                type: "POST",
                url: "modal-requests.php",
                data: dataString,
                cache: false,
                beforeSend: function(){
                    $('#' + FormAction + '-result').val('Please wait..');
                },
                success: function(data) {
                    console.log(data);
                    if (data == 0) {
                        btnDisplayNone.style.display = "none";
                        sucBlock.textContent = "Минимальная длина отзыва 30 символов!";
                        sucBlock.style.background = "#fcf8e3";
                        sucBlock.style.display = "block";
                        scroll(0, 0);
                    } else if (data == 200) {
                        btnDisplayNone.style.display = "none";
                        sucBlock.textContent = "Спасибо! Ваш отзыв будет опубликован после проверки модератором в ближайшее время";
                        sucBlock.style.background = "#dff0d8";
                        sucBlock.style.display = "block";
                        scroll(0, 0);

                        $('#comments-title').val('');
                        $('#comments-name').val('');
                    }

                    if (Timeout != 0) {
                        $('#' + FormAction + '-result').delay(5000).fadeOut(Timeout, function() {
                            this.remove();
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error occurred: " + status + " " + error);
                    console.log(xhr);
                }
            });
        }
    }

    function OtzyvCreateS() {
        TakeFormData('#add-otzyvPage', 'add-otzyvPage', 'Отзыв был успешно добавлен.', false, 1500);
    }

    $(function() {
        $('.js-send-otzyv').on('click', function(event) {
            OtzyvCreateS();
        });
    });

    var onloadCallback = function() {
        let mysitekey = '6LfyYREhAAAAAH11z8NHRcipo4sK_nb9i2155CJX';
        if ($('#recaptcha1').length) {
            grecaptcha.render('recaptcha1', {
                'sitekey': mysitekey
            });
        }
        if ($('#recaptcha2').length) {
            grecaptcha.render('recaptcha2', {
                'sitekey': mysitekey
            });
        }
    };
</script>
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async defer></script>

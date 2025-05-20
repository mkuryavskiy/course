<?php require_once('files/header.php'); ?>
<?php
$payeer = getPayeerSettings(); // Отримання налаштувань Payeer
$liqpay_public = $settings['liqpay_public'];
$liqpay_private = $settings['liqpay_private'];
$liqpay_comission = $settings['liqpay_comission'];
?>

<script>
function ChangeLiqpayModal() {
    $("#changeLiqpay-modal").modal();
}

function ChangePayeerModal() {
    $("#changePayeer-modal").modal();
}

function save_liqpay_settings() {
    var l_private = $('#liqpay_private').val();
    var l_public = $('#liqpay_public').val();
    var l_comission = $('#liqpay_comission').val();
    $.ajax({
        type: "POST",
        url: "/liqpay_create.php",
        data: {
            change_settings: '1',
            private: l_private,
            public: l_public,
            comission: l_comission
        },
        success: function(html) {
            $('#liqpay_result').html(html);
        }
    });
}

function save_payeer_settings() {
    var p_merchant = $('#payeer_merchant_id').val();
    var p_secret = $('#payeer_secret_key').val();
    var p_commission = $('#payeer_commission').val();
    var p_bonus = $('#payeer_bonus').val();
    $.ajax({
        type: "POST",
        url: "/payeer_settings.php",
        data: {
            change_settings: '1',
            merchant_id: p_merchant,
            secret_key: p_secret,
            commission: p_commission,
            bonus: p_bonus,
        },
        success: function(html) {
            $('#payeer_result').html(html);
        }
    });
}
</script>

<section class="page-section" style="overflow:auto;">
    <div class="row col-lg-12 col-center">
        <table id="deposits" style="border-bottom: 1px solid #000;" class="cell-border dataTable" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Платіжна система</th>
                    <th>API Public</th>
                    <th>API Private</th>
                    <th>Бонус до поповнення</th>
                    <th>Комісія поповнення</th>
                    <th>Редагувати</th>
                </tr>
            </thead>
            <tbody>
                <tr role="row" class="odd">
                    <td>1</td>
                    <td>LiqPay</td>
                    <td><?=htmlspecialchars($liqpay_public)?></td>
                    <td><?=htmlspecialchars($liqpay_private)?></td>
                    <td><?=htmlspecialchars($liqpay_bonus)?></td>
                    <td><?=htmlspecialchars($liqpay_comission)?></td>
                    <td><a class="btn btn-primary btn-lg" onclick="ChangeLiqpayModal()">Редагувати</a></td>
                </tr>
                <tr role="row" class="odd">
                    <td>2</td>
                    <td>Payeer</td>
                    <td><?=htmlspecialchars($payeer['merchant_id'])?></td>
                    <td><?=htmlspecialchars($payeer['secret_key'])?></td>
                    <td><?=htmlspecialchars($payeer['bonus'])?></td>
                    <td><?=htmlspecialchars($payeer['commission'])?></td>
                    <td><a class="btn btn-primary btn-lg" onclick="ChangePayeerModal()">Редагувати</a></td>
                </tr>
            </tbody>
        </table>
    </div>
</section>

<?php require_once('files/footer.php'); ?>

<?php
    require_once('files/header.php');
?>
<section class="page-section" style="padding-top: 100px !important;">
    <div class="container">
        <h1 class="section-title font-alt"><?=Language('_discount_on_services')?></h1>
        <div class="row">
            <div class="col-md-12" style="font-size: 18px;">
                <p class="text-center">
                    <img src="/theme/img/other/wiq.png" width="35%">
                </p>
                <p class="text-center"><b><?=Language('_get_discount_on_all_services')?></b></p>
				<p><?=Language('_to_get_permanent_discount')?> <br>
				<?=Language('_total_replenishments')?> <a href="deposit.php"><?=Language('_balance')?></a><br>
                <p id="answ" class="text-center">
                    <?php 
                        $user->IsLogged();
                        $stmt = $pdo->prepare('SELECT UserID FROM users WHERE UserID = :UserID AND UserGroup = :UserGroup LIMIT 1');
                        $stmt->execute([':UserID' => (int)$_SESSION['auth'], ':UserGroup' => 'user']);
                        
                        if ($stmt->rowCount() == 0) {
                            echo '<a class="reseller-link">'.Language('_already_reseller').'</a>';
                        } else {
                            echo '<button id="btn_discount_checks" class="btn btn-default btn-lg" onclick="create_userstatus_reseller()">
                                    <i class="fa fa-handshake-o"></i> '.Language('_get_discount').'
                                  </button>';
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
</section>

<?php
    require_once('files/footer.php');
?>

<script>
function create_userstatus_reseller() {
    $.post('/requests.php', { action: 'discount-check' }, function(data) {
        $('#answ').html(data.error ? data.error : '<?= Language('_success_discount') ?>');
    }, 'json');
}
</script>

<style>
    .reseller-link {
        background: rgb(114, 189, 53);
        color: #fff;
        font-weight: bold;
        padding: 4px 6px;
        font-size: 12px;
        text-decoration: none;
        border-radius: 3px;
    }
</style>

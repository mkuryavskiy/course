<?php
    $needDataTables = true;

	require_once('files/header.php');

	$user->IsLogged();

    $userHasOpertions = $user->hasOperations();

?>

<style>
    .copy-url {
        cursor: pointer;
    }
    #referral-url-input {
        border-top-right-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        padding-left: 6px;
    }
</style>
<section class="page-section">
    <div class="row col-lg-12 col-center">
        <div class="container relative">
            <h2 class="section-title font-alt mb-40 mb-sm-40">
                <?= Language('_partner_program') ?>
            </h2>
            <div class="row">
                <div class="col-sm-12">
                    <h5 class="uppercase" style="margin-bottom: 10px !important;">
                        <strong><?= Language('_how_it_works') ?></strong>
                    </h5>
                    <blockquote style="margin-top: 0; margin-bottom: 20px">
                        <p style="font-size: 16px;">
                            <?= Language('_partner_program_description') ?> <strong><?= $settings['ReferrsPercent']; ?>%</strong> <?= Language('_partner_description') ?>
                        </p>
                    </blockquote>
                </div>
            </div>
            <div class="row">
                <div class='col-lg-4 mb-40' id="referral-url" style="font-size: 14px;">
                    <b><?= Language('_your_referral_link') ?>:</b><br />
                    <div class="input-group">
                        <input type="text" id="referral-url-input" value="<?php echo $url; ?>?ref=<?php echo $UserID; ?>" class="input-md round form-control def-text" readonly>
                        <span class="input-group-addon">
                            <font class="copy-url" onclick="copyClipboard('referral-url-input')"><?= Language('_copy_url') ?></font>
                        </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class='col-lg-12'>
                    <div class="alert" style="background-color:#f0f1f2">
                        <span class="label label-success" style="font-size:10px;">
                        <?php
                            $refBalance = $layer->GetReferrBalance($UserID);
                        ?>
                            <img src="https://wiq.bt/img/icons/coins.png" width="35" /> <?= Language('_your_earnings') ?>: <b><?= $refBalance ?> $</b>
                        </span>
                        <a class="btn btn-xs" role="button" data-toggle="modal" data-target="#outpay_ref" style='margin-left: 10px; text-decoration: none;'>
                            <i class="fal fa-wallet"></i> <?= Language('_withdraw') ?>
                        </a>
                    </div>
                </div>
            </div>

            <section class="" style="padding-top: 40px;">
                <div class="row">
                    <div class="col-lg-12 col-center">
                        <table id="referred-users" class="cell-border" cellspacing="0" width="100%" style="box-shadow:0px 0px 16px 0px rgba(86, 77, 77, 0.21);">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><?= Language('_partner') ?></th>
                                    <th><?= Language('_registration_date') ?></th>
                                    <th><?= Language('_income') ?></th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>ID</th>
                                    <th><?= Language('_partner') ?></th>
                                    <th><?= Language('_registration_date') ?></th>
                                    <th><?= Language('_income') ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

            </section>
        </div>
    </div>
</section>

<?php
	require_once('files/footer.php');
?>


<div class="modal fade" id="outpay_ref" tabindex="-1" role="dialog" aria-labelledby="outpay_ref" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= Language('_modal_title') ?><b id="user_balance2"><?= $refBalance ?></b> $</h5>
            </div>
            <div class="modal-body">
                <form id="outpay_ref_form" method="post" action="/referr-documentation.php">
                    <div class="form-check">
                        <label class="form-check-label" for="out_ref_UserBalance">
                            <input class="form-check-input" type="radio" name="exampleRadios" id='out_ref_UserBalance' value="UserBalance" data-toggle="collapse" data-target=".collapseOne:not(.in)">
                            <?= Language('_option_ad_balance') ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="out_ref_Qiwi">
                            <input class="form-check-input" type="radio" name="exampleRadios" id='out_ref_Qiwi' value="Qiwi" data-toggle="collapse" data-target=".collapseOne:not(.in)">
                            <?= Language('_option_card') ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="out_ref_Card">
                            <input class="form-check-input" type="radio" name="exampleRadios" id='out_ref_Card' value="Card" data-toggle="collapse" data-target=".collapseOne:not(.in)">
                            <?= Language('_option_qiwi') ?>
                        </label>
                    </div>
                    <div class="form-check">
                        <label class="form-check-label" for="out_ref_Payeer">
                            <input class="form-check-input" type="radio" name="exampleRadios" id='out_ref_Payeer' value="Payeer" data-toggle="collapse" data-target=".collapseOne:not(.in)">
                            <?= Language('_option_payeer') ?>
                        </label>
                    </div>
                    <div class="collapse collapseOne">
                        <div class="form-group" style="margin-top: 15px;">
                            <label for="outdraw_amount"><?= Language('_amount_label') ?></label>
                            <input type="text" class="form-control" name="amount" id="outdraw_amount" autocomplete="off" value="" required />
                        </div>
                        <div class="form-group" style="display: none">
                            <label for="data"><?= Language('_enter_account_number') ?></label>
                            <input type="text" class="form-control" name="data" id="data" placeholder="<?= Language('_wallet_card_phone_number') ?>" />
                            <?= Language('_note') ?>
                        </div>
                    </div>
                    <div class='col-md-12 out_ref_error' style='display: none; margin-left: 0; padding-left: 0'>
                        <div class="form-group">
                            <div class="text-danger"></div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary" id="outpay_ref_but"><?= Language('_submit_button') ?></button>
                </form>
                <div class="alert alert-warning alert-dismissible mt-10" role="alert">
                    <?= Language('_attention_message') ?>
                </div>
                <div class="alert alert-info alert-dismissible mt-10" role="alert">
                    <?= Language('_fees_message') ?>
                </div>
            </div>
            <div class="col-sm-12">
                <h4 class="text-center"><?= Language('_last_operations_title') ?></h4>
                <?php if($userHasOpertions): ?>
                    <table id="referr-outs" class="cell-border" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th><?= Language('_date') ?></th>
                                <th><?= Language('_amount_label') ?></th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>ID</th>
                                <th><?= Language('_date') ?></th>
                                <th><?= Language('_amount_label') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                <?php else: ?>
                    <?= Language('_no_operations') ?>
                <?php endif; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= Language('_close') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
	$(document).ready(function() {
    $('#referred-users').DataTable( {
        "order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/referred-users.php",
        "language": {
			"processing": "<?= Language('_processing') ?>",
			"search": "<?= Language('_search') ?>:",
            "lengthMenu": "<?= Language('_show_entries') ?> _MENU_ <?= Language('_records') ?>",
            "info": "<?= Language('_showing_records') ?> _START_ <?= Language('_to') ?> _END_ <?= Language('_from') ?> _TOTAL_ <?= Language('_records') ?>",
			"infoEmpty": "<?= Language('_showing_records') ?> 0 <?= Language('_to') ?> 0 <?= Language('_from') ?> 0 <?= Language('_records') ?>",
			"infoFiltered": "<?= Language('_filtered_from') ?> _MAX_ <?= Language('_records') ?>",
			"infoPostFix": "",
			"loadingRecords": "<?= Language('_loading_records') ?>...",
			"zeroRecords": "<?= Language('_zero_records') ?>.",
			"emptyTable": "<?= Language('_empty_table') ?>",
			"paginate": {
				"first": "<?= Language('_first') ?>",
				"previous": "<?= Language('_previous') ?>",
				"next": "<?= Language('_next') ?>",
				"last": "<?= Language('_last') ?>"
			},
			"aria": {
				"sortAscending": ": <?= Language('_sort_ascending') ?>",
				"sortDescending": ": <?= Language('_sort_descending') ?>"
            },
			"select": {
				"rows": {
					"_": "<?= Language('_selected_rows') ?> %d",
					"0": "<?= Language('_click_to_select') ?>",
					"1": "<?= Language('_one_row_selected') ?>"
				}
			}
		}
	} );
    <?php if($userHasOpertions): ?>
    $('#referr-outs').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/referr-outs.php",
        "order": [[ 0, 'desc' ]],
        "searching": false,
        "paging": false,
        "info": false
    } );
    <?php endif; ?>

} );
</script>


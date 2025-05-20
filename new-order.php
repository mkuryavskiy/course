<?php
	require_once('files/header.php');
    require_once('files/currency_conversion.php');
	$user->IsLogged();
?>
<style>
    #res-ban {
        position: relative;
        display: flex;
        align-items: center;
        width: 100%;
        height: 80px;
        padding: 0 20px 0 20px;
        border-radius: 10px;
        color: #fff;
        background: linear-gradient(110deg,#ea50a3,#0587f7);
        text-decoration: none;
        box-shadow: 0 0 15px 0 rgb(0 0 0 / 10%);
        overflow: hidden;
    }

    #res-ban:before {
        background-image: url(/theme/img/reseller-banner-bg-md.webp?2);
        background-position: 100%;
        background-repeat: no-repeat;
        background-size: contain;
        content: " ";
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        z-index: 0;
    }
    #res-ban .title {
        text-transform: uppercase;
        font-size: 24px;
        position: relative;
        line-height: 18px;
        font-weight: 500;
        text-align: left;
        letter-spacing: 2px;
        width: 800px;
        margin-bottom: unset;
        margin-top: unset;
    }
    #res-ban .title br {
        display: none !important;
    }
    #res-ban .arrow {
        right: 30px;
        position: absolute;
        display: flex;
        align-items: center;
        justify-content: center;
        top: 0;
        bottom: 0;
        margin: auto;
        width: 150px;
        height: 32px;
        border-radius: 16px;
        color: #fff;
        background-color: #e81586;
        font-size: 14px;
        font-weight: 800;
        letter-spacing: .88px;
    }
    #res-ban .arrow .icon {
        display: none;
    }

    @media only screen and (max-width: 1126px) {
        #res-ban .title {
            font-size: 20px;
        }
    }

    @media only screen and (max-width: 900px) {
        #res-ban .title {
            font-size: 20px;
            line-height: 26px;
        }
        #res-ban .title br {
            display: inline !important;
        }
    }

    @media only screen and (max-width: 540px) {
        #res-ban:before {
            background-image: none;
        }
        #res-ban .arrow {
            right: 20px;
            width: 32px;
        }
        #res-ban .arrow .arrow-text {
            display: none;
        }
        #res-ban .arrow .icon {
            display: block;
        }
    }
	
    .payment_system_tab {
        display:none;
    }
    .payment_system {
        margin-bottom: 3px;
    }
    .payment_system label {
        cursor: pointer;
    }
    .payment_error {
        color: red;
        font-weight: bold;
    }

</style>
<section class="page-section new-order" style="padding-top: 100px !important;">
    <?php
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE CategoryActive = "Yes" ORDER BY sort DESC');
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
    ?>
        <div class="container relative">
            <a style="text-decoration: none;" href="bonus" target="_blank" <?php echo ($_GET["lang"] == "en"); ?>>
                <i class="icon far fa-usd-circle" aria-hidden="true"></i> 
                <?=Language("_get_daily_bonus")?>
            </a>
            <div class="row col-center">
                <div class="col-portlet mb-40" style="font-size: 14px; font-weight: 600; color: #5f5f5f; padding: 10px; border: 1px solid #ccc; border-radius:  5px;text-align: center; margin-bottom: 15px;">
                    <div>
                        <img src="/theme/img/smile.webp" width="20">
                        <?=Language("_read_or_leave_reviews")?> <a href="otzyvy" target="_blank"><?=Language("_link")?></a>
                    </div>
                </div>
                <div style="margin-bottom: 15px;">
                    <a id="res-ban" href="discount" target="_blank">
                        <h4 class="title"><?=Language("_become_reseller_and_get_discount")?></h4> 
                        <div class="arrow">
                            <span class="arrow-text d-md-inline-block mr-10"><?=Language("_more")?></span>
                            <i class="icon fa fa-arrow-right" aria-hidden="true"></i>
                        </div>
                    </a>
                </div>
				<div class="col-sm-6 mb-20 col-portlet">
					<div class="col-sm-12">
						<a style="text-decoration: none; margin-bottom: 15px;" href="new-order-multi" class="text-center btn btn-default btn-default-2 btn-sm">
							<i class="fal fa-files-medical"></i> <?=Language("_mass_order")?>
						</a>
						<form method="POST" id="new-order" onsubmit="event.preventDefault(); newOrder();">
							<div class="form-group">
								<div><?=Language("_category")?></div>
								<select class="input-md form-control round" id="category" onChange="handleCategoryChange(); removeQuantity();" autocomplete="off">
									<option value="" disabled selected id="sel"><?=Language("_select_category")?></option>
									<?php
									$lang = $_GET['lang'] ?? 'ru';
									foreach ($stmt->fetchAll() as $row) {
										$categoryName = ($lang == "ru") ? $row['CategoryName'] : $row['CategoryName'.mb_strtoupper($lang)];
										echo "<option value='{$row['CategoryID']}' data-original='$categoryName'>$categoryName</option>";
									} ?>
								</select>
                            </div>      
							<div class="form-group">
								<div><?= Language("_service_cost_per_1000") ?></div>
								<select 
									class="input-md form-control round" 
									id="service" 
									name="service" 
									onChange="selectService(this.value); nullQuantity(); updateMinQuantity(this.value); updateMaxQuantity(this.value); updateDescription(this.value);" 
									autocomplete="off"
								>
									<option value="" style="display:none;">
										<?= Language("_select_category") ?>
									</option>
								</select>
							</div>

							<div class="form-group">
								<div>
									<?= Language("_links") ?>
									<a 
										href="<?= ($_GET['lang'] == 'en') ? '' : 'info.php?name=kak-skopirovat-ssylku-instagram' ?>" 
										target="_blank"
									>
										<i class="far fa-question-circle"></i>
									</a>
								</div>
								<input 
									type="text" 
									id="order_link" 
									name="link" 
									class="input-md round form-control def-text" 
									placeholder="<?= Language("_links") ?>" 
									required
								>
							</div>
							<div class="form-group">
								<div><?= Language("_quantity") ?></div>
								<input 
									type="number" 
									id="order_quantity" 
									name="quantity" 
									class="input-md round form-control def-text" 
									placeholder="<?= Language("_quantity") ?>" 
									required 
									onChange="updatePrice(service.value, this.value);"
								>
							</div>
                            <div class="form-group">
                                <div class="form-tip">
                                    <i class="fa fa-hryvnia" aria-hidden="true" style="width: 0px;visibility: hidden;"></i>
                                    <?=Language("_charge")?>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="input-md form-control def-text" id="new_order_price_usd" style="cursor: not-allowed;background-color: #eeeeee;" value="0">
							<span class="input-group-addon" id="basic-addon2">
								<span class="new_order_price_rub">0</span><?=Language('_currency')?></span>
                                </div>
                                <a href="discount" target="_blank" style="color: #aaa;"><?=Language("_get_discount")?></a>
                            </div>
                            <div id="additional"></div>
                            <div class="form-group">
                                <div style="font-size: 14px;">
                                    <span id="service-description"></span>
                                    <hr>
                                    <div class="form-group">
                                        <b><?=Language("_min_order")?>: </b><span id="min_quantity">0</span>
                                        <b><?=Language("_max_order")?>: </b><span id="max_quantity">0</span><br>
                                    </div>
                                </div>
                                <input type="submit" name="order" class="submit_btn btn btn-mod btn-medium btn-round" value="<?=Language("_create_order")?>">
                            </div>
                           <?=Language('_order_overlap_notice')?>
                        </form>
                    </div>
                </div>
                <div class="col-sm-5 mb-20 col-sm-offset-1 col-portlet">
                    <div class="col-sm-12">
                        <div style="font-size: 14px;">
                            <h4 class="uppercase text-center"><?=Language('_add_funds_title')?></h4>
                            <div class="alert bshadow"><?=Language('_bonus_notice')?></div>
                            <hr>
                            <h5 class="uppercase"><b><?=Language('_current_balance')?></b> <span id="current-balance"><?php echo $UserBalance; ?></span> $</h5>
                            <hr>
                                <style>
								.payment_system_tab { display: none; }
								.pay_system { margin-bottom: 3px; }
								.pay_system label { cursor: pointer; }
								.pay_error { color: red; font-weight: bold; }
                                </style>
								<div class="">
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="CARDLINK_CARD-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/bankcard.png" width="25"> <?=Language('_bank_card_rf')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" name="paymentType" value="LIQPAY"> <span style="font-weight: 400;">
											<img src="theme/img/payment/bankcard.png" width="25"> <?=Language('_bank_card_other_countries')?> <span class="badge"><?=$liqpay_comission;?></span></span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="OBMENKA_LAVA-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/lava.svg" width="25"> <?=Language('_lava')?> <span class="badge">0%</span> </span>
										</label>
									</div>								
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="OBMENKA_QIWI-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/um.png" width="25"> <?=Language('_yandex_money')?> <span class="badge">3%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="OBMENKA_QIWI-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/apple.png" width="25"> <?=Language('_apple_pay')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="OBMENKA_QIWI-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/google.png" width="35"> <?=Language('_google_pay')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="OBMENKA_ADV-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/advcash.png" width="25"> <?=Language('_advcash')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="PAYEER-">
											<span style="font-weight: 400;">
											<i class="fab fa-product-hunt" style="font-size: 25px; vertical-align: middle;"></i> <?=Language('_payeer_eur')?> <span class="badge">0%</span>
											</span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="PAYEER-">
											<span style="font-weight: 400;">
											<i class="fab fa-product-hunt" style="font-size: 25px; vertical-align: middle;"></i> <?=Language('_payeer_usd')?> <span class="badge">0%</span>
											</span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="PERFECTMONEY-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/pm.png" width="25"> <?=Language('_perfect_money')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="USDT_ERC20-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/usdt.png?2" width="25"> <?=Language('_usdt_erc20')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="USDT_TRC20-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/usdt.png?2" width="25"> <?=Language('_usdt_trc20')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<div class="col-sm-12 input-group m-bot15 payment_system">
										<label class="pay">
											<input type="radio" disabled name="paymentType" value="COINBASE-"> <span style="font-weight: 400;">
											<img src="theme/img/payment/crypto.png" width="25"> <?=Language('_cryptocurrency')?> <span class="badge">0%</span> </span>
										</label>
									</div>
									<hr>
								</div>
							<div class="col-sm-12 payment_system_tab" id="tabLIQPAY" style="display:none">
								<div class="form-group">
									<form method="get" action="liqpay_create.php">
										<div class="col-sm-12 input-group m-bot15 pb-20">
											<div><?=Language('_enter_payment_amount')?></div>
											<div class="input-group">
												<input inputmode="decimal" class="input-md form-control def-text form_amount" data-min="2.5" name="amount" autocomplete="off" value="0 $">
												<span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>UAH</span>
												<input type="hidden" name="user" value="<?php echo $UserID; ?>">
											</div>
											<div class="payment_error" style="display:none"></div>
											<span class="usercom"><?=Language('_commission')?> <?=$liqpay_comission;?></span> 
											<br><span>1 USD = <?php echo $rate . ' ' ?></span>
										</div>
										<input type="submit" name="liqpay_create" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
									</form>
								</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUNITPAY_MOB">
							<div class="form-group">
								<form method="POST" action="payment/unitpay-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 12%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="mc">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUNITPAY_APPLE">
							<div class="form-group">
								<form method="POST" action="payment/unitpay-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="applepay">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabPAYV2_APPLE">
							<div class="form-group">
								<form method="POST" action="payment/unitpay-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 9-10%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="applepay">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUNITPAY_SAMSUNG">
							<div class="form-group">
								<form method="POST" action="payment/unitpay-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="samsungpay">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUNITPAY_GOOGLE">
							<div class="form-group">
								<form method="POST" action="payment/unitpay-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 3%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="googlepay">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabYOOMONEY">
							<div class="form-group">
								<form method="POST" action="payment/ym-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.02" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="PC">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabYOOKASSA_YOOMONEY">
							<div class="form-group">
								<form method="POST" action="payment/yk-create-smart.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.02" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 3%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="yoo_money">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabYOOKASSA_APPLE">
							<div class="form-group">
								<form method="POST" action="payment/yk-create-smart.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 3%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabFK_YOOMONEY">
							<div class="form-group">
								<form method="POST" action="payment/fk-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.5" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 3%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="6">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabCARDLINK_CARD">
							<div class="form-group">
								<form method="POST" action="payment/cardlink-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.15" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabCARDLINK_CARD_INT">
							<div class="form-group">
								<form method="POST" action="payment/cardlink-create-int.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="2" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 9%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUNITPAY_WM">
							<div class="form-group">
								<form method="POST" action="payment/unitpay-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="webmoney">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabWM">
							<div class="form-group">
								<form method="POST" action="payment/wm-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>" name="ok">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabPERFECTMONEY">
							<div class="form-group">
								<form method="POST" action="payment/pm-create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabCOINBASE">
							<div class="form-group">
								<form method="POST" action="payment/coinbase_create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="user_id" value="350597">
									<input type="submit" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabENOT_ADVCASH">
							<div class="form-group">
								<form method="POST" action="payment/enot_create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.45" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="cd">
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabbeznal">
							<div class="form-group"> <b>Только для юр.лиц и ИП</b>
								<br> Для получения реквизитов, свяжитесь с нами:
								<br> <i class="fab fa-telegram"></i> <a href="tg://resolve?domain=wiqsupport" target="_blank">wiqsupport</a> | <i class="fab fa-whatsapp-square"></i> <a href="https://wa.me/79006269838" target="_blank">+79006269838</a> </div>
							<hr>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabOBMENKA_QIWI">
							<div class="form-group">
								<form method="POST" action="payment/obmenka_create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="user_id" value="350597">
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabOBMENKA_ADV">
							<div class="form-group">
								<form method="POST" action="payment/obmenka_create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="0.1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="advcash.usd">
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUSDT_ERC20">
							<div class="form-group">
								<form method="POST" action="payment/obmenka_create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									 <input type="hidden" name="type" value="usdt_erc20">
						             <input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>

						<div class="col-sm-12 payment_system_tab" id="tabUSDT_TRC20">
							<div class="form-group">
								<form method="POST" action="payment/obmenka_create.php" onsubmit="return payment_validate(this)">
									<div class="col-sm-12 input-group m-bot15 pb-20">
										<div><?=Language('_enter_payment_amount')?></div>
										<div class="input-group">
											<input type="text" inputmode="decimal" class="input-md form-control def-text form_amount" data-min="1" name="amount" autocomplete="off" value="0 $"> <span class="input-group-addon" id="basic-addon2"><span class="amount_rub">0</span>₽</span>
										</div>
										<div class="payment_error" style="display: none"></div> <span class="usercom"><?=Language('_commission')?> 0%</span>
										<br> <span>1 USD = <?php echo $get_curs_valam; ?> ₽</span> </div>
									<input type="hidden" name="type" value="usdt_trc20">
									<input type="submit" name="ok" class="font-alt submit_btn btn btn-mod btn-medium btn-round" value="<?=Language('_deposit')?>">
								</form>
							</div>
						</div>
							<script>
							document.addEventListener('DOMContentLoaded', function() {
							  var formAmountInput = document.querySelector('.form_amount');
							  var paymentError = document.querySelector('.payment_error');

							  formAmountInput.addEventListener('input', function() {
								paymentError.textContent = '';
								paymentError.classList.remove('payment_error');
								paymentError.style.display = 'none';
							  });

							  formAmountInput.form.addEventListener('submit', validateAmount);

							  function validateAmount(e) {
								var minAmount = parseFloat(formAmountInput.getAttribute('data-min'));
								var enteredAmount = parseFloat(formAmountInput.value);
								if (!isNumber(enteredAmount) || enteredAmount < minAmount) {
								  e.preventDefault();
								  paymentError.textContent = '<?=Language('_min_amount')?> ' + minAmount + ' $';
								  paymentError.classList.add('payment_error');
								  paymentError.style.display = 'block';
								}
							  }
							  function isNumber(value) {
								return !isNaN(value) && !Number.isNaN(value);
							  }
							});
						</script>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>
</section>
<?php  
	require_once('files/footer.php');
    $viewed = $_COOKIE['news_view_list'];
    if (isset($uuvcN) && $uuvcN > 0) {
        $viewed = array_map('intval', explode(',', $viewed));
        $stmt = $pdo->prepare('SELECT * FROM news WHERE NEWSID > :uuvidN AND specshow > 0'); 
        $stmt->execute([':uuvidN' => $uuvidN]);
        $lang = strtoupper($_GET["lang"] ?? "");
        if ($lang == "EN") { $btn = "I read it";  
		} else if ( $lang == "UA" ) { $btn = "Я ознайомився"; 
			} else { $btn = "Я ознакомился"; $lang = "";}
			while($row = $stmt->fetch()) { 
            if (!in_array((int)$row['NEWSID'], $viewed)) { 
                ?>
                <div id="myModal_<?= $row['NEWSID'] ?>" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header" style="background-image: none">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                <h4 class="modal-title"><?= $row['NEWSQuestion'.$lang] ?></h4>
                            </div>
                            <div class="modal-body">
                                <?= $row['NEWSAnswer'.$lang] ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default modal_received_but" data-modal-id="<?= $row['NEWSID'] ?>"><?= $btn ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="#myModal_<?= $row['NEWSID'] ?>" data-toggle="modal"></a>
                <script>
                    $(document).ready(function () { 
                        if(!window.myModalPassActive && !window.myModalActive) {
                            $("#myModal_<?= $row['NEWSID'] ?>").modal('show'); 
                            window.myModalActive = true;
                        }
                        $("#myModal_<?= $row['NEWSID'] ?>").on('hidden.bs.modal', function (e) {
                            window.myModalActive = false;
                        });
                    });
                </script>
                <?php
            }
        }
    }
?>
<script type="text/javascript">
$(function() {
    $('.modal_received_but').on('click', function(event) {
        let id = $(event.target).data('modal-id');
        $.post('/requests.php', {'action' : 'set-news-viewed', 'news-id' : id}, function(data) {
            if (data.result) {
                window.myModalActive = false;
                $('#myModal_' + id).modal('hide');
                let nextId = parseInt(data.next);
                if (nextId > 0) {
                    $('#myModal_' + nextId).modal('hide');
                }
            }
        }, 'json')
    });

    $(window).bind('beforeunload', function() {
        $('body').html('');
    });

    // Получаем курс валюты и символ
    let rate = <?= json_encode($rate) ?>;
    let symbol = '<?= $currency ?>';

    // Обработчик для поля пополнения баланса
    $('.payment_system_tab input[name=amount]').on('change paste input focusout', function () {
        let amount_usd = this.value.replace(/,/, '.'), amount_converted = 0;

        if (!isNaN(parseFloat(amount_usd)) && amount_usd != 0 && amount_usd != '' && amount_usd != false) {
            amount_converted = (parseFloat(amount_usd) * rate).toFixed(2);
        }
        $(this).closest('.payment_system_tab').find('.amount_rub').text(amount_converted);
        $(this).closest('.payment_system_tab').find('input[name=amount_rub]').val(amount_converted);
        $(this).closest('.payment_system_tab').find('.input-group-addon#basic-addon2').html('<span class="amount_rub">' + amount_converted + '</span>' + symbol);
    });

    // Обработчик для поля создания заказа
    $("#new_order_price_usd").on("change input", function() {
        let usdVal = parseFloat($(this).val().replace(/[^.0-9]/g, ''));
        let convertedPrice = Math.round(usdVal * rate * 100) / 100;

        $(".new_order_price_rub").html(convertedPrice);
        $("#basic-addon2").html('<span class="new_order_price_rub">' + convertedPrice + '</span>' + symbol);
    });

    // Очистка поля при фокусе (для пополнения баланса)
    $('.form_amount').on('focusin', function () {
        let val = $(this).val(), val_clear = parseFloat(val.replace(/,/, '.').replace(/\$/, ''));
        if (val_clear == 0 || isNaN(val_clear)) {
            val_clear = '';
        }
        $(this).val(val_clear);
    });

    // Форматирование поля при потере фокуса (для пополнения баланса)
    $('.form_amount').on('focusout', function () {
        let val = $(this).val(), val_clear = parseFloat(val.replace(/,/, '.'));
        if (val_clear == 0 || isNaN(val_clear) || val_clear == '') {
            val_clear = '0';
        }
        $(this).val(val_clear + ' $');
    });
});
</script>
<script>
function handleCategoryChange() {
    const select = document.getElementById('category');
    const options = select.options;

    for (let i = 0; i < options.length; i++) {
        const option = options[i];
        if (option.value === "") {
            // Пропускаем опцию "Выберите категорию"
            continue;
        }
        if (option.selected) {
            option.textContent = option.textContent.replace(/[\u{1F600}-\u{1F64F}\u{1F300}-\u{1F5FF}\u{1F680}-\u{1F6FF}\u{2600}-\u{26FF}\u{2700}-\u{27BF}]/gu, '');
        } else {
            option.textContent = option.getAttribute('data-original');
        }
    }

    // Если ничего не выбрано, показываем плейсхолдер
    if (select.value === "") {
        select.selectedIndex = 0;
    }

    // Вызываем существующую функцию removeQuantity()
    removeQuantity();
}

// Вызываем функцию при загрузке страницы для инициализации
document.addEventListener('DOMContentLoaded', handleCategoryChange);
</script>


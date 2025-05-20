<?php
require_once('files/header.php');
?>
<style type="text/css">@charset "UTF-8";
.mx-datepicker {
    position: relative;
    display: inline-block;
    width: 210px;
    color: #73879c;
    font: 14px/1.5 'Helvetica Neue', Helvetica, Arial, 'Microsoft Yahei', sans-serif;
}

.mx-datepicker * {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.mx-datepicker.disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.mx-datepicker-range {
    width: 320px;
}

.mx-datepicker-popup {
    position: absolute;
    margin-top: 1px;
    margin-bottom: 1px;
    border: 1px solid #d9d9d9;
    background-color: #fff;
    -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
    z-index: 1000;
}

.mx-input-wrapper {
    position: relative;
}

.mx-input-wrapper .mx-clear-wrapper {
    display: none;
}

.mx-input-wrapper:hover .mx-clear-wrapper {
    display: block;
}

.mx-input {
    display: inline-block;
    width: 100%;
    height: 34px;
    padding: 6px 30px;
    padding-left: 10px;
    font-size: 14px;
    line-height: 1.4;
    color: #555;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
}

.mx-input:disabled, .mx-input.disabled {
    opacity: 0.7;
    cursor: not-allowed;
}

.mx-input:focus {
    outline: none;
}

.mx-input-append {
    position: absolute;
    top: 0;
    right: 0;
    width: 30px;
    height: 100%;
    padding: 6px;
    background-color: #fff;
    background-clip: content-box;
}

.mx-input-icon {
    display: inline-block;
    width: 100%;
    height: 100%;
    font-style: normal;
    color: #555;
    text-align: center;
    cursor: pointer;
}

.mx-calendar-icon {
    width: 100%;
    height: 100%;
    color: #555;
    stroke-width: 8px;
    stroke: currentColor;
    fill: currentColor;
}

.mx-clear-icon::before {
    display: inline-block;
    content: '\2716';
    vertical-align: middle;
}

.mx-clear-icon::after {
    content: '';
    display: inline-block;
    width: 0;
    height: 100%;
    vertical-align: middle;
}

.mx-range-wrapper {
    width: 496px;
    overflow: hidden;
}

.mx-shortcuts-wrapper {
    text-align: left;
    padding: 0 12px;
    line-height: 34px;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.mx-shortcuts-wrapper .mx-shortcuts {
    background: none;
    outline: none;
    border: 0;
    color: inherit;
    margin: 0;
    padding: 0;
    white-space: nowrap;
    cursor: pointer;
}

.mx-shortcuts-wrapper .mx-shortcuts:hover {
    color: #419dec;
}

.mx-shortcuts-wrapper .mx-shortcuts:after {
    content: '|';
    margin: 0 10px;
    color: #48576a;
}

.mx-datepicker-footer {
    padding: 4px;
    clear: both;
    text-align: right;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
}

.mx-datepicker-btn {
    font-size: 12px;
    line-height: 1;
    padding: 7px 15px;
    margin: 0 5px;
    cursor: pointer;
    background-color: transparent;
    outline: none;
    border: none;
    border-radius: 3px;
}

.mx-datepicker-btn-confirm {
    border: 1px solid rgba(0, 0, 0, 0.1);
    color: #73879c;
}

.mx-datepicker-btn-confirm:hover {
    color: #1284e7;
    border-color: #1284e7;
}

/* 日历组件 */
.mx-calendar {
    float: left;
    color: #73879c;
    padding: 6px 12px;
    font: 14px/1.5 Helvetica Neue, Helvetica, Arial, Microsoft Yahei, sans-serif;
}

.mx-calendar * {
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.mx-calendar-header {
    padding: 0 4px;
    height: 34px;
    line-height: 34px;
    text-align: center;
    overflow: hidden;
}

.mx-calendar-header > a {
    color: inherit;
    text-decoration: none;
    cursor: pointer;
}

.mx-calendar-header > a:hover {
    color: #419dec;
}

.mx-icon-last-month, .mx-icon-last-year,
.mx-icon-next-month,
.mx-icon-next-year {
    padding: 0 6px;
    font-size: 20px;
    line-height: 30px;
}

.mx-icon-last-month, .mx-icon-last-year {
    float: left;
}

.mx-icon-next-month,
.mx-icon-next-year {
    float: right;
}

.mx-calendar-content {
    width: 224px;
    height: 224px;
}

.mx-calendar-content .cell {
    vertical-align: middle;
    cursor: pointer;
}

.mx-calendar-content .cell:hover {
    background-color: #eaf8fe;
}

.mx-calendar-content .cell.actived {
    color: #fff;
    background-color: #1284e7;
}

.mx-calendar-content .cell.inrange {
    background-color: #eaf8fe;
}

.mx-calendar-content .cell.disabled {
    cursor: not-allowed;
    color: #ccc;
    background-color: #f3f3f3;
}

.mx-panel {
    width: 100%;
    height: 100%;
    text-align: center;
}

.mx-panel-date {
    table-layout: fixed;
    border-collapse: collapse;
    border-spacing: 0;
}

.mx-panel-date td, .mx-panel-date th {
    font-size: 12px;
    width: 32px;
    height: 32px;
    padding: 0;
    overflow: hidden;
    text-align: center;
}

.mx-panel-date td.today {
    color: #2a90e9;
}

.mx-panel-date td.last-month, .mx-panel-date td.next-month {
    color: #ddd;
}

.mx-panel-year {
    padding: 7px 0;
}

.mx-panel-year .cell {
    display: inline-block;
    width: 40%;
    margin: 1px 5%;
    line-height: 40px;
}

.mx-panel-month .cell {
    display: inline-block;
    width: 30%;
    line-height: 40px;
    margin: 8px 1.5%;
}

.mx-time-list {
    position: relative;
    float: left;
    margin: 0;
    padding: 0;
    list-style: none;
    width: 100%;
    height: 100%;
    border-top: 1px solid rgba(0, 0, 0, 0.05);
    border-left: 1px solid rgba(0, 0, 0, 0.05);
    overflow-y: auto;
    /* 滚动条滑块 */
}

.mx-time-list .mx-time-picker-item {
    display: block;
    text-align: left;
    padding-left: 10px;
}

.mx-time-list:first-child {
    border-left: 0;
}

.mx-time-list .cell {
    width: 100%;
    font-size: 12px;
    height: 30px;
    line-height: 30px;
}

.mx-time-list::-webkit-scrollbar {
    width: 8px;
    height: 8px;
}

.mx-time-list::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.05);
    border-radius: 10px;
    -webkit-box-shadow: inset 1px 1px 0 rgba(0, 0, 0, 0.1);
    box-shadow: inset 1px 1px 0 rgba(0, 0, 0, 0.1);
}

.mx-time-list:hover::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.2);
}
</style>
<style type="text/css">
    .vue-modal-resizer {
        display: block;
        overflow: hidden;
        position: absolute;
        width: 12px;
        height: 12px;
        right: 0;
        bottom: 0;
        z-index: 9999999;
        background: transparent;
        cursor: se-resize;
    }

    .vue-modal-resizer::after {
        display: block;
        position: absolute;
        content: '';
        background: transparent;
        left: 0;
        top: 0;
        width: 0;
        height: 0;
        border-bottom: 10px solid #ddd;
        border-left: 10px solid transparent;
    }

    .vue-modal-resizer.clicked::after {
        border-bottom: 10px solid #369be9;
    }
</style>
<style type="text/css">
    .v--modal-block-scroll {
        overflow: hidden;
        width: 100vw;
    }

    .v--modal-overlay {
        position: fixed;
        box-sizing: border-box;
        left: 0;
        top: 0;
        width: 100%;
        height: 100vh;
        background: rgba(0, 0, 0, 0.2);
        z-index: 999;
        opacity: 1;
    }

    .v--modal-overlay.scrollable {
        height: 100%;
        min-height: 100vh;
        overflow-y: auto;
        -webkit-overflow-scrolling: touch;
    }

    .v--modal-overlay .v--modal-background-click {
        width: 100%;
        height: 100%;
    }

    .v--modal-overlay .v--modal-box {
        position: relative;
        overflow: hidden;
        box-sizing: border-box;
    }

    .v--modal-overlay.scrollable .v--modal-box {
        margin-bottom: 2px;
    }

    .v--modal {
        background-color: white;
        text-align: left;
        border-radius: 3px;
        box-shadow: 0 20px 60px -2px rgba(27, 33, 58, 0.4);
        padding: 0;
    }

    .v--modal.v--modal-fullscreen {
        width: 100vw;
        height: 100vh;
        margin: 0;
        left: 0;
        top: 0;
    }

    .v--modal-top-right {
        display: block;
        position: absolute;
        right: 0;
        top: 0;
    }

    .overlay-fade-enter-active,
    .overlay-fade-leave-active {
        transition: all 0.2s;
    }

    .overlay-fade-enter,
    .overlay-fade-leave-active {
        opacity: 0;
    }

    .nice-modal-fade-enter-active,
    .nice-modal-fade-leave-active {
        transition: all 0.4s;
    }

    .nice-modal-fade-enter,
    .nice-modal-fade-leave-active {
        opacity: 0;
        transform: translateY(-20px);
    }
</style>
<style type="text/css">
    .vue-dialog div {
        box-sizing: border-box;
    }

    .vue-dialog .dialog-flex {
        width: 100%;
        height: 100%;
    }

    .vue-dialog .dialog-content {
        flex: 1 0 auto;
        width: 100%;
        padding: 15px;
        font-size: 14px;
    }

    .vue-dialog .dialog-c-title {
        font-weight: 600;
        padding-bottom: 15px;
    }

    .vue-dialog .dialog-c-text {
    }

    .vue-dialog .vue-dialog-buttons {
        display: flex;
        flex: 0 1 auto;
        width: 100%;
        border-top: 1px solid #eee;
    }

    .vue-dialog .vue-dialog-buttons-none {
        width: 100%;
        padding-bottom: 15px;
    }

    .vue-dialog-button {
        font-size: 12px !important;
        background: transparent;
        padding: 0;
        margin: 0;
        border: 0;
        cursor: pointer;
        box-sizing: border-box;
        line-height: 40px;
        height: 40px;
        color: inherit;
        font: inherit;
        outline: none;
    }

    .vue-dialog-button:hover {
        background: rgba(0, 0, 0, 0.01);
    }

    .vue-dialog-button:active {
        background: rgba(0, 0, 0, 0.025);
    }

    .vue-dialog-button:not(:first-of-type) {
        border-left: 1px solid #eee;
    }

    <
    /
    div >
    <

    /
    div >
    <

    /
    nav >
    < style >
    html {
        overflow-y: visible !important;
        -ms-overflow-style: visible !important;
    }

    [v-cloak] {
        display: none;
    }

    .franchise_order {
        cursor: pointer;
    }

    .modal_order .panel {
        padding: 20px 30px;
        font-size: 14px;
    }

    .pricingTable {
        border: 1px solid #e7e7e7;
        text-align: center;
        padding: 0 30px 30px;
        transition: all 0.5s ease 0s;
    }

    .pricingTable:hover {
        border: 1px solid #0e056e;
    }

    .pricingTable .pricingTable-header {
        width: 210px;
        background: #0e056e;
        color: #fff;
        margin: -15px auto 95px;
        padding-top: 35px;
        position: relative;
        line-height: 30px;
    }

    .pricingTable .pricingTable-header:before {
        content: "";
        border-width: 0 0 15px 10px;
        border-style: solid;
        border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #000;
        position: absolute;
        top: 0;
        left: -10px;
    }

    .pricingTable .pricingTable-header:after {
        content: "";
        border-width: 15px 0 0 10px;
        border-style: solid;
        border-color: rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) rgba(0, 0, 0, 0) #000;
        position: absolute;
        top: 0;
        right: -10px;
    }

    .pricingTable .heading {
        font-size: 30px;
        font-weight: 800;
        margin: 5px 0;
        text-transform: uppercase;
        position: relative;
    }

    .pricingTable .heading:after {
        content: "";
        border-width: 60px 105px 0;
        border-style: solid;
        border-color: #0e056e rgba(0, 0, 0, 0) rgba(0, 0, 0, 0);
        position: absolute;
        bottom: -133px;
        left: 0;
    }

    .pricingTable .currency,
    .pricingTable .month {
        font-size: 20px;
    }

    .pricingTable .price-value {
        color: #e93689;
        font-weight: bold;
        font-size: 41px;
    }

    .pricingTable .pricing-content ul {
        list-style: none;
        padding: 0;
        margin: 0 0 25px 0;
    }

    .pricingTable .pricing-content ul li {
        font-size: 14px;
        color: #334a6b;
        line-height: 40px;
    }

    .pricingTable-signup {
        display: inline-block;
        font-size: 14px;
        font-weight: 600;
        color: #334a6b;
        border: 2px solid #e7e7e7;
        padding: 10px 40px;
        transition: all 0.5s ease 0s;
    }

    .pricingTable-signup:hover {
        border: 2px solid #ea3489;
        color: #ea3489;
    }

    @media only screen and (max-width: 990px) {
        .pricingTable {
            margin-bottom: 50px;
        }
    }

    .timer {
        font-size: 0;
        text-align: center;
    }

    .timer_section {
        display: inline-block;
        vertical-align: top;
    }

    .timer_section > div {
        display: inline-block;
        vertical-align: top;
        font-size: 50px;
        background: #e93689;
        color: #ffffff;
        line-height: 70px;
        width: 55px;
        margin: 0 1px;
        border-radius: 2px;
    }

    .timer_section > div.timer_section_desc {
        display: block;
        background: none;
        color: inherit;
        text-transform: uppercase;
        font-size: 16px;
        line-height: 30px;
        width: auto;
        margin: 0;
    }

    .timer_delimetr {
        display: inline-block;
        vertical-align: top;
        font-size: 50px;
        line-height: 70px;
        margin: 0 5px;
    }

    @media (max-width: 767px) {
        .timer_section > div {
            font-size: 30px;
            width: 30px;
            line-height: 40px;
        }

        .timer_delimetr {
            line-height: 40px;
            font-size: 30px;
        }

        .timer_section > div.timer_section_desc {
            font-size: 14px;
            line-height: 26px;
        }
    }

</style>

<script>
    window.base_url = 'https://wiq.by/';
    window.user_id = null;
    window.user_email = '';
    window.myModalActive = false;
    window.usd = 76.1;
    window.lang = 'ru';
</script>
<section class='page-section' id='app' v-cloak>
    <div class='row col-md-12 col-center'>
        <div class='container relative'>
            <h1 class='section-title font-alt'><?=Language('_franchise')?></h1>
					<div class='row'>
						<div class='col-md-12' style='font-size: 18px;'>
							<p class='text-center' style='margin-bottom: 1em;'>
								<img src='https://wiq.by/theme/img/franschise/header.jpg'>
							</p>
							<p class='text-center' style='text-transform: uppercase;'>
								<i class='fas fa-database' style='color: gold;'></i> <?=Language('_partners_earned')?> <?= substr(number_format($settings['PartnersEarned'], 2, ',', ' '), 0, -3); ?> $
							</p>
							<center>
								<a class='pricingTable-signup but_order franchise_order' @click='order()'><?=Language('_start_earning')?></a>
							</center>
							<hr style='margin-top: 47px'>
							<p class='text-center'><h2 class='text-center'><?=Language('_what_you_get')?></h2></p>
							<div class='col-lg-4' style='text-align:center;'>
								<img src='/theme/img/franschise/block0.jpg?2'>
								<h3><?=Language('_high_income_business')?></h3>
								<p>
									<?=Language('_high_income_description')?>
								</p>
							</div>
							<div class='col-lg-4' style='text-align:center;'>
								<img src='/theme/img/franschise/block1.jpg?3'>
								<h3><?=Language('_full_automation')?></h3>
								<p>
									<?=Language('_full_automation_description')?>
								</p>
							</div>
							<div class='col-lg-4' style='text-align:center;'>
								<img src='/theme/img/franschise/block3.jpg'>
								<h3><?=Language('_support_247')?></h3>
								<p>
									<?=Language('_support_247_description')?>
								</p>
							</div>
						</div>
					</div>
					<div class='row text-center col-center'>
						<hr style='margin-bottom: 47px;'>
						<h2 class='text-center mb-60'><?=Language('_payment_systems')?></h2>
						<div class='franchise_payment_block_box'>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/ydnew.png'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/bankcard.png'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/qiwi2.png'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/apple.png' style='width: 57px;'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/crypto.png'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/sp.png' style='width: 111px;'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/wm.jpg' style='width: 93px;'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/enot.jpeg' style='width: 110px;'></div>
							<div class='franchise_payment_block'><img src='./theme/img/franschise/franschisecashmaal.png' style='width: 100px;'></div>
							<div class='franchise_payment_block '><img class='franchise_payment_block_long' src='./theme/img/franschise/franschisepayeer.png' style='width: 118px;'></div>
							<div class='franchise_payment_block '><img class='franchise_payment_block_long' src='./theme/img/franschise/franschisepaypal.svg' style='width: 130px;'></div>
							<div class='franchise_payment_block '><img class='franchise_payment_block_long' src='./theme/img/franschise/franschisefondy.svg' style='width: 126px;'></div>
							<div class='franchise_payment_block '><img class='franchise_payment_block_long' src='./theme/img/franschise/franschiseinterkassa.png' style='width: 149px;'></div>
							<div class='franchise_payment_block '><img class='franchise_payment_block_long' src='./theme/img/franschise/franschisecardlink.svg' style='width: 128px;'></div>
							<div class='franchise_payment_block '><img class='franchise_payment_block_long' src='./theme/img/franschise/franschisepm.png' style='width: 166px;'></div>
						</div>
					</div>
					<center>
						<a class='pricingTable-signup but_order franchise_order' @click='order()'><?=Language('_become_partner')?></a>
					</center>
					<hr style='margin-top: 47px' />
					<div class='row'>
						<h2 class='text-center'><?=Language('_tariffs')?></h2>
						<div class='timer' data-finish='1674853200000' style='padding-bottom: 56px;'>
							<div class='timer_section'>
								<div class='days_1'>0</div>
								<div class='days_2'>0</div>
								<div class='timer_section_desc'><?=Language('_days')?></div>
							</div>
							<div class='timer_delimetr'>:</div>
							<div class='timer_section'>
								<div class='hours_1'>0</div>
								<div class='hours_2'>0</div>
								<div class='timer_section_desc'><?=Language('_hours')?></div>
							</div>
							<div class='timer_delimetr'>:</div>
							<div class='timer_section'>
								<div class='minutes_1'>0</div>
								<div class='minutes_2'>0</div>
								<div class='timer_section_desc'><?=Language('_minutes')?></div>
							</div>
							<div class='timer_delimetr'>:</div>
							<div class='timer_section'>
								<div class='seconds_1'>0</div>
								<div class='seconds_2'>0</div>
								<div class='timer_section_desc'><?=Language('_seconds')?></div>
							</div>
						</div>
						<div class='col-md-12' style='font-size: 18px;'>
							<div class='col-md-4 col-sm-6'>
								<div class='pricingTable'>
									<div class='pricingTable-header'>
										<h3 class='heading'><?=Language('_lite')?></h3>
										<s>30$</s><BR />
										<span class='price-value'>15$</span>
									</div>
									<div class='pricing-content'>
										<ul>
											<li><i class='fas fa-check'></i> <?=Language('_rent_panel')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_domain_binding')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_weekly_updates')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_technical_support')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_reseller_status')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_20_payment_systems')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_monthly_payment')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_up_to_1000_orders')?></li>
										</ul>
									</div>
									<a class='pricingTable-signup but_order franchise_order' @click='order("lite")'><?=Language('_buy')?></a>
								</div>
							</div>
							<div class='col-md-4 col-sm-6'>
								<div class='pricingTable' style='background-color: #fafaff;'>
									<div class='pricingTable-header'>
										<h3 class='heading'><?=Language('_full')?></h3>
										<s style='text-decoration: none'>от</s><BR />
										<span class='price-value'>60$</span>
									</div>
									<div class='pricing-content'>
										<ul>
											<li><i class='fas fa-check'></i> <?=Language('_rent_panel')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_domain_ru_gift')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_weekly_updates')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_technical_support')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_reseller_status')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_20_payment_systems')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_any_suppliers_api')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_monthly_payment')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_personal_manager')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_from_5000_orders')?></li>
										</ul>
									</div>
									<a class='pricingTable-signup but_order franchise_order' @click='order("full")'><?=Language('_buy')?></a>
								</div>
							</div>
							<div class='col-md-4 col-sm-6'>
								<div class='pricingTable'>
									<div class='pricingTable-header'>
										<h3 class='heading'><?=Language('_standard')?></h3>
										<s>60$</s><BR />
										<span class='price-value'>30$</span>
									</div>
									<div class='pricing-content'>
										<ul>
											<li><i class='fas fa-check'></i> <?=Language('_rent_panel')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_domain_ru_gift')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_weekly_updates')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_technical_support')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_reseller_status')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_20_payment_systems')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_any_suppliers_api')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_monthly_payment')?></li>
											<li><i class='fas fa-check'></i> <?=Language('_up_to_2000_orders')?></li>
										</ul>
									</div>
									<a class='pricingTable-signup but_order franchise_order' @click='order("standard")'><?=Language('_buy')?></a>
								</div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
              <modal name="modal_order" class="modal_order" width="50%" :min-width="300" :max-width="500" height="auto" :adaptive="true" :click-to-close="true" classes="" :scrollable="true">
                 <div class="panel panel-default">
                    <div class="panel-body">
                       <button @click="$modal.hide('modal_order')" type="button" class="close pull-right" aria-label="Close">
                          <i class="fa fa-times" aria-hidden="true" style="padding: 0px 0px 10px 10px;"></i>
                      </button>
                      <div class='row'>
                          <div class='col-md-12'>
                             <div class="form-group">
							<label style='font-weight: normal'><?=Language('_tariff')?></label>
							<select class='form-control' v-model='modal_order_tariff'>
								<option value='lite'><?=Language('_lite')?></option>
								<option value='standart'><?=Language('_standard')?></option>
								<option value='full'><?=Language('_full')?></option>
                               </select>
                           </div>
                       </div>
                       <div class='col-md-12'>
                         <div class="form-group">
                            <label style='font-weight: normal'><?=Language('_domain')?></label>
                            <input type="text" class="form-control" autocomplete='off' v-model="modal_order_domain" />
                        </div>
                    </div>
                    <div class='col-md-12'>
                     <div class="form-group">
                        <label style='font-weight: normal'><?=Language('_your_name')?></label>
                        <input type="text" class="form-control" autocomplete='off' v-model="modal_order_name" />
                    </div>
                </div>
                <div class='col-md-12'>
                 <div class="form-group">
                    <label style='font-weight: normal'><?=Language('_telegram')?></label>
                    <input type="text" class="form-control" autocomplete='off' placeholder="@login" v-model="modal_order_telegram" />
                </div>
            </div>
            <div class='col-md-12'>
             <div class="form-group">
                <label style='font-weight: normal'><?=Language('_email')?></label>
                <input type="text" class="form-control" autocomplete='off' v-model="modal_order_email" />
            </div>
        </div>
        <div class='col-md-12'>
         <div class="form-group">
            <label style='font-weight: normal'><?=Language('_questions')?></label>
            <textarea class="form-control" rows="8" v-model="modal_order_comment"></textarea>
        </div>
    </div>
    <div class='col-md-12'>
     <div class="form-group">
        <div class="text-danger" v-if="modal_order_error_text">
           {{modal_order_error_text}}
       </div>
   </div>
</div>
<div class='col-md-12'>
 <button type="button" class="btn btn-mod btn-medium btn-round pull-left" @click="modal_order_submit" :disabled="modal_order_submit_clicked">
    <span><?=Language('_send_request')?></span>
</button>
</div>
</div>
</div>
</div>
</modal>
<modal name="modal_order_success" width="300" height="auto" classes="bg-success" :adaptive="true" :scrollable="true">
 <div style="padding: 40px; text-align: center; color: black">
    <h3><?= Language('_application_sent') ?></h3>
</div>
</modal>
</section>
<script type="text/javascript" src="https://wiq.by/theme/js/jquery-1.11.2.min.js"></script>

<script type="text/javascript">
 
    $(document).ready(function () {

        $('.but_order').click(function () {
            ym(77586568, 'reachGoal', 'BUT_ORDER');
        });
    });

    function timer(f_time) {
        function timer_go() {
            var n_time = Date.now();
            var diff = f_time - n_time;
            if (diff <= 0)
                return false;
            var left = diff % 1000;

            //секунды
            diff = parseInt(diff / 1000);
            var s = diff % 60;
            if (s < 10) {
                $(".seconds_1").html(0);
                $(".seconds_2").html(s);
            } else {
                $(".seconds_1").html(parseInt(s / 10));
                $(".seconds_2").html(s % 10);
            }

            //минуты
            diff = parseInt(diff / 60);
            var m = diff % 60;
            if (m < 10) {
                $(".minutes_1").html(0);
                $(".minutes_2").html(m);
            } else {
                $(".minutes_1").html(parseInt(m / 10));
                $(".minutes_2").html(m % 10);
            }

            //часы
            diff = parseInt(diff / 60);
            var h = diff % 24;
            if (h < 10) {
                $(".hours_1").html(0);
                $(".hours_2").html(h);
            } else {
                $(".hours_1").html(parseInt(h / 10));
                $(".hours_2").html(h % 10);
            }

            //дни
            var d = parseInt(diff / 24);
            if (d < 10) {
                $(".days_1").html(0);
                $(".days_2").html(d);
            } else {
                $(".days_1").html(parseInt(d / 10));
                $(".days_2").html(d % 10);
            }

            setTimeout(timer_go, left);
        }

        setTimeout(timer_go, 0);
    }

    $(document).ready(function () {
        var time = $(".timer").attr("data-finish");

        timer(time);
    });


</script>
<script src="https://wiq.by/theme/js/vue/vue-2.6.12.min.js?8" type="text/javascript"></script>
<script src="https://wiq.by/theme/js/axios.min.js"></script>
<script src="https://wiq.by/theme/js/vue/vue2-datepicker/vue2-datepicker.lib.js"></script>
<link href="https://wiq.by/theme/js/vue/vue-js-modal/styles.css?3" rel="stylesheet">
<script src="https://wiq.by/theme/js/vue/vue-js-modal/index.js"></script>
<script type="text/javascript">
  Vue.use(DatePicker.default);
  Vue.use(window["vue-js-modal"].default);

  const getLang = '<?=$lang?>';

  var app = new Vue({
     el: '#app',
     data: {
        base_url: null,
        user_id: null,
        modal_order_tariff: '',
        modal_order_user_id: null,
        modal_order_name: '',
        modal_order_domain: '',
        modal_order_telegram: '',
        modal_order_email: '',
        modal_order_comment: '',
        modal_order_submit_clicked: false,
        modal_order_error_text: '',

        modal_error_text: ''
    },
    watch: {

    },
    computed: {

    },
    filters: {
        to_fixed: function(v) {
           if(!v) {
              return '';
          }

          var value = parseFloat(v);

          return value.toFixed(0);
      },
      json_br: function(v) {
       if(v) {
          return v.replace(/\n/g, "<br>");
      }

      return v;
  }
},
created: function () {
    this.base_url = window.base_url;
    this.user_id = '<?= $UserID; ?>';

    this.modal_order_user_id = this.user_id;
    this.modal_order_email = '<?= $UserEmail; ?>';
},
mounted: function () {
    console.log(window.user_id);
},
methods: {
    order: function(tariff = null) {
       if(tariff) {
          this.modal_order_tariff = tariff;
      }

      this.$modal.show('modal_order');
  },
  modal_order_create_clear: function() {
   this.modal_order_tariff = '';
   this.modal_order_name = '';
   this.modal_order_domain = '';
   this.modal_order_telegram = '';
   this.modal_order_email = '';
   this.modal_order_comment = '';
   this.modal_order_submit_clicked = false;
   this.modal_order_error_text = '';
},
modal_order_submit_error: function(error_text, obj) {
   this.modal_order_error_text = error_text;
   this.modal_order_submit_clicked = false;

   if(obj) {
      console.log(error_text, obj);
  }
},
modal_order_submit: function() {
   var _this = this;
   this.modal_order_submit_clicked = true;

   if(!this.user_id) {
      this.modal_order_error_text = 'Зарегистрируйтесь на сайте';
      this.modal_order_submit_clicked = false;

      return false;
  }

  if(!this.modal_order_tariff) {
if (getLang=='ru') { this.modal_order_error_text = 'Выберите тариф'; }
if (getLang=='en') { this.modal_order_error_text = 'Select tariff'; }   
if (getLang=='ua') { this.modal_order_error_text = 'Виберіть тариф'; }  
      this.modal_order_submit_clicked = false;

      return false;
  }

  if(!this.modal_order_telegram && !this.modal_order_email) {
if (getLang=='ru') { this.modal_order_error_text = 'Укажите телеграм или емейл'; }
if (getLang=='en') { this.modal_order_error_text = 'Enter telegram or email'; }   
if (getLang=='ua') { this.modal_order_error_text = 'Вкажіть телеграм або емейл'; } 
      this.modal_order_submit_clicked = false;

      return false;
  }

  var formData = new FormData();
  formData.append('tariff', this.modal_order_tariff);
  formData.append('name', this.modal_order_name);
  formData.append('domain', this.modal_order_domain);
  formData.append('telegram', this.modal_order_telegram);
  formData.append('email', this.modal_order_email);
  formData.append('comment', this.modal_order_comment);

  axios.post(this.base_url + 'tickets/api.php?lang=' + getLang + '&action=createFranschise', formData).then(function (response) {
      if(response.data.status === true) {
         _this.$modal.hide('modal_order');
         _this.modal_order_create_clear();
         _this.$modal.show('modal_order_success');
     } else {
         _this.modal_order_submit_error(response.data.data, response.data.data);
     }
 })
  .catch(function (error) {
      _this.modal_order_submit_error('Ошибка HTTP', error);
  });
},

json_br: function(v) {
   return v.replace(/\n/g, "<br>");
},

modal_error: function(error_text, error_obj) {
   console.log(error_obj);
   this.modal_error_text = error_text;
   this.$modal.show('modal_error');
}
},
directives: {
    'input-focus': function (el, binding) {
       Vue.nextTick(function() {
          el.focus();
                    //console.log(el);
      });
   }
}
});
</script>
<?php
	require_once('files/footer.php');
?>
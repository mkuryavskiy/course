<?php
require_once('files/header.php');

$user->IsLogged();
?>
<style>
	.generate-api {
		text-decoration: none;
		color: #1A315C;
		box-shadow: 0px 0px 5px 0px #f0f0f0;
	}

	.generate-api:hover {
		text-decoration: none;
		cursor: pointer;
		color: #1F1A5C;
	}
</style>
<section class="page-section" id="settings">
	<div class="row center-block">
		<div class="container">
			<h1 class="section-title font-alt" style="margin-bottom: 40px;"><?= Language('_profile_settings') ?></h1>
			<div class="col-sm-6 mb-70">
				<div class="form-group">
					<div class="form-tip"><?= Language('_email') ?></div>
					<input type="text" value="<?php echo ($UserEmail); ?>" class="input-md round form-control def-text" readonly>
				</div>

				<div class="form-group">
					<div class="form-tip"><?= Language('_telegram') ?></div>
					<div class="input-group">
						<input type="text" id="set-telegram" value="<?php echo ($UserTelegram); ?>" class="input-md round form-control def-text" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;">
						<span class="input-group-addon" style="padding: 0 1.5rem;" onclick="saveTelegram()">
							<font id="btn-set-telegram" class="copy-api" data-clipboard-target="#set-telegram">
								<?= Language('_save') ?>
							</font>
						</span>
					</div>
				</div>

				<div class="form-tip"><?= Language('_api_key') ?></div>
				<div class="input-group">
					<input type="text" id="user-api" value="<?php echo ($UserAPI); ?>" class="input-md round form-control def-text" style="border-top-right-radius: 0 !important; border-bottom-right-radius: 0 !important;" readonly>
					<span class="input-group-addon" onclick="copyClipboard('user-api')">
						<font class="copy-api" data-clipboard-target="#user-api">
							<?= Language('_copy') ?>
						</font>
					</span>
				</div>
				<a onClick="generateNewAPI();" class="generate-api"><?= Language('_generate_new') ?></a>
			</div>
			<div class="col-sm-6 mb-70">
				<form method="POST" id="update-password" onsubmit="event.preventDefault(); updatePassword();">
					<div class="form-group">
						<div class="form-tip"><?= Language('_old_password') ?></div>
						<input type="password" name="current-password" class="input-md round form-control def-text" required autocomplete="off" placeholder="<?= Language('_old_password') ?>">
					</div>
					<div class="form-group">
						<div class="form-tip"><?= Language('_new_password') ?></div>
						<input type="password" name="new-password" class="input-md round form-control def-text" required autocomplete="off" placeholder="<?= Language('_new_password') ?>">
					</div>
					<div class="form-group">
						<div class="form-tip"><?= Language('_repeat_new_password') ?></div>
						<input type="password" name="repeat-new-password" class="input-md round form-control def-text" required autocomplete="off" placeholder="<?= Language('_repeat_new_password') ?>">
					</div>
					<div class="form-group pull-right">
						<button class="btn btn-mod btn-border btn-large btn-round"><?= Language('_update_password') ?></button>
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
<?php
require_once('files/footer.php');
?>
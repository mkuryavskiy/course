<?php
	require_once('files/header.php');

	if(isset($_SESSION['auth'])) {
		$layer->redirect('index.php');
	}
?>
<section class="page-section">
	<div class="container relative">
		<div class="align-center mb-40 mb-xxs-30">
			<ul class="nav nav-tabs tpl-minimal-tabs">
				<li class="active">
					<a href="#mini-one" data-toggle="tab">Восстановление пароля</a>
				</li>
			</ul>
		</div>
		<div class="tab-content tpl-minimal-tabs-cont section-text">
			<div class="tab-pane fade in active" id="mini-one">
				<div class="row">
					<div class="col-md-4 col-md-offset-4">
						<form class="form contact-form" id="restore" onsubmit="event.preventDefault(); restore();" method="POST">
							<div class="clearfix">
								<div class="form-group">
									<input type="email" name="email" id="email" class="input-md round form-control def-text" placeholder="E-mail" required>
								</div>
								<div class="form-group">
									<input type="text" name="norobot" id="code" style="width: 35%" autocomplete="off" class="input-md round form-control def-text" placeholder="Код с картинки" required>
									<img src="captcha.php" id='capcha-image'>
									<a style="text-decoration: none; border-bottom: 1px dashed #f00; color: #f00; cursor: pointer;" href="javascript:void(0);" onclick="document.getElementById('capcha-image').src='captcha.php?rid=' + Math.random();">Обновить</a>
								</div>
							</div>
							<div class="clearfix">
								<div class="cf-left-col">
									<div class="form-tip pt-20">
										<a href="login.php">Войти</a>
									</div>
								</div>
								<div class="cf-right-col">
									<div class="align-right pt-10">
										<button class="submit_btn btn btn-mod btn-medium btn-round" id="login-btn">Восстановить</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<?php
	require_once('files/footer.php');
?>

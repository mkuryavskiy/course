function subscribe(email) {
	$.ajax({
		type: "POST",
		url: "requests.php",
		data: 'action=subscribe&email='+email,
		cache: false,
		beforeSend: function(){
			$("#result").val('Подписка...');
		},
		success: function(data){
			if(data) {
				$('#result').html('<div class="text-danger">'+data+'</div>');
			} else {
				$('#result').html('<div class="text-success">Вы были успешно зарегистрированы!</div>');

				window.setTimeout(function () {
					location.href = "dashboard.php";
				}, 2500);
			}
		}
	});
}

function TakeFormData(FormID, FormAction, Message, Clear, Timeout, Highlight, Out) {
	var formData = $(FormID).serialize();
	var dataString = formData+'&action='+FormAction;
	var $btn_submit = $(FormID).find('input[type=submit]');
	var btn_submit_text = $btn_submit.val();
	
	Clear = Clear || true;
	Timeout = Timeout || 0;
	Highlight = Highlight || false;
	Out = Out || false;

	if($(FormID+"-result").length === 0) {
		if(Out == true)
			$(FormID).parent().after("<div id='"+FormAction+"-result'></div>");
		else
			$(FormID).append("<div id='"+FormAction+"-result' style='margin-top: 10px;'></div>");
	}

	$.ajax({
		type: "POST",
		url: "requests.php",
		data: dataString,
		cache: false,
		beforeSend: function(){
			$('#'+FormAction + '-result').val('Подождите..');
			$btn_submit.attr("disabled", true).val("Загрузка...");
		},
		success: function(data){
			if(data) {
				if(Highlight == false) {
					$('#'+FormAction + '-result').html('<div class="text-danger">'+data+'</div>');
				} else {
					$('#'+FormAction + '-result').html('<div class="text-danger"><mark>'+data+'</mark></div>');
				}
			} else {
				if(Highlight == false) {
					$('#'+FormAction + '-result').html('<div class="text-success" style="font-weight: bolder; font-size: 14px;">'+Message+'</div>');
				} else {
					$('#'+FormAction + '-result').html('<div class="text-success" style="font-weight: bolder; font-size: 14px;"><mark>'+Message+'</mark></div>');
				}
				if(Clear == true) {
					$(FormID).trigger("reset");
					$('select').prop('selectedIndex', 0);
				}
			}

			if(Timeout != 0) {
				$('#'+FormAction + '-result').delay(5000).fadeOut(Timeout, function() {
					this.remove();
				});
			}

			if(FormAction == 'new-order') {
				$("#support").load(location.href + " #support");
			}
		},
		complete: function() {
			$btn_submit.attr("disabled", false).val(btn_submit_text);
		}
	});
}


function login() {
	const captcha = captchaValidator(0)
    if (captcha) {
        TakeFormData('#login', 'login', 'Добро пожаловать.', true, 3000);
    }
}

function register() {
    const captcha = captchaValidator(1)
    if (captcha) {
        TakeFormData('#register', 'register', 'Ваш аккаунт был успешно создан.', true, 3000);
    }
}

function restore() {
	TakeFormData('#restore', 'restore', 'Вам отправлен новый пароль.', true, 3000);
}

function lock() {
	TakeFormData('#lock', 'lock', 'Добро пожаловать.', true, 3000, true, true);
}

function userSupport() {
	TakeFormData('#user-support', 'user-support', 'Ваше сообщение отправлено.', true, 3000);
}

function newOrder() {
	$("#service-description").css({"margin-top": "0"});
	TakeFormData('#new-order', 'new-order', 'Ваш заказ принят.', true, 3000);
	getBalance();
}

function updatePassword() {
	TakeFormData('#update-password', 'update-password', 'Пароль успешно изменен.', true, 3000);
}

function updateSkype() {
	TakeFormData('#update-skype', 'update-skype', 'Телефон изменен.', true, 3000);
}

function updateInstagram() {
	TakeFormData('#update-instagram', 'update-instagram', 'Instagram изменен.', true, 3000);
}

function captchaValidator(widget_id=0) {
	var captcha = grecaptcha.getResponse(widget_id);
	
	if (!captcha.length) {
		$('#recaptchaError1').text('Не пройдена проверка CAPTCHA');
		$('#recaptchaError2').text('Не пройдена проверка CAPTCHA');
	} else {
		$('#recaptchaError1').text('');
		$('#recaptchaError2').text('');
	}

	return captcha.length
}

function copyClipboard(target) {
	var target = $('#' + target);

	target.focus();
	target.select();

	document.execCommand("copy");
}

function saveTelegram() {
	$.ajax({
		type: "POST",
		url: "requests.php",
		data: 'action=sava_talegram&telegram='+$("#set-telegram").val(),
		cache: false,
		beforeSend: function(){
			$("#btn-set-telegram").html('Сохраняем...');
		},
		success: function(data){
			console.log(data);
			if(data > 0) {
				$("#set-telegram").attr('readonly', 'readonly')
				$('#btn-set-telegram').html('Готово');
			} else {
				$('#btn-set-telegram').html('Ошибка');
			}
		}
	});
}

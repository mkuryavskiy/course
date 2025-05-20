function TakeFormData(FormID, FormAction, Message, Clear, Timeout) {
	console.log('111+');

	var formData = $(FormID).serialize();
	var dataString = formData+'&action='+FormAction;
	Clear = Clear || false;
	Timeout = Timeout || 0;

	if($(FormID+"-result").length === 0) {
		$(FormID).append("<div id='"+FormAction+"-result'></div>");
		$('#NEWSQuestion').val('');
	} else {
		$(FormID).append("<div id='"+FormAction+"-result'></div>");
		$('#'+FormAction+'-result').remove();
		$('#NEWSQuestion').val('');
	}

	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: dataString,
		cache: false,
		beforeSend: function(){
			$('#'+FormAction + '-result').val('Please wait..');
		},
		success: function(data){
			console.log(data);
			if(data) {
				$('#'+FormAction + '-result').html('<div class="text-danger">'+data+'</div>');
			} else {
				$('#'+FormAction + '-result').html('<div class="text-success">'+Message+'</div>');
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
		}
	});
}









function CategoryEdit(CategoryID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-category-details&CategoryID='+CategoryID,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);

				$('#EditCategoryID').val(CategoryID);
				$('#EditCategoryName').val(obj.CategoryName);
				$('#EditCategoryNameUA').val(obj.CategoryNameUA);
				$('#EditCategoryNameEN').val(obj.CategoryNameEN);
				$('#EditCategoryDescription').val(obj.CategoryDescription);
				$('#EditCategoryDescriptionUA').val(obj.CategoryDescriptionUA);
				$('#EditCategoryDescriptionEN').val(obj.CategoryDescriptionEN);
				$('#EditCategoryActive').val(obj.CategoryActive);
				$('#EditCategoryActive').html(obj.CategoryActive === "Yes" ? "Активна" : "Выключена");
			}
		}
	});

	$("#edit-category-modal").modal();
}

function ChangeLiqpayModal() {
	$("#changeLiqpay-modal").modal();
}

function save_liqpay_settings()
{
	var l_private      = $('#liqpay_private').val();
			l_public       = $('#liqpay_public').val();
			l_comission    = $('#liqpay_comission').val();
	$.ajax({
			type: "POST",
			url:  "/liqpay_create.php",
			data:
			{
				 change_settings: '1',
				 private: l_private,
				 public: l_public,
				 comission: l_comission
			 },
			success: function(html)
			{
				$('#liqpay_result').html(html);
			}
	});
}

function CategoryDelete() {
	TakeFormData('#save-category', 'delete-category', 'Category was deleted.', false, 1500);
	$('#categories').dataTable()._fnAjaxUpdate();

	$(function () {
		$('#edit-category-modal').modal('toggle');
	});
}

function CategorySave() {
	TakeFormData('#save-category', 'save-category', 'Category was saved successfully.', false, 1500);
	$('#categories').dataTable()._fnAjaxUpdate();
}

function CategoryCreateModal() {
	$("#create-category-modal").modal();
}

function CategoryCreate() {
	TakeFormData('#create-category', 'create-category', 'Category is successfully created.', false, 1500);
	$('#categories').dataTable()._fnAjaxUpdate();
}

function NewsCreateModal() {
	$("#add-news-modal").modal();
}

function NewsDelete() {
	TakeFormData('#save-news', 'delete-news', 'New was deleted.', false, 1500);

	$('#news').dataTable()._fnAjaxUpdate();

	$(function () {
		$('#edit-news-modal').modal('toggle');
	});
}

function NewsSave() {
	TakeFormData('#save-news', 'save-news', 'New was saved successfully.', false, 1500);
	$('#news').dataTable()._fnAjaxUpdate();
}

function NewsEdit(NewsID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-news-details&NewsID='+NewsID,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);

				$('#EditNewID').val(NewsID);
				$('#EditNewTitle').val(obj.NewTitle);
				$('#EditNewIcon').val(obj.NewIcon);
				$('#EditNewContent').val(obj.NewContent);
				tinyMCE.activeEditor.setContent(obj.NewContent);
			}
		}
	});

	$("#edit-news-modal").modal();
}

function NewsAdd() {
	TakeFormData('#add-news', 'add-news', 'New is successfully created.', false, 1500);
	$('#news').dataTable()._fnAjaxUpdate();
}



function ServiceCreateModal() {
	$("#create-service-modal").modal();
}

function ServiceCreate() {
	TakeFormData('#create-service', 'create-service', 'Service is successfully created.', false, 1500);
	$('#services').dataTable()._fnAjaxUpdate();
}

function ServiceEdit(ServiceID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-service-details&ServiceID='+ServiceID,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);

				$('#EditServiceID').val(ServiceID);
				$('#EditServiceName').val(obj.ServiceName);
				$('#EditServiceNameUA').val(obj.ServiceNameUA);
				$('#EditServiceNameEN').val(obj.ServiceNameEN);
				$('#EditServiceDescription').val(obj.ServiceDescription);
				$('#EditServiceDescriptionUA').val(obj.ServiceDescriptionUA);
				$('#EditServiceDescriptionEN').val(obj.ServiceDescriptionEN);
				$('#EditServiceCategoryID').val(obj.ServiceCategoryID);
				$('#EditServiceCategoryID').html(obj.ServiceCategoryName);
				$('#EditServiceAPI').val(obj.ServiceAPI);
				$('#EditServiceOrderAPI').val(obj.ServiceOrderAPI);
				$('#EditServiceType').val(obj.ServiceType);
				$('#EditServiceType').html(obj.ServiceType);
				$('#EditServicePrice').val(obj.ServicePrice);
				$('#EditServiceMinQuantity').val(obj.ServiceMinQuantity);
				$('#EditServiceMaxQuantity').val(obj.ServiceMaxQuantity);
				$('#EditServiceResellerPrice').val(obj.ServiceResellerPrice);
				$('#EditServiceActive').val(obj.ServiceActive);
				$('#EditServiceActive').html(obj.ServiceActive === "Yes" ? "Активна" : "Выключена");

				$('#EditServiceCancel').val( obj.cancel==1 ? "Yes" : "No");
				$('#EditServiceCancel').html(obj.cancel==1 ? "Да" : "Нет");
				$('#EditServiceRefill').val( obj.refill==1 ? "Yes" : "No");
				$('#EditServiceRefill').html(obj.refill==1 ? "Да" : "Нет");
				$('#EditServiceRefillDuration').val(obj.refill_duration);
			}
		}
	});

	$("#edit-service-modal").modal();
}

function ServiceSave() {
	//console.log('111');
	TakeFormData('#save-service', 'save-service', 'Service was saved successfully.', false, 1500);
	$('#services').dataTable()._fnAjaxUpdate();
}

function ServiceDelete() {
	TakeFormData('#save-service', 'delete-service', 'Service was deleted.', false, 1500);
	$('#services').dataTable()._fnAjaxUpdate();

	$(function () {
		$('#save-service-modal').modal('toggle');
	});
}

function WhitelistCreateModal() {
	$("#add-whitelist-modal").modal();
}

function WhitelistAdd() {
	TakeFormData('#add-whitelist', 'add-whitelist', 'Targeted IP address was saved successfully whitelisted.', false, 1500);
	$('#whitelist').dataTable()._fnAjaxUpdate();
}

function WhitelistEdit(WhitelistIPID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-whitelist-details&WhitelistIPID='+WhitelistIPID,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);

				$('#EditWhitelistID').val(WhitelistIPID);
				$('#EditWhitelistIPAddress').val(obj.WhitelistIPAddress);
			}
		}
	});

	$("#edit-whitelist-modal").modal();
}

function WhitelistSave() {
	TakeFormData('#save-whitelist', 'save-whitelist', 'Whitelisted IP was saved successfully.', false, 1500);
	$('#whitelist').dataTable()._fnAjaxUpdate();
}

function WhitelistDelete() {
	TakeFormData('#save-whitelist', 'delete-whitelist', 'Whitelisted IP was deleted.', false, 1500);

	$(function () {
		$('#save-whitelist-modal').modal('toggle');
	});

	$('#whitelist').dataTable()._fnAjaxUpdate();
}

function BlacklistCreateModal() {
	$("#add-blacklist-modal").modal();
}

function BlacklistAdd() {
	TakeFormData('#add-blacklist', 'add-blacklist', 'Targeted IP address was saved successfully blacklisted.', false, 1500);
	$('#blacklist').dataTable()._fnAjaxUpdate();
}

function BlacklistEdit(BlacklistID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-blacklist-details&BlacklistID='+BlacklistID,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);

				$('#EditBlacklistID').val(BlacklistID);
				$('#EditBlacklistIP').val(obj.BannedIP);
				$('#EditBlacklistExpireDate').val(obj.BannedExpireDateFormat);
			}
		}
	});

	$("#edit-blacklist-modal").modal();
}

function BlacklistSave() {
	TakeFormData('#save-blacklist', 'save-blacklist', 'Blacklisted IP was saved successfully.', false, 1500);
	$('#blacklist').dataTable()._fnAjaxUpdate();
}

function BlacklistDelete() {
	TakeFormData('#save-blacklist', 'delete-blacklist', 'Blacklisted IP was deleted.', false, 1500);

	$(function () {
		$('#edit-blacklist-modal').modal('toggle');
	});

	$('#blacklist').dataTable()._fnAjaxUpdate();
}

function UserCreateModal() {
	$("#create-user-modal").modal();
}

function UserCreate() {
	TakeFormData('#create-user', 'create-user', 'User is successfully created.', false, 1500);
	$('#users').dataTable()._fnAjaxUpdate();
}

function UserEdit(UserID) {
    $.ajax({
        type: "POST",
        url: "modal-requests.php",
        data: 'action=get-user-details&UserID='+UserID,
        cache: false,
        success: function(data){
            if(data) {
                var obj = jQuery.parseJSON(data);
                console.log(obj);
                $('#EditUserID').val(UserID);
                $('#EditUserName').val(obj.UserName);
                $('#EditUserEmail').val(obj.UserEmail);
                $('#EditUserGroup').val(obj.UserGroup);
                $('#EditUserGroup').html(obj.UserGroup);
                $('#EditUserAPI').val(obj.UserAPI);
                $('#EditUserBalance').val(obj.UserBalance);
                $('#EditUserTelegram').val(obj.UserTelegram);
            }
        }
    });
    $("#edit-user-modal").modal();
}

function UserDelete(UserID) {
	if (confirm('Вы действительно хотите удалить пользователя?')) {
		$.ajax({
			type: "POST",
			url: "modal-requests.php",
			data: 'action=delete-user&UserID='+UserID,
			cache: false,
			success: function(data){
				if(data) {
					$('#users').dataTable()._fnAjaxUpdate();
				}
			}
		});

	}
}


function UserSave() {
	TakeFormData('#save-user', 'save-user', 'User was saved successfully.', false, 1500);
	$('#users').dataTable()._fnAjaxUpdate();
}

function UserBan() {
	TakeFormData('#save-user', 'ban-user', 'User was banned.', false, 1500);
	$('#users').dataTable()._fnAjaxUpdate();
}

function UserCreate() {
	TakeFormData('#create-user', 'create-user', 'User was registered.', false, 1500);
	$('#users').dataTable()._fnAjaxUpdate();
}

function UserUnban(UserID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=unban-user&UserID='+UserID,
		cache: false,
		success: function(data){
			$('#users-banned').dataTable()._fnAjaxUpdate();
		}
	});
}

function UserDelete() {
	TakeFormData('#save-user', 'delete-user', 'User was deleted.', false, 1500);
	$('#services').dataTable()._fnAjaxUpdate();

	$(function () {
		$('#edit-user-modal').modal('toggle');
	});

	$('#users').dataTable()._fnAjaxUpdate();
}


// Individual Prices

function IPCreateModal() {
	$("#add-ip-modal").modal();
}

function IPAdd() {
	TakeFormData('#add-ip', 'add-ip', 'Indivudal price was successfully added.', false, 1500);
	$('#individual-prices').dataTable()._fnAjaxUpdate();
}

function IPEdit(IPID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-ip-details&IPID='+IPID,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);

				$('#EditIPID').val(IPID);
				$('#EditIPUserID').val(obj.IPUserName);
				$('#EditIPServiceID').val(obj.IPServiceName);
				$('#EditIPServiceID').html(obj.IPServiceName);
				$('#EditIPPrice').val(obj.IPPrice);
			}
		}
	});

	$("#edit-ip-modal").modal();
}

function IPSave() {
	TakeFormData('#save-ip', 'save-ip', 'Individual price was saved successfully.', false, 1500);
	$('#individual-prices').dataTable()._fnAjaxUpdate();
}

function IPDelete() {
	TakeFormData('#save-ip', 'delete-ip', 'Individual price was deleted.', false, 1500);

	$(function () {
		$('#edit-ip-modal').modal('toggle');
	});

	$('#individual-prices').dataTable()._fnAjaxUpdate();
}

// Deposits

function DepositDelete(DepositID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=delete-deposit&DepositID='+DepositID,
		cache: false,
		success: function(data){}
	});

	$('#deposits').dataTable()._fnAjaxUpdate();
}

function DepositUpdate(DepositID, DepositRefunded) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=update-deposit&DepositID='+DepositID+'&DepositRefunded='+DepositRefunded,
		cache: false,
		success: function(data){}
	});

	$('#deposits').dataTable()._fnAjaxUpdate();
}

// NEWS

function NEWSCreateModal() { // header 154
	$("#add-News-modal").modal();
}


function NEWSCreate() { // modals 789
	TakeFormData('#add-News', 'add-News', 'NEWS was successfully added.', false, 1500);
	$('#News').dataTable()._fnAjaxUpdate();
}


function NEWSEdit(NEWSID) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-News-details&NEWSID='+NEWSID,
		cache: false,
		success: function(data){
			if(data) {
				let object = jQuery.parseJSON(data);

				$('#EditNEWSID').val(NEWSID);
				$('#EditNEWSQuestion').val(object.NEWSQuestion);
				$('#EditNEWSQuestionUA').val(object.NEWSQuestionUA);
				$('#EditNEWSQuestionEN').val(object.NEWSQuestionEN);
				$('#EditNEWSAnswer').val(object.NEWSAnswer); // <------------------
				$('#EditNEWSAnswerUA').val(object.NEWSAnswerUA); // <------------------
				$('#EditNEWSAnswerEN').val(object.NEWSAnswerEN); // <------------------
				if (parseInt(object.specshow) == 1) {
					$('#editspecshow').prop('checked', true);
				} else {
					$('#editspecshow').prop('checked', false);

				}
			}
		}
	});

	$("#edit-News-modal").modal();
	$('#NEWSQuestion').val('');
	$('#NEWSAnswer').val('');
	$('#NEWSQuestionEN').val('');
	$('#NEWSAnswerEN').val('');
	$('#specshow').prop('checked', false);
}



function NEWSSave() {
	TakeFormData('#save-News', 'save-News', 'News was saved successfully.', false, 1500);
	$('#News').dataTable()._fnAjaxUpdate();
}

function NEWSDelete() {
	TakeFormData('#save-News', 'delete-News', 'News was deleted.', false, 1500);

	$(function () {
		$('#edit-News-modal').modal('toggle');
	});

	$('#News').dataTable()._fnAjaxUpdate();
}


// NEWS
var txt = $("#EditServiceResellerPrice").val();
if (typeof txt != "undefined") {
	txt.replace(/[.]/g, ",");
	$("#EditServiceResellerPrice").val(txt);

}

function update_create_modal() {
	$("#add-update-modal").modal();
}

function update_create() {
	TakeFormData('#add-update', 'add-update', 'Обновление успешно добавлено', false, 1500);
	$('#updates').dataTable()._fnAjaxUpdate();
}

function update_edit(id) {
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-update-details&id='+id,
		cache: false,
		success: function(data){
			if(data) {
				var obj = jQuery.parseJSON(data);
console.log(obj);
				$('#update-edit-id').val(id);
				$('#update-edit-service').val(obj.service);
				$('#update-edit-changes').val(obj.changes);
				$('#update-edit-serviceEN').val(obj.serviceEN);
				$('#update-edit-changesEN').val(obj.changesEN);
				$('#update-edit-serviceUA').val(obj.serviceUA);
				$('#update-edit-changesUA').val(obj.changesUA);
			}
		}
	});

	$("#edit-update-modal").modal();
}

function update_save() {
	TakeFormData('#save-update', 'save-update', 'Обновление успешно сохранено', false, 1500);
	$('#updates').dataTable()._fnAjaxUpdate();
}

function update_delete() {
	TakeFormData('#save-update', 'delete-update', 'Обновление удалено', false, 1500);

	$(function () {
		$('#edit-update-modal').modal('toggle');
	});

	$('#updates').dataTable()._fnAjaxUpdate();
}






function OtzyvCreateModal() {
	$("#add-otzyv-modal").modal();
}

function OtzyvCreate() {
	TakeFormData('#add-otzyv', 'add-otzyv', 'Otzyv was successfully added.', false, 1500);
	$('#otzyv').dataTable()._fnAjaxUpdate();
}

function OtzyvEdit(CommentsID) {
	console.log(CommentsID);
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-otzyv-details&CommentsID='+CommentsID,
		cache: false,
		success: function(data){
			if(data) {
				var objectes = jQuery.parseJSON(data);
				console.log(objectes);



				// Считаем длину строк
				let optionsSizeA = objectes.comments_answer;
				console.log(optionsSizeA.split(" ").length);

				let commentsAnswerSizeA;
				if (optionsSizeA.split(" ").length < 76 || optionsSizeA.split(" ").length == 187) commentsAnswerSizeA = 0;
				if (optionsSizeA.split(" ").length == 76) commentsAnswerSizeA = 1;
				if (optionsSizeA.split(" ").length == 77) commentsAnswerSizeA = 2;
				if (optionsSizeA.split(" ").length == 78) commentsAnswerSizeA = 3;
				if (optionsSizeA.split(" ").length == 79) commentsAnswerSizeA = 4;
				if (optionsSizeA.split(" ").length == 80) commentsAnswerSizeA = 5;
				if (optionsSizeA.split(" ").length > 80) console.log("Ошибка базы данных! файл - main-modals.js");

				$('#edit-comments-id').val(CommentsID);
				$('#edit-comments-title').val(objectes.comments_title);
				$('#edit-comments-name').val(objectes.comments_name);
				$('#edit-comments-answer').val(objectes.comments_answer);

				$('#edit-comments-active').val(objectes.comments_answer);
				$('#edit-comments-active').html(commentsAnswerSizeA);

				// $('#edit-comments-active').val(objectes.comments_answer);
				// $('#edit-comments-active').val(objectes.comments_answer==1 ? '1' : '2');
				// $('#edit-comments-active').html(objectes.comments_answer==1 ? '1' : '2');


			}
		}
	});

	$("#edit-otzyv-modal").modal();
}

function OtzyvSave() {
	TakeFormData('#save-otzyv', 'save-otzyv', 'Otzyv was saved successfully.', false, 1500);
	$('#otzyv').dataTable()._fnAjaxUpdate();
}




function OtzyvDelete() {
	TakeFormData('#save-otzyv', 'delete-otzyv', 'Otzyv was deleted.', false, 1500);

	$(function () {
		$('#edit-otzyv-modal').modal('toggle');
	});

	$('#otzyv').dataTable()._fnAjaxUpdate();
}

function OtzyvAdded() {
	TakeFormData('#save-otzyv', 'added-otzyv', 'Otzyv was saved successfully.', false, 1500);
	$('#otzyv').dataTable()._fnAjaxUpdate();
}
// Редактирование отзыва ADD, который на странице отзывов
function OtzyvAddEdit(CommentsID) {
	// console.log(CommentsID);
	$.ajax({
		type: "POST",
		url: "modal-requests.php",
		data: 'action=get-otzyvAdd-details&CommentsID='+CommentsID,
		cache: false,
		success: function(data){
			if(data) {
				var objected = jQuery.parseJSON(data);
				// console.log(objected);

				// Считаем длину строк
				let optionsSize = objected.comments_answer;
				// console.log(optionsSize.split(" ").length);

				let commentsAnswerSize;
				if (optionsSize.split(" ").length < 76) commentsAnswerSize = 0;
				if (optionsSize.split(" ").length == 76) commentsAnswerSize = 1;
				if (optionsSize.split(" ").length == 77) commentsAnswerSize = 2;
				if (optionsSize.split(" ").length == 78) commentsAnswerSize = 3;
				if (optionsSize.split(" ").length == 79) commentsAnswerSize = 4;
				if (optionsSize.split(" ").length == 80) commentsAnswerSize = 5;
				if (optionsSize.split(" ").length > 80) console.log("Ошибка базы данных! файл - main-modals.js");

				$('#edit-commentsAdd-id').val(CommentsID);
				$('#edit-commentsAdd-title').val(objected.comments_title);
				$('#edit-commentsAdd-name').val(objected.comments_name);
				$('#edit-commentsAdd-active').val(objected.comments_answer);
				$('#edit-commentsAdd-active').html(commentsAnswerSize);

			}
		}
	});

	$("#edit-otzyvAdd-modal").modal();
}

function OtzyvAddSave() {
	TakeFormData('#save-otzyvAdd', 'save-otzyvAdd', 'Otzyv was saved successfully.', false, 1500);
	$('#otzyvAdd').dataTable()._fnAjaxUpdate();
}



function OtzyvAddDelete() {
	TakeFormData('#save-otzyvAdd', 'delete-otzyvAdd', 'Otzyv was deleted.', false, 1500);

	$(function () {
		$('#edit-otzyvAdd-modal').modal('toggle');
	});

	$('#otzyvAdd').dataTable()._fnAjaxUpdate();
}
// Редактирование отзыва ADD, который на странице отзывов

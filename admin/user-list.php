<?php
	require_once('files/header.php');
?>
	<section class="page-section">
		<div class="row col-lg-12 col-center m-t-10">
			<table id="users" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Користувач</th>
						<th>Email</th>
						<th>Група</th>
						<th>API ключ</th>
						<th>Баланс</th>
						<th>Дата реєстрації</th>
						<th>IP реєстрації</th>
						<th>Telegram</th>
                        <th>Редагувати</th>
                        <th>Видалити</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Користувач</th>
						<th>Email</th>
						<th>Група</th>
						<th>API ключ</th>
						<th>Баланс</th>
						<th>Дата реєстрації</th>
						<th>IP реєстрації</th>
						<th>Telegram</th>
                        <th>Редагувати</th>
                        <th>Видалити</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</section>
<?php
	require_once('files/footer.php');
?>
<script>
$(document).ready(function() {
    var table = $('#users').DataTable( {
      	"order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
		"scrollX": "200px",
        "deferRender": true,
        "ajax": "files/SSP/users.php"
    });
});

$(function(){
	$( "#EditUserBanExpireDate" ).datepicker();
});
</script>
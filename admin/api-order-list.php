<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center m-t-10">
			<table id="api-orders" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Сервис</th>
						<th>Пользователь</th>
						<th>Цена</th>
						<th>Кол-во</th>
						<th style="width: 220px;">Ссылка</th>
						<th>Время</th>
						<th>Остаток</th>
						<th>Было</th>
						<th>Статус</th>
						<th>Оформлено</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Сервис</th>
						<th>Пользователь</th>
						<th>Цена</th>
						<th>Кол-во</th>
						<th style="width: 220px;">Ссылка</th>
						<th>Время</th>
						<th>Остаток</th>
						<th>Было</th>
						<th>Статус</th>
						<th>Оформлено</th>
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
    var table = $('#api-orders').DataTable( {
        "processing": true,
        "serverSide": true,
		"scrollX": "200px",
        "scrollCollapse": true,
        "ajax": "files/SSP/api-orders.php"
    });
});
</script>
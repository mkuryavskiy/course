<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center m-t-10">
			<table id="in-process-orders" class="cell-border" cellspacing="0" width="100%">
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
    var table = $('#in-process-orders').DataTable( {
        "order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
		"scrollX": "200px",
        "scrollCollapse": true,
        "ajax": "files/SSP/in-process-orders.php"
    });
});
</script>
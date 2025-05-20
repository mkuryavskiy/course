<?php
	require_once('files/header.php');
	
	echo '<section class="page-section" style="overflow:auto;">';
		?>
			
		<div class="row col-lg-12 col-center m-t-10">
				<table id="all-user-orders" class="cell-border" cellspacing="0" width="100%">
					<thead>
						<tr>
							<th>ID</th>
							<th>Сервис</th>
							<th>Пользователь</th>
							<th>Цена</th>
							<th>Количество</th>
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
							<th>Количество</th>
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
			<script>
				$(document).ready(function() {
					var table = $('#all-user-orders').DataTable( {
						"processing": true,
						"serverSide": true,
						"ajax": "files/SSP/all-user-orders.php"
					});
			</script>
		<?php

	echo '</section>';
	
	require_once('files/footer.php');
?>
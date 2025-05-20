<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center m-t-10">
            <table id="all-orders" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Сервіс</th>
						<th>Користувач</th>
						<th>Ціна</th>
						<th>Кількість</th>
						<th style="width: 220px;">Посилання</th>
						<th>Час</th>
						<th>Залишок</th>
						<th>Було</th>
						<th>Статус</th>
						<th>Оформлено</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Сервіс</th>
						<th>Користувач</th>
						<th>Ціна</th>
						<th>Кількість</th>
						<th style="width: 220px;">Посилання</th>
						<th>Час</th>
						<th>Залишок</th>
						<th>Було</th>
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
    var table = $('#all-orders').DataTable( {
      	"order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/all-orders.php"
    });
});
</script>

<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center">
            <style>
                input[type=search] {
                    border-top: 1px solid #bbb !important;
                    box-shadow: none;
                }
            </style>
			<table id="completed-orders" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Послуга</th>
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
						<th>Послуга</th>
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
    var table = $('#completed-orders').DataTable({
        "order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "scrollX": "200px",
        "scrollCollapse": true,
        "ajax": "files/SSP/completed-orders.php",
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Ukrainian.json"
        }
    });
});
</script>
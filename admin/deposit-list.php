<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center m-t-10">
			<table id="deposits" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Користувач</th>
						<th>Статус</th>
						<th>Сума</th>
						<th>Метод оплати</th>
						<th>Повернути?</th>
						<th>Дата</th>
						<th>Видалити</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Користувач</th>
						<th>Статус</th>
						<th>Сума</th>
						<th>Метод оплати</th>
						<th>Повернути?</th>
						<th>Дата</th>
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
    var table = $('#deposits').DataTable( {
      	"order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/deposits.php"
    });
});
</script>

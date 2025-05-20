<?php
	require_once('files/header.php');
?>
<section class="page-section" style="overflow:auto;">
	<div class="row col-lg-12 col-center m-t-10">
		<table id="updates" class="cell-border" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Дата</th>
					<th>Послуга</th>
					<th>Зміни</th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Дата</th>
					<th>Послуга</th>
					<th>Зміни</th>
					<th></th>
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
    var table = $('#updates').DataTable({
        "processing": true,
        "serverSide": true,
        "bProcessing": true,
        "bServerSide": true,
        "order": [[0, "desc"]],
        "ajax": "files/SSP/updates.php"
    });

    // Автоматичне оновлення таблиці кожні 2 хвилини
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 120000);
});
</script>

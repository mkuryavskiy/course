<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center m-t-10">
			<table id="otzyv" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Коментар</th>
						<th>Ім’я</th>
						<th>Дата</th>
						<th>Зірки</th>
						<th>Редагувати</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Коментар</th>
						<th>Ім’я</th>
						<th>Дата</th>
						<th>Зірки</th>
						<th>Редагувати</th>
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
    var table = $('#otzyv').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/otzyvy.php"
    });

    // Сортування одразу за стовпцем ID (0) за спаданням
    table.order([[0, 'desc']]).draw();
});
</script>

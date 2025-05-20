<?php
	require_once('files/header.php');
?>
<section class="page-section" style="overflow:auto;">
	<div class="row col-lg-12 col-center m-t-10">
		<table id="News" class="cell-border" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
                    <th>Заголовок</th>
                    <th>Текст</th>
					<th>Створено</th>
					<th>Редагувати</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
                    <th>Заголовок</th>
                    <th>Текст</th>
					<th>Створено</th>
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
    var table = $('#News').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/news.php"
    });

    // Сортування одразу після завантаження
    table.order([[0, 'desc']]).draw();
});
</script>

<?php
	require_once('files/header.php');
?>
<section class="page-section" style="overflow:auto;">
	<div class="row col-lg-12 col-center m-t-10">
		<table id="services" class="cell-border" cellspacing="0" width="100%">
			<thead>
				<tr>
					<th>ID</th>
					<th>Назва</th>
					<th style="width: 280px !important;">Опис</th>
					<th>Категорія</th>
					<th>Створення замовлення API</th>
					<th>Перевірка замовлення API</th>
					<th>Тип</th>
					<th>Мінімум</th>
					<th>Максимум</th>
					<th>Ціна для реселерів</th>
					<th>Статус</th>
					<th>Створено</th>
					<th>Редагувати</th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<th>ID</th>
					<th>Назва</th>
					<th style="width: 280px !important;">Опис</th>
					<th>Категорія</th>
					<th>Створення замовлення API</th>
					<th>Перевірка замовлення API</th>
					<th>Тип</th>
					<th>Мінімум</th>
					<th>Максимум</th>
					<th>Ціна для реселерів</th>
					<th>Статус</th>
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
var currentDragRow;

$(document).ready(function() {
    var table = $('#services').DataTable({
        "order": [[0, "desc"]],
        "processing": true,
        "serverSide": true,
        "deferRender": true,
        "ajax": "files/SSP/services.php",
        "rowCallback": function(row, data) {
            $(row).prop('draggable', true);
            $(row).data('rowid', data[0]);

            $(row).on('dragstart', function(event) {
                currentDragRow = event.target;
            });

            $(row).on('dragover', function(event) {
                event.preventDefault();
                let children = Array.from(event.target.parentNode.parentNode.children);
                if (children.indexOf(event.target.parentNode) > children.indexOf(currentDragRow)) {
                    event.target.parentNode.after(currentDragRow);
                } else {
                    event.target.parentNode.before(currentDragRow);
                }
            });

            $(row).on('drop', function(event) {
                $.post('files/SSP/services_order.php', {
                    'target': $(currentDragRow).data('rowid'),
                    'prev': $(currentDragRow).prev('tr').data('rowid'),
                    'next': $(currentDragRow).next('tr').data('rowid')
                });
            });
        },
        "columnDefs": [
            { "orderable": false, "targets": [0, 1, 2, 3] }
        ]
    });
});
</script>

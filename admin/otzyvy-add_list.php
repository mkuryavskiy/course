<?php
	require_once('files/header.php');
?>
	<section class="page-section" style="overflow:auto;">
		<div class="row col-lg-12 col-center m-t-10">
			<table id="otzyvAdd" class="cell-border" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th>ID</th>
						<th>Комментарий</th>
						<th>Имя</th>
						<th>Дата</th>
						<th>Звёзды</th>
						<th>Редактировать</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Комментарий</th>
						<th>Имя</th>
						<th>Дата</th>
						<th>Звёзды</th>
						<th>Редактировать</th>
					</tr>
				</tfoot>
			</table>
		</div>
	</section>

	<style type="text/css">
		.checked {
    		color: orange;
		}
	</style>

<?php
	require_once('files/footer.php');
?>
<script>
$(document).ready(function() {
    var table = $('#otzyvAdd').DataTable( {
        "processing": true,
        "serverSide": true,
        "bProcessing": true,
        "bServerSide": true,
        "ajax": "files/SSP/otzyvy-add.php"
	});
	
	setInterval( function () {
		table.ajax.reload( null, false );
	}, 120000 );
});


$(document).ready(function() {
  var oTable = $('#otzyvAdd').dataTable();

  // Sort immediately with columns 0 and 1
  oTable.fnSort( [[0,'desc']] );
} );

</script>
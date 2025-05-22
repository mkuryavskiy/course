<?php
    require_once('files/header.php');
?>
<section class="page-section" style="overflow:auto;">
    <div class="row col-lg-12 col-center m-t-10">
        <table id="users-referred" class="cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Хто запросив</th>
                    <th>Запрошений</th>
                    <th>Сума виплат</th>
                    <th>Дата реєстрації</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Хто запросив</th>
                    <th>Запрошений</th>
                    <th>Сума виплат</th>
                    <th>Дата реєстрації</th>
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
    var table = $('#users-referred').DataTable({
        "processing": true,
        "serverSide": true,
        "scrollX": "200px",
        "scrollCollapse": true,
        "ajax": "files/SSP/referred.php"
    });
    
    setInterval(function () {
        table.ajax.reload(null, false);
    }, 120000); // кожні 2 хвилини
});
</script>

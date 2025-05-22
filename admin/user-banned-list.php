<?php
    require_once('files/header.php');
?>
<section class="page-section" style="overflow:auto;">
    <div class="row col-lg-12 col-center m-t-10">
        <table id="users-banned" class="cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Користувач</th>
                    <th>Дата блокування</th>
                    <th>Закінчення</th>
                    <th>Причина</th>
                    <th>Розблокувати</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>ID</th>
                    <th>Користувач</th>
                    <th>Дата блокування</th>
                    <th>Закінчення</th>
                    <th>Причина</th>
                    <th>Розблокувати</th>
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
    var table = $('#users-banned').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "files/SSP/users-banned.php"
    });
});
</script>

<?php
    $needDataTables = true;

    require_once('files/header.php');

    $user->IsLogged();

    $stmt = $pdo->prepare('SELECT id FROM updates ORDER BY id DESC LIMIT 1');
    $stmt->execute();
    if ($stmt->rowCount() == 1) {
        $muid_r = $stmt->fetch();
        $muid = $muid_r['id'];
        $stmt = $pdo->prepare('INSERT INTO updates_uv (user_id, update_id) VALUES (:user_id, :update_id) ON DUPLICATE KEY UPDATE update_id = :update_id');
        $stmt->execute([':user_id' => $_SESSION['auth'], ':update_id' => $muid]);
    }
?>

<section class="page-section" style="overflow:auto;">
    <div class="row col-md-10 col-center">
        <table id="updates" class="cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?=Language("_date")?></th>
                    <th><?=Language("_service")?></th>
                    <th><?=Language("_change")?></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><?=Language("_date")?></th>
                    <th><?=Language("_service")?></th>
                    <th><?=Language("_change")?></th>
                </tr>
            </tfoot>
            <tbody></tbody>
        </table>
    </div>
</section>

<?php
  require_once('files/footer.php');
?>

<script type="text/javascript">
    $(document).ready(function() {
        $('#updates').DataTable( {
            "order": [[0, "desc"]],
            "processing": true,
            "serverSide": true,
            "ajax": "files/SSP/updates.php"
        } );
    } );
</script>




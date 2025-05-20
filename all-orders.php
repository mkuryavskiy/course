<?php
    $needDataTables = true;
    require_once('files/header.php');
    $user->IsLogged();
?>


<section class="page-section" style="overflow:auto;">
    <div class="row col-md-10 col-center">
        <div id="all-orders_wrapper" class="dataTables_wrapper">
            <table id="all-orders" class="display" style="width: 100%;">
                <thead>
                    <tr>
                        <th><?= Language('_id') ?></th>
                        <th><?= Language('_service') ?></th>
                        <th><?= Language('_price') ?></th>
                        <th><?= Language('_quantity') ?></th>
                        <th><?= Language('_link') ?></th>
                        <th><?= Language('_time') ?></th>
                        <th><?= Language('_remain') ?></th>
                        <th><?= Language('_was') ?></th>
                        <th><?= Language('_status') ?></th>
                        <th><?= Language('_action') ?></th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th><?= Language('_id') ?></th>
                        <th><?= Language('_service') ?></th>
                        <th><?= Language('_price') ?></th>
                        <th><?= Language('_quantity') ?></th>
                        <th><?= Language('_link') ?></th>
                        <th><?= Language('_time') ?></th>
                        <th><?= Language('_remain') ?></th>
                        <th><?= Language('_was') ?></th>
                        <th><?= Language('_status') ?></th>
                        <th><?= Language('_action') ?></th>
                    </tr>
                </tfoot>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</section>
<hr>

<?php require_once('files/footer.php'); ?>

<script>
let table = $('#all-orders').DataTable({
    order: [[0, "desc"]],
    processing: true,
    serverSide: true,
    deferRender: true,
    ajax: "files/SSP/all-orders.php",
    language: {
        processing: <?= Language("processing") ?>,
        search: <?= Language("search") ?>,
        lengthMenu: <?= Language("lengthMenu") ?>,
        info: <?= Language("info") ?>,
        infoEmpty: <?= Language("infoEmpty") ?>,
        infoFiltered: <?= Language("infoFiltered") ?>,
        infoPostFix: <?= Language("infoPostFix") ?>,
        loadingRecords: <?= Language("loadingRecords") ?>,
        zeroRecords: <?= Language("zeroRecords") ?>,
        emptyTable: <?= Language("emptyTable") ?>,
        paginate: {
            first: <?= Language("first") ?>,
            previous: <?= Language("previous") ?>,
            next: <?= Language("next") ?>,
            last: <?= Language("last") ?>
        },
        aria: {
            sortAscending: <?= Language("sortAscending") ?>,
            sortDescending: <?= Language("sortDescending") ?>
        },
        select: {
            rows: {
                _: <?= Language("select_rows_all") ?>,
                0: <?= Language("select_rows_none") ?>,
                1: <?= Language("select_rows_single") ?>
            }
        }
    }
});

function order_refill(order_id, refill_period_check) {
    let buttons = document.querySelectorAll('button');
    buttons.forEach(function(el) { el.setAttribute('disabled', 'disabled'); });

    if (!refill_period_check) {
        alert('Срок гарантии истек');
        buttons.forEach(function(el) { el.removeAttribute('disabled'); });
        return;
    }

    $.post('/refill.php', { order_id }, function(data) {
        if (data.error) {
            alert(data.error === 'Refill not allowed' ? 'Докрутка не требуется!' : data.error);
        } else {
            alert('Отправлено на докрутку, ожидайте поступления');
        }
        buttons.forEach(function(el) { el.removeAttribute('disabled'); });
    }, 'json');
}

function order_cancel(order_id) {
    let buttons = document.querySelectorAll('button');
    buttons.forEach(function(el) { el.setAttribute('disabled', 'disabled'); });

    $.post('/requests.php', { action: 'cancel', order_id }, function() {
        alert('Заказ будет отменен в течении 15 минут');
        buttons.forEach(function(el) { el.removeAttribute('disabled'); });
    }, 'json');
}
</script>
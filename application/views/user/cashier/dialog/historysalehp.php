<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">History Sale</h4>
    </div>

</div>
<div class="row">
    <div class="col-12 border">
        <small class="text-left font-weight-bold">Done</small>
        <div class="list-group text-left">
            <?php
            $i = 1;
            foreach ($qhs as $key) { ?>
            <a onclick="historysaledetailhp('<?=$key->id ?>')" id="list-history-sale-<?=$key->id ?>"
                class="list-group-item list-group-item-action list-history-sale">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?=$key->id ?> - <?=$key->customer_name ?></h5>
                    <small><?=$key->status ?></small>
                </div>
                <p class="mb-1"><?='Rp ' . number_format($key->total_amount) ?></p>
                <small><?=$key->update_time ?></small>
            </a>
            <?php }?>


        </div>

    </div>
    <!-- <div id="container-modal-right" class="col-8">


    </div> -->
</div>

<script>
function historysaledetailhp(param) {
    $.ajax({
        type: "GET",
        url: "<?=base_url('order/historysaledetail?saleid='); ?>" + param,
        cache: false,
        dataType: 'html',
        contentType: 'html',
        success: function(res) {

            $('#modalcontentlg').html(res);
            $("#modallg").modal('show');

        },
        error: function(error) {
            $("#modallg").modal('show');
        }
    });
}

function cancel() {
    $("#modallg").modal('hide');
}

function printReceiptForm() {

    var cartid = $('#cartid').val();
    window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=", "_blank");

}
</script>
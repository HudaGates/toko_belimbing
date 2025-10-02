<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">Customer</h4>
    </div>
    <div class="col-3 text-right">
        <button type="button" class="btn btn-danger btn-sm" onclick=" $('#modallg').modal('hide');">X</button>

    </div>
</div>
<div class="row mb-3">
    <div class="col-12 text-left">
        <button type="button" class="btn btn-primary btn-sm" onclick="formaddcustomer()">Add</button>
    </div>

</div>
<div class="row">
    <div class="col-4 border" style="height: 50vh; overflow-y:scroll;">

        <div class="list-group text-left pt-2">
            <?php
            $i = 1;
            foreach ($qmc as $key) { ?>
            <a onclick="detailcustomer('<?=$key->id ?>')" id="list-history-sale-<?=$key->id ?>"
                class="list-group-item list-group-item-action list-history-sale">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?=$key->id ?> - <?=$key->customer_name ?></h5>
                    <!-- <small><?=$key->address ?></small> -->
                </div>
                <p class="mb-1">
                    <!-- <?='Rp ' . number_format($key->total_amount) ?> -->
                </p>
                <small><?=$key->city ?></small>
            </a>
            <?php }?>
        </div>


    </div>
    <div id="container-modal-right" class="col-8">


    </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-outline-danger btn-sm"
            onclick=" $('#modallg').modal('hide');">BATAL</button>
        <!-- <button type="button" class="btn btn-primary btn-sm" onclick="paySubmit()">BAYAR</button> -->

    </div>
</div>
<script>
function detailcustomer(param) {
    $.ajax({
        type: "POST",
        url: "<?=base_url('cashier/detailcustomer?api='.$this->id_t); ?>",
        data: "saleid=" + param + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        // dataType: 'html',
        // contentType: 'html',
        success: function(res) {

            $('#container-modal-right').html(res);
            $(".list-history-sale").removeClass('active');
            $("#list-history-sale-" + param).addClass('active');

        },
        error: function(error) {
            $("#modallg").modal('show');
        }
    });
}

function formaddcustomer() {
    $.ajax({
        type: "GET",
        url: "<?=base_url('cashier/formaddcustomer?api='.$this->id_t); ?>",
        // data: "saleid=" + param + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        // dataType: 'html',
        // contentType: 'html',
        success: function(res) {

            $('#container-modal-right').html(res);


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
    window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");

}
</script>
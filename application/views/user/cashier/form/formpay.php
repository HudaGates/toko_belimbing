<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">Pay</h4>
    </div>
    <div class="col-3 text-right">
        <button type="button" class="btn btn-danger btn-sm" onclick="cancel()">X</button>
    </div>
</div>
<div class="row">
    <div class="col">

        <!-- <p><?= $qd->product_code?> </p> -->

        <br>

        <table class="table">
            <tbody>
                <tr>
                    <td class="text-muted text-right text-sm">Cart ID</td>
                    <td class="font-weight-bold  text-left">
                        <input type="text" id="cartid" value="<?=$cartid?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Customer</td>
                    <td class="font-weight-bold  text-left">
                        <input type="text" id="customer_name" value="<?=$customer_name?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Jumlah Tagihan</td>
                    <td class="font-weight-bold  text-left">
                        <input type="number" id="amount" value="<?=$amount?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Uang Tunai</td>
                    <td class="font-weight-bold  text-left">
                        <input oninput="getMoneyChange()" id="cash" type="number">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Kembalian</td>
                    <td id="change" class="font-weight-bold  text-left">
                        <input id="change-data" type="number">
                    </td>
                </tr>


            </tbody>
        </table>



    </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="">BATAL</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="paySubmit()">BAYAR</button>

    </div>
</div>
<script>
function paySubmit() {
    var cartid = $("#cartid").val();
    var customer_name = $("#customer_name").val();
    var amount = $("#amount").val();
    var pay_amount = $("#cash").val();


    if (!parseInt(amount)) {
        alert(`Tidak boleh kosong (Uang Tunai)`);
    } else {

        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/paysubmit?api='.$this->id_t); ?>",
            data: "cartid=" + cartid + "&customer_name=" + customer_name + "&amount=" + amount +
                "&pay_amount=" + pay_amount +
                "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    console.log(res.success)
                    printReceiptForm()
                    $("#modalxl").modal('hide');
                    window.location.href = "<?=base_url('cashier?api='.$this->id_t); ?>";


                }
            },
            error: function(error) {
                // $("#modalxl").modal('show');
                console.log(error)
            }
        });
    }

}

function cancel() {
    $("#modalxl").modal('hide');
}

function printReceiptForm() {

    var cartid = $('#cartid').val();
    window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");

}
</script>
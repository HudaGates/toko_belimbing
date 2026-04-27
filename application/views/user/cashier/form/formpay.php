<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold"><?= lang('modal_pay_title'); ?></h4>
    </div>
    <div class="col-3 text-right">
        <button type="button" class="btn btn-danger btn-sm" onclick="cancel()">X</button>
    </div>
</div>
<div class="row">
    <div class="col">

        <br>

        <table class="table">
            <tbody>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_cart_id'); ?></td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm" type="text" id="cartid" value="<?=$cartid?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_customer'); ?></td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm" type="text" id="modal_customer_name" value="<?=$customer_name?>">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_jumlah_tagihan'); ?></td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm font-weight-bold" type="number" id="amount" value="<?=$amount?>" readonly style="background-color: #ffeeba; color: #d39e00;">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_uang_tunai'); ?></td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm" oninput="getMoneyChange()" id="cash" type="number" autofocus>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_kembalian'); ?></td>
                    <td id="change" class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm font-weight-bold text-success" id="change-data-display" type="text" readonly placeholder="Rp 0">
                        <input id="change-data" type="hidden" value="0">
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<div class="row">
    <div class="col text-right">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancel()"><?= lang('btn_cancel'); ?></button>
        <button type="button" class="btn btn-primary btn-sm" onclick="paySubmit()"><?= lang('btn_pay'); ?></button>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#modalxl').on('shown.bs.modal', function () {
        $('#cash').focus();
    });
});

function getMoneyChange() {
    var amount = parseFloat($("#amount").val()); 
    var cash = parseFloat($("#cash").val()); 

    if (isNaN(cash) || cash === 0) {
        $("#change-data").val(0);
        $("#change-data-display").val("Rp 0");
        return; 
    }
    
    if (isNaN(amount)) { amount = 0; }

    var change = cash - amount;
    $("#change-data").val(change.toFixed(0)); 
    
    var formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(change);
    $("#change-data-display").val(formatRupiah);
    
    if (change < 0) {
        $("#change-data-display").removeClass('text-success').addClass('text-danger');
    } else {
        $("#change-data-display").removeClass('text-danger').addClass('text-success');
    }
}

function paySubmit() {
    var cartid = $("#cartid").val();
    var customer_name = $("#modal_customer_name").val(); 
    var amount = $("#amount").val();
    var pay_amount = $("#cash").val();
    var change = parseFloat($("#change-data").val()); 

    if (!parseInt(pay_amount)) {
        swal("Attention!", "Cash In cannot be empty!", "warning");
        return; 
    } 
    
    if (change < 0) {
        swal("Insufficient Payment!", "Cash is still short of " + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(Math.abs(change)), "error");
        return; 
    }
    
    $('.btn-primary').prop('disabled', true).text('Processing...');
    
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
                // 1. Tutup pop-up pembayaran
                $("#modalxl").modal('hide');
                
                // 2. Panggil fungsi Iframe Siluman yang ada di halaman utama (home.php)
                if(typeof printReceipt === "function") {
                    printReceipt(); 
                }

                // 3. Jeda 1.5 Detik biar pop-up print browser muncul dulu, baru refresh halamannya
                setTimeout(function() {
                    window.location.href = "<?=base_url('cashier?api='.$this->id_t); ?>";
                }, 1500);
                
            } else {
                swal("Failed!", "Error processing payment.", "error");
                $('.btn-primary').prop('disabled', false).text("<?= lang('btn_pay'); ?>");
            }
        },
        error: function(error) {
            swal("Server Error!", "Could not connect to server.", "error");
            $('.btn-primary').prop('disabled', false).text("<?= lang('btn_pay'); ?>");
        }
    });
}

function cancel() {
    $("#modalxl").modal('hide');
}
</script>
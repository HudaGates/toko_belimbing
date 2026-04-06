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

        <br>

        <table class="table">
            <tbody>
                <tr>
                    <td class="text-muted text-right text-sm">Cart ID</td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm" type="text" id="cartid" value="<?=$cartid?>" readonly>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Customer</td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm" type="text" id="modal_customer_name" value="<?=$customer_name?>">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Jumlah Tagihan</td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm font-weight-bold" type="number" id="amount" value="<?=$amount?>" readonly style="background-color: #ffeeba; color: #d39e00;">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Uang Tunai</td>
                    <td class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm" oninput="getMoneyChange()" id="cash" type="number" autofocus>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Kembalian</td>
                    <td id="change" class="font-weight-bold  text-left">
                        <input class="form-control form-control-sm font-weight-bold text-success" id="change-data-display" type="text" readonly>
                        <input id="change-data" type="hidden" value="0">
                    </td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="cancel()">BATAL</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="paySubmit()">BAYAR</button>
    </div>
</div>

<script>
// Trik agar autofocus bekerja sempurna di dalam Modal Bootstrap
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
    
    if (isNaN(amount)) {
        amount = 0;
    }

    var change = cash - amount;

    // Simpan nilai asli ke input hidden
    $("#change-data").val(change.toFixed(0)); 
    
    // Tampilkan format Rupiah ke input display
    var formatRupiah = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(change);
    $("#change-data-display").val(formatRupiah);
    
    // Beri warna merah jika uangnya kurang
    if (change < 0) {
        $("#change-data-display").removeClass('text-success').addClass('text-danger');
    } else {
        $("#change-data-display").removeClass('text-danger').addClass('text-success');
    }
}


function paySubmit() {
    var cartid = $("#cartid").val();
    
    // PERBAIKAN 2: Mengambil value dari ID modal_customer_name yang baru
    var customer_name = $("#modal_customer_name").val(); 
    
    var amount = $("#amount").val();
    var pay_amount = $("#cash").val();
    var change = parseFloat($("#change-data").val()); 

    if (!parseInt(pay_amount)) {
        // Ganti alert bawaan dengan SweetAlert agar lebih elegan
        swal("Peringatan!", "Uang Tunai tidak boleh kosong!", "warning");
        return; 
    } 
    
    if (change < 0) {
        swal("Pembayaran Kurang!", "Uang tunai kurang " + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(Math.abs(change)), "error");
        return; 
    }
    
    // Disable tombol Bayar saat proses untuk mencegah klik ganda (Double Submit)
    $('.btn-primary').prop('disabled', true).text('Memproses...');
    
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
                printReceiptForm();
                $("#modalxl").modal('hide');
                // Beri jeda sedikit agar struk punya waktu ter-*generate* sebelum reload halaman
                setTimeout(function() {
                    window.location.href = "<?=base_url('cashier?api='.$this->id_t); ?>";
                }, 500);
            } else {
                swal("Gagal!", "Terjadi kesalahan saat memproses pembayaran.", "error");
                $('.btn-primary').prop('disabled', false).text('BAYAR');
            }
        },
        error: function(error) {
            console.log(error);
            swal("Error Server!", "Tidak dapat terhubung ke server.", "error");
            $('.btn-primary').prop('disabled', false).text('BAYAR');
        }
    });
}

function cancel() {
    $("#modalxl").modal('hide');
}

function printReceiptForm() {
    var cartid = $('#cartid').val();
    window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");
}
</script>
<div class="row mb-3">
    <div class="col-12 text-left">
        <h4 class="font-weight-bold text-black">Form Add Customer</h4>
        <hr>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <?=form_open('cashier/addcustomersubmit?api='.$id_t, 'id="mydata"'); ?>
            <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
            
            <div class="form-group row align-items-center mb-3">
                <label class="col-sm-3 text-muted text-sm-right mb-0">Customer</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="customer_name" name="customer_name" placeholder="Nama Lengkap">
                </div>
            </div>

            <div class="form-group row align-items-center mb-3">
                <label class="col-sm-3 text-muted text-sm-right mb-0">Gender</label>
                <div class="col-sm-9">
                    <select class="form-control custom-select" id="gender" name="gender">
                        <option value="" disabled selected>-- Pilih Gender --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>
            </div>

            <div class="form-group row align-items-center mb-3">
                <label class="col-sm-3 text-muted text-sm-right mb-0">Phone</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="cash" name="phone" placeholder="Contoh: 08123456789">
                </div>
            </div>

            <div class="form-group row mb-3">
                <label class="col-sm-3 text-muted text-sm-right mt-2">Address</label>
                <div class="col-sm-9">
                    <textarea class="form-control" name="address" id="address" rows="3" placeholder="Alamat lengkap pelanggan"></textarea>
                </div>
            </div>

            <div class="form-group row align-items-center mb-4">
                <label class="col-sm-3 text-muted text-sm-right mb-0">City</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="city" name="city" placeholder="Nama Kota">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-9 offset-sm-3 text-left">
                    <button type="submit" class="btn btn-primary shadow-sm px-4" style="border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-save mr-1"></i> Submit
                    </button>
                </div>
            </div>
        <?=form_close(); ?>
    </div>
</div>
<div class="row">
    <div class="col-12 text-left">
        <!-- <button type="button" class="btn btn-outline-danger btn-sm" onclick="">BATAL</button> -->
        <!-- <button type="button" class="btn btn-primary btn-sm" onclick="addcustomer()">Submit</button> -->

    </div>
</div>
<script>
$('#mydata').submit(function(e) {
    e.preventDefault();
    var fa = $(this);
    $.ajax({
        url: fa.attr('action'),
        type: 'POST',
        data: fa.serialize(),
        cache: false,
        success: function(res) {
            // if (res.success == true) {
            //     formcustomer()
            //     $("#modalxl").modal('hide');

            // }

            $("#modallg").modal('hide');
            location.reload();
        },
        error: function(error) {
            console.log(error)
        }
    });

});

function cancel() {
    $("#modalxl").modal('hide');
}

function printReceiptForm() {

    var cartid = $('#cartid').val();
    window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");

}
</script>
<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">Form Add Customer</h4>
    </div>
</div>
<div class="row">
    <div class="col">

        <!-- <p><?= $qd->product_code?> </p> -->

        <br>
        <!-- <?=form_open('cashier/addcustomersubmit', 'id="mydata" '); ?> -->
        <?=form_open('cashier/addcustomersubmit?api='.$id_t, 'id="mydata"'); ?>
        <table class="table">
            <tbody>
                <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name"
                    value="<?=$this->security->get_csrf_hash(); ?>">
                <!-- <tr>
                    <td class="text-muted text-right text-sm">Cart ID</td>
                    <td class="font-weight-bold  text-left">
                        <input type="text" id="cartid" value="<?=$cartid?>" readonly>
                    </td>
                </tr> -->
                <tr>
                    <td class="text-muted text-right text-sm">Customer</td>
                    <td class="font-weight-bold  text-left">
                        <input type="text" id="customer_name" name="customer_name" value="">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Gender</td>
                    <td class="font-weight-bold  text-left">
                        <input type="text" id="gender" name="gender" value="">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Phone</td>
                    <td class="font-weight-bold  text-left">
                        <input id="cash" name="phone" type="text">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Address</td>
                    <td class="font-weight-bold  text-left">
                        <textarea name="address" id="address" cols="30" rows="3"></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">City</td>
                    <td class="font-weight-bold  text-left">
                        <input id="city" name="city" type="text">
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"></td>
                    <td class="font-weight-bold  text-left">
                        <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                    </td>
                </tr>

            </tbody>
        </table>
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
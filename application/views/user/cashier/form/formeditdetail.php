<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">Edit Item</h4>
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
            <!-- <thead>
                <tr>
                    <th>Product Name</th>
                    <th>QTY</th>
                </tr>
            </thead> -->
            <tbody>
                <tr>
                    <td class="text-muted text-right text-sm">Product Code</td>
                    <td class="font-weight-bold  text-left"><?= $qd->product_code?> </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Product Name</td>
                    <td class="font-weight-bold  text-left"><?= $qd->product_name?></td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">Unit Price</td>
                    <td class="font-weight-bold  text-left">
                        <!-- <?= $qd->unit_price?> -->
                        <?php echo 'Rp ' . number_format($qd->unit_price); ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm">QTY</td>
                    <td class="font-weight-bold text-left">
                        <input type="number" id="qtyItem" value="<?= $qd->quantity?>" max="<?= $qmp->stock?>"> <br>
                        <small class="text-muted">Tidak boleh lebih dari <?= $qmp->stock?> (stock)</small>
                    </td>
                </tr>

            </tbody>
        </table>



    </div>
</div>
<div class="row">
    <div class="col">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem()">DELETE</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="save()">SAVE</button>

    </div>
</div>
<script>
let itemID = '<?= $qd->id?>';
let stockItem = '<?= $qmp->stock?>';


function removeItem() {
    $.ajax({
        type: "POST",
        url: "<?=base_url('cashier/removeitem?api='.$this->id_t); ?>",
        data: "id=" + itemID + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        dataType: 'json',
        success: function(res) {
            if (res.success == true) {
                console.log(res.success)
                $("#modalxl").modal('hide');

                location.reload();
                getAmount()
            }
        },
        error: function(error) {
            // $("#modalxl").modal('show');
            console.log(error)
        }
    });
}

function save() {
    let qtyItem = $("#qtyItem").val();;
    if (parseInt(qtyItem) > parseInt(stockItem)) {
        alert(`Tidak boleh lebih dari ${stockItem} (stock)`);
    } else {

        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/edititem?api='.$this->id_t); ?>",
            data: "id=" + itemID + "&qty=" + qtyItem + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    console.log(res.success)
                    $("#modalxl").modal('hide');

                    location.reload();
                    getAmount()
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
</script>
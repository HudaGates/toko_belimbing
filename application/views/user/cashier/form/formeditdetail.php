<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold"><?= lang('modal_edit_title'); ?></h4>
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
                    <td class="text-muted text-right text-sm"><?= lang('lbl_product_code'); ?></td>
                    <td class="font-weight-bold  text-left"><?= $qd->product_code?> </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_product_name'); ?></td>
                    <td class="font-weight-bold  text-left"><?= $qd->product_name?></td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_unit_price'); ?></td>
                    <td class="font-weight-bold  text-left">
                        <?php echo 'Rp ' . number_format($qd->unit_price); ?>
                    </td>
                </tr>
                <tr>
                    <td class="text-muted text-right text-sm"><?= lang('lbl_qty_edit'); ?></td>
                    <td class="font-weight-bold text-left">
                        <input type="number" id="qtyItem" class="form-control form-control-sm w-50" value="<?= $qd->quantity?>" max="<?= $qmp->stock?>"> 
                        <small class="text-muted"><?= lang('msg_max_stock'); ?> <?= $qmp->stock?> <?= lang('lbl_stock'); ?></small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col text-right">
        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem()"><?= lang('btn_delete'); ?></button>
        <button type="button" class="btn btn-primary btn-sm" onclick="save()"><?= lang('btn_save'); ?></button>
    </div>
</div>

<script>
let itemID = '<?= $qd->id?>';
let stockItem = '<?= $qmp->stock?>';

// Meneruskan variabel bahasa ke Javascript
let msgMaxStock = "<?= lang('msg_max_stock'); ?>";
let lblStock = "<?= lang('lbl_stock'); ?>";

function removeItem() {
    $.ajax({
        type: "POST",
        url: "<?=base_url('cashier/removeitem?api='.$this->id_t); ?>",
        data: "id=" + itemID + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        dataType: 'json',
        success: function(res) {
            if (res.success == true) {
                $("#modalxl").modal('hide');
                location.reload();
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function save() {
    let qtyItem = $("#qtyItem").val();
    
    if (parseInt(qtyItem) > parseInt(stockItem)) {
        // Mengganti alert biasa dengan SweetAlert yang sudah mendukung multibahasa
        if(typeof swal === 'function') {
            swal("Warning", `${msgMaxStock} ${stockItem} ${lblStock}`, "warning");
        } else {
            alert(`${msgMaxStock} ${stockItem} ${lblStock}`);
        }
    } else {
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/edititem?api='.$this->id_t); ?>",
            data: "id=" + itemID + "&qty=" + qtyItem + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    $("#modalxl").modal('hide');
                    location.reload();
                }
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
}

function cancel() {
    $("#modalxl").modal('hide');
}
</script>
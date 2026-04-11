<table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse; font-size: 90%;">
    <thead style="background-color:#171718; color: #f5f5f7; " class="text-sm font-weight-normal p-2">
        <tr>
            <th style="width: 7%; padding: 0px;font-size: 90%;vertical-align: middle;" class="text-bold;">
                ID
            </th>
            <th style="padding: 0px;font-size: 90%;vertical-align: middle;" class="text-bold;">
                <?= $this->lang->line('lbl_product') ? $this->lang->line('lbl_product') : 'Product Name'; ?>
            </th>
            <th style="width: 7%; padding: 0px;font-size: 90%;vertical-align: middle;" class="text-bold;">
                <?= $this->lang->line('lbl_qty') ? $this->lang->line('lbl_qty') : 'Qty'; ?>
            </th>
            <th style="padding: 0px;font-size: 90%;vertical-align: middle;" class="text-bold;">
                <?= $this->lang->line('lbl_price') ? $this->lang->line('lbl_price') : 'Harga'; ?>
            </th>
            <th style="padding: 0px;font-size: 90%;vertical-align: middle;" class="text-bold;">
                <?= $this->lang->line('lbl_subtotal') ? $this->lang->line('lbl_subtotal') : 'Sub Total'; ?>
            </th>
            <th style="padding: 0px;font-size: 90%;vertical-align: middle;" class="text-bold;">
                <?= $this->lang->line('lbl_action') ? $this->lang->line('lbl_action') : 'Action'; ?>
            </th>
        </tr>
    </thead>
    <tbody style="font-weight: bold;">
        <?php foreach ($qsd as $key) { ?>
        <tr style="background-color: <?= $key->id%2 == 0 ? '#cecece':'#efefef'?>;">
            <td style=" padding: 0px;font-size: 100%;vertical-align: middle;" class="text-center;">
                <?=$key->product_code ?>
            </td>
            <td style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-center;">
                <?=strtoupper($key->product_name) ?>
            </td>
            <td style=" padding: 0px;font-size: 100%;vertical-align: middle;" class="text-center;">
                <?=$key->quantity ?>
            </td>
            <td style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-center;">
                <?php echo 'Rp ' . number_format($key->unit_price); ?>
            </td>
            <td style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-center;">
                <?php echo 'Rp ' . number_format($key->sub_total); ?>
            </td>
            <td style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-center; p-1">
                <button type="button" class="btn btn-xs " style="font-size: 80%; background-color: red; color:#f5f5f7"
                    onclick="editDetail('<?=$key->id ?>')" <?=$qts->status == 'done'?'disabled':''?>><?= $this->lang->line('btn_edit') ? $this->lang->line('btn_edit') : 'EDIT'; ?></button>
            </td>
        </tr>
        <?php }?>
    </tbody>
</table>

<script>
</script>
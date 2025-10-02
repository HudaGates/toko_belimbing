<!-- <div class="row mb-2">
    <div class="col-12 text-left">
        <button type="button" class="btn  btn-primary btn-sm" onclick="printreceipt()">Print</button>
        <button type="button" class="btn  btn-primary btn-sm" onclick="openviewcart()">Open</button>
    </div>
</div> -->
<div class="row mb-2">
    <div class="col-12 text-left">
        <table>
            <tr>
                <td>
                    CART ID
                </td>
                <td>
                    :
                </td>
                <td>
                    <?=$qhs->id?>
                </td>
            </tr>
        </table>
    </div>
</div>
<table class="table">
    <thead style="background-color:#ccc">

        <tr>
            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                No
            </th>
            <th style="width: 15%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                SKU
            </th>
            <th style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Product Name
            </th>

            <th style="width: 20%;padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Harga
            </th>
            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Qty
            </th>
            <th style="text-align: right; width: 20%; padding: 0px;font-size: 100%;vertical-align: middle;"
                class="text-bold;">
                Sub Total
            </th>

        </tr>
    </thead>
    <tbody>
        <?php
$i = 1;
$total = 0;
foreach ($qhsd as $key) { 
    $total = $total + $key->sub_total;
    ?>
        <tr>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$i++; ?>
            </td>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->product_code ?>
            </td>
            <td style="padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->product_name ?>
            </td>

            <td style="padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?='Rp ' . number_format($key->unit_price) ?>
            </td>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->quantity ?>
            </td>
            <td style="text-align: right; padding: 5px;font-size: 100%;vertical-align: middle;">
                <?='Rp ' . number_format($key->sub_total) ?>
            </td>

        </tr>
        <?php }?>
        <tr>
            <td colspan="5" style="text-align: right; padding: 5px;font-size: 100%;vertical-align: middle;">
                Total
            </td>
            <td style="text-align: right; padding: 5px;font-size: 100%;vertical-align: middle;">
                <?='Rp ' . number_format($total) ?>
            </td>
        </tr>
    </tbody>
</table>
<div class="row mb-2">
    <div class="col-12 text-left">
        <small>Silakan datang ke toko dengan menyebutkan nomor hp untuk membayar dan mengambil pesanan</small>
    </div>
</div>
<script>

</script>
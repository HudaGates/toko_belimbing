<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
html,
body {
    height: 100%;
    width: 100%;
    padding: 0;
    margin: 0px;
    font-family: arial;
    color: #000;
    /* text-align: center; */
    font-size: 8pt;
}
</style>

<body>
    <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
        <tr>
            <td>
                <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <td style="width: 5%; font-size: 150%; font-weight: bold">LOGO</td>
                        <td><br></td>
                        <td>
                            <?= $qt->owner?> <br>
                            <?= $qt->address?>
                            <br>
                            <?= $qt->tlp?>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse; text-align: left;">
                    <tr>
                        <td style="width: 20%;">RECEIPT NO</td>
                        <td style="width: 2%;">:</td>
                        <td><?= $qs->id?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">CUSTOMER</td>
                        <td>:</td>
                        <td>
                            <?= $qs->customer_name?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">TRX. DATE</td>
                        <td>:</td>
                        <td>
                            <?= $qs->update_time?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">CASHIER</td>
                        <td>:</td>
                        <td>
                            <?= $qs->cashier?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse; text-align: left;">
                    <thead style="background-color:#ccc">

                        <tr>
                            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;"
                                class="text-bold;">
                                No
                            </th>
                            <th style="width: 15%; padding: 0px;font-size: 100%;vertical-align: middle;"
                                class="text-bold;">
                                SKU
                            </th>
                            <th style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                                Product Name
                            </th>

                            <th style="width: 20%;padding: 0px;font-size: 100%;vertical-align: middle;"
                                class="text-bold;">
                                Harga
                            </th>
                            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;"
                                class="text-bold;">
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
                        foreach ($qsd as $key) { ?>
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
                            <td style="text-align: right; padding: 5px;font-size: 100%;vertical-align: middle;"
                                class="text-left;">
                                <?='Rp ' . number_format($key->sub_total) ?>
                            </td>

                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <table style="width: 100%;" border="0">
                    <tr>
                        <td style="width: 70%;">Jumlah Tagihan :</td>
                        <td><?php echo 'Rp ' . number_format($qs->total_amount); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 70%;">Uang Tunai :</td>
                        <td><?php echo 'Rp ' . number_format($qs->pay_amount); ?></td>
                    </tr>
                    <tr>
                        <td>Kembalian :</td>
                        <td><?php echo 'Rp ' . number_format($qs->pay_amount - $qs->total_amount); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <hr>
            </td>
        </tr>
        <tr>
            <td>
                NOTE: Barang yang sudah dibeli tidak dapat dikembalikan
            </td>
        </tr>
    </table>



    <script type="text/javascript">
    setTimeout(function() {
        window.print();
    }, 100);
    </script>
</body>

</html>
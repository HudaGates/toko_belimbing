<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
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
    font-size: 8pt;
}
</style>

<body>
    <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
        <tr>
            <td>
                <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <!-- ZettBOT: Bagian LOGO Diubah di Sini -->
                        <td style="width: 80px; text-align: left; vertical-align: top;">
                            <img src="<?= base_url('assets/img/toko_belimbing.png'); ?>" alt="Logo Toko" style="max-width: 80px; height: auto; filter: grayscale(100%);">
                        </td>
                        <td style="width: 10px;"><br></td>
                        <td style="vertical-align: top;">
                            <strong style="font-size: 120%;"><?= $qt->owner?></strong> <br>
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
            <td><hr style="border: 0; border-top: 1px dashed #000; margin: 10px 0;"></td>
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
                        <td><?= $qs->customer_name?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">TRX. DATE</td>
                        <td>:</td>
                        <td><?= $qs->update_time?></td>
                    </tr>
                    <tr>
                        <td style="width: 20%;">CASHIER</td>
                        <td>:</td>
                        <td><?= $qs->cashier?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><hr style="border: 0; border-top: 1px dashed #000; margin: 10px 0;"></td>
        </tr>
        <tr>
            <td>
                <table border="0" style="width: 100%;border-spacing: 0px;border-collapse: collapse; text-align: left;">
                    <thead style="border-bottom: 1px solid #000;">
                        <tr>
                            <th style="width: 5%; padding: 5px 0px; font-size: 100%; vertical-align: middle;">No</th>
                            <th style="width: 15%; padding: 5px 0px; font-size: 100%; vertical-align: middle;">SKU</th>
                            <th style="padding: 5px 0px; font-size: 100%; vertical-align: middle;">Product Name</th>
                            <th style="width: 20%; padding: 5px 0px; font-size: 100%; vertical-align: middle;">Harga</th>
                            <th style="width: 5%; padding: 5px 0px; font-size: 100%; vertical-align: middle;">Qty</th>
                            <th style="text-align: right; width: 20%; padding: 5px 0px; font-size: 100%; vertical-align: middle;">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($qsd as $key) { ?>
                        <tr>
                            <td style="padding: 5px 0px; font-size: 100%; vertical-align: middle;" class="text-left"><?=$i++; ?></td>
                            <td style="padding: 5px 0px; font-size: 100%; vertical-align: middle;" class="text-left"><?=$key->product_code ?></td>
                            <td style="padding: 5px 0px; font-size: 100%; vertical-align: middle;" class="text-left"><?=$key->product_name ?></td>
                            <td style="padding: 5px 0px; font-size: 100%; vertical-align: middle;" class="text-left"><?='Rp ' . number_format($key->unit_price) ?></td>
                            <td style="padding: 5px 0px; font-size: 100%; vertical-align: middle;" class="text-left"><?=$key->quantity ?></td>
                            <td style="text-align: right; padding: 5px 0px; font-size: 100%; vertical-align: middle;" class="text-left"><?='Rp ' . number_format($key->sub_total) ?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </td>
        </tr>
        <tr>
            <td><hr style="border: 0; border-top: 1px solid #000; margin: 10px 0;"></td>
        </tr>
        <tr>
            <td style="text-align: right;">
                <table style="width: 100%;" border="0">
                    <tr>
                        <td style="width: 70%; text-align: right;">Jumlah Tagihan :</td>
                        <td style="text-align: right;"><?php echo 'Rp ' . number_format($qs->total_amount); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 70%; text-align: right;">Uang Tunai :</td>
                        <td style="text-align: right;"><?php echo 'Rp ' . number_format($qs->pay_amount); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 70%; text-align: right;">Kembalian :</td>
                        <td style="text-align: right;"><?php echo 'Rp ' . number_format($qs->pay_amount - $qs->total_amount); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td><hr style="border: 0; border-top: 1px dashed #000; margin: 10px 0;"></td>
        </tr>
        <tr>
            <td style="text-align: center; padding-top: 5px;">NOTE: Barang yang sudah dibeli tidak dapat dikembalikan</td>
        </tr>
    </table>

    <script type="text/javascript">
    // FIX: Pastikan seluruh konten struk ke-load dulu baru muncul pop-up print
    window.onload = function() {
        window.print();
    };
    </script>
</body>

</html>
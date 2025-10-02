<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report <?=$month?> - <?=$year?></title>
</head>

<style>
html,
body {
    font-size: 8pt;

    font-family: Arial, Helvetica, sans-serif;
    -webkit-print-color-adjust: exact !important;
    print-color-adjust: exact !important;
}
</style>

<body>
    <h2 class="m-0 font-weight-bold">TOKO BELIMBING</h2>
    <p class="m-0 text-xs" style="font-size: small;"><?=$qt->address?></p>
    <hr>

    <h3>Laporan Penjualan per Hari <?=$day?></h3>
    <table style="width: 100%; border-spacing: 0px; border-collapse: collapse;">
        <tr>
            <td>
                <table style="width: 20%; border-spacing: 0px; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: black; color: white;">
                            <td>
                                No
                            </td>
                            <td>
                                Date Time
                            </td>
                            <td>
                                Cashier
                            </td>
                            <td>
                                Customer
                            </td>
                            <td style="text-align: right;">
                                Amount
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        $all = 0;
                        foreach ($qr as $key) { 
                            $all = $all + $key->total_amount;
                            
                            ?>
                        <tr>
                            <td style="border: 1px solid #777; padding: 2px;">
                                <?=$i++;?>
                            </td>
                            <td style="border: 1px solid #777;">
                                <?=$key->update_time?>
                            </td>
                            <td style="border: 1px solid #777;">
                                <?=$key->cashier?>
                            </td>
                            <td style="border: 1px solid #777;">
                                <?=$key->customer_name?>
                            </td>


                            <td style="border: 1px solid #777; text-align: right;">
                                <?php echo 'Rp ' . number_format($key->total_amount); ?>

                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" style="text-align: right; padding: 2px;">
                                Total :
                            </td>
                            <td style="font-weight: bold; text-align: right;">
                                <?php echo 'Rp ' . number_format($all); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </td>
        </tr>

    </table>
</body>

</html>
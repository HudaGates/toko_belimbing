<?php
require_once('assets/lte/mpdf60/qrcode/qrcode.class.php');
?>
<!DOCTYPE html>
<html>

<head>
    <style type="text/css">
    /* @font-face {
        font-family: Arial, Helvetica, sans-serif;
        src: url('fonts/Roboto-Black.ttf') format('truetype');
    } */

    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0px;
        margin: 0px;
        font-family: Arial, Helvetica, sans-serif;
        background-color: white;
        color: #444;
        text-align: center;
        vertical-align: top;
        font-weight: 700;
        font-size: 10pt;
    }

    table,
    tr,
    td {
        padding: 1px;
        vertical-align: middle;
        font-family: Arial, Helvetica, sans-serif;
    }

    .page {
        page-break-after: always;
    }

    .page:last-child {
        page-break-after: unset;
    }
    </style>
</head>

<body>



    <div class="page" style="padding: 10mm">
        <table border="0" cellspacing="0" style="width: 100%;font-family: Arial;font-size:10px;">

            <tr valign="top">
                <td>
                    <table style="width: 100%">
                        <tr valign="top">
                            <td width="40%">
                                <div style=" text-align:left;font-size:14px; font-weight:700;">PT. FUJI SEAT INDONESIA
                                </div>
                                <div style=" text-align:left;font-size:12px; font-weight: normal;">
                                    SUNTER PLANT
                                    <!-- <hr style="margin:0"> -->
                                    <br>
                                    Jl.Agung perkasa blok 9 k1 no 9, 15, Sunter Agung<br>
                                    Kawasan Industri Sunter - Jakarta Utara<br>
                                    14230 Jakarta - Indonesia<br>
                                    Telp. &nbsp;: (021) 6530 2228<br>
                                    Fax. &nbsp; : (021) 6530 2228<br>
                                </div>
                            </td>
                            <td width="33%" style=" text-align:center;font-size:22px; font-weight:bold;">
                                <U>DELIVERY NOTE</U>
                            </td>

                        </tr>
                    </table>

                </td>
            </tr>


            <tr>
                <td>
                    <table border="0"
                        style=" font-family:'Helvetica Neue',Arial,sans-serif;font-size:13px;line-height:18px;table-layout:auto;width:100%; border-collapse: collapse; ">
                        <tr>
                            <td style="width: 45%; padding: 5px; padding-right: 30px; vertical-align: top;">

                                <table style="width:100%; height:auto; line-height: 1.2rem; padding: 0px;">
                                    <tr>
                                        <td class="bold" style="width:25%; font-size: 8pt;">
                                            Supplier
                                        </td>
                                        <td style="width: 2%;">
                                            :
                                        </td>
                                        <td>
                                            <strong
                                                class="val-detail bold"><?= strtoupper($qpo->supplier_name)  ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold" style=" font-size: 8pt;">
                                            Address
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <strong class="val-detail"><?= $qpo->address  ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold" style=" font-size: 8pt;">
                                            Tel
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <strong
                                                class="val-detail"><?= strtoupper(substr($qpo->tlp,0,50));  ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold" style=" font-size: 8pt;">
                                            Email
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <strong
                                                class="val-detail"><?= strtoupper(substr($qpo->email,0,75));  ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold" style=" font-size: 8pt;">
                                            Attn
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <strong
                                                class="val-detail"><?= strtolower($qpo->pic) . ' (' . strtolower($qpo->supplier_code) . ')' ?></strong>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 30%; padding: 5px; padding-left: 10px; vertical-align: top;">
                                <table border="0" style="width:100%; padding: 0px;">
                                    <tr>
                                        <td class="bold" style="width:30%; font-size: 8pt;">
                                            No. Order
                                        </td>
                                        <td style="width: 2%;">
                                            :
                                        </td>
                                        <td>
                                            <?= $qpo->po_no ?>
                                        </td>
                                        <!-- <td rowspan="3" style="vertical-align: top; text-align: center">

                                    </td> -->
                                    </tr>
                                    <tr>
                                        <td class="bold" style=" font-size: 8pt;">
                                            PO Date
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <?= $qpo->po_date ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="bold" style="width:30%; font-size: 8pt;">
                                            Delv. Date
                                        </td>
                                        <td style="width: 2%;">
                                            :
                                        </td>
                                        <td>
                                            <?= $qpo->delv_date ?>
                                        </td>
                                        <!-- <td rowspan="3" style="vertical-align: top; text-align: center">

                                    </td> -->
                                    </tr>
                                    <tr>
                                        <td class="bold" style=" font-size: 8pt;">
                                            Total Page
                                        </td>
                                        <td>
                                            :
                                        </td>
                                        <td>
                                            <?= $page ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 10%; padding: 0px; vertical-align: middle; text-align: center">
                                <img src="<?= base_url('assets/lte/mpdf60/qrcode/image.php?msg=' . urlencode($qpo->po_no) . '&amp;err=' . urlencode('Q')); ?>"
                                    style="width:70px;height: 70px;">
                                <div style="font-size: 6pt;">
                                    <?= $qpo->po_no ?>
                                </div>

                            </td>

                        </tr>


                    </table>
                </td>
            </tr>

            <tr>
                <td style="">
                    &nbsp;
                </td>
            </tr>
            <tr valign="top">
                <td>
                    <table border="0" cellspacing="0"
                        style="width: 100%;  font-family: Arial;font-size:12px; border:medium;border-bottom:1px solid #000;">
                        <tr align="center" style="font-family: Arial;font-size:10px; font-weight:bold;">
                            <td width="6%" style=" border:1px solid #000">NO</td>
                            <td style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"
                                width="20%">CODE FUJI SEAT INDONESIA</td>
                            <td
                                style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000">
                                NAMA BARANG</td>
                            <td style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000"
                                width="15%">BANYAK NYA</td>
                        </tr>
                        <!-- <?php $i=1; foreach ($data_table as $key) { ?> -->
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                <!-- <?=$i;?> -->
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                <!-- <?=$key->part_no;?> -->
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                <!-- <?=$key->item.' '.$key->code;?> -->
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                <!-- <?=$key->jumlah;?> -->
                            </td>
                        </tr>
                        <!-- <?php $i=$i+1; } ?> -->
                        <!-- DATA TEST -->
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                i++
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                PART_NO
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                ITEM_KEY
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                JUMLAH
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                i++
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                PART_NO
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                ITEM_KEY
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                JUMLAH
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                i++
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                PART_NO
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                ITEM_KEY
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                JUMLAH
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                i++
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                PART_NO
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                ITEM_KEY
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                JUMLAH
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                i++
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                PART_NO
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                ITEM_KEY
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                JUMLAH
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; ">
                                i++
                            </td>
                            <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                                PART_NO
                            </td>

                            <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                                ITEM_KEY
                            </td>
                            <td style="text-align: center;border-right:1px solid #000;">
                                JUMLAH
                            </td>
                        </tr>

                        <tr>
                            <td width="6%"
                                style="border-right:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000">
                            </td>
                            <td style="border-right:1px solid #000;border-bottom:1px solid #000;" width="20%"></td>
                            <td style="border-right:1px solid #000;border-bottom:1px solid #000;">&nbsp;</td>
                            <td style="border-right:1px solid #000;border-bottom:1px solid #000;" width="15%"></td>
                        </tr>

                    </table>

                </td>
            </tr>
            <tr>
                <td>&nbsp;</td>
            </tr>
            <tr>
                <td>
                    <table style="width: 100%;font-family: Arial;font-size:10px;">
                        <tr>
                            <td width="70%">Diterima Tanggal : ..............................................</td>
                            <td style="text-align: center;">&nbsp;&nbsp;Kep. Seksi Ekspedisi</td>
                        </tr>
                        <tr>
                            <td>Jam : ......................... s/d Jam : ........................</td>
                            <td style="text-align: center;">PT. FUJI SEAT INDONESIA</td>
                        </tr>
                        <tr valign="bottom">
                            <td><br><br><br><br></td>
                            <td style="text-align: center;">YUTAKA TSUJIMURA</td>
                        </tr>
                        <tr>
                            <td>(Tanda Tangan Penerima dan Nama Terang)</td>
                            <td>...........................................................................</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div class="page">
        <table border="1" style="text-align: center;border-spacing:0px;border-collapse: collapse;">
            <tr>
                <td> your left side table </td>
                <td>
                    <table border="1" style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td> your left side table tes</td>
                            <td> your right side table </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>



</body>

</html>
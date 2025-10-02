<?php
require_once('assets/lte/mpdf60/barcode/barcode.php');
?>
<!DOCTYPE html>
<html>

<head>

    <style type="text/css">
    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0px;
        margin: 0px;
        font-family: sans-serif;
        background-color: white;
        color: #000;
        text-align: center;
        vertical-align: top;
        font-weight: 700;
        font-size: 10px;
        -webkit-print-color-adjust: exact !important;

    }

    @page {
        size: A4;
        margin: 0;
    }

    @media print {

        html,
        body {
            width: 210mm;
            height: 297mm;
        }

        /* ... the rest of the rules ... */
    }

    table,
    tr,
    td {
        padding: 2px;
        vertical-align: middle;
    }
    </style>
</head>

<body>
    <?php
  $date =gmdate('Y-m-d H:i:s',time()+60*60*7);
  $height=100;
  $width=100;
    
  
    
  
  $persen=100/5;
  $x =0;
  $z=0; foreach ($data_table as $key){  if($z % 8==0){ 
    if(($jumlah-($x*8))<=1){
        $width=100/2;
      }
   ?>
    <table border="0" style="width: <?=$width;?>%;text-align: center;border-spacing:0px;page-break-after: always;">
        <?php } 
  if($z % 2==0){?>
        <tr>
            <td style="padding: 2mm;  height:<?=$persen;?>%; width: 50%; border: dotted 1px #777;">
                <?php }else{?>
            <td style="padding: 2mm; height:<?=$persen;?>%; width: 50%; border: dotted 1px #777;">
                <?php }?>
                <!--isi-->
                <table border="0"
                    style="background-color:yellow; width: 100%;height: 100%;border-collapse: collapse;border-spacing: 0px;">
                    <tr>
                        <td colspan="0" style="padding:2mm; text-align:left; font-size:5mm">
                            <?= $key->product_name;?>
                        </td>

                    </tr>
                    <tr>

                        <td colspan="0"
                            style="background-color:white; text-align: left; font-size: 10mm; padding: 2mm;">
                            Rp. <?= number_format($key->price,2, ',','.');?>
                        </td>

                    </tr>
                    <tr>

                        <td style="padding:2mm;font-size: 12px; text-align:left; font-size: 4mm;">
                            <?= $key->supplier_code;?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:2mm; text-align:left;">
                            <img src="<?=base_url('assets/lte/mpdf60/barcode/barcode.php?f=svg&s=code-128&d='.urlencode($key->product_code).'&sx=100&sy=30&bc=#ffff00&p=0');?>"
                                style="height:10mm;text-align: left; padding: 1mm;">
                        </td>

                    </tr>
                    <tr>
                        <td style="padding:2mm; text-align:left;padding-left:5mm; font-size: 4mm; font-weight: normal;">
                            BC: <?= $key->product_code;?> | PAT:
                            <?= $date;?>
                        </td>

                    </tr>

                </table>

                <?php $z=$z+1; if($z % 2==0){?>
            </td>
        </tr>
        <?php }else{?>
        </td>
        <?php } 
    if($z % 8==0 OR $z==$jumlah){ $x=$x+1; echo "</table>"; } } ?>
        <script type="text/javascript">
        setTimeout(function() {
            window.print();
        }, 100);
        </script>
</body>

</html>
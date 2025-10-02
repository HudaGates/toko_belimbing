<?php
require_once('assets/lte/mpdf60/qrcode/qrcode.class.php');
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
        font-family: "Microsoft Sans Serif", sans-serif !important;
        background-color: white;
        color: #000;
        text-align: center;
        vertical-align: top;
        font-weight: 700;
        font-size: 16pt;
    }

    table,
    tr,
    td {
        padding: 2px;
        vertical-align: middle;
        font-size: 100%;
    }
    </style>
</head>

<body>
    <?php
  $date =gmdate('Y-m-d',time()+60*60*7);
  $height=100;
  $width=100;
    
  
    
  
  $persen=100/2;
  $x =0;
  $z=0; foreach ($data_table as $key){  if($z % 4==0){ 
    if(($jumlah-($x*4))<=1){
        $width=100;
      }
   ?>
    <table border="0"
        style="width: <?=$width;?>%; height: 100%; text-align: center;border-spacing:0px;page-break-after: always;">
        <?php } 
  if($z % 2==0){?>
        <tr>
            <td style="padding: 2mm;  height:<?=$persen;?>%; width: 50%; border: dotted 1px #777;">
                <?php }else{?>
            <td style="padding: 2mm; height:<?=$persen;?>%; width: 50%; border: dotted 1px #777;">
                <?php }?>
                <!--isi-->
                <table border="1" style="width: 100%;height: 100%;border-collapse: collapse;border-spacing: 0px;">
                    <tr>
                        <td colspan="2" style="text-align: center; font-size: 5mm; padding: 1mm;">
                            <?= $key->part_no_fsi;?>
                        </td>

                    </tr>
                    <tr>
                        <td colspan="2" style=" text-align:center;">
                            <h2 style="margin: 0; font-size: 5mm; padding: 1mm;">
                                <?= $key->part_name;?>
                            </h2>
                        </td>

                    </tr>
                    <tr>
                        <td rowspan="3" style="width: 75%; font-size: 10px; text-align:center;margin: auto;">
                            <img src="<?= base_url('assets/part/img/' . $key->part_no_fsi . '.jpg?'.time()); ?>"
                                style="">
                        </td>
                        <td style="font-size: 12px; text-align:center; font-size: 4mm;">
                            <?= $key->storage;?>
                        </td>
                    </tr>
                    <tr>
                        <td style=" text-align:center;">
                            <img src="<?=base_url('assets/lte/mpdf60/qrcode/image.php?msg='.urlencode($key->part_no_fsi.'_'.$key->no_box).'&amp;err='.urlencode('Q'));?>"
                                style="width:20mm;height: 20mm;text-align: center; padding: 1mm;">
                        </td>

                    </tr>
                    <tr>
                        <td style="font-size: 12px; text-align:center; font-size: 4mm;">
                             <?= $key->part_no_fsi.'_'.$key->no_box;?>
                        </td>

                    </tr>

                </table>

                <?php $z=$z+1; if($z % 2==0){?>
            </td>
        </tr>
        <?php }else{?>
        </td>
        <?php } 
    if($z % 4==0 OR $z==$jumlah){ $x=$x+1; echo "</table>"; } } ?>
        <script type="text/javascript">
        setTimeout(function() {
            window.print();
        }, 100);
        </script>
</body>

</html>
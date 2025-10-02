<?php
require_once('assets/lte/mpdf60/qrcode/qrcode.class.php');
?>
<!DOCTYPE html>
<html>
<head>
<style type="text/css">
html,body { 
      height: 100%;
      width: 100%;
      padding:0px;
      margin:0px;
      font-family: sans-serif;
      background-color: white;
      color: #000;
      text-align: center;
      vertical-align: top;
      font-weight: 700;
      font-size: 11px;  
    }
    table,tr,td{
      padding: 1px;
      vertical-align: middle;
    }
}

</style>
</head>
<body>
  <?php
  if($jumlah>0){
  $date =gmdate('Y-m-d',time()+60*60*7);
  if($jumlah<10){
    $height=100/10*$jumlah;
    $width=100;
  }else{
    $height=100;
    $width=100;
  }
  $persen=100/10;
  $z=0; foreach ($data_table as $key){  if($z % 10==0){ 
    if($jumlah % 10==1){
      $width=50;
    }
   ?>
  <table style="width: <?=$width;?>%;height:<?=$height;?> %;text-align: center;border-spacing:0px;page-break-after: always;border-collapse: collapse;">
  <?php } 
  if($z % 2==0){?>
    <tr>
      <td style="padding: 5px;height:<?=$persen;?> %;border:1px dotted #444">
  <?php }else{?>
    <td style="padding: 5px;height:<?=$persen;?> %;border:1px dotted #444">
    <?php }?>
        <!--isi-->
        <table style="width: 100%;height: 100%;border-collapse: collapse;border-spacing: 0px;border:1px solid black;text-align: left">
          <tr>
            <td style="width: 33%;border:1px solid black;font-size: 8px;text-align: center;">
              <img src="<?=base_url($logo);?>" style="width:50px;height:35px;vertical-align: middle;">
              <br><?=$owner;?>
            </td>
            <td style="border:1px solid black;font-size: 18px;text-align: center;">
              <?=$doc_name;?>
            </td>
            <td style="width: 33%;border:1px solid black;font-size: 8px;">
              <table style="width: 100%;height: 100%;border-collapse: collapse;border-spacing: 0px;border-color: black">
                <tr>
                  <td>Document No</td>
                  <td>: <?=$doc_no;?></td>
                </tr>
                <tr>
                  <td>Active Date</td>
                  <td>: <?=date('F d, Y',strtotime($active_date));?></td>
                </tr>
                <tr>
                  <td>Revision</td>
                  <td>: <?=$revision;?></td>
                </tr>
                <tr>
                  <td>Page</td>
                  <td>:</td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              PRODUCTION DATE
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 13px;">
              : <?=date('d F Y',strtotime($key->prod_date));?>
            </td>
            <td rowspan="4" style="text-align: center;">
              <img src="<?=base_url('assets/lte/mpdf60/qrcode/image.php?msg='.urlencode($key->qr_partlabel).'&amp;err='.urlencode('Q'));?>" style="width:60px;height: 57px;text-align: center;padding-top:2px;">
              <br>
              Seq.<?=$key->label_seq;?> Id.<?=$key->id;?>
            </td>
          </tr>
          <tr>
            <td>
              PART NO
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 13px;">
              : <?=$key->part_no;?>
            </td>
          </tr>
          <tr>
            <td>
              QUANTITY
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 13px;">
              : <?=$key->qty_kbn;?> Pcs
            </td>
  
          </tr>
          <tr>
            <td>
              LOT NO / LOT SEQ
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 13px;">
              : <?=$key->lot_no.' / '.$key->lot_seq;?>
            </td>
          </tr>
          <tr>
            <td>
              OPERATOR
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 13px;">
              : <?=$key->prod_pic;?>
            </td>
            <td rowspan="3" style="padding: 1px;text-align: center;">
              <table border="1" style="width: 100%;height: 100%;border-collapse: collapse;border-spacing: 0px;border-color: black">
                <tr>
                  <td>INSPECTION</td>
                </tr>
                <tr>
                  <td style="font-size:18px"><?php $level=explode(' ',$key->level);
                  echo $level[0]."<br>".$level[1]; ?></td>
                </tr>
              </table>
            </td>
          </tr>
          <tr>
            <td>
              CUSTOMER
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 13px;">
              : <?=$key->customer_code;?>
            </td>
          </tr>
          <tr>
            <td>
              RACK NO
            </td>
            <td style="border-bottom: 1px dotted black;font-size: 14px;">
              : <?=$key->rack_no;?>
            </td>
          </tr>
        </table>

    <?php $z=$z+1; if($z % 2==0){?>
      </td>
    </tr>
  <?php }else{?>
    </td>
    <?php } 
    if($z % 10==0 OR $z==$jumlah){ echo "</table>"; } }
    }else{
      echo "DATA TIDAK DITEMUKAN";
    } ?>
<script type="text/javascript">
    setTimeout(function() { 
       window.print();
   }, 100);
</script>
</body>
</html>
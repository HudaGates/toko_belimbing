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
      font-family: arial;
      color: #000;
      text-align: center;
      font-size: 12px;
    }
</style>
</head>
<body>
  <?php
  if($jumlah>0){
  $date =gmdate('Y-m-d',time()+60*60*7);
  if($jumlah<9){
    $height=100/9*$jumlah;
    $width=100;
  }else{
    $height=100;
    $width=100;
  }
  $persen=100/9;
  $z=0; foreach ($data_table as $key){  if($z % 9==0){ 
    if($jumlah % 9==1){
      $width=33;
    }
   ?>
<table style="width: <?=$width;?>%;height:<?=$height;?> %;text-align: center;border-spacing:0px;page-break-after: always;border-collapse: collapse;">
  <?php } 
  if($z % 3==0){?>
    <tr>
      <td style="padding: 15px;height:<?=$persen;?> %;border:0px solid #444;text-align: center;">
  <?php }else{?>
    <td style="padding: 15px;height:<?=$persen;?> %;border:0px solid #444;text-align: center;">
    <?php }?>
    <table><tr><td style="padding:3px;border:1px solid #999;">
      <table style="width: 189px;height:302px;border-spacing: 0px;border-collapse: collapse;background-image:url('<?=base_url('assets/img/bgidcard.jpg');?>');opacity:1;background-repeat: no-repeat;background-size:100% 100%;">
        <tr>
          <td style="height: 40px;text-align: left;font-size: 14px;font-weight: bold;color: white;">
            <img src=".<?=$logo;?>" style="width:45px;height:35px;vertical-align: middle;">      
          </td>
        </tr>
        <tr style="height:235px;">
          <td>
            <table style="width: 100%;height:100%;text-align: center;">
              <tr>
                <td style="height:20px;font-weight: bold;">
                  
                </td>
              </tr>
              <tr>
                <td>
                  ID CARD ACCESS<br><br>
                  <img src="<?=base_url('assets/lte/mpdf60/qrcode/image.php?msg='.urlencode($key->idcard).'&amp;err='.urlencode('Q'));?>" style="width:60px;height: 60px;text-align: center;">

                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;font-size:12px;font-weight: bold">
                  <?=$detail;?>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;">
                  <?=$key->nik.'/'.strtoupper($key->nama);?>
                </td>
              </tr>
              <tr>
                <td style="vertical-align: middle;">
                  
                  <?=strtoupper($key->user_level);?>  <br><br>
                </td>
              </tr>
              <tr>
                <td style="height:20px;font-weight: bold;">
                  
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr>
          <td style="text-align: center;background-color: white;">
            <?=$owner;?>
          </td>
        </tr>
      </table>
      </td></tr></table>
 <?php $z=$z+1; if($z % 3==0){?>
      </td>
    </tr>
  <?php }else{?>
    </td>
    <?php } 
    if($z % 9==0 OR $z==$jumlah){ echo "</table>"; } }
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
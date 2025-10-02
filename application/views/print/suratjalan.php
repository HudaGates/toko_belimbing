<?php
require_once('assets/lte/mpdf60/qrcode/qrcode.class.php');
?>
<!DOCTYPE html PUBLIC>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Surat Jalan</title>
</head>

<body>
<table style="width:100%;height:100%; border-spacing:0px;" >
<tr>
<td align="center" style="padding-left:70px; padding-right:60px; padding-top:40px; padding-bottom:30px">
<table border="0" cellspacing="0" style="width: 100%;height:100%;font-family: Arial;font-size:10px;">
    
  <tr valign="top" height="14%">
    <td >
      <table style="width: 100%;height:100%;">
          <tr valign="top">
            <td width="40%">
            <div style=" text-align:left;font-size:14px; font-weight:bold;">PT. FUJI SEAT INDONESIA</div>
            <div style=" text-align:left;font-size:12px; ">
            SUNTER PLANT<br>
            Jl.Agung perkasa blok 9 k1 no 9, 15, Sunter Agung<br>
            Kawasan Industri Sunter - Jakarta Utara<br>
            14230 Jakarta - Indonesia<br>
            Telp. &nbsp;: (021) 6530 2228<br>
            Fax. &nbsp; : (021) 6530 2228<br>
            </div>
            </td>
            <td  width="33%" style=" text-align:center;font-size:22px; font-weight:bold;"><U>SURAT JALAN</U></td>
            <td align="center" valign="middle"><img src="<?=base_url('assets/lte/mpdf60/qrcode/image.php?msg='.urlencode($sj_no).'&amp;err='.urlencode('Q'));?>" style="width: 75px;height: 75px;"></td>
          </tr>
        </table>

    </td>
  </tr>
  <tr height="3%">
    <td style="font-family: Arial;font-size:12px;">&nbsp;T022-1</td>
  </tr>
  <tr height="3%" >
    <td>
      <table style="width: 100%;height:100%;font-family: Arial;font-size:12px;">
          <tr>
            <td width="33%" style="text-align:right; font-weight:bold;">Nomor :&nbsp; </td>
            <td width="40%">&nbsp;<?=$sj_no;?> <b>Trip No : </b> <?=$qt->trip;?></td>
            <td align="right" >Jakarta, </td>
            <td  align="left" width="19%" nowrap><?=$prod_date;?></td>
          </tr>
        </table>

    </td>
  </tr>
  <tr height="2%">
    <td>
      <table style="width: 100%;height:100%;font-family: Arial;font-size:12px; font-weight:bold;">
          <tr>
            <td width="65%">PEMESAN :</td>
            <td>KIRIM KE :</td>
          </tr>
        </table>
    </td>
  </tr>
  <tr height="8%" valign="top"> 
    <td>
      <table style="width: 100%;height:100%;font-family: Arial;font-size:12px;">
          <tr valign="top">
            <td width="2%"></td>
            <td width="50%">
              PT. ASTRA DAIHATSU MOTOR<br>
                Kawasan Gaya Motor<br>
                Jl. Gaya Motor Barat No. 3<br>
            </td>
            <td>
              PT. ASTRA DAIHATSU MOTOR  ASSY <?=$qt->shop;?><br>
                Jl. Gaya Motor Barat No. 3, Kawasan Industri Gaya Motor<br>
                Jakarta Utara 1431 - Jakarta, INDONESIA<br>
                Telp. (021) 6531 0202<br>
            </td>
          </tr>
        </table>
    </td>
  </tr>
  <tr height="2%">
    <td style="font-family: Arial;font-size:12px;font-weight: bold;">ORDER NO. : <?=$seqmin." TO ".$seqmax;?></td>
  </tr>
  <tr valign="top" >
    <td style="height:40%;">
      <table border="0"  cellspacing="0" style="width: 100%; height:100%; font-family: Arial;font-size:12px; border:medium;border-bottom:1px solid #000;">
          <tr align="center" style="font-family: Arial;font-size:10px; font-weight:bold;">
            <td width="6%" style="height:5%; border:1px solid #000">NO</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000" width="20%">CODE FUJI SEAT INDONESIA</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000" >NAMA BARANG</td>
            <td style="border-right:1px solid #000;border-top:1px solid #000;border-bottom:1px solid #000" width="15%" >BANYAK NYA</td>
          </tr>
          <?php $i=1; foreach ($data_table as $key) { ?>
              <tr>
                <td style="text-align: center;border-right:1px solid #000;border-left:1px solid #000; height:5%;">
                  <?=$i;?>
                </td>
                <td width="15%" style="text-align: left;border-right:1px solid #000;">&nbsp;
                  <?=$key->part_no;?>
                </td>
                
                <td style="text-align: left;border-right:1px solid #000;">&nbsp;
                  <?=$key->item.' '.$key->code;?>
                </td>
                <td style="text-align: center;border-right:1px solid #000;">
                  <?=$key->jumlah;?>
                </td>
              </tr>
            <?php $i=$i+1; } ?>
            
            <tr>
            <td width="6%" style="border-right:1px solid #000;border-bottom:1px solid #000;border-left:1px solid #000"></td>
            <td style="border-right:1px solid #000;border-bottom:1px solid #000;" width="20%"></td>
            <td style="border-right:1px solid #000;border-bottom:1px solid #000;" >&nbsp;</td>
            <td style="border-right:1px solid #000;border-bottom:1px solid #000;" width="15%" ></td>
          </tr>
          
        </table>

    </td>
  </tr>
  <tr height="1%">
    <td>&nbsp;</td>
  </tr>
  <tr height="15%">
    <td><table style="width: 100%;height:100%;font-family: Arial;font-size:10px;">
      <tr>
        <td width="70%">Diterima Tanggal : ..............................................</td>
        <td>&nbsp;&nbsp;Kep. Seksi Ekspedisi</td>
      </tr>
      <tr>
        <td>Jam : ......................... s/d Jam : ........................</td>
        <td>PT. FUJI SEAT INDONESIA</td>
      </tr>
      <tr height="80%" valign="bottom">
        <td>&nbsp;</td>
        <td>YUTAKA TSUJIMURA</td>
      </tr>
      <tr>
        <td>(Tanda Tangan Penerima dan Nama Terang)</td>
        <td>...........................................................................</td>
      </tr>
    </table></td>
  </tr>
</table>

</td>
</tr>
</table>
<script type="text/javascript">
  window.print();
   setTimeout(function() { 
        //window.close();
   }, 10);
   
</script>
</body>
</html>
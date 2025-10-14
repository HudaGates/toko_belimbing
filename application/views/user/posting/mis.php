<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Posting</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?=site_url('assets/lte/sweetalert/sweetalert.css') ?>"/>
  <style type="text/css">
    html, body { 
      height: 100%;
      width: 100%;
      padding:0px;
      margin:0px;
      font-family: sans-serif;
      overflow-x: auto;
      overflow-y: auto;
      font-size: 10px;
      font-weight: 700;
    }

    .btn {
        display: inline-block;
        padding: 6px 12px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: normal;
        line-height: 1.42857143;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        -ms-touch-action: manipulation;
            touch-action: manipulation;
        cursor: pointer;
        -webkit-user-select: none;
           -moz-user-select: none;
            -ms-user-select: none;
                user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
      }
      .btn-block {
        display: block;
        width: 100%;
        }
      .btn-danger {
        color: #fff;
        background-color: #d9534f;
        border-color: #d43f3a;
      }

      .btn-primary {
        color: #fff;
        background-color: #3c8dbc;
        border-color: #367fa9;
      }
      .btn-success {
        color: #fff;
        background-color: #00a65a;
        border-color: #008d4c;
      }
      .btn-success:hover,
      .btn-success:active,
      .btn-success.hover {
        background-color: #008d4c;
     }
      .tb{
        padding: 5px;
      }
      .text-danger {
        color: #a94442;
        font-size: 10px;
        font-weight: bold;
        margin: 0px;
      }
      .form-group {
        margin-bottom:0px;
        }
      .form-control {
        display: block;
        width: 90%;
        height: 25px;
        padding: 3px 6px;
        font-size: 14px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #999;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
             -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
                transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
      }
      .form-control:focus {
        border-color: #66afe9;
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
                box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102, 175, 233, .6);
      }
      .has-error .form-control {
        border-color: #a94442;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .015);
                box-shadow: inset 0 1px 1px rgba(0, 0, 0, .015);
      }
      .has-error .form-control:focus {
        padding: 0px;
        border-color: #843534;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 2px #ce8483;
      }
         
</style>
  <!-- Ionicons -->
  <script type="text/javascript">
    //set timezone
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    //buat object date berdasarkan waktu di server
    var serverTime = new Date(<?php print date('Y, m, d, H, i, s, 0'); ?>);
    //buat object date berdasarkan waktu di client
    var clientTime = new Date();
    //hitung selisih
    var Diff = serverTime.getTime() - clientTime.getTime();    
    //fungsi displayTime yang dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
    function displayServerTime(){
        //buat object date berdasarkan waktu di client
        var clientTime = new Date();
        //buat object date dengan menghitung selisih waktu client dan server
        var time = new Date(clientTime.getTime() + Diff);
        //ambil nilai jam
        var sh = time.getHours().toString();
        //ambil nilai menit
        var sm = time.getMinutes().toString();
        //ambil nilai detik
        var ss = time.getSeconds().toString();
        //tampilkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
        $("#clock").text((sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss));
    }
    setInterval('displayServerTime()',500);
</script>
</head>
<body>
<table style="height: 100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
  <tr>
    <td>
      <table border="1" style="height:100%;width: 100%;border-spacing: 0px;border-radius: 10px;border-spacing: 0px;border-collapse: collapse;border-color:#aaa"> 
        <tr>
          <td colspan="2" style="height: 5%">
            <table style="width: 100%;height: 100%;border-spacing: 0px;background-color:teal;border-spacing: 0px;border-collapse: collapse;">
              <tr>
                <td style="width:40px;text-align: center;">
                  <img src="<?=base_url('assets/img/logo.jpg');?>" style="width:40px;height:30px;vertical-align: middle;text-align: center">
                </td>
                  <td style="color:white;text-align: center;font-weight: bold;font-size: 18px;">
                  POSTING PART
                </td>
              </tr>
            </table>
          </td>
        </tr>
        <tr style="background-color: #ddd;height: 6%;vertical-align: middle;">
          <td style="border-right: 0px;">
            <?=$this->nama;?>
          </td>
          <td style="text-align: right;border-left: 0px;">
            <?=date('l, d-m-Y');?> <span id="clock"><?=date('H:i:s');?></span>
          </td>
        </tr>
          <tr>              
            <td colspan="2" style="padding: 8px;vertical-align: top;background-color: white;font-size: 11px;">
                <table style="height: 100%;width: 100%;border-spacing: 0px;color: black;border-color:#aaa;">
                  <tr>
                    <td style="padding: 0px;">
                      <table style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                        <tr>
                          <td style="height:10%;text-align: left;font-size: 150%;text-align: center;color:red;padding-bottom: 2px;font-weight: bold;">  
                            TELAH TERJADI SALAH POSTING !!!         
                          </td>
                        </tr>
                        
                        <tr>
                          <td>
                            <table border="1" style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #ccc;border:1px solid #ccc;">
                               <tr>
                                <td style="text-align: right;padding: 3px;">
                                 PART NO TRUE
                                </td>
                                <td style="text-align: left;padding: 3px;background-color: green;color: white;font-size:150%">
                                  <?=$data_mis->true_part_no;?>
                                </td>
                              </tr>
                              <tr>
                                <td style="width: 35%;text-align: right;padding: 3px;">
                                  RACK NO TRUE
                                </td>
                                <td style="text-align: left;padding: 3px;background-color: green;color: white;">
                                  <?=$data_mis->true_rack_no;?>
                                </td>
                              </tr>
                             <tr>
                                <td style="text-align: right;padding: 3px;">
                                  PART NO FALSE
                                </td>
                                <td style="text-align: left;padding: 3px;background-color: red;color: white;font-size:150%">
                                  <?=$data_mis->false_part_no;?>
                                </td>
                              </tr>
                              <tr>
                                <td style="text-align: right;padding: 3px;">
                                  RACK NO FALSE
                                </td>
                                <td style="text-align: left;padding: 3px;background-color: red;color: white">
                                  <?=$data_mis->false_rack_no;?>
                                </td>
                              </tr> 
                              <tr>
                                <td style="text-align: right;padding: 3px;">
                                  POSTING DATE
                                </td>
                                <td style="text-align: left;padding: 3px;">
                                  <?=$data_mis->posting_date;?>
                                </td>
                              </tr>
                            </table>

                          </td>
                        </tr>
                        <tr>
                          <td style="height:7%;text-align: center;vertical-align: bottom;font-size: 130%;color: blue;padding: 3px">  
                            KONFIRMASI LEADER       
                          </td>
                        </tr>          
                        <tr>
                          <td style="vertical-align: top;text-align: right;height:50%">
                            <?=form_open('posting/submitmis?api='.$this->id_t, 'id="mydata1" ');?>
                            <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
                            <input type="hidden" id="id" name="id" value="<?=$data_mis->id;?>" />
                            <table border="1" style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #ccc;border:1px solid #ccc;">
                              <tr>
                                <td style="width: 35%;text-align: right;height: 40px;padding: 3px;">
                                  PROBLEM
                                </td>
                                <td style="text-align: left;font-weight: normal;vertical-align: middle;padding: 5px;">
                                  <div class="form-group" style="padding: 0px;">
                                  <input type="text" id="problem" name="problem" class="form-control"/>
                                </div>
                                </td>
                              </tr>
                              <tr>
                                <td style="text-align: right;height:40px;padding: 3px;">
                                 PASS. LEADER
                                </td>
                                <td style="text-align: left;font-weight: normal;padding: 3px;">
                                  <div class="form-group" style="padding: 0px;">
                                    <input type="password" id="password" name="password" class="form-control">
                                  </div>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="2" style="text-align: center;padding: 3px;">
                                  <button type="submit" class="btn btn-success" style="width: 50%;margin: auto;"> SUBMIT </button>
                                </td>
                              </tr> 
                            </table>
                            <?=form_close();?>
                          </td>
                        </tr>
                    </table>
                    </td>
                  </tr>
                </table>         
           </td>
          </tr>
        </table>
    </td>
  </tr>
</table>
<script src="<?=site_url('assets/lte/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>

<script type="text/javascript">
 
$('#mydata1').submit(function(e){
    e.preventDefault();
     var fa = $(this);            
      $.ajax({
        url: fa.attr('action'),
        type: 'post' ,
        data: fa.serialize(),
        cache:false,
        dataType: 'json',
        success: function(response) {
          if(response.success == true) {
              swal({
                title: "Submit Success",
                text: "",
                type: "success",
                timer: 1200,
                showConfirmButton: false
              });
              window.location.href ="<?=base_url('posting/start?pos='.$pos_level.'&api='.$this->id_t);?>";  
          } else {
            $.each(response.messages,function(key, value){
              var element = $('#' + key);
              element.closest('div.form-group')
              .removeClass('has-error')
              .addClass(value.length > 0 ? 'has-error' : 'has-success')
              .find('.text-danger')
              .remove();
              element.after(value);
            });
          }
        }
     });
  });
var id ="<?=$data_mis->id;?>";
if(id==''){
  window.location.href ="<?=base_url('posting/start?pos='.$pos_level.'&api='.$this->id_t); ?>"; 
}
</script>

</body>
</html>
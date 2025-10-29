<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Posting</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
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
        color: green;
      }
      .label{
        text-align: left;
        font-size: 11px;
        color:#000;
      }
  </style>
  <script type="text/javascript">
    //set timezone
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    //buat object date berdasarkan waktu di server
    var serverTime = new Date(<?=date('Y, m, d, H, i, s, 0'); ?>);
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
        document.getElementById("clock").innerHTML = (sh.length==1?"0"+sh:sh) + ":" + (sm.length==1?"0"+sm:sm) + ":" + (ss.length==1?"0"+ss:ss);
    }
</script> 
</head>
<body onLoad="setInterval('displayServerTime()',100);">
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
              <td onclick="logout()"  style="width: 35px;text-align: center;vertical-align: middle;">
                <img src="<?=base_url('assets/img/logout.png');?>" style="width:35px;height:30px;vertical-align: middle;">
              </td>
            </tr>
          </table>
        </td>
        </tr>
        <tr style="background-color: #ddd;height: 6%;vertical-align: middle;">
          <td style="border-right: 0px;">
            <?=$this->nama.' ('.$pos_level.')';?>
          </td>
          <td style="text-align: right;border-left: 0px;">
            <?=date('l, d-m-Y');?> <span id="clock"><?=date('H:i:s');?></span>
          </td>
        </tr>
        <tr>
          <td colspan="2" style="padding: 0px;">            
             <table  border="1" style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;font-size: 14px;font-weight: bold;border-color: #ccc;border:1px solid #ccc;text-align:center;">             
              <tr>
                <td class="tb" style="width: 50%;height: 20%">
                  <div class="label">Variant</div>
                  <?=$variant;?>
                </td>
                <td class="tb">
                  <div class="label">Model</div>
                  <?=$model;?>
                </td>
              </tr>
              <tr>
                <td class="tb" style="width: 50%;height: 20%">
                  <div class="label">Part No</div>
                  <?=$part_no;?>
                </td>
                <td class="tb">
                  <div class="label">Rack No</div>
                  <?=$rack_no;?>
                </td>
              </tr>
              <tr>
                <td colspan="2" style="vertical-align: top">
                  <table border="1"  style="width: 100%;border-spacing: 0px;border-collapse: collapse;font-size: 11px;font-weight: bold;border-color: #ccc;border:1px solid #ccc;text-align:center;">
                    <tr>
                      <td colspan="5" style="text-align: left;height: 14px;border:1px solid #fff">History Scan Posting</td>
                    </tr>
                    <tr style="background-color: teal;color:white;height: 20px">
                      <td>No</td><td>Part No</td><td>Model</td><td>Rack&nbsp;No</td><td>Posting Date</td>
                    </tr>
                    <?php if(!empty($data_posting)){
                      $i=1; foreach ($data_posting as $key) { ?>
                    <tr>
                      <td style="height: 20px;"><?=$i++;?></td>
                      <td><?=$key->part_no;?></td>
                      <td><?=$key->model;?></td>
                      <td><?=$key->rack_no;?></td>
                      <td><?=$key->posting_date;?></td>
                    </tr>
                  <?php } }else{ ?>
                    <tr>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                      <td>&nbsp;</td>
                    </tr>
                  <?php } ?>
                  </table>
                </td>
              </tr>
            </table>

          </td>
        </tr>
        <tr>
          <td colspan="2" style="height:8%;padding:8px;">
           <?=form_open('posting/scan?api='.$this->id_t, 'id="mydata" '); ?>
           <input id="pos_level" type="hidden" name="pos_level" value="<?=$pos_level; ?>">
           <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
            <input id="qrcode" name="qrcode" type="text" style="font-size: 100%;height:16px;vertical-align: middle;width: 100%;border:1px solid #999;text-align: center;" autocomplete="off" onfocus="this.value=''">
          <?=form_close();?>
        </td>
        </tr>
        <tr>
          <td id="scanstatus" colspan="2" style="height: 12%;font-size: 14px;text-align: center;vertical-align:middle;font-weight: bold;background-color: #aea">
            <?=$scanstatus;?>
          </td>
        </tr>
        <tr>
          <td style="padding: 3px;height: 5%;width: 50%">
            <button  class="btn btn-danger btn-block btn-outline" onclick="back()">Back</button>
          </td>
          <td style="padding: 3px;">
            <button class="btn  btn-primary btn-block btn-outline" onclick="home()">Home</button>
          </td>
        </tr>     
      </table>
    </td>
  </tr>
</table>
<script src="<?=site_url('assets/lte/jquery/jquery-2.2.3.min.js')?>"></script>
<script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>
<script type="text/javascript">
 function loaded(b){
    var audioCtx = new (window.AudioContext || window.webkitAudioContext)();
    var source = audioCtx.createBufferSource();
    var xhr = new XMLHttpRequest();
    xhr.open('GET', b);
    xhr.responseType = 'arraybuffer';
    xhr.addEventListener('load', function (r) {
    audioCtx.decodeAudioData(
      xhr.response,
      function (buffer) {
      source.buffer = buffer;
      source.connect(audioCtx.destination);
      source.loop = false;
      });
    playsound();
    });
    xhr.send();
    var playsound = function () {
      source.start(0);
      };
    }
cv='<?=$this->security->get_csrf_hash(); ?>';
$(document).ready(function() {
       var mis_posting="<?=$mis_posting;?>";
       $("#qrcode").focus();

       if(mis_posting!=''){
          window.location.href ="<?=base_url('posting/mis?pos='.$pos_level.'&api='.$this->id_t); ?>"; 
       }
  });

$("*").click(function(){
          $("#qrcode").focus();
      });

$('#mydata').submit(function(e){
        e.preventDefault();
         var fa = $(this);            
          $.ajax({
            url: fa.attr('action'),
            type: 'post' ,
            data: fa.serialize(),
            dataType: 'json',
            success: function(data) {
              $("#scanstatus").text(data.status);
              if(data.status == 'SUCCESS'){
                  $("#scanstatus").css({"background-color": "green","color": "white"});
                  var b = '<?=base_url('mp3/ok');?>.mpeg';
                  loaded(b);
                  setTimeout(function(){
                     location.reload();
                  },1000);
               }else if(data.status == 'MIS POSTING'){
                   $("#scanstatus").css({"background-color": "red","color": "white"});
                    var b = '<?=base_url('mp3/error');?>.mpeg';
                    loaded(b);
                    setTimeout(function(){
                      window.location.href ="<?=base_url('posting/mis?pos='.$pos_level.'&api='.$this->id_t); ?>";  
                      },700);
              }else if(data.status == 'LOGOUT'){
                setTimeout(function(){
                   window.location.href ="<?=base_url('action/logout?api='.$this->id_t);?>"
                  },300);    
              }else{
                $("#scanstatus").css({"background-color": "red","color": "white"});
                var b = '<?=base_url('mp3/error');?>.mpeg';
                loaded(b);
              }
              $("#qrcode").focus();
              
            }
         });

      });
  function back(){
          swal({
              title: "Are you sure?",
              text: "Back Page",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: 'btn-danger',
              confirmButtonText: 'Yes',
              closeOnConfirm: false,
                //closeOnCancel: false
              },
              function(){
                window.location.href ="<?=base_url('posting?api='.$this->id_t); ?>";
              });      
      }
   function home(){
          swal({
              title: "Are you sure?",
              text: "Back Home",
              type: "warning",
              showCancelButton: true,
              confirmButtonClass: 'btn-danger',
              confirmButtonText: 'Yes',
              closeOnConfirm: false,
                //closeOnCancel: false
              },
              function(){
                window.location.href ="<?=base_url('home?api='.$this->id_t); ?>";
              });      
      }
   function logout(){
    swal({
        title: "Are you sure logout?",
        text: "Finish this session",
        type: "warning",
        showCancelButton: true,
        confirmButtonClass: 'btn-danger',
        confirmButtonText: 'Yes',
        closeOnConfirm: false,
          //closeOnCancel: false
        },
        function(){
          window.location.href ="<?=base_url('action/logout?api='.$this->id_t); ?>";
        });             
  }
  function cekmis(){
    $.ajax({
            type: "POST",
            url : "<?=base_url('posting/cekmis?pos='.$pos_level.'&api='.$this->id_t); ?>",
            data:"<?=$this->security->get_csrf_token_name();?>="+cv,
            cache:false,
            dataType:'json',
            success: function(data){
                 if(data.status==true){
                        window.location.href ="<?=base_url('posting/mis?pos='.$pos_level.'&api='.$this->id_t); ?>"; 
                  }
              },
               error: function(error)
                     {
                    window.location.reload();
                    } 
          });
  }
  setInterval(function(){
    cekmis();  
    },3000);
</script>


</script>
</body>
</html>

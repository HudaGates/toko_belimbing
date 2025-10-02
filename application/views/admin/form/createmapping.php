<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Quality</title>
  <!-- Tell tde browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.6 -->
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/AdminLTE.min.css');?>">
  <style type="text/css">
    html,body { 
        height: 100% !important;
        width: 100% !important;
        padding:0px !important;
        margin:0px !important;
        font-family: sans-serif;
        background-color: #00a7d0;
        color: #000;
        text-align: center;
        font-weight: bold;
        overflow: auto !important;
        
      }
      table{
        height: 100% !important;
        width: 100% !important;
        

        }
      tr,td {
        padding: 0px !important;
        margin: 0px !important;
        
      }
  </style>
</head>
<body>
  <?php 
    $filex='gambar/qc/'.$part_no.'.jpg';
    $ss=substr(trim($qmp->item),-2);
    if($ss=='.2'){
      $ss='RR2';
    }
    $dummy=$ss.'-'.trim($qmp->code);
    if(!file_exists($filex)){
       $filex=base_url('gambar/qc/'.$dummy.'.jpg');
    }else{
       $filex=base_url('gambar/qc/'.$part_no.'.jpg');
    }
   
   ?>
<table>
  <tr>
    <td style="padding: 3px !important;">
      <table>
        <tr>     
          <td style="height:5%;border:1px solid #444;color:white;background-color: #00a7d0;text-align: center;font-size: 24px;">
            UPDATE MAPPING PROBLEM NG (<?=$qmp->grade.' '.$part_no.' '.$qmp->code;?>) <button id="close" class="btn btn-danger btn-sm" type="submit">CLOSE</button> 
          </td>
        </tr>
        <tr>
          <td style="padding:3px !important;border:1px solid #444;background-color: #fff;">

            
              <table style="width: 100%;height:100%;background:url('<?=$filex;?>');background-repeat: no-repeat;background-size:100% 100%">
                <?php for($i=1;$i<=25;$i++){?>
                <tr>
                  <?php for($j=1;$j<=50;$j++){ 
                    $bg="";
                    $no='';
                    foreach ($data_mapping as $key) {
                      
                      if('A'.$i.'B'.$j==$key->mapping_no){$bg="background-color:red"; $no=$key->problem_no;}
                     }
                    ?>
                  <td id="set<?='A'.$i.'B'.$j;?>" onclick="mapping('<?='A'.$i.'B'.$j;?>')" style="height:4%;width:2%;border:1px solid #00a7d0;font-weight:bold;color:#fff;opacity: 0.4;vertical-align:middle;<?=$bg;?>">
                    <span id="<?='A'.$i.'B'.$j;?>"><?=$no;?></span>
                  </td>
                  <?php } ?>
                </tr>
                <?php } ?>
              </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
</table>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-header bg-blue text-center" style="font-size: 150%;">
                PILIH NO PROBLEM  
            </div>
        <div class="modal-content" style="border:1px solid #444;">
            <div class="box small-box" id="problem">
            </div>                      
        </div>
    </div>
</div>
<!-- modal ng -->
<script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js');?>"></script>
<script src="<?=base_url('assets/lte/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>

<script type="text/javascript">
   var csfrData = {};
    csfrData['<?=$this->security->get_csrf_token_name(); ?>'] = '<?=$this->security->get_csrf_hash(); ?>';
    $.ajaxSetup({
    data: csfrData
    });
  cv='<?=$this->security->get_csrf_hash(); ?>';
function mapping(AiBj){
      var part_no = "<?=$part_no;?>";
      var grade = "<?=$qmp->grade;?>";
      var mapping_no = AiBj;
      var setid =  $("#"+AiBj).text();
        if(setid==''){
           $.ajax({
              type: "POST",
              url : "<?=base_url('mapping/viewproblem?api='.$id_t); ?>",
               data:"part_no="+part_no+"&mapping_no="+mapping_no+"&grade="+grade+"&<?=$this->security->get_csrf_token_name();?>="+cv,
              cache:false,
              success: function(data){
                  $("#problem").html(data);
                  $("#myModal").modal('show'); 
                }
            });

        }else{
          $.ajax({
            type: "POST",
            url : "<?=base_url('mapping/setremove?api='.$id_t); ?>",
             data:"part_no="+part_no+"&mapping_no="+mapping_no+"&grade="+grade+"&<?=$this->security->get_csrf_token_name();?>="+cv,
            cache:false,
            success: function(data){
                $("#set"+AiBj).css({"background-color": ""});          
                $("#"+AiBj).text(''); 
              }
          });
         
          
        }
      };
 $("#close").click(function(){ 
  window.top.close();   // Closes the new window
});
</script>
</body>
</html>

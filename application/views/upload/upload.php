<!-- /.box -->
<div id="form1"  class="box no-border" style="margin-top: -15px;padding: 5px;">
  <div class="small-box text-purple" style="border:1px solid #ccd;margin:5px;padding: 2px;">
    <div class="box-header with-border">
      <button class="btn btn-default text-red pull-right exit"><span class="glyphicon glyphicon-remove"></span></button>
      <h5 class="text-bold">FORM UPLOAD DATA</h5>
    </div>
<!-- /.box-header -->
<!-- form start -->
<form id="submit">
  <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
  <div class="box-body">
    <div class="form-group">
      
        <a href="<?=base_url()?>formatexcel/<?=$table;?>.xlsx" class="btn btn-default text-green" title="Download Format Excel Upload">
            <span class="fa fa-file-excel-o fa-lg"> </span> Format upload file excel
        </a>
    </br></br> 
      <label for="exampleInputFile">File upload excel</label>
      <input id="fileupload" type="file" name="fileimport">
    </div>
    <p><code id="hasil">Progress</code></p>
    <div class="progress active" id="progress">
      
    </div>


  </div>
  <!-- /.box-body -->
    <div class="box-footer width-border">
        <button type="submit" class="btn btn-success" id="save"> Submit </button>
        <button type="reset" class="btn btn-default exit">Close</button>
    </div>
</form>
</div>
</div>
<script  type="text/javascript">
$(document).ready(function(){
  var myVar;
  var x = 100;
  var tabel1 = "<?=$table;?>";
  function statusupload(){
  myVar = setTimeout(function(){
        $.ajax({
            async: true,
            type: "POST",
            url : "<?=base_url('master/statusupload?api='.$id_t);?>",
            data: "table="+tabel1,
            cache:false,
            dataType: 'json',
            success: function(data){
                persen = (data.persen *1)+0;
                $('#hasil').text(data.success+" success "+data.failed+" failed from "+data.total+" rows");
                $("#progress").html("<div class='progress-bar progress-bar-primary progress-bar-striped text-center text-red' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:"+persen+"%'>"+persen+"%</div>");                       
                if(persen == 100){
                  x= 0; 
                  clearTimeout(myVar);
                  setTimeout(function(){
                     table.ajax.reload();
                    swal({
                        title: "Upload Finish",
                        text: '',
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                      }); 
                    $("#form1").hide(); 
                  },2000);                                    
                }
                
            }
        });
         statusupload();
      },x);  
                  
  } 
  $(".exit").click(function(){
  $("#form1").hide();
  });
  $('#submit').submit(function(e){
      $("#save").attr('disabled', true);
      statusupload(); 
      e.preventDefault(); 
           $.ajax({
               async:true,
               url:'<?=base_url('master/upload?api='.$id_t);?>',
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               dataType: 'json',
                success: function(data){                  
                  if(data.status == "error"){
                     $("#save").attr('disabled', false);
                      x= 0;
                      clearTimeout(myVar);
                      swal({
                        title: "Error!",
                        text: data.msg,
                        type: "warning",
                        timer: 1200,
                        showConfirmButton: false
                      });                          
                  }
                                                                             
             }

           });
            
      }); 

         
    });   

</script>
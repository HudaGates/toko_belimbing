<!-- /.box -->
<div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">ADD ORDER</h4>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <div class="box">
      <form id="submit">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
              <label for="exampleInputFile">File upload excel<a href="<?=base_url()?>formatexcel/<?='ADD_20200428';?>.xlsx" class="btn btn-default text-green" title="Download Format Excel Upload">
                <span class="fa fa-file-excel-o fa-lg"> </span> Format upload file excel
              </a></label>
               <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
              <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
              <input id="fileupload" type="file" name="fileimport">
            </div>
            <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
              <div class="callout callout-danger" style="padding: 3px">
            <big><code>Ketentuan Additional Order</code></big>
            <ul>
              <li><b>1. Customer Code</b> (Pastikan ada di Master Customer)</li>
              <li><b>2. Order No</b> (Pastikan ada di Data Order Customer)</li>
              <li><b>3. Part No</b> (Pastikan ada di Master Part)</li>
              <li><b>4. Order Kbn</b> (Pastikan Lebih dari 0)</li>
              <li><b>5. Pastikan kolom-kolom lain terisi dengan baik</li>
              <li><b>6. Bila Sudah Proses Pulling, Cancel Order(pengurangan) harus melalui SCAN</li>
           </ul>
              </div>
            </div>
          </div>  
        </div>
        <div class="form-group">
          <p><code id="hasil">Progress</code></p>
          <div class="progress active" id="progress"  style="height:30px;"></div>
        </div>
      <!-- /.box-body -->
        <div class="box-footer width-border">
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
             <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
    </form>
</div>
</div>
<script  type="text/javascript">
$(document).ready(function(){
  var myVar;
  var x = 1000;
  var tabel1 = "<?=$table;?>";
  function statusupload(){
  myVar = setTimeout(function(){
        $.ajax({
            async: true,
            type: "POST",
            url : "<?=base_url('planning/statusupload?api='.$id_t);?>",
            data: "table="+tabel1+"&<?=$this->security->get_csrf_token_name();?>="+cv,
            cache:false,
            dataType: 'json',
            success: function(data){
                persen = (data.persen *1)+0;
                $('#hasil').text(data.success+" success "+data.failed+" failed from "+data.total+" rows");
                $("#progress").html("<div class='progress-bar progress-bar-primary progress-bar-striped text-center text-red bg-green' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:"+persen+"%'>"+persen+"%</div>");                       
                if(persen == 100){
                  x= 0; 
                  clearTimeout(myVar);
                  setTimeout(function(){
                    $('#example').DataTable().ajax.reload();
                    swal({
                        title: "Upload Finish",
                        text: '',
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                      }); 
                    $("#myModal").modal('hide'); 
                  },2000);                                    
                }
                
            }
        });
         statusupload();
      },x);  
                  
  } 
  $(".exit").click(function(){
    x= 0; 
    clearTimeout(myVar);
  });

  $('#submit').submit(function(e){
      $("#save").attr('disabled', true);
      statusupload();
      e.preventDefault(); 
           $.ajax({
               url:'<?=base_url('planning/uploadaddorder?api='.$id_t);?>',
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:true,
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
                  }else{
                    if(data.status == "gagal"){
                      $("#save").attr('disabled', false);
                      gagalupload(tabel1);
                      x= 0; 
                      clearTimeout(myVar);                         
                    }  
                  }
                                                                                
             }

           });
            
      });                   
         
    });   

function gagalupload(table){
    $.ajax({
          type: "POST",
          url : "<?=base_url('planning/gagalupload?api='.$id_t); ?>",
          data:"table="+table+"&<?=$this->security->get_csrf_token_name();?>="+cv,
            cache:false,
            success: function(data){
                $("#view").html(data);
                $("#myModal").modal('show');
            }
        });
}
</script>
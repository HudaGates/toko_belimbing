<!-- form start -->
<div class="modal-header">
  <h4 class="modal-title">Excel file import <a href='<?=base_url()?>formatexcel/planning_20210130.xlsx' class='btn btn-outline-info' title='Download Format file excel'><span class='fa fa-file-excel-o fa-lg'></span>Download format file</a></h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  
  <div class="box">
    <form id="submit">
      <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Pilih Line</label>
          <select class="form-control" name="line_no" id="line_no">
              <option value="All">All</option>
              <?php foreach ($data_line as $key) { ?>
                <option value="<?=$key->line_no;?>"><?=$key->line_name.'(Line '.$key->line_no.')';?></option>
              <?php  } ?>
          </select> 
        </div>
        <div class="form-group">
          <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
          <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
          <input id="fileimport" type="file" name="fileimport">
        </div>
        <p><code id="hasil">Progress</code></p>
        <div class="progress active" id="progress">  
        </div>
      </div>
      <!-- /.box-body -->
        <div class="box-footer width-border">
          <br>
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
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
            url : "<?=base_url('master/statusupload?api='.$id_t);?>",
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
  $(".close").click(function(){
    x= 0; 
    clearTimeout(myVar);
  });

  $('#submit').submit(function(e){
      $("#save").attr('disabled', true);
      statusupload();
      e.preventDefault(); 
           $.ajax({
               url:'<?=base_url('master/uploadplanning?api='.$id_t);?>',
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
          url : "<?=base_url('master/gagaluploadpl?api='.$id_t); ?>",
          data:"table="+table+"&<?=$this->security->get_csrf_token_name();?>="+cv,
            cache:false,
            success: function(data){
                $(".modal-content").html(data);
                $("#myModal").modal('show');
            }
        });
}
</script>

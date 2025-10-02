<div class="modal-header">
  <h4 class="modal-title">Form Swicthing Lifting</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  
  <div class="box">
      <?=form_open('master/switching?api='.$id_t, 'id="mydata"'); ?>
        <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class="box-body">                               
            <div class="form-group">
              <label for="exampleInputEmail1">From Lifting</label>
              <input id="lifting_no1" type="text" class="form-control" name="lifting_no1" class="form-control">
            </div> 
            <div class="form-group">
              <label for="exampleInputEmail1">To Lifting</label>
              <input id="lifting_no2" type="text" class="form-control" name="lifting_no2" class="form-control">
            </div>                        
          </div>
    <!-- /.box-body -->
          <div class="box-footer width-border">
            <button type="submit" class="btn btn-success"> Submit </button>
          </div>
       </form>
    </div>
 </div>   
<script type="text/javascript"> 
$('#mydata').submit(function(e){
    e.preventDefault();
     var fa = $(this);            
      $.ajax({
        url: fa.attr('action'),
        type: 'post' ,
        data: fa.serialize(),
        dataType: 'json',
        success: function(response) {
          if(response.success == true){
            swal({
                title: "Success!!",
                text: "",
                type: "success",
                timer: 1200,
                showConfirmButton: false
              });
                  $('.form-group').removeClass('has-error')
                                  .removeClass('has-success');
                  $('.text-danger').remove();
                  fa[0].reset();
                  $("#myModal").modal('hide');
                  $('#example').DataTable().ajax.reload();
          
          }else{
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
</script>

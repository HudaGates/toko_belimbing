<div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">FORM Re-EMAIL ORDER </h4>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <div class="box">
      <?=form_open('planning/reemail?api='.$this->id_t, 'id="mydata"');?>
    <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
    <div class="box-body">
        <div class="form-group">
          <label for="exampleInputEmail1">Input Order No</label>
          <input type="text" id="order_no" name="order_no" class="form-control" required="required">
        </div>
        <div class="form-group" id="hasilx">
        </div>
    </div>
    <!-- /.box-body -->
      <div class="box-footer width-border">
          <button type="submit" class="btn btn-success" id="save"> Submit </button>
          <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Cancel</button>
      </div>
<?=form_close();?>
</div>
</div>
<script type="text/javascript">
 $('#mydata').submit(function(e){
    e.preventDefault();
     var fa = $(this); 
      $("#save").attr('disabled', true);
      $("#hasilx").html('<div class="box text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i></div>');            
      $.ajax({
        url: fa.attr('action'),
        type: 'post' ,
        data: fa.serialize(),
        dataType: 'json',
        success: function(response) {
          if(response.success == true){
              $('.form-group').removeClass('has-error')
                              .removeClass('has-success');
              $('.text-danger').remove();
              fa[0].reset();
              
              if(response.email==true){
                 swal({
                      title: "Release Order Success",
                      type: "success",
                      timer: 2000,
                      showConfirmButton: false
                    });
                  $("#myModal").modal('hide');  
                }else{
                  $("#view").html('<div class="modal-header"><h4 class="text-red">Koneksi Email Error !!</h4><button type="button" class="close exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div><div class="modal-body text-center">'+response.email+' </div>');                             
                }  
              
          } else {
            $("#save").attr('disabled', false);
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
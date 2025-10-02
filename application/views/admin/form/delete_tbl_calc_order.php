  <div id="form4" class="box no-border" style="margin-top: -15px;padding: 5px;">
  <div class="small-box text-purple" style="border:1px solid #ccd;margin:5px;padding: 2px;">
      <div class="box-header with-border">
        <button class="btn btn-default text-red pull-right exit"><span class="glyphicon glyphicon-remove"></span></button>
        <h5 class="text-bold text-left">FORM DELETE DATA</h5>
        <small class="text-danger">*Data Kalkulasi dan Order akan Terhapus</small>
      </div>
  <!-- /.box-header -->
  <!-- form start -->
      <?=form_open('mastercrud/delete_all?api='.$id_t, 'id="mydata3"'); ?>
        <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
        <div class="box-body">                               
            <div class="form-group">
              <label for="exampleInputEmail1">PO NO</label>
              <input type="text" id="po_no1" name="po_no1" class="form-control">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Input Delivery Date</label>
              <input type="text" id="delv_date1" name="delv_date1" class="form-control date">
            </div>                        
          </div>
    <!-- /.box-body -->
          <div class="box-footer width-border">
            <button type="submit" class="btn btn-success"> Submit </button>
            <button type="reset" class="btn btn-default exit">Cancel</button>
          </div>
       </form>
    </div>
</div>
</div>
<script type="text/javascript"> 
$('#mydata3').submit(function(e){
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
                  $("#form").toggle();
                  table.ajax.reload();
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
<script  type="text/javascript">
$(document).ready(function(){
   $('.form-control.date').datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-100:+0",
        dateFormat:"yy-mm-dd"
        });
  $(".exit").click(function(){
  $("#form4").toggle();
  });

});
</script>
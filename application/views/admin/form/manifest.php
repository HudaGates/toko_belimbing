  <div id="form4" class="box no-border" style="margin-top: -15px;padding: 5px;">
  <div class="small-box text-purple" style="border:1px solid #ccd;margin:5px;padding: 2px;">
      <div class="box-header with-border">
        <button class="btn btn-default text-red pull-right exit"><span class="glyphicon glyphicon-remove"></span></button>
        <h5 class="text-bold text-left">FORM INPUT MANIFEST</h5>
      </div>
  <!-- /.box-header -->
  <!-- form start -->
      <?=form_open('mastercrud/inputmanifest?api='.$id_t, 'id="mydata"'); ?>
        <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
        <div class="box-body">                               
            <div class="form-group">
              <label for="exampleInputEmail1">From Sequence No</label>
              <input type="hidden" value="<?=$id1;?>">
              <input id="sequence1" type="text" class="form-control" name="sequence1" class="form-control" value="<?=$sequence1;?>">
            </div> 
            <div class="form-group">
              <label for="exampleInputEmail1">To Sequence No</label>
              <input type="hidden" value="<?=$id2;?>">
              <input id="sequence2" type="text" class="form-control" name="sequence2" class="form-control" value="<?=$sequence2;?>">
            </div>
            <div class="form-group">
              <label for="exampleInputEmail1">Manifest No</label>
              <input id="manifest_no" type="text" class="form-control" name="manifest_no" class="form-control">
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
  $(".exit").click(function(){
  $("#form4").toggle();
  });

});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    $('.form-control.datetime').timepicker({
    dateFormat: 'yy-mm-dd',
    timeFormat: 'HH:mm:ss',
    stepHour: 1,
    stepMinute: 1,
    stepSecond: 1
    });
    $('.form-control.date').datepicker({
        changeMonth:true,
        changeYear:true,
        yearRange:"-100:+0",
        dateFormat:"yy-mm-dd"
        });
    });
</script>
<!-- /.box -->
<div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">FORM BERITA ACARA</h4>
  
</div>
<div class="modal-body">
  <div class="card">
    <div class="card-header text-bold">SJ NO <?=$sj_no;?></div>
  <?=form_open('master/submitberitaacara?api='.$this->id_t, 'id="mydata"'); ?>
    <div class="card-body" style="padding: 5px">
      <input type="hidden" name="sj_no" value="<?=$sj_no;?>"/>
      <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
      <div id="viewrecsjsc" style="overflow-y: auto;">
        <table class="table table-bordered">
          <tr>
            <th class="text-center" style="width: 1%">No</th>
            <th>Part_No</th>
            <th>Part_Name</th>
            <th class="text-center" style="width: 10%">Qty Delv<br>(box)</th>
            <th class="text-center" style="width: 10%">Qty Problem<br>(box)</th>
            <th>Problem (Note)</th>
          </tr>
          <?php if(!empty($data_table)){ $i=1; foreach ($data_table as $key) {?>
          <tr>
            <td class="text-center">
              <?=$i++;?>
            </td>
            <td>
              <?=$key->part_no;?>
            </td>
            <td>
              <?=$key->part_name;?>
            </td>
            <td  class="text-center">
              <input type="text" class="form-control text-center" name="delv_qtybox[]" class="form-control" value="<?=$key->delv_qtybox;?>" disabled style="padding:0px;">
            </td>
            <td  class="text-center">
              <input type="text" class="form-control text-center" name="qtybox_problem[]" class="form-control" value="<?=$key->qtybox_problem;?>" disabled style="padding:0px;">
            </td>
            <td>
             <input id="id[]" type="hidden" name="id[]" value="<?=$key->id;?>"/>
             <input id="problem[]" type="text" class="form-control" name="problem[]" class="form-control" placeholder="Problem" required="required" value="<?=$key->problem;?>" style="padding:0px;">
            </td>
          </tr>
        <?php } }else{ ?>
          <tr>
              <td colspan="6">
                No Data
              </td>      
            </tr>
        <?php } ?>
        </table>
      </div>
    </div>
    <div class="card-footer border-top">
      <button type="submit" class="btn btn-success"> Submit </button>
    </div>
       <?=form_close();?>
  </div>
</div>   
<script  type="text/javascript">
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
            $("#viewrecsjsc").addClass('text-danger');
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

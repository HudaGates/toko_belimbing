<div class="modal-header">
  <h4 class="modal-title">Form Order Part</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  
  <div class="card">
      <?=form_open('master/orderpart?api='.$this->id_t, 'id="mydata"'); ?>
        <input id="id" type="hidden" name="id" value="<?=$id;?>"/>
        <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class="card-body">
          <div class="row">
            <div class="col-6">
              <div class="form-group">
                <label for="exampleInputEmail1">PartNoFsi</label>
                <input id="part_no_fsi" type="text" class="form-control" name="part_no_fsi" readonly value="<?=$qs->part_no_fsi;?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">PartName</label>
                <input id="part_name" type="text" class="form-control" name="part_name" readonly value="<?=$qs->part_name;?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">Model</label>
                <input id="model" type="text" class="form-control" name="model" readonly value="<?=$qs->model;?>">
              </div>                                 
              <div class="form-group">
                <label for="exampleInputEmail1">Supplier</label>
                <input id="supplier_code" type="text" class="form-control" name="supplier_code" readonly value="<?=$qs->supplier_code;?>">
              </div>
            </div>
            <div class="col-6">
              <div class="form-group">
                <label for="exampleInputEmail1">StockAkhir<code>(*jika stock tdk sesuai silahkan edit stock)</code></label>
                <input id="stock_akhir" type="text" class="form-control" name="stock_akhir" readonly value="<?=$qs->stock_akhir;?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">DeliveryDate</label>
                <input id="delv_date" type="date" class="form-control" name="delv_date" required value="<?=gmdate('Y-m-d',time()+60*60*7);?>">
              </div>
              <div class="form-group">
                <label for="exampleInputEmail1">OrderPart</label>
                <input id="order_part" type="number" class="form-control" name="order_part" required value="<?=abs($qs->stock_akhir);?>">
              </div>              
            </div>
            <div id="hasil"></div>
          </div>                        
        </div>
    <!-- /.box-body -->
          <div class="card-footer width-border">
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
            <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Close</button>
          </div>
       <?=form_close();?>
    </div>
 </div>   
<script type="text/javascript"> 
$('#mydata').submit(function(e){
    e.preventDefault();
     var fa = $(this); 
      $("#save").attr('disabled', true);           
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
                  $("#hasil").html("<span class='text-success text-lg text-bold'>Order Success !!</span>");
                  $('#example').DataTable().ajax.reload();
          
          }else{
            $("#hasil").html("<span class='text-red text-lg text-bold'>"+response.success+"</span>");
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

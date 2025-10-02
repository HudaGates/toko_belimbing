<div class="modal-header">
  <h5 class="modal-title">Form Create Label E-Planning <sup><i class="fa fa-file text-purple"></i></sup></h5>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
       <?=form_open('planning/submitlabelepl?api='.$this->id_t,array('id'=>'mydata1','target'=>'_blank','method'=>'post')); ?> 
          <div class="box-body">
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <div class="form-group" id="op">
                  <label for="exampleInputEmail1">Select Operator</label>
                  <select id="prod_pic" class="form-control" name="prod_pic" onchange="detail(this.value,'<?=$id;?>')" required>
                    <option value=""></option>
                   <?php foreach ($do as $key) { ?>
                    <option value="<?=$key->nama.'#'.$key->shift.'#'.$key->line;?>"><?=$key->nama .' - SHF '.$key->shift.'- LINE '.$key->line;?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                <div class="form-group">
                      <label for="exampleInputEmail1">Part No</label>
                      <input id="part_no" type="text" name="part_no" class="form-control"  value="<?=$qs->part_no_child;?>" readonly>
                </div>
              </div>
            </div>
            <div class="row" id="detail">
              
              
            </div>
          </div>
          <!-- /.box-body -->
          <div class="box-footer width-border">
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
            <span id="hasilx"></span>
          </div>
       <?=form_close();?>
 </div>   
<script type="text/javascript"> 
$('#mydata1').submit(function(e) {
    $("#save").attr('disabled', true);
    $("#myModal").modal('hide');
    $('#example').DataTable().ajax.reload();
    countep('','');
  });
function detail(val,id){
  $("#save").attr('disabled', true);
  $("#op").removeClass('text-red'); $("#op").removeClass('text-success');
  if(val!=''){
    $("#op").addClass('text-success');  
    $.ajax({
        type: "POST",
        url : "<?=base_url('planning/detaillblepl?api='.$this->id_t); ?>",
        data: "val="+val+"&id="+id+"&<?=$this->security->get_csrf_token_name();?>="+cv,
        cache:false,
        success: function(data){
            $("#detail").html(data);
            $("#save").attr('disabled', false);
            $("#qty_print").focus();       
        }
    });
  }else{
     $("#op").addClass('text-red');   
  }
}
</script>
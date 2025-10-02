<div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">Create Part Label</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
</div>
<div class="modal-body">
  <div class="box">
       <?=form_open('planning/create_partlabel?api='.$this->id_t,array('id'=>'mydata2','target'=>'_blank','method'=>'post')); ?> 
        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
          <div class="box-body">
            <div class="row">           
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <label for="exampleInputEmail1">Ketik Part No</label>
                <input type="text" name="part_nox" id="part_nox" class="form-control" onkeyup="form_detail_partno()" style="border:1px solid orange;" required="required" autocomplete="off">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">  
                <div class="form-group"  id="part_no_detail">
                <label for="exampleInputEmail1">Pilih Part No & Customer</label>                               
                  <input type="text" name="x" id="x" class="form-control">
                </div>
              </div>
              <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">      
                <div class="form-group">
                  <label for="exampleInputEmail1">Pilih Operator Prod</label>
                  <select id="prod_pic" class="form-control" name="prod_pic">
                  <?php foreach ($data_operator as $key) { ?>
                    <option value="<?=$key->nama.'_'.$key->shift.'_'.$key->line;?>"><?=$key->nama .' - SHF '.$key->shift.'- LINE '.$key->line;?></option>
                    <?php } ?>
                  </select>
                </div>
            </div>
          </div>
          <div class="row" id="detail"></div>
    <!-- /.box-body -->
          <div class="box-footer width-border">
            <button type="submit" class="btn btn-success"> Submit </button>
            <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
          </div>
       <?=form_close();?>
    </div>
 </div>   
<script type="text/javascript"> 
$(document).ready(function(){
  $("#mydata2").submit(function(){
    setTimeout(function(){
      $('#myModal').modal('hide');
      $('#example').DataTable().ajax.reload();
    },2000);

  });
  
})
$('#myModal').on('shown.bs.modal', function () {
    $("#part_nox").focus();
})  
function form_detail_partno(){
    var part_no=$("#part_nox").val();
    $.ajax({
        type: "POST",
        url : "<?=base_url('planning/form_detail_partno?api='.$this->id_t); ?>",
        data: "part_no="+part_no+"&<?=$this->security->get_csrf_token_name();?>="+cv,
        cache:false,
        success: function(data){
            $('#part_no_detail').html(data);
        }
    });
}
</script>
<!-- /.box -->
<div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">RECEIVING PART</h4>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="card">
  <div class="card-header input-group">
      <input class="form-control col-lg-3 col-xs-3 border-end-0 border border-success rounded-pill" type="text" placeholder="Surat Jalan No" autocomplete="off" id="sj_no" name="sj_no" required="required"  onkeyup="viewrecsjsc()">
      <span class="input-group-append">
        <button class="btn btn-outline-secondary bg-white border-start-0 border border-success  rounded-pill ms-n3" type="button" onclick="viewrecsjsc()">
            <i class="fa fa-search"></i>
        </button>
      </span>
  </div>
  <?=form_open('master/submitrecsjsc?api='.$this->id_t, 'id="mydata"'); ?>
    <div class="card-body" style="padding: 5px">
    <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
    <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash();?>">
    <div id="viewrecsjsc" style="overflow-y: auto;">
      <table class="table table-bordered">
        <tr>
          <th class="text-center" style="width: 1%">No</th>
          <th>Part_No</th>
          <th>Part_Name</th>
          <th class="text-center" style="width: 5%">Qty/Box</th>
          <th class="text-center" style="width: 5%">Delv<br>(pcs)</th>
          <th class="text-center" style="width: 5%">Delv<br>(box)</th>
          <th class="text-center" style="width: 5%">Rec<br>(box)</th>
          <th>Status</th>
        </tr>
        <tr>
          <td colspan="8">
            No Data
          </td>
          
        </tr>

        </table>
      </div>
    </div>
    <div class="card-footer border-top">
      <button id="save" type="submit" class="btn btn-success"> Submit </button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
    </div>
       <?=form_close();?>
  </div>
</div>   
<script  type="text/javascript">
$('#myModal').on('shown.bs.modal', function () {
    $("#sj_no").focus();
})
$('#sj_no').autocomplete({
    source: function (request, response) {

          $.getJSON("master/searchsjsc?query=" + request.term +"&api=<?=$this->id_t;?>"+"&<?=$this->security->get_csrf_token_name();?>="+cv+"&val=<?=$val;?>", function (data) {
          //console.log(data);
            response($.map(data, function (value, key) {
                //console.log(value);
                return {
                    value: value.value
                };
            }));
        });
    },
    width: 300,
    max: 20,
    delay: 100,
    minLength: 1,
    autoFocus: true,
    cacheLength: 1,
    scroll: true,
    highlight: false,
    select: function(event, ui) {
      var sj_no = ui.value;
     }
  })
$( "#sj_no" ).autocomplete( "option", "appendTo", "#myModal" );
function viewrecsjsc(){
        $("#viewrecsjsc").removeClass('text-success');
        $("#viewrecsjsc").removeClass('text-danger');
        var sj_no = $("#sj_no").val();            
        if(sj_no!=''){
            $.ajax({
                type: "POST",
                url : "<?=base_url('master/viewrecsjsc?api='.$this->id_t); ?>",
                data: "<?=$this->security->get_csrf_token_name();?>="+cv+"&sj_no="+sj_no+"&val=<?=$val;?>",
                cache:false,
                success: function(data){               
                    $("#viewrecsjsc").html(data);
                  }
              });
         }        
        }
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
                  $("#viewrecsjsc").addClass('text-success');
                  $('#example').DataTable().ajax.reload();
          }else if(response.success == 'problem'){
            formberitaacara();
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
function formberitaacara(){
    var sj_no = $("#sj_no").val();
        $.ajax({
          type: "POST",
          url : "<?=base_url('master/formberitaacara?api='.$this->id_t); ?>",
          data: "sj_no="+sj_no+"&<?=$this->security->get_csrf_token_name();?>="+cv,
          cache:false,
          success: function(data){
              $(".modal-content").html(data);
              
          }
      });
    }
</script>

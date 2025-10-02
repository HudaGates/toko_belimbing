<div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">FORM CREATE DELIVERY NOTE SUBCONT-STEP</h4>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
  <div class="card">
    <?=form_open('master/submitcreatesjsc?api='.$this->id_t, 'id="mydata"'); ?>
    <div class="card-header text-bold">    
      <div class="input-group align-middle">
        <h4>DN NO : <?=$sj_no;?></h4>&nbsp;
        <input id="delv_date" type="date" name="delv_date" class="form-control   rounded-pill col-lg-2 col-xs-2" value="<?=gmdate('Y-m-d',time()+60*60*7);?>"  required="required" placeholder="Delv Date" title="Delivery date" style="cursor: pointer;">&nbsp;
        <input type="number" name="baris"  id="baris" class="form-control border-success col-lg-1 col-xs-1 text-center  rounded-pill" autocomplete="off" required="required" placeholder="Rows" title="Row SJ"  style="cursor: pointer;" min="1" value="1" />
        <span class="input-group-append">
        <button id="btnbaris" class="btn btn-outline-success rounded-pill ms-n3" type="button" onclick="viewcreatesjsc('add')" title="Add Row SJ">
           <i class="fas fa-arrow-right"></i>
       </button>
      </div>
       <code>(Jika belum diprint nomor delivery note akan tetap sama)</code>
    </div>
  
    <div class="card-body" style="padding: 5px">
      <input type="hidden" name="table" value="<?=$table;?>"/>
      <input type="hidden" name="sj_no" value="<?=$sj_no;?>"/>
      <input type="hidden" name="sc" value="<?=$sc;?>"/>
      <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
      <div id="viewcreatesjsc" style="overflow-y: auto;">
        <table class="table table-bordered">
          <tr>
            <th class="text-center" style="width: 1%">No</th>
            <th>Part_No</th>
            <th>Part_Name</th>
            <th class="text-center" style="width: 15%">Qty/Kbn<br>(pcs)</th>
            <th class="text-center" style="width: 7%">Delv.<br>(box)</th>
            <th class="text-center" style="width: 7%">Delv<br>(pcs)</th>
            <th class="text-center" style="width: 7%">Total<br>(pcs)</th> 
            <th class="text-center" style="width: 15%">Action</th>
          </tr>
          <?php if(!empty($data_table)){ $i=1; foreach ($data_table as $key) {
           $rec_qtybox=$key->rec_qtybox;
           if($rec_qtybox<=0){
            $rec_qtybox=$key->delv_qtybox;
           } ?>
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
              <input type="text" class="form-control text-center" name="qty_kbn[]" class="form-control" value="<?=$key->qty_kbn;?>" disabled style="padding:0px;">
            </td>
            <td  class="text-center">
              <input id="id[]" type="hidden" name="id[]" value="<?=$key->id;?>"/>
              <input type="text" class="form-control text-center" name="delv_qtybox[]" class="form-control" value="<?=$key->delv_qtybox;?>" disabled style="padding:0px;">
            </td>
            <td  class="text-center">
              <input type="text" class="form-control text-center" name="delv_qtypcs[]" class="form-control" value="<?=$key->delv_qtypcs;?>" disabled style="padding:0px;">
            </td>
            <td  class="text-center">
              <input type="text" class="form-control text-center" name="total_delv[]" class="form-control" value="<?=$key->total_delv;?>" disabled style="padding:0px;">
            </td>
            <td  class="text-center">
              <button class="btn btn-outline-danger rounded-pill ms-n3" type="button" title="Remove" onclick="removesc('<?=$table;?>','<?=$key->id;?>')">
                <i class="fa fa-trash"></i>
              </button>
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
      <button id="save" type="submit" class="btn btn-success" disabled> Save Change </button>
      <button id="print" type="button" class="btn btn-success" disabled onclick="printsjsc()"> View DN </button>
      <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Close</button>
    </div>
       <?=form_close();?>
  </div>
</div> 
<script  type="text/javascript">
$('#myModal').on('shown.bs.modal', function () {
    $("#baris").focus();
    var pr = "<?=$print;?>";
    if(pr=='yes'){
      $("#print").prop( "disabled", false );
    }
});

function viewcreatesjsc(save){
    $("#viewcreatesjsc").removeClass('text-success');
    $("#viewcreatesjsc").removeClass('text-danger');
    var baris = $("#baris").val();  
    var delv_date = $("#delv_date").val();  
    var sj_no = "<?=$sj_no;?>";      
    if(baris!=''){
        $.ajax({
            type: "POST",
            url : "<?=base_url('master/viewcreatesjsc?api='.$this->id_t); ?>",
            data: "<?=$this->security->get_csrf_token_name();?>="+cv+"&sj_no="+sj_no+"&delv_date="+delv_date+"&baris="+baris+"&sc=<?=$sc;?>"+"&table=<?=$table;?>"+"&save="+save,
            cache:false,
            success: function(data){               
                $("#viewcreatesjsc").html(data);
                $("#btnbaris").prop( "disabled", true );
                $("#print").prop( "disabled", false );
                $("#save").prop( "disabled", false );
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
                  $("#viewcreatesjsc").addClass('text-success');
                  $("#save").prop( "disabled", true );
                  $("#btnbaris").prop( "disabled", true );
                  $("#print").prop( "disabled", false );
                  $(".btnhapusform").prop( "disabled", true );
                  $('#example').DataTable().ajax.reload();
                  viewcreatesjsc('ok');
          
          }else{
            ("#viewcreatesjsc").addClass('text-danger');
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
function printsjsc(){
  var sj_no = "<?=$sj_no;?>";
  var delv_date = $("#delv_date").val();
  $.ajax({
        type: "POST",
        url : "<?=base_url('s_print/view_sjscstep?api='.$this->id_t); ?>",
        data: "sj_no="+sj_no+"&delv_date="+delv_date+"&<?=$this->security->get_csrf_token_name();?>="+cv,
        cache:false,
        success: function(data){
            $("#view1").html(data);
            $("#myModal1").modal('show');
        }
    }); 

}
function removesc(table,id){
  swal({
          title: "Are you sure?",
          text: "Remove data",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Yes',
          closeOnConfirm: false,
          //closeOnCancel: false
        },
        function(){
           
          $.ajax({  
                type: "POST",
                url : "<?=base_url('master/removesc?api='.$this->id_t); ?>",
                data: "table="+table+"&id="+id+"&<?=$this->security->get_csrf_token_name();?>="+cv,
                cache:false,
                success: function(data){
                  swal({
                        title: "Remove Success",
                        text: "",
                        type: "success",
                        timer: 1200,
                        showConfirmButton: false
                      });
                   $('#example').DataTable().ajax.reload();
                   formcreatesjsc(table);
                  }

                });
        } );            
    }
function removescview(table,id){
  swal({
          title: "Are you sure?",
          text: "Remove data",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Yes',
          closeOnConfirm: false,
          //closeOnCancel: false
        },
        function(){
           
          $.ajax({  
                type: "POST",
                url : "<?=base_url('master/removesc?api='.$this->id_t); ?>",
                data: "table="+table+"&id="+id+"&<?=$this->security->get_csrf_token_name();?>="+cv,
                cache:false,
                success: function(data){
                  swal({
                        title: "Remove Success",
                        text: "",
                        type: "success",
                        timer: 1200,
                        showConfirmButton: false
                      });
                   $('#example').DataTable().ajax.reload();
                   viewcreatesjsc();
                  }

                });
        } );            
    }
</script>

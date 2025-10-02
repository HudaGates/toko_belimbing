<?php 
$min_date =date('Y-m-d\TH:i', strtotime('-12 hour', strtotime(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))));
$max_date =date('Y-m-d\TH:i', strtotime('+1 days', strtotime(gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7))));
?>
 <div class="modal-header bg-<?=$this->qt->thema;?>">
  <h4 class="modal-title">Create Report Production</h4> 
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
  <div class="card">
      <?=form_open('report/production?api='.$this->id_t, 'id="mydata"'); ?>
      <input type="hidden" name="table" value="<?=$table;?>"/>
       <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
          <div class="card-header input-group">
            <input class="form-control col-lg-4 col-xs-4 border-end-0 border border-success rounded-pill" type="text" placeholder="Please Scan SOP" autocomplete="off" id="qrsop" name="qrsop" required="required">
            <span class="input-group-append">
              <button class="btn btn-outline-secondary bg-white border-start-0 border border-success  rounded-pill ms-n3" type="button" onclick="viewformreport()">
                  <i class="fa fa-search"></i>
              </button>
            </span>
        </div>
         <div class="card-body">
            
            <div class="row">           
             <div class="col-xs-12 col-sm-12 col-md-8 col-lg-4">
                    <span class="fa fa-edit text-green"></span> <label for="exampleInputEmail1">Input Production</label>
                    <table class="table" style="border-spacing:0px;margin-bottom:0px;width:100px;">
                      <tr>
                        <td style="padding:3px;vertical-align:middle;">Prod.Start</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin:1px;">
                            <input  id="prod_start" name="prod_start" type="datetime-local" class="datetime" format="HH:mm" 
                            min="<?=$min_date;?>" max="<?=$max_date;?>" required>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align:middle;">Prod.Finish</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin:1px;">
                            <input id="prod_finish" name="prod_finish" type="datetime-local" class="datetime" format="hh:mm" required min="<?=$min_date;?>" max="<?=$max_date;?>">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Group & Shift</td>
                        <td style="padding:3px;">
                            <div class="form-group" style="margin:1px;vertical-align: middle;">
                              <div class="input-group">
                              <select id="group_no" name="group_no">
                                <option value="">Pilih Group</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="N">N</option>
                              </select>
                              <select id="shift"  name="shift">
                                <option value="">Pilih Shift</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                              </select>
                              </div>
                            </div>
                        </td>
                        
                      </tr>
                      
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Machine&nbsp;No.</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin:1px;vertical-align: middle;">
                            <select id="machine_no" name="machine_no">
                                <option value="">Pilih Machine</option>
                                <?php foreach ($data_machine as $key) { ?>
                                <option value="<?=$key->machine_no;?>"><?=$key->machine_no;?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Cavity&Shoot</td>
                        <td style="padding:3px;">
                            <div class="form-group" style="margin:1px;vertical-align: middle;">
                              <input id="qty_category" name="qty_category" type="number" style="width: 30%" required="required">
                             <select id="category" name="category" required="required">
                                <option value="Cavity">Cavity</option>
                                <option value="Shoot">Shoot</option>
                              </select>
                            </div>
                        </td>
                        
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Part&nbsp;No.</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <input id="act_machine" name="act_machine" type="hidden">
                            <input id="part_no" name="part_no" type="text" required="required" readonly>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Process&nbsp;No.</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <input id="process_no" name="process_no" type="text">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Dandori<small class="text-warning">(minute)</small></td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <input id="dandori" name="dandori" type="number">
                          </div>
                        </td>
                      </tr>
                      
                      <tr>
                        <td style="padding:3px;vertical-align: middle;" class="text-green">QTY OK<small class="text-warning">(pcs)</small></td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <input id="qty_ok" name="qty_ok" type="number" required="required">
                          </div>

                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;" class="text-red">QTY NG<small class="text-warning">(pcs)</small></td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <input id="qty_ng" name="qty_ng" type="number">
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Code NG</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <select id="code_ng" name="code_ng">
                                <option value="">Pilih Code</option>
                                <?php foreach ($data_problem as $key) { ?>
                                <option value="<?=$key->problem;?>"><?=$key->problem;?></option>
                                <?php } ?>
                                <option value="Other">Other</option>
                            </select>
                          </div>
                        </td>
                      </tr>
                      <tr>
                        <td style="padding:3px;vertical-align: middle;">Remarks</td>
                        <td style="padding:3px;">
                          <div class="form-group" style="margin: 2px;vertical-align: middle;">
                            <textarea id="remarks" name="remarks" cols="23" rows="3"></textarea>
                          </div>
                        </td>
                      </tr>
                    </table>                 
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mr-0 pr-0">
             
              <span class="fa fa-edit text-green"></span>
              <label for="exampleInputEmail1">Input Lost Time</label>  
              <table class="table  table-sm table-bordered">
                <tr class="bg-gray">
                  <td class="text-center" style="width:15px;">No</td>
                  <td style="width:50px">Category</td>
                  <td style="width: 10px" class="text-center">ID</td>
                  <td>Problem</td>
                  <td style="width:50px">Minutes</td>
                </tr>
                <?php $i=1; foreach ($data_losttime->result() as $key) { if($i<=ceil($data_losttime->num_rows()/2)){ ?>
                  <tr class="bg-<?=$key->bg_color;?>">
                    <td class="text-center" style="border-bottom: 1px solid #ccc;padding:3px;"><?=$i;?></td>
                    <td style="border-bottom: 1px solid #ccc;padding:3px;"><?=$key->category;?></td>
                    <td class="text-center" style="border-bottom: 1px solid #ccc;padding:3px;"><?=$key->id_problem;?></td>
                    <td style="border-bottom: 1px solid #ccc;padding:3px;"><?=$key->detail_problem;?></td>
                    <td style="border-bottom: 1px solid #ccc;padding:3px;text-align: center;">
                      <div class="form-control">
                        <select id="<?=$key->id_problem;?>"  name="<?=$key->id_problem;?>" class="text-center">
                          <option value="">0</option>
                          <option value="3">3</option>
                          <option value="5">5</option>
                          <option value="8">8</option>
                          <option value="10">10</option>
                          <option value="15">15</option>
                          <option value="20">20</option>
                          <option value="25">25</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                          <option value="45">45</option>
                          <option value="50">50</option>
                          <option value="55">55</option>
                          <option value="60">60</option>
                        </select>
                      </div>
                    </td>
                  </tr>
                <?php  } $i++; } ?>
                </table>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4 mr-0 pr-0">

            <span class="fa fa-edit text-green"></span>
            <label for="exampleInputEmail1">Input Lost Time</label>    
             <table class="table  table-sm table-bordered">
                <tr class="bg-gray">
                  <td class="text-center" style="width:15px;">No</td>
                  <td style="width:50px">Category</td>
                  <td style="width: 10px" class="text-center">ID</td>
                  <td>Problem</td>
                  <td style="width:50px">Minutes</td>
                </tr>
              <?php $i=1; foreach ($data_losttime->result() as $key) { if($i>ceil($data_losttime->num_rows()/2)){ ?>
                <tr class="bg-<?=$key->bg_color;?>">
                  <td class="text-center" style="border-bottom: 1px solid #ccc;padding:3px;"><?=$i;?></td>
                  <td style="border-bottom: 1px solid #ccc;padding:3px;"><?=$key->category;?></td>
                  <td class="text-center" style="border-bottom: 1px solid #ccc;padding:3px;"><?=$key->id_problem;?></td>
                  <td style="border-bottom: 1px solid #ccc;padding:3px;"><?=$key->detail_problem;?></td>
                  <td style="border-bottom: 1px solid #ccc;padding:3px;text-align: center;">
                      <div class="form-control">
                        <select id="<?=$key->id_problem;?>"  name="<?=$key->id_problem;?>" class="text-center">
                        <option value="">0</option>
                        <option value="3">3</option>
                        <option value="5">5</option>
                        <option value="8">8</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="45">45</option>
                        <option value="50">50</option>
                        <option value="55">55</option>
                        <option value="60">60</option>
                      </select>
                    </div>
                  </td>
                </tr>
              <?php }  $i++; } ?>
              </table>               
            
           </div>
         </div>
         <br>
       <div class="box-footer width-border">
          <button type="submit" class="btn btn-success" id="save"> Submit </button>
          <button type="button" class="btn btn-danger" data-dismiss="modal" aria-label="Close">Cancel</button>
       </div>
     </div>
       <?=form_close();?>
       
</div>
</div>
<script type="text/javascript"> 
$('#myModal').on('shown.bs.modal', function () {
    $('#qrsop').focus();
})
$("#qrsop").on('keypress',function(e) {
    var qrsop = $("#qrsop").val();
    var qrsop =qrsop.trim();   
    if(e.which == 13 && qrsop!='') {
      $.ajax({
            async: true,
            type: "POST",
            url :"<?=base_url("report/viewformreport?api=".$this->id_t);?>",
            cache:false,
            dataType: 'json',
            data: "qrsop="+qrsop+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,                
            success: function(data){
                $("#shift").val(data.shift);
                $("#group_no").val(data.group_no);
                $("#machine_no  option:selected").text(data.machine_no);
                $("#machine_no  option:selected").val(data.machine_no);
                $("#act_machine").val(data.machine_no);
                $("#qty_category").val(data.qty_category);
                $("#category").val(data.category);
                $("#part_no").val(data.part_no); 
                $("#process_no").val(data.process_no);
                $("#dandori").val(data.dandori);        
            }
          });
        
    }
});
function viewformreport(){
  var qrsop = $("#qrsop").val();
  var qrsop =qrsop.trim();               
   if(qrsop!='') {
       $.ajax({
            async: true,
            type: "POST",
            url :"<?=base_url("report/viewformreport?api=".$this->id_t);?>",
            cache:false,
            dataType: 'json',
            data: "qrsop="+qrsop+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,                
            success: function(data){
                $("#shift").val(data.shift);
                $("#group_no").val(data.group_no);
                $("#machine_no  option:selected").text(data.machine_no);
                $("#machine_no  option:selected").val(data.machine_no);
                $("#act_machine").val(data.machine_no);
                $("#qty_category").val(data.qty_category);
                $("#category").val(data.category);
                $("#part_no").val(data.part_no); 
                $("#process_no").val(data.process_no);
                $("#dandori").val(data.dandori);        
            }
          });
    }      
 }
$('#mydata').submit(function(e){
    e.preventDefault();
     var fa = $(this);              
      $.ajax({
         url: fa.attr('action'),
         type:"post",
         data:new FormData(this),
         processData:false,
         contentType:false,
         cache:false,
         async:false,
         dataType: 'json',  
        success: function(response) {
          if(response.success ==true){ 
                swal({
                title: "Add Success!!",
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
                  $('#example').DataTable().ajax.reload();;

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

  $('#part_no').autocomplete({
    source: function (request, response) {
          $.getJSON("report/get_part_no?query=" + request.term +"&api=<?=$this->id_t;?>&<?=$this->security->get_csrf_token_name();?>="+cv, function (data) {
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
      var part_no = ui.value;
     }
  })
  $( "#part_no" ).autocomplete( "option", "appendTo", "#mydata" );
  </script>
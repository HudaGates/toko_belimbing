  <div class="row">
    <div class="col-sm-6">
      <div class="card text-left"  style="border:1px solid #ccc">
        <div class="card-header">
          <h3 class="card-title text-bold">FORM INPUT BY SUFFIX</h3>
        </div>
        <!-- form start -->
        <?=form_open('sliporder/submitinputspecial?api='.$id_t, 'id="mydata"'); ?> 
        <input type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash();?>"> 
          <div class="card-body">
            
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label>Pilih Item</label>
                  <select class="form-control text-bold" name="item" id="item" required="required" >
                        <option value=""></option>
                        <option value="All">All Item</option>
                      <?php foreach ($qseat as $key) { ?>
                        <option value="<?=$key->item.'_'.$key->code;?>"><?=$key->item.' '.$key->code;?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="form-group">
                  <label>Prod Date</label>
                  <div class="input-group">
                    <input name="prod_date" type="date" class="form-control date" required="required" value="<?=$prod_date;?>">
                    &nbsp;
                    <select name="prod_shift" style="border:1px solid #ccc;">
                          <option value="<?=$prod_shift;?>"><?=$prod_shift;?></option>
                          <option value="Day">Day</option>
                          <option value="Night">Night</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Suffix</label>
                  <input id="suffix" type="text" class="form-control text-bold" name="suffix" style="text-transform: uppercase;border:1px solid #9af;"  minlength="2" maxlength="2"  required="required" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Qty</label>
                  <input id="qty" type="number" class="form-control text-bold" name="qty" style="text-transform: uppercase;border:1px solid #9af;" max="5"  required="required" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Remark</label>
              <textarea id="remark" name="remark" class="form-control" rows="2" placeholder="Type ..." required></textarea>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer" style="border-top:1px solid #ccc">
            <button type="submit" class="btn btn-success" id="save">Submit</button>&nbsp;
            <button type="reset" class="btn btn-danger btn-outline">Reset</button>
          </div>
        <?=form_close();?>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="card  text-left"  style="border:1px solid #ccc">
        <div class="card-header">
          <h3 class="card-title text-bold">FORM INPUT BY IDSEAT</h3> <code>(suffix ambil 2 digit dimaster seat)</code>
        </div>
        <!-- form start -->
        <?=form_open('sliporder/submitinputspecialx?api='.$id_t, 'id="mydata1"'); ?> 
        <input type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash();?>"> 
          <div class="card-body">
            <div class="row">
              <div class="col-sm-5">
                <div class="form-group">
                  <label>Pilih Code</label>
                  <select class="form-control text-bold" name="code" id="code" required="required">
                        <option value=""></option>
                        <option value="All">All</option>
                      <?php foreach ($q as $key) { ?>
                        <option value="<?=$key->code;?>"><?=$key->code;?></option>
                      <?php } ?>
                  </select>
                </div>
              </div>
              <div class="col-sm-7">
                <div class="form-group">
                  <label>Prod Date</label>
                  <div class="input-group">
                    <input name="prod_date" type="date" class="form-control date" required="required" value="<?=$prod_date;?>">
                    &nbsp;
                    <select name="prod_shift" style="border:1px solid #ccc;">
                          <option value="<?=$prod_shift;?>"><?=$prod_shift;?></option>
                          <option value="Day">Day</option>
                          <option value="Night">Night</option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-6">
                <div class="form-group">
                  <label>ID Seat</label>
                  <input id="idseat" type="text" class="form-control text-bold" name="idseat" style="text-transform: uppercase;border:1px solid #9af;"  minlength="3" maxlength="10"  required="required" autocomplete="off">
                </div>
              </div>
              <div class="col-sm-6">
                <div class="form-group">
                  <label>Qty</label>
                  <input id="qty1" type="number" class="form-control text-bold" name="qty1" style="text-transform: uppercase;border:1px solid #9af;" max="5"  required="required" autocomplete="off">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Remark</label>
              <textarea id="remark1" name="remark1" class="form-control" rows="2" placeholder="Type ..." required></textarea>
            </div>
          </div>
          <!-- /.card-body -->
          <div class="card-footer" style="border-top:1px solid #ccc">
            <button type="submit" class="btn btn-success" id="save1">Submit</button>&nbsp;
            <button type="reset" class="btn btn-danger btn-outline">Reset</button>
          </div>
        <?=form_close();?>
      </div>
    </div>
  </div>
<script type="text/javascript">
  $('#mydata').submit(function(e){
    e.preventDefault();
       var fa = $(this);
       $("#save").attr('disabled', true);
       setTimeout(function() { 
            $("#save").attr('disabled', false);
       }, 3000); 
    swal({
      title: "Are you sure?",
      text: "This submit",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: 'btn-danger',
      confirmButtonText: 'Yes',
      closeOnConfirm: true,
        //closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {                            
            $.ajax({
              url: fa.attr('action'),
              type: 'post' ,
              data: fa.serialize(),
              dataType: 'json',
              success: function(response) {
                if(response.success == true){
                  swal({
                      title: "Sucess!!",
                      text: "Input Success",
                      type: "success",
                      timer: 1200,
                      showConfirmButton: false
                    });
                        $('.form-group').removeClass('has-error')
                                        .removeClass('has-success');
                        $('.text-danger').remove();
                        fa[0].reset();
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
      }     
      });
    });
$('#mydata1').submit(function(e){
    e.preventDefault();
       var fa = $(this);
       $("#save1").attr('disabled', true);
       setTimeout(function() { 
            $("#save1").attr('disabled', false);
       }, 3000); 
    swal({
      title: "Are you sure?",
      text: "This submit",
      type: "warning",
      showCancelButton: true,
      confirmButtonClass: 'btn-danger',
      confirmButtonText: 'Yes',
      closeOnConfirm: true,
        //closeOnCancel: false
      },
      function(isConfirm){
        if (isConfirm) {                            
            $.ajax({
              url: fa.attr('action'),
              type: 'post' ,
              data: fa.serialize(),
              dataType: 'json',
              success: function(response) {
                if(response.success == true){
                  swal({
                      title: "Sucess!!",
                      text: "Input Success",
                      type: "success",
                      timer: 1200,
                      showConfirmButton: false
                    });
                        $('.form-group').removeClass('has-error')
                                        .removeClass('has-success');
                        $('.text-danger').remove();
                        fa[0].reset();
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
      }     
      });
    });

</script>

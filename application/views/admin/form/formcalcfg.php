<!-- /.box -->
<div class="modal-header">
  <h5 class="modal-title">Form Calculation Production <sup><i class="fa fa-plus text-purple"></i></sup></h5>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
    <div class="card card-body p-0">
        <span class="pt-1">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0"><i class="fa fa-check text-green"></i> Calc. FG</li>
                <li class="list-group-item border-0"><i class="fa fa-check text-green"></i> Calc. Childpart</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Select & Update Qty Prod</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Release Prod(Print E-Planning)</li>
            </ul>
        </span>
    </div>
    <div class="card card-body border-1 m-0 p-2">
      <form id="submit">
        <div class="form-group">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
              <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash();?>">
              <input id="table" type="hidden" name="table" value="<?=$table;?>"/>
               <input id="table1" type="hidden" name="table1" value="<?=$table1;?>"/>
              <div class="form-group">
                <label for="exampleInputEmail1">Pulling Date</label>
                <input type="date" id="pulling_date" name="pulling_date" class="form-control col-11" required value="<?=gmdate('Y-m-d', time() + 60 * 60 * 7);?>" min='<?=gmdate('Y-m-d', time() + 60 * 60 * 7);?>'>
              </div>
              <div class="form-group row">
                <div class="col-6">
                    <label for="exampleInputEmail1">Prod Date</label>
                    <input type="date" id="prod_date" name="prod_date" class="form-control col-11" required value="<?php echo $qpd->prod_date!='' ? $qpd->prod_date : gmdate('Y-m-d', time() + 60 * 60 * 7); ?>" min='<?=gmdate('Y-m-d', time() + 60 * 60 * 7);?>'>
                </div>  
                <div class="col-6">
                    <label for="exampleInputEmail1">Prod Shift</label>
                    <select class="form-control col-10" name="prod_shift" id="prod_shift"  required="required">
                      <?php foreach($qsh as $key){
                      if($key->prod_shift==$qpd->shift){ ?>
                      <option value="<?=$qpd->shift;?>"><?=$qpd->shift;?></option>
                  <?php }else{ ?>
                      <option value="<?=$key->prod_shift;?>"><?=$key->prod_shift;?></option>
                      <?php } } ?>
                    </select>
                </div>
              </div>
              <div class="form-group">
                <label>Total Part FG : <?=$t_fg;?> </label>
                <p id="errormsg"></p>
              </div>
              
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
          <div class="callout callout-danger" style="padding: 3px">
            <big><code>Ketentuan Kalkulasi </code></big>
            <ul>
              <li><b>1. Master Part List</b> (Pastikan lengkap)</li>
              <li><b>2. Master Consume</b> (Pastikan lengkap) </li>
              <li><b>3. Pulling Date</b> (Pastikan sesuai data order customer)</li>
              <li><b>4. Judge Stock Store</b> (Sesuai kebutuhan)</li>
              <li><b>5. Judge Stock Prod</b> (Label sudah print belum posting)</li>
              <li><b>6. Judge Add Prod</b> (Sesuai kebutuhan)</li>
              <li><b>7. Data kalkulasi sebelumnya akan diganti dengan data kalkulasi yg baru utk produksi</li>
           </ul>
              </div>
            </div>
          </div>  
        </div>
        <div class="form-group">
          <label><code id="hasil">Progress calc fg</code></label>
          <div class="progress active" id="progress" style="height:30px;"></div>
        </div>
        <div class="form-group">
          <label><code id="hasil1">Progress calc childpart</code></label>
          <div class="progress active" id="progress1" style="height:30px;"></div>
        </div>
      <!-- /.box-body -->
        <div class="box-footer width-border">
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
            <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Close</button>
        </div>
    <?=form_close();?>
</div>
</div>
<script  type="text/javascript">
  var myVar;
  var x = 2000;
function statusupload(table3){
  myVar = setTimeout(function(){
        $.ajax({
            async: true,
            type: "POST",
            url : "<?=base_url('planning/statusupload?api='.$this->id_t);?>",
            data: "table="+table3+"&<?=$this->security->get_csrf_token_name();?>="+cv,
            cache:false,
            dataType: 'json',
            success: function(data){
                persen = (data.persen *1)+0;
                if(table3=='<?=$table;?>'){
                    $('#hasil').text("Calc. FG "+data.success+" success "+data.failed+" failed from "+data.total+" rows");
                    $("#progress").html("<div class='progress-bar progress-bar-primary progress-bar-striped text-center text-red bg-green' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:"+persen+"%;'>"+persen+"%</div>"); 
                }else{
                    $('#hasil1').text("Calc. Child Part "+data.success+" success "+data.failed+" failed from "+data.total+" rows");
                    $("#progress1").html("<div class='progress-bar progress-bar-primary progress-bar-striped text-center text-red bg-green' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:"+persen+"%;'>"+persen+"%</div>"); 
                }
                
                if(table3=='<?=$table;?>' && parseInt(persen)==100){
                clearTimeout(myVar);
                 statusupload('<?=$table1;?>');
                }
                if(table3=='<?=$table1;?>' && parseInt(persen)==100){
                    $("#errormsg").html("<span class='text-success text-bold'> Calculation Success Please check data to release production !!</code>"); 
                    x= 0; 
                    clearTimeout(myVar); 
                      setTimeout(function(){
                        $('#example').DataTable().ajax.reload();
                        $('#example1').DataTable().ajax.reload();
                        $("#myModal").modal('hide');
                        countep('<?=$table;?>','<?=$table1;?>');
                      },3000);
                }
                
            }
        });
         statusupload(table3);
      },x);  
                  
  } 
  $(".exit").click(function(){
    x= 0; 
    clearTimeout(myVar);
    $('#example').DataTable().ajax.reload();
    $('#example1').DataTable().ajax.reload();
    countep('<?=$table;?>','<?=$table1;?>');
  });

  $('#submit').submit(function(e){
      $("#save").attr('disabled', true);
      $(".exit").attr('disabled', true);
      statusupload('<?=$table;?>');
      $("#errormsg").html(
                '<div><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>'
            );
      e.preventDefault();
           $.ajax({
               url:'<?=base_url('planning/calcfg?api='.$this->id_t);?>',
               type:"post",
               data:new FormData(this),
               processData:false,
               contentType:false,
               cache:false,
               async:true,
               dataType: 'json',
               success: function(response) {
                if (response.success == false) {
                      $(".exit").attr('disabled', false);

                      x= 0;
                      clearTimeout(myVar);
                      $("#errormsg").html('');
                      $.each(response.messages, function(key, value) {
                        var element = $('#' + key);
                        element.closest('div.form-group')
                          .removeClass('has-error')
                          .addClass(value.length > 0 ? 'has-error' : 'has-success')
                          .find('.text-danger')
                          .remove();
                        element.after(value);
                      });               
                  }else{
                      $(".exit").attr('disabled', false);                                              
                  }
                                                                                
                },
                 error: function(xhr, status, error) {
                  $(".exit").attr('disabled', false);
                  x= 0; 
                  clearTimeout(myVar);                    
                  $("#errormsg").html('<code>Error '+error+'</code>');  
                }

           });
            
      });                   

</script>

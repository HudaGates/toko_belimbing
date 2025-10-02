    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <table style="width: 100%;border-spacing:0px;border-collapse: collapse !important;">
                  <tr>
                    <td class="text-lg text-bold">
                      INPUT SLIP ORDER  <small><code><i>(Tips Pindah baris gunakan Tombol Tabs)</i></code></small>
                    </td>
                    <td style="width: 100px;text-align: right">
                      Pilih Shop
                    </td>
                    <td style="width: 250px">
                    <select class="form-control text-bold" name="shop" id="shop" onchange="forminput()" style="padding: 1px !important">
                        <option value=""></option>
                        <option value="1" selected>Assy 1</option>
                        <option value="2">Assy 2</option>
                        <option value="s">Special Production</option>
                    </select>
                    </td>
                    <td onclick="formcalcjust()" style="width: 50px;text-align: center;cursor:pointer;"  title="Judgement Slip Order"> 
                    <i class="fas fa-cogs text-lg"></i>
                  </td>
                </tr>
              </table>
              </div>

              <div class="card-body text-center"  id="forminput">
                 
              </div>
              <!-- /.card-body -->
            </div>
            <div class="modal fade" id="myModal">
              <div class="modal-dialog modal-lg">
                <div class="modal-content" id="view">
                 
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div> 
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
 <script type="text/javascript">
  forminput();
  function formcalcjust(){
        var cv='<?=$this->security->get_csrf_hash(); ?>';
            $.ajax({
                type: "POST",
                url : "<?=base_url('sliporder/formcalcjust?api='.$id_t); ?>",
                data: "<?=$this->security->get_csrf_token_name(); ?>="+cv,
                cache:false,
                success: function(data){
                      $("#view").html(data);
                      $("#myModal").modal('show');
                }
            });
        }
  function forminput(shop){
        if(shop == null){
          var shop = $("#shop").val();
        }
            
        if(shop!=''){
          var cv='<?=$this->security->get_csrf_hash(); ?>';
            $.ajax({
                type: "POST",
                url : "<?=base_url('sliporder/forminput?api='.$id_t); ?>",
                data: "<?=$this->security->get_csrf_token_name(); ?>="+cv+"&shop="+shop,
                cache:false,
                success: function(data){               
                  $("#forminput").html(data);
                }
            });
        }
        
        }
</script>     





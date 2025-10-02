    <?=form_open('sliporder/submitinput?api='.$id_t, 'id="mydata"'); ?>
      <label class="text-lg text-bold">SHOP : ASSY <?=$qjudge->shop.'  - TRIP : '.$qjudge->trip;?></label> 
      <input id="prod_date" type="date" class="text-center" name="prod_date" required="required" value="<?=$prod_date;?>" style="border:1px solid #ccc">
      <select class="text-center"  name="prod_shift" id="prod_shift" required="required" style="border:1px solid #ccc">
            <option value="<?=$prod_shift;?>"><?=$prod_shift;?></option>
            <option value="Day">Day</option>
            <option value="Night">Night</option>
      </select>
      <table style="width: 100%;border-spacing: 0px;border-collapse: collapse;">
          <tr>
            <td style="width: 18%;vertical-align: top;text-align: justify;">
              <code class="text-bold text-lg">SILAHKAN CEK STOCK</code>
              <br>
              <code class="text-bold">* JIKA OVER SILAHKAN SET QTY LOT MASTER SEAT KE NOL, SEAT TDK AKAN DIPRODUKSI</code>
              <br>
              <code class="text-bold">* JIKA EMPTY ATAU CRITICAL SILAHKAN INPUT SPECIAL PRODUCTION SESUAI KEBUTUHAN</code>
              <br>
              <br>
              <div class="btn btn-outline-info btn-sm">SET QTY LOT&nbsp;&nbsp;&nbsp;&nbsp;</div>
              <br>
              <br>
              <div class="btn btn-outline-info btn-sm" onclick="forminput('s'); $('#shop').val('s')">SPECIAL PROD.</div>
            </td>
            <td style="width: 1%;vertical-align: top;text-align: justify;">
            </td>
            <td>
            <table style="width: 100%;">
              <tr>
                <td>
                <div id="finput" style="overflow-y:auto;padding: 10px;margin: 5px;border:3px solid #ccc;">          
                    <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash();?>"> 
                    <input type="hidden" name="shop" value="<?=$qjudge->shop;?>">
                    <input type="hidden" name="trip" value="<?=$qjudge->trip;?>">
                    <input type="hidden" name="sliporder" value="<?=$qjudge->sliporder;?>">
                    <input type="hidden" name="lifting_no" value="<?=$qjudge->lifting_no;?>">
                    <input type="hidden" name="max_slip_trip" value="<?=$qjudge->max_slip_trip;?>"> 
                    <input type="hidden" name="max_lifting_slip" value="<?=$qjudge->max_lifting_slip;?>">
                    <input type="hidden" name="max_slip_input" value="<?=$qjudge->max_slip_input;?>">  
                    <table style="width: 100%;">
                      <?php 
                      $sliporder=$qjudge->sliporder;
                      $lifting_no=$qjudge->lifting_no;
                      $no=1;
                      for($i=0;$i<$qjudge->max_slip_input;$i++){ ?>
                        <tr>
                          <td class="text-left text-bold" style="font-size: 18px">Slip order No : <?=$sliporder+$i;?></td>
                        </tr>
                        <tr>
                          <td  class="text-center" style="text-align: center;justify-content: center;align-items: center;">
                              <table class="table table-bordered" style="width:100%;border:0px solid #000;border-color:#444 !important;">
                                <tr style="background-color: #ddd">
                                  <td class="text-center" style="border:1px solid #aaa;">No</td>
                                  <td class="text-center" style="border:1px solid #aaa;">Lifting</td>
                                  <td class="text-center" style="border:1px solid #aaa;" style="width: 35%">Input Suffix</td>
                                  <td class="text-center" style="border:1px solid #aaa;width: 35%">Pesan Error</td>
                                </tr>
                              <?php for($j=0;$j<$qjudge->max_lifting_slip;$j++){
                                   ?>
                                <tr>
                                   <td style="border:1px solid #aaa;font-size: 18px">
                                    <?=$no;?>
                                   </td>
                                   <td style="border:1px solid #aaa;font-size: 18px"  class="text-bold">
                                    <?php $lifting_fsi=$lifting_no;
                                    if($lifting_fsi<10){
                                      $lifting_fsi='000'.$lifting_fsi;
                                    }elseif ($lifting_fsi>=10 and $lifting_fsi<100) {
                                      $lifting_fsi='00'.$lifting_fsi;
                                    }elseif ($lifting_fsi>=100 and $lifting_fsi<1000) {
                                      $lifting_fsi='0'.$lifting_fsi;
                                    }else{
                                      $lifting_fsi=$lifting_fsi;
                                    }
                                    echo $lifting_fsi; ?>
                                   </td> 
                                   <td style="border:1px solid #aaa;padding: 3px;vertical-align: middle;">
                                        <input id="suffix<?=$no;?>" type="text" class="text-center text-bold abc" name="suffix<?=$no;?>" style="text-transform: uppercase;font-size: 18px;height:40px;width: 100px;background-color: #fff;" minlength="2" maxlength="2"  required="required" autocomplete="off">
                                   </td>
                                   <td style="border:1px solid #aaa;">
                                    <div class="form-group">
                                      <span class="suffix<?=$no;?>"></span>
                                    </div>
                                   </td>
                                </tr>
                            <?php 
                            $lifting_no=$lifting_no+1;
                            if($lifting_no==10000){
                              $lifting_no=1;
                            }
                            $no=$no+1;
                              } ?>
                              </table>
                            </td>
                        </tr>
                        <?php  } ?> 
                      </table>
                     
                    </div>
                </td>
              </tr>
              <tr>
                <td>
                  <table style="width: 100%">
                    <tr>
                      <td>               
                      </td>
                      <td></td>
                      <td class="text-center" style="width: 35%">
                        <button type="reset" class="btn btn-danger btn-outline" onclick="backToTop()">Reset</button>&nbsp;
                        <button type="submit" class="btn btn-success btn-outline" id="save"> Submit </button>
                        </td>
                        <td style="width: 30%">
                            <span class='text-bold text-danger' id="error">CEK ULANG SEBELUM SUBMIT !!!</span>               
                        </td>
                        <td style="width: 4%">
                          <a href="#" title="Scroll to Top" class="pull-right" id="totop">
                              <i class="fas fa-chevron-circle-up text-lg" onclick="backToTop()"></i>
                            </a>
                        </td>
                      </tr>
                  </table>

                  </td>
                </tr>
              </table> 
           
         </td>
         <td style="width: 15%;vertical-align: top">
          <code class="text-bold text-lg">PASTIKAN !!!</code>
          <br>
          <code class="text-bold">* INPUT SESUAI URUTAN SLIP ORDER ADM</code>
         </td>
         </tr>
       </table>
       <?=form_close();?>
        <script type="text/javascript">
        // $('#totop').hide();
        // $('#finput').scroll(function() {
        //     $('#totop').show();
        // });
        // function errorreset(){
        //   $('#error').text('CEK ULANG SEBELUM SUBMIT !!!');
        // }
        function backToTop() {
            $("#finput").animate({scrollTop: 0}, 1500);
          }
        var xx = ($(window).height()-363);
        $(document).ready(function() {
          $("#finput").css({"height":+xx+"px"}); 
          $("#suffix1").focus(); 
        });
        $('#mydata').submit(function(e){
            e.preventDefault();
             var fa = $(this);
             $("#save").attr('disabled', true);
             setTimeout(function() { 
                  $("#save").attr('disabled', false);
             }, 3000);
             $('#error').removeClass("text-danger");
             
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
                    $('#error').addClass("text-success");
                    $('#error').text("PROCESSING CALCULATION...");
                    $("input").css({"background-color": "#ccc","color": "#444"});
                    $.ajax({
                      url: fa.attr('action'),
                      type: 'post' ,
                      data: fa.serialize(),
                      dataType: 'json',
                      success: function(response) {
                        if(response.success == true){                     
                          
                                $('.form-group').removeClass('has-error')
                                                .removeClass('has-success');
                                $('.text-danger').remove();
                                fa[0].reset();
                                $('#error').text("SUCCESS CALCULATION...");
                                //kbnreg(response.lotid);
                                setTimeout(function() { 
                                      forminput();
                                      $('#example').DataTable().ajax.reload();
                                 }, 1000);
                                
                        }else{
                          $.each(response.messages,function(key, value){
                            var element = $('.' + key);
                            element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.text-danger')
                            .remove();
                            element.after(value);
                          });
                          $('#error').removeClass("text-success");
                          $('#error').addClass("text-danger");
                          $('#error').text("Ada input yang Error !!!");
                        }
                      }
                   });
              }     
            });
          });
        function kbnreg(lotid){
          window.open("<?=base_url('s_print/kbnreg');?>?lotid="+lotid+"&print=A&api=<?=$id_t;?>", "_blank");
        }
        </script>

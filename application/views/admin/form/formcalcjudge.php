   <div class="modal-header">
       <h4 class="modal-title">Judgement Slip Order</h4>
       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
           <span aria-hidden="true">&times;</span>
       </button>
   </div>
   <div class="modal-body" style="overflow: auto">
       <p style="padding:0px;">Format Value: <code>Numeric Angka</code></p>
       <div id="psn" class="text-center text-lg"></div>
       <table nowrap border="1" cellspacing="1" class="text-center table-border" style="width:100%;border-color:#aaa">
           <thead>
               <tr style="background-color: #ccc">
                   <th class="text-Center">Shop</th>
                   <th class="text-center">Trip</th>
                   <th class="text-center">Slip</th>
                   <th class="text-center">Lifting</th>
                   <th class="text-center">Max<br>Lifting/Slip</th>
                   <th class="text-center">Max<br>Slip/Trip</th>
                   <th class="text-center">Max<br>Slip/Input</th>
                   <th class="text-center">Last Update</th>
                   <th class="text-center">Action</th>
               </tr>
           </thead>
           <tbody>
               <?php foreach($data_judge as $key){ ?>
               <tr>
                   <td>
                       <?=$key->shop;?>
                   </td>
                   <td style="padding: 2px">
                       <input id="trip<?=$key->shop;?>" type="number" class="form-control text-center text-bold"
                           name="trip<?=$key->shop;?>" value="<?=$key->trip;?>" style="border:1px solid #9af;"
                           required="required" autocomplete="off">
                   </td>
                   <td style="padding: 2px">
                       <input id="sliporder<?=$key->shop;?>" type="number" class="form-control text-center text-bold"
                           name="sliporder<?=$key->shop;?>" value="<?=$key->sliporder;?>" style="border:1px solid #9af;"
                           required="required" autocomplete="off">
                   </td>
                   <td style="padding: 2px">
                       <input id="lifting_no<?=$key->shop;?>" type="number" class="form-control text-center text-bold"
                           name="lifting_no<?=$key->shop;?>" value="<?=$key->lifting_no;?>"
                           style="border:1px solid #9af;" required="required" autocomplete="off">
                   </td>
                   <td style="padding: 2px">
                       <input id="max_lifting_slip<?=$key->shop;?>" type="number"
                           class="form-control text-center text-bold" name="max_lifting_slip<?=$key->shop;?>"
                           value="<?=$key->max_lifting_slip;?>" max="4" style="border:1px solid #9af;" maxlength="1"
                           required="required" autocomplete="off">
                   </td>
                   <td style="padding: 2px">
                       <input id="max_slip_trip<?=$key->shop;?>" type="number"
                           class="form-control text-center text-bold" name="max_slip_trip<?=$key->shop;?>"
                           value="<?=$key->max_slip_trip;?>" style="border:1px solid #9af;" maxlength="1"
                           required="required" autocomplete="off">
                   </td>
                   <td style="padding: 2px">
                       <input id="max_slip_input<?=$key->shop;?>" type="number"
                           class="form-control text-center text-bold" name="max_slip_input<?=$key->shop;?>"
                           value="<?=$key->max_slip_input;?>" style="border:1px solid #9af;" maxlength="1"
                           required="required" autocomplete="off">
                   </td>
                   <td class="text-sm">
                       <?=$key->update_time;?>
                   </td>
                   <td style="padding: 2px">
                       <button class="btn btn-success btn-sm"
                           onclick="submitcalcjudge('<?=$key->shop;?>')">Submit</button>
                   </td>
               </tr>
               <?php } ?>
           </tbody>
       </table>
   </div>
   <script type="text/javascript">
var cv = '<?=$this->security->get_csrf_hash(); ?>';

function submitcalcjudge(shop) {
    $("#psn").text('');
    swal({
            title: "Are you sure?",
            text: "Judgement Shop " + shop,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes',
            closeOnConfirm: true,
            //closeOnCancel: false
        },
        function() {
            var trip = $("#trip" + shop).val();
            var sliporder = $("#sliporder" + shop).val();
            var lifting_no = $("#lifting_no" + shop).val();
            var max_lifting_slip = $("#max_lifting_slip" + shop).val();
            var max_slip_trip = $("#max_slip_trip" + shop).val();
            var max_slip_input = $("#max_slip_input" + shop).val();
            var jumlift = max_slip_trip * max_lifting_slip;
            $("#trip" + shop).removeClass('border-danger ');
            $("#sliporder" + shop).removeClass('border-danger ');
            $("#lifting_no" + shop).removeClass('border-danger ');
            $("#max_lifting_slip" + shop).removeClass('border-danger ');
            $("#max_slip_trip" + shop).removeClass('border-danger ');
            $("#max_slip_input" + shop).removeClass('border-danger ');
            if (trip == 0) {
                $("#trip" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error,Tidak boleh angka 0 !!!');
            } else if (sliporder == 0) {
                $("#sliporder" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error,Tidak boleh angka 0 !!!');
            } else if (lifting_no == 0) {
                $("#lifting_no" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error,Tidak boleh angka 0 !!!');
            } else if (max_lifting_slip == 0) {
                $("#max_lifting_slip" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error,Tidak boleh angka 0 !!!');
            } else if (max_lifting_slip != 4) {
                $("#max_lifting_slip" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error, max_lifting_slip Harus angka 4 !!!');
            } else if (max_slip_trip == 0) {
                $("#max_slip_trip" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error,Tidak boleh angka 0 !!!');
            } else if (max_slip_input == 0) {
                $("#max_slip_input" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error,Tidak boleh angka 0 !!!');
            } else if (max_slip_trip % max_slip_input != 0) {
                $("#max_slip_input" + shop).addClass('border-danger ');
                $("#psn").removeClass('text-success ');
                $("#psn").addClass('text-danger ');
                $("#psn").text('Error, Bukan faktor bilangan max slip/trip ...!!!');
            } else {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url('sliporder/submitcalcjudge?api='.$id_t); ?>",
                    dataType: 'json',
                    data: "<?=$this->security->get_csrf_token_name();?>=" + cv + "&shop=" + shop +
                        "&sliporder=" + sliporder + "&trip=" + trip + "&lifting_no=" + lifting_no +
                        "&max_lifting_slip=" + max_lifting_slip + "&max_slip_trip=" + max_slip_trip +
                        "&max_slip_input=" + max_slip_input,
                    cache: false,
                    success: function(data) {

                        $("#psn").removeClass('text-danger ');
                        $("#psn").addClass('text-success ');
                        $("#psn").text('Success Update...!!!');
                        forminput();
                    }

                });
            }

        });
}

function validateNumber(e) {
    alert(e.key)
}
   </script>
<input type="hidden" name="sj_no" value="<?=$sj_no;?>"/>
<table class="table table-bordered">
  <tr>
    <th class="text-center" style="width: 1%">No</th>
    <th>Part_No</th>
    <th>Part_Name</th>
    <th class="text-center" style="width: 5%">Qty<br>/box</th>
    <th class="text-center" style="width: 5%">Delv<br>(pcs)</th>
    <th class="text-center" style="width: 5%">Delv<br>(box)</th>
    <th class="text-center" style="width: 5%">Rec<br>(box)</th>
    <th>Status</th>
  </tr>
  <?php if(!empty($data_table)){ $i=1; foreach ($data_table as $key) {
   $rec_qtybox=$key->rec_qtybox;
   if(($rec_qtybox+$key->problem_qtybox)<=0){
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
      <input type="text" class="form-control text-center" name="xx[]" class="form-control" value="<?=$key->delv_qtybox*$key->qty_kbn;?>" disabled style="padding:0px;">
    </td>
    <td class="text-center">
      <input type="text" class="form-control text-center" name="delv_qtybox[]" class="form-control" value="<?=$key->delv_qtybox;?>" disabled style="padding:0px;">
    </td>
    <td class="text-center">
      <input id="id[]" type="hidden" name="id[]" value="<?=$key->id;?>"/>
      <input id="rec_qtybox[]" type="number" class="form-control text-center border-info" name="rec_qtybox[]" class="form-control" placeholder="Rec Qty" required="required" value="<?=$rec_qtybox;?>"  style="padding:0px;">
    </td>
    <td>
      <?=$key->status;?>
    </td>
  </tr>
<?php } }else{ ?>
  <tr>
      <td colspan="8">
        No Data
      </td>      
    </tr>
<?php } ?>
</table>
<script type="text/javascript">
  var rec = "<?=$receipt_date;?>";
  if(rec!=''){
    $("#save").prop( "disabled", true );
    $("#viewrecsjsc").addClass('text-success');
  }
</script>
  
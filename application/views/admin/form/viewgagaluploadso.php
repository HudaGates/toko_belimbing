<div class="modal-header text-red">
  <h4 class="modal-title">DATA GAGAL UPLOAD, PLEASE CHECK FORM EXCEL!</h4>
  <button class="close text-red" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
  <div class="modal-content">
    <table class="table table-hover table-striped compact">
    <tr class="bg-red">
      <td>No</td>
      <td>Error</td>
      <td>supplier Code</td>
      <td>Delv Date</td>
      <td>Material Spec</td>
      <td>MaterialCode</td>
      <td>Part No</td>
      <td>Order Kbn</td>
      <td>Remark</td>
    </tr>
    <?php foreach ($data_table as $key) { 
      if($key->status_upload!='OK'){
        $bg="text-red";
      }else{
        $bg="";
      } ?>
    <tr>
      <td><?=$key->id;?></td>
      <td class="<?=$bg;?>"><?=$key->status_upload;?></td>
      <td><?=$key->supplier_code;?></td>
      <td><?=$key->delv_date;?></td>
      <td><?=$key->material_spec;?></td>
      <td><?=$key->material_code;?></td>
      <td><?=$key->part_no;?></td>
      <td><?=$key->order_kbn;?></td>
      <td><?=$key->remark;?></td>
    </tr>
  <?php } ?>
  </table>
</div>
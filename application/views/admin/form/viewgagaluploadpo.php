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
      <td>Period</td>
      <td>PO No</td>
      <td>supplier Code</td>
      <td>Material Spec</td>
      <td>Part No</td>
      <td>PO Qty</td>
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
      <td><?=$key->period;?></td>
      <td><?=$key->po_no;?></td>
      <td><?=$key->supplier_code;?></td>
      <td><?=$key->material_spec;?></td>
      <td><?=$key->part_no;?></td>
      <td><?=$key->po_qty;?></td>
    </tr>
  <?php } ?>
  </table>
</div>
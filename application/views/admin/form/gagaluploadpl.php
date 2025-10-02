<!-- form start -->
<div class="modal-header">
  <h4 class="modal-title">ERROR, PLEASE CHECK FORM EXCEL!</h4>
  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
   <table style="width: 100%;height: 100%;border-collapse: collapse;border-spacing: 0px;text-align: center;">
    <tr class="bg-blue">
      <td>No</td>
      <td>Error</td>
      <td>Upload Date</td>
      <td>Prod. Shift</td>
      <td>Suffix</td>
    </tr>
    <?php foreach ($data_table as $key) { 
      if($key->status_upload!='Valid'){
        $bg="text-red";
      }else{
        $bg="";
      } ?>
    <tr class="<?=$bg;?>">
      <td><?=$key->id;?></td>
      <td><?=$key->status_upload;?></td>
      <td><?=$key->upload_date;?></td>
      <td><?=$key->prod_shift;?></td>
      <td><?=$key->suffix;?></td>
    </tr>
  <?php } ?>
  </table>                  
</div>
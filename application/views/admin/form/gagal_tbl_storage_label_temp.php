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
            <td>Part No Customer</td>
            <td>Storage Label</td>
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
            <td><?=$key->part_no_customer;?></td>
            <td><?=$key->storage_label;?></td>
        </tr>
        <?php } ?>
    </table>
</div>
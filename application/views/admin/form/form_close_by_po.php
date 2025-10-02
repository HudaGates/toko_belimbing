<!-- /.box -->
<div class="modal-header bg-<?=$this->qt->thema;?>">
    <h4 class="modal-title">CLOSE PER ITEM </h4>
    <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="box">
        <form id="submit">
            <div class="form-group">
                <div class="row">
                    <div class="col-12">
                        <label for="po_no">List part to be executed:</label>
                    </div>
                    <div class="col-12">
                        <table border="1" style="width: 100%; border-collapse: collapse; ">
                            <tr style="background-color: #ddd;">
                                <th style="padding: 2px;">
                                    ID
                                </th>
                                <th style="padding: 2px;">
                                    PO/CUST.
                                </th>
                                <th style="padding: 2px;">
                                    Part No Customer
                                </th>
                                <th style="padding: 2px;">
                                    Remain(pcs)
                                </th>
                                <th style="padding: 2px;">
                                    Current Status
                                </th>
                                
                            </tr>
                            <?php $st='';
                            foreach($qpo as $row){ $bg=''; if($row->status=='Finish'){ $st='disabled'; $bg='bg-red'; } ?>
                            <tr class="<?=$bg;?>">
                                <td style="padding: 2px;">
                                    <?= $row->id; ?>
                                    <input type="text" class="id" value="<?= $row->id;?>" hidden>
                                </td>
                                <td style="padding: 2px;">
                                    <?= $row->po_no; ?> / <?= $row->customer; ?>
                                </td>
                                <td style="padding: 2px;">
                                    <?= $row->part_no_customer; ?>
                                </td>
                                <td style="padding: 2px;">
                                    <?= $row->po_qty-$row->pulling; ?>
                                </td>
                                <td style="padding: 2px;">
                                    <?= $row->status; ?>
                                </td>
                                
                            </tr>
                            <?php }?>
                        </table>
                    </div>

                    <div class="col-12 mt-2">
                        <label for="po_no">Note:</label>
                        <textarea class="form-control" name="note" id="note" cols="30" rows="10" required></textarea>
                    </div>
                    <div class="col-12" id="hasil">
                        <!-- <input type="text" id="note" name="note"> -->
                        
                    </div>
                </div>
            </div>

            <div class="box-footer width-border">
                <button onclick="close_by_po()" type="button" class="btn btn-success" id="save" <?=$st;?>> Submit
                </button>
                <button type="button" class="btn btn-danger exit" data-dismiss="modal"
                    aria-label="Close">Close</button>
            </div>
            <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
let arrId = [];
let filledBlanks = Array.from(document.getElementsByClassName('id'));
filledBlanks.map((input) => {
    return input.value;
}).forEach((value) => {
    arrId.push(value);
});

// console.log(arrId);

function close_by_po() {

    // let po_no = document.getElementById('po_no').value;
    let note = document.getElementById('note').value;
    $.ajax({
        type: "POST",
        url: "<?=base_url('planning/close_by_po?api='.$this->id_t); ?>",
        data: "id=" + arrId + "&note=" + note + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        dataType: 'json',
        success: function(data) {
            if (data.success == true) {
                swal({
                    title: "Submit Success",
                    text: '',
                    type: "success",
                    timer: 1000,
                    showConfirmButton: false
                });
                $('#example').DataTable().ajax.reload();
                $("#myModal").modal('hide');
            } else {
                $("#hasil").html("<h3 class='text-red'>Submit Failed !!!</h3>");
            }

        }
    });
}
</script>
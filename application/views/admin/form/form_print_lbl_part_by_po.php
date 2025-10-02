<!-- /.box -->
<div class="modal-header bg-<?=$this->qt->thema;?>">
    <h4 class="modal-title">PRINT LABEL PART BY PO </h4>
    <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="box">
        <form id="submit">
            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="po_no">Choose a PO:</label>

                        <select name="po_no" id="po_no">
                            <?php 
                            foreach($qpo as $row){ ?>
                            <option value="<?= $row->po_no; ?>">(<?= $row->customer; ?>) - <?= $row->po_no; ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="box-footer width-border">
                <button onclick="print_lbl_part_by_po()" type="button" class="btn btn-success" id="save"> Submit
                </button>
                <button type="button" class="btn btn-danger exit" data-dismiss="modal"
                    aria-label="Close">Cancel</button>
            </div>
            <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
function print_lbl_part_by_po() {
    let po_no = document.getElementById('po_no').value;
    window.open("<?=base_url('planning/print_lbl_part_by_po');?>?po_no=" + po_no +
        "&api=<?=$this->id_t;?>",
        "_blank");
    $("#myModal").modal('hide');
}
</script>
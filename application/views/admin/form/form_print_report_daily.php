<!-- /.box -->
<div class="modal-header ">
    <h4 class="modal-title">PRINT REPORT DAILY</h4>
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
                        <label for="po_no">Date:</label>

                        <input type="date" name="day" id="day">
                    </div>
                </div>
            </div>
            <!-- <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="po_no">End:</label>

                        <input type="date" name="end" id="end">
                    </div>
                </div>
            </div> -->
            <!-- <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="po_no">Mont:</label>
                        <select name="yearmonth" id="yearmonth">
                            <?php
                                foreach ($qsubstr as $key) { 
                            ?>
                            <option value="<?=$key->substr?>"><?=$key->substr?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div> -->

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
    // let start = document.getElementById('start').value;
    // let end = document.getElementById('end').value;

    let day = document.getElementById('day').value;
    window.open("<?=base_url('s_print/reportday');?>?day=" + day +
        "&api=<?=$this->id_t;?>",
        "_blank");
    $("#myModal").modal('hide');
}
</script>
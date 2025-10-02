<div class="modal-header bg-<?=$this->qt->thema;?>">
    <h4 class="modal-title">FORM UPDATE STOCK PART</h4>
    <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="box">
        <form id="submit">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">

                        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name"
                            value="<?=$this->security->get_csrf_hash(); ?>">
                        <input id="table" type="hidden" name="table" value="<?=$table;?>" />
                        <div class="form-group">
                            <label for="exampleInputFile">File upload excel <a
                                href="<?=base_url()?>formatexcel/<?='UpdateStock';?>.xlsx"
                                class="btn btn-default text-green" title="Download Format Excel Upload">
                                <span class="fa fa-file-excel-o fa-lg"> </span> Format upload file excel
                                </a>
                            </label>
                            <input  class="form-control col-10" id="fileupload" type="file" name="fileimport" accept=".xls,.xlsx" required>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                        <div class="callout callout-danger" style="padding: 3px">
                            <big><code>Ketentuan Update Stock</code></big>
                            <ul>
                                <li><b>1. PartNoFSI</b> (Pastikan ada di Master Partlist)</li>
                                <li><b>2. Stock</b> (Pastikan type numeric)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <p><code id="hasil">Progress</code></p>
                <div class="progress active" id="progress" style="height:30px;"></div>                
            </div>
            <div id="hasil1"></div>
            <!-- /.box-body -->
            <div class="box-footer width-border">
                <button type="submit" class="btn btn-success" id="save"> Submit </button>
                <button type="button" class="btn btn-danger exit" data-dismiss="modal"
                    aria-label="Close">Close</button>
            </div>
            <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var myVar;
    var x = 1000;
    var tabel1 = "tbl_temp_stock";

    function statusupload() {
        myVar = setTimeout(function() {
            $.ajax({
                async: true,
                type: "POST",
                url: "<?=base_url('master/statusupload?api='.$this->id_t);?>",
                data: "table=" + tabel1 + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
                cache: false,
                dataType: 'json',
                success: function(data) {
                    persen = (data.persen * 1) + 0;
                    $('#hasil').text(data.success + " success " + data.failed +
                        " failed from " + data.total + " rows");
                    $("#progress").html(
                        "<div class='progress-bar progress-bar-primary progress-bar-striped text-center text-red bg-green' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:" +
                        persen + "%'>" + persen + "%</div>");
                    if (persen == 100) {
                        x = 0;
                        clearTimeout(myVar);
                        $('#example').DataTable().ajax.reload();
                        $('#hasil1').html("<span class='text-lg text-success'>Upload Finish !!</span>");
                    }

                }
            });
            statusupload();
        }, x);

    }
    $(".exit").click(function() {
        x = 0;
        clearTimeout(myVar);
    });

    $('#submit').submit(function(e) {
        $("#save").attr('disabled', true);
        statusupload();
        e.preventDefault();
        $.ajax({
            url: '<?=base_url('master/uploadstock?api='.$this->id_t);?>',
            type: "post",
            data: new FormData(this),
            processData: false,
            contentType: false,
            cache: false,
            async: true,
            dataType: 'json',
            success: function(data) {
                if (data.status == "error") {
                    $("#save").attr('disabled', false);
                    x = 0;
                    clearTimeout(myVar);
                   $('#hasil1').html("<span class='text-lg text-red'>"+data.msg+"</span>");
                } else {
                    if (data.status == "gagal") {
                        $("#save").attr('disabled', false);
                        gagalupload('tbl_temp_stock');
                        x = 0;
                        clearTimeout(myVar);
                    }
                }

            }

        });

    });

});

function gagalupload(table) {
    $.ajax({
        type: "POST",
        url: "<?=base_url('master/gagalupload?api='.$this->id_t); ?>",
        data: "table=" + table + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        success: function(data) {
            $("#view").html(data);
            $("#myModal").modal('show');
        }
    });
}
</script>
<?php 
$yl=gmdate('Y', time() + 60 * 60 * 7);
$yn=gmdate('Y', time() + 60 * 60 * 7);
$yx=gmdate('Y', time() + 60 * 60 * 7);
$mn=intval(gmdate('m', time() + 60 * 60 * 7));
$ml=$mn-1;
$mx=$mn+1;

if($mn==1){
    $ml=12;
    $yl=$yn-1;
}
if($mn==12){
    $mx=1;
    $yx=$yn+1;
}
if($mx<10){
    $mx='0'.$mx;
}
if($ml<10){
    $ml='0'.$ml;
}
if($mn<10){
    $mn='0'.$mn;
}
$yl=$yl.$ml;
$yn=$yn.$mn;
$yx=$yx.$mx;

?>
<!-- /.box -->
<div class="modal-header bg-<?=$this->qt->thema;?>">
    <h4 class="modal-title">FORM UPDATE LABEL STORAGE</h4>
    <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <div class="card card-body p-1 pb-0">
        <span class="pt-1">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info"></i>Format
                    Excel</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Chosesing File</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Click Submit</li>
            </ul>
        </span>
    </div>
    <div class="box">
        <form id="submit">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name"
                            value="<?=$this->security->get_csrf_hash(); ?>">
                        <input id="table" type="hidden" name="table" value="<?=$table;?>" />
                        <div class="form-group">
                            <label for="exampleInputFile">File upload excel <a
                                    href="<?=base_url()?>formatexcel/<?='storage-label_update';?>.xlsx"
                                    class="btn btn-default text-green" title="Download Format Excel Upload">
                                    <span class="fa fa-file-excel-o fa-lg"> </span> Format upload file excel
                                </a>
                            </label>
                            <input class="form-control col-12" id="fileupload" type="file" name="fileimport"
                                accept=".xls,.xlsx" required>
                        </div>

                    </div>

                </div>
            </div>
            <div class="form-group">
                <p><code id="hasil">Progress</code></p>
                <div class="progress active" id="progress" style="height:30px;"></div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer width-border">
                <button type="submit" class="btn btn-success" id="save"> Submit </button>
                <button type="button" class="btn btn-danger exit" data-dismiss="modal"
                    aria-label="Close">Cancel</button>
            </div>
            <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    var myVar;
    var x = 4000;
    var tabel1 = "<?=$table;?>";

    function statusupload() {
        myVar = setTimeout(function() {
            $.ajax({
                async: true,
                type: "POST",
                url: "<?=base_url('master/statusupload?api='.$id_t);?>",
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
                        setTimeout(function() {
                            $('#example').DataTable().ajax.reload();
                            swal({
                                title: "Upload Finish",
                                text: '',
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            $("#myModal").modal('hide');
                        }, 2000);
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
            url: '<?=base_url('master/upload_upd_stge_lbl?api='.$id_t);?>',
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
                    swal({
                        title: "Error!",
                        text: data.msg,
                        type: "warning",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    if (data.status == "gagal") {
                        $("#save").attr('disabled', false);
                        gagalupload('tbl_storage_label_temp');
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
        url: "<?=base_url('master/gagalupload?api='.$id_t); ?>",
        data: "table=" + table + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        success: function(data) {
            $("#view").html(data);
            $("#myModal").modal('show');
        }
    });
}
</script>
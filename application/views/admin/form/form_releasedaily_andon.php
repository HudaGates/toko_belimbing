<!-- /.box -->

<div class="modal-body">
    <!-- <div class="card card-body p-1 pb-0">
        <span class="pt-1">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0"><i class="fa fa-check text-green"></i> Calculation</li>
                <li class="list-group-item border-0"><i class="fa fa-check text-green"></i>
                    Select & Update Calc_Pcs</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Release Order</li>
            </ul>
        </span>
    </div> -->
    <hr>
    <div class="card card-body border-1 m-0 p-2">
        <form id="submit">
            <div class="form-group">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-8">
                        <div class="callout callout-danger" style="padding: 3px">
                            <big><code>Ketentuan CALC PART</code></big>
                            <ul>
                                <li><b>1. Part No</b> (Pastikan ada di Master Partlist)</li>
                                <li><b>2. Forecast</b> (Pastikan Lebih dari 0)</li>
                                <li><b>3. Judge Calc_Pcs</b> (Pastikan Lebih dari 0)</li>
                                <li><b>4. Delete Row</b> (Cancel Calculation)</li>
                                <li><b>5. Calc_PCS = PO_QTY - FORECAST - LAST_CALC</b></li>
                                <li><b>6. Release Order </b> (Status 'Open' -> 'Release')</li>
                            </ul>
                        </div>
                    </div>
                    <hr>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name"
                            value="<?=$this->security->get_csrf_hash();?>">
                        <input id="table" type="hidden" name="table" value="<?=$table;?>" />
                        <div class="form-group">
                            <label for="exampleInputEmail1">Delv Date:</label><br>
                            <input type="date" id="delv_date" name="delv_date" class="form-control" required
                                value="<?=gmdate('Y-m-d', time() + 60 * 60 * 7);?>"
                                min='<?=gmdate('Y-m-d', time() + 60 * 60 * 7);?>'>
                        </div>
                        <br>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Supplier Code(Status->Open):</label><br>
                            <select class="form-control" name="supplier_code" id="supplier_code" required="required">
                                <option value=""></option>
                                <?php if(!empty($qcust)){ foreach($qcust as $key){ ?>
                                <option value="<?=$key->supplier_code;?>"><?=$key->supplier_code;?></option>
                                <?php  } ?>
                                <option value="All">All</option>
                                <?php  } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <p id="errormsg"></p>
                        </div>

                    </div>
                    <hr>
                </div>
            </div>
            <div class="form-group">
                <label><code id="hasil">Progress release</code></label>
                <div class="progress active" id="progress" style="height:30px;"></div>
            </div>

            <!-- /.box-body -->
            <div class="box-footer width-border">
                <button type="submit" class="btn btn-success" id="save"> Submit </button>
                <button type="button" onclick="closeModal()">Close</button>
            </div>
            <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
var modal = document.getElementById("myModal");
var myVar;
var x = 2000;

function statusupload(table3) {
    myVar = setTimeout(function() {
        $.ajax({
            async: true,
            type: "POST",
            url: "<?=base_url('planning/statusupload?api='.$this->id_t);?>",
            data: "table=" + table3 + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(data) {
                persen = (data.persen * 1) + 0;
                $('#hasil').text("Release order  " + data.success + " success " + data.failed +
                    " failed from " + data.total + " rows");
                $("#progress").html(
                    "<div class='progress-bar progress-bar-primary progress-bar-striped text-center text-red bg-green' role='progressbar' aria-valuenow='100' aria-valuemin='0' aria-valuemax='100' style='width:" +
                    persen + "%;'>" + persen + "%</div>");
                if (parseInt(persen) == 100) {
                    $("#errormsg").html(
                        "<span class='text-success text-bold'> Release order success!!</code>");
                    x = 0;
                    clearTimeout(myVar);
                    setTimeout(function() {
                        $('#example').DataTable().ajax.reload();
                        if (modal.getAttribute('data-toggle') == 'modal') {
                            $("#myModal").modal('hide');
                        } else {
                            modal.style.display = "none";
                        }


                    }, 3000);
                }

            }
        });
        statusupload(table3);
    }, x);

}
$(".exit").click(function() {
    x = 0;
    clearTimeout(myVar);
    $('#example').DataTable().ajax.reload();
});

$('#submit').submit(function(e) {
    $("#save").attr('disabled', true);
    $(".exit").attr('disabled', true);
    statusupload('<?=$table;?>');
    $("#errormsg").html(
        '<div><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>'
    );
    e.preventDefault();
    $.ajax({
        url: '<?=base_url('planning/release_orderdaily?api='.$this->id_t);?>',
        type: "post",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        async: true,
        dataType: 'json',
        success: function(response) {
            if (response.success == false) {
                $(".exit").attr('disabled', false);

                x = 0;
                clearTimeout(myVar);
                $("#errormsg").html('');
                $.each(response.messages, function(key, value) {
                    var element = $('#' + key);
                    element.closest('div.form-group')
                        .removeClass('has-error')
                        .addClass(value.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger')
                        .remove();
                    element.after(value);
                });
            } else {
                $(".exit").attr('disabled', false);
            }

        },
        error: function(xhr, status, error) {
            $(".exit").attr('disabled', false);
            x = 0;
            clearTimeout(myVar);
            $("#errormsg").html('<code>Error ' + error + '</code>');
        }

    });

});
</script>
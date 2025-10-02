<div class="modal-header bg-<?= $this->qt->thema; ?>">
    <h4 class="modal-title">KALKULASI ORDER MATERIAL </h4>
    <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="box">
        <?= form_open('planning/calcorder?api=' . $id_t, 'id="mydata"'); ?>
        <input id="table" type="hidden" name="table" value="<?= $table; ?>" />
        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?= $this->security->get_csrf_hash(); ?>">
        <div class="form-group">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <label for="exampleInputEmail1">Input Delivery Date</label>
                    <input type="date" id="delv_date" name="delv_date" class="form-control date" required>

                </div>
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <div class="callout callout-danger">
                        <big><code>Ketentuan Kalkulasi Order</code></big>
                        <ul>
                            <li><b>1. Data PO </b> ( Pastikan matrial_spec + part_no benar sesuai Master Row Material)
                            </li>
                            <li><b>2. Qty PO</b> (Pastikan Mencukupi Untuk Order)</li>
                            <li><b>3. Delivery Date</b> (Pastikan Minimal hari ini)</li>
                            <li><b>4. Cek Hasil Kalkulasi Pada Kolom Remark</b> (PO KOSONG,PO KURANG,NO PROD.,STOCK >
                                MIN)</li>
                            <li><b>5. Kolom Remark 'OK' Siap Release Order</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <p><code id="hasil">Progress</code></p>
            <div class="progress active" id="progress"></div>
        </div>
        <!-- /.box-body -->
        <div class="box-footer width-border">
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
            <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Cancel</button>
        </div>
        <?= form_close(); ?>
    </div>
</div>
<script type="text/javascript">
var myVar;
var x = 1000;
var tabel1 = "<?= $table; ?>";

function statusupload() {
    myVar = setTimeout(function() {
        $.ajax({
            async: true,
            type: "POST",
            url: "<?= base_url('planning/statusupload?api=' . $id_t); ?>",
            data: "table=" + tabel1 + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(data) {
                persen = (data.persen * 1) + 0;
                $('#hasil').text(data.success + " success " + data.failed + " failed from " + data
                    .total + " rows");
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

$('#mydata').submit(function(e) {
    statusupload();
    e.preventDefault();
    var fa = $(this);
    $("#save").attr('disabled', true);

    $.ajax({
        url: fa.attr('action'),
        type: 'post',
        data: fa.serialize(),
        dataType: 'json',
        success: function(response) {

            if (response.success == true) {
                $('.form-group').removeClass('has-error')
                    .removeClass('has-success');
                $('.text-danger').remove();
                fa[0].reset();
            } else {
                $("#save").attr('disabled', false);
                x = 0;
                clearTimeout(myVar);
                $.each(response.messages, function(key, value) {
                    var element = $('#' + key);
                    element.closest('div.form-group')
                        .removeClass('has-error')
                        .addClass(value.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger')
                        .remove();
                    element.after(value);
                });
            }
        }
    });
});
</script>
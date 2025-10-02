<style>
input {
    width: 100%;
}
</style>
<div class="modal-body">
    <hr>
    <div class="card">
        <?=form_open('andon/orderpart?api=andon', 'id="mydata"'); ?>
        <!-- <input id="id" type="hidden" name="id" value="<?=$id;?>" /> -->
        <!-- <input id="table" type="hidden" name="table" value="<?=$table;?>" /> -->
        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name" value="<?=$this->security->get_csrf_hash(); ?>">
        <div class="card-body">
            <table style="width: 100%; font-size: 100%; padding: 5px;">
                <tr>
                    <td style="width:13%">
                        <label for="exampleInputEmail1">PartNoFsi</label>
                    </td>
                    <td style="width:2%">
                        :
                    </td>
                    <td style="width:40%">
                        <input id="part_no_fsi" type="text" class="form-control" name="part_no_fsi" readonly
                            value="<?=$qs->part_no_fsi;?>">
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="exampleInputEmail1">Part Name</label>
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <input id="part_name" type="text" class="form-control" name="part_name" readonly
                            value="<?=$qs->part_name;?>">
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="exampleInputEmail1">Model</label>
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <input id="model" type="text" class="form-control" name="model" readonly
                            value="<?=$qs->model;?>">
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="exampleInputEmail1">Supplier</label>
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <input id="supplier_code" type="text" class="form-control" name="supplier_code" readonly
                            value="<?=$qs->supplier_code;?>">
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="exampleInputEmail1">StockAkhir

                        </label>
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <input id="stock_akhir" type="text" class="form-control" name="stock_akhir" readonly
                            value="<?=$qs->stock_akhir;?>">
                    </td>
                    <td style="color:yellow;">&nbsp; &nbsp;<sub>(*jika stock tdk sesuai silahkan edit stock)</sub></td>
                </tr>
                <tr>
                    <td>
                        <label for="exampleInputEmail1">DeliveryDate</label>
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <input id="delv_date" type="date" class="form-control" name="delv_date" required
                            value="<?=gmdate('Y-m-d',time()+60*60*7);?>">
                    </td>
                    <td>

                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="exampleInputEmail1">OrderPart</label>
                    </td>
                    <td>
                        :
                    </td>
                    <td>
                        <input id="order_part" type="number" class="form-control" name="order_part" required
                            value="<?=abs($qs->stock_akhir);?>">
                    </td>
                    <td>

                    </td>
                </tr>
            </table>
            <div class="row">
                <div id="hasil"></div>
            </div>
        </div>
        <hr>
        <!-- /.box-body -->
        <div class="card-footer width-border">
            <button type="submit" class="btn btn-success" id="save"> Submit </button>
            <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Close</button>
        </div>
        <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
$('#mydata').submit(function(e) {
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
                // swal({
                //     title: "Success!!",
                //     text: "",
                //     type: "success",
                //     timer: 1200,
                //     showConfirmButton: false
                // });
                $('.form-group').removeClass('has-error')
                    .removeClass('has-success');
                $('.text-danger').remove();
                fa[0].reset();
                $("#hasil").html(
                    "<span class='text-success text-lg text-bold'>Order Success !!</span>");
                $('#example').DataTable().ajax.reload();
                modal.style.display = "none";

            } else {
                $("#hasil").html("<span class='text-red text-lg text-bold'>" + response.success +
                    "</span>");
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
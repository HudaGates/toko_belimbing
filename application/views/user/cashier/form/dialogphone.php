<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">Input Phone Number</h4>
    </div>
    <div class="col-3 text-right">
        <button type="button" class="btn btn-danger btn-sm" onclick="cancel()">X</button>
    </div>
</div>
<div class="row">
    <div class="col">



        <br>

        <table class="table">
            <!-- <thead>
                <tr>
                    <th>Product Name</th>
                    <th>QTY</th>
                </tr>
            </thead> -->
            <tbody>

                <tr>
                    <td class="text-muted text-right text-sm">Phone</td>
                    <td class="font-weight-bold text-left">
                        <input type="text" id="phone" value="<?= $phone?>">
                        <!-- <small class="text-muted"><?= $phone?></small> -->
                    </td>
                </tr>

            </tbody>
        </table>



    </div>
</div>
<div class="row">
    <div class="col">
        <!-- <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeItem()">DELETE</button> -->
        <button type="button" class="btn btn-primary btn-sm" onclick="submitphone()">SAVE</button>

    </div>
</div>
<script>
var phone = $('#phone').val();;



function submitphone() {

    var phone = $('#phone').val();
    window.open("<?=base_url('order');?>?p=" + phone + "&api=1", "_self");

}

function cancel() {
    $("#modallg").modal('hide');
}
</script>
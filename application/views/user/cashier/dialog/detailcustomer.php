<div class="row mb-2">
    <div class="col-12 text-left">
        <!-- <button type="button" class="btn  btn-primary btn-sm" onclick="printreceipt()">Print</button>
        <button type="button" class="btn  btn-primary btn-sm" onclick="openviewcart()">Open</button> -->
        <h5>Detail Customer</h5>
    </div>
</div>
<table class="table">
    <thead style="background-color:#ccc">

        <tr>
            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                No
            </th>
            <th style="width: 20%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Customer Name
            </th>
            <th style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Gender
            </th>

            <th style="width: 20%;padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Phone
            </th>
            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Email
            </th>
            <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Address
            </th>
            <!-- <th style="width: 5%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                Subdistrict
            </th> -->
            <th style="text-align: right; width: 20%; padding: 0px;font-size: 100%;vertical-align: middle;"
                class="text-bold;">
                City
            </th>

        </tr>
    </thead>
    <tbody>
        <?php
$i = 1;
foreach ($qhsd as $key) { ?>
        <tr>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$i++; ?>
            </td>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->customer_name ?>
            </td>
            <td style="padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->gender ?>
            </td>

            <td style="padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->phone ?>
            </td>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->email ?>
            </td>
            <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->address ?>
            </td>
            <!-- <td style=" padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->subdistrict ?>
            </td> -->
            <td style="text-align: right; padding: 5px;font-size: 100%;vertical-align: middle;" class="text-left;">
                <?=$key->city ?>
            </td>

        </tr>
        <?php }?>
    </tbody>
</table>

<script>
var saleid = '<?=$qhs->id?>';

// function printreceipt() {


//     window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + saleid + "&api=<?=$this->id_t;?>", "_blank");

// }

// function openviewcart() {


//     window.open("<?=base_url('cashier');?>?cartid=" + saleid + "&api=<?=$this->id_t;?>", "_self");

// }
</script>
<style>
/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}
</style>
<div class="row">
    <?php
if (count($qmp) == 0) {
    echo "<div class='p-3'>
    <h3 class='m-0 p-0'><i class='fa fa-exclamation-triangle text-yellow'></i> Not Found</h3>
    <p class='m-0 p-0'>Please search any item...</p>
    </div>";
} else {

    foreach ($qmp as $qmp) {
        $filex = base_url('assets/product/img/'.$qmp->product_code.'.jpg?id='.time());
        if (!file_exists($filex)) {
            // $filex = base_url('assets/img/noimage.png');
            $filex = base_url('assets/product/img/'.$qmp->product_code.'.jpg?id='.time());
        }

        $tags = $qmp->category_id;
        if ($tags == 'rokok') {
            $tags = 'indigo';
        } else {
            $tags = 'success';
        }
?>

    <!-- <?=base_url().'assets/product/img/'.$qmp->product_code.'.jpg?id='.time();?> -->

    <div class="col-6 col-md-2 col-sm-6 ">
        <div class="card p-1 border-0" style="border-radius: 2px;">
            <div class="row">

                <div class="col-12">
                    <div class="col-12 p-0 mb-1">
                        <img src="<?= $filex; ?>" class="product-image" alt="Product Image" style="height: 100px">
                    </div>
                    <h5 class="d-inline-block m-0 font-weight-bold" style="font-size: 0.9rem; color: #181818;">
                        <?= strtoupper($qmp->product_name) ?>
                    </h5>
                </div>
                <div class="col-12">
                    <p class="jetbrains m-0 mb-1" style="font-size: 0.7rem; color: #818181">
                        <?= strtoupper($qmp->supplier_code) . '-' . $qmp->product_code; ?>
                    </p>
                </div>
                <div class="col-12 mb-1">
                    <table border="0" style="width: 100%;">
                        <tr>
                            <td class="text-center"
                                style="width: 40%; font-size: 0.6rem; color: #818181; border: 1px dotted #dedede;">
                                CATEGORY
                            </td>
                            <td class="text-center"
                                style="width: 40%; font-size: 0.6rem; color: #818181; border: 1px dotted #dedede;">
                                STOCK
                            </td>
                            <td class="text-center"
                                style="width: 20%; font-size: 0.6rem; color: #818181; border: 1px dotted #dedede;">
                                UNIT
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center "
                                style="font-size: 0.7rem; color: #454545; border: 1px dotted #dedede;">
                                <?= strtoupper($qmp->category_id); ?>
                            </td>
                            <td class="text-center"
                                style="font-size: 0.7rem; color: #454545; border: 1px dotted #dedede;">
                                <?= $qmp->stock; ?>
                            </td>
                            <td class="text-center"
                                style="font-size: 0.7rem; color: #454545; border: 1px dotted #dedede;">
                                <?= strtoupper($qmp->unit); ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-12 mb-1 text-center">
                    <h5 class="m-0 text-bold" style="font-size: <?= $qmp->price >= 9999999 ? '0.9' : '1.1'; ?>rem;">
                        <?php echo 'Rp ' . number_format($qmp->price); ?>
                    </h5>
                </div>
                <div class="col-12 mb-1 px-3">
                    <div class="input-group inline-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-sm btn-outline-secondary btn-minus p-1 px-2">
                                -
                            </button>
                        </div>
                        <input class="form-control form-control-sm quantity text-center p-1" min="1" name="quantity"
                            value="1" id="<?= $qmp->product_code; ?>" type="number">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-outline-secondary btn-plus p-1 px-2">
                                +
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-2">
                    <!-- <button class="add_cart btn btn-sm btn-success btn-block">
                        Add To Cart
                    </button> -->
                    <button style="background-color:gold; color: #000; border-radius: 2px;"
                        class="add_cart btn btn-sm btn-block text-xs" data-product_code="<?= $qmp->product_code; ?>"
                        data-product_name="<?= $qmp->product_name; ?>" data-price="<?= $qmp->price; ?>"
                        <?= $qmp->stock <1?'disabled':''; ?>>
                        ADD
                    </button>
                </div>

            </div>
        </div>
    </div>

    <?php }
} ?>
</div>

<!-- <div class="row ">
    <?php 
                      $i=1;
                      if(!count($qmp)<1){
                        foreach ($qmp as $key) {
                      
                       ?>
    <div class="col-1 mb-2">
        <div class="card" onclick="add('<?=$key->product_code?>')">

            <div class="card-body p-1">
                <div class="ratio ratio-1x1">
                    <img src="<?= base_url().'assets/product/img/'.$key->product_code;?>.jpg?id='<?=time();?>"
                        style="height: auto; max-width: 100%;" class=" img-fluid" alt="...">
                </div>

                <p class="text-bold text-xs m-0 mt-2 text-primary lh-1" style="line-height: 95%;">
                    <?=$key->product_name;?></p>
                <p class="card-text text-xs m-0 lh-1">Rp. <?= number_format($key->price,2,",",".");?> </p>
            </div>
        </div>
    </div>
    <?php }}else{
        echo '<p>Not found !</p>';
    } ?>
</div> -->
<script>
$(document).ready(function() {
    var cartid = $('#cartid').val();
    $.ajax({
        url: "<?= base_url('cart/show_cart?api='); ?>",
        method: "POST",
        data: {
            cartid: cartid,
        },
        success: function(data) {
            $('#detail_cart').html(data);
            getAmount()
        }
    });
});

function add(param) {
    console.log(param)
}

$('.add_cart').click(function() {
    var cartid = $('#cartid').val();
    var product_code = $(this).data("product_code");
    // var supplier_code = $(this).data("supplier_code");
    var product_name = $(this).data("product_name");
    var price = $(this).data("price");
    // var dimensi = $(this).data("dimensi");
    var quantity = $('#' + product_code).val();
    console.log('click');
    $.ajax({
        url: "<?= base_url('order/add_to_cart?api='); ?>",
        method: "POST",
        cache: false,
        dataType: 'json',
        // contentType: 'json',
        // data: "cartid=" + cartid + "&product_code=" + product_code + "&product_name=" + product_name +
        //     "&price=" + price + "&quantity=" + quantity +
        //     "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,

        data: {
            cartid: cartid,
            product_code: product_code,
            product_name: product_name,
            price: price,
            quantity: quantity
        },
        success: function(res) {
            if (res.success == true) {
                console.log(res.success)
                $("#modalxl").modal('hide');

                location.reload();

                swal({
                    title: "Success",
                    text: res.message,
                    type: "success",
                    timer: 1200,
                    showConfirmButton: false
                });
            } else {

                swal({
                    title: "Ups...",
                    text: res.message,
                    type: "warning",
                    timer: 1200,
                    showConfirmButton: false
                });
            }
        },
    });
});



$('.btn-plus, .btn-minus').on('click', function(e) {
    const isNegative = $(e.target).closest('.btn-minus').is('.btn-minus');
    const input = $(e.target).closest('.input-group').find('input');
    if (input.is('input')) {
        input[0][isNegative ? 'stepDown' : 'stepUp']()
    }
});

function getAmount() {
    var cartid = $('#cartid').val();
    $.ajax({
        url: "<?= base_url('cart/get_amount?api='); ?>",
        method: "POST",
        data: {
            cartid: cartid,
        },
        success: function(data) {
            $('#amount').val(data);
            $('#amount-display').text(new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(data));
        }
    });
}
</script>
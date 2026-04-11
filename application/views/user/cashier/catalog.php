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

/* --- Gaya Baru untuk Tampilan V3 --- */
.product-card-v2 {
    border: 1px solid #dee2e6;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    background: #fff;
    transition: transform 0.2s;
    overflow: hidden;
}

.product-card-v2:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 10px rgba(0, 0, 0, 0.1);
}

.product-image-v2 {
    width: 100%;
    height: 100px; 
    object-fit: contain;
    padding: 10px;
}

.product-info-v2 {
    padding: 8px 10px;
}

.price-stock-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 5px 0 10px 0;
}

.price-stock-row h5 {
    font-size: 1.1rem;
    font-weight: 700;
    color: #212529;
    margin: 0;
}

.stock-pill {
    background-color: #f8f9fa;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 5px;
}

.add-btn-v2 {
    padding: 10px 0;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 6px;
    background-color: #007bff !important;
    border-color: #007bff;
    color: #fff !important;
}

/* Kuantitas Group Styling */
.input-group.inline-group {
    display: flex !important;
    border: none;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 10px;
}

.input-group.inline-group .btn {
    background-color: #e9ecef;
    border: none;
    color: #4a6cf7;
    font-weight: bold;
    border-radius: 8px;
    padding: 8px 15px;
}

.input-group.inline-group .form-control {
    border: none;
    box-shadow: none;
    background-color: #fff;
    font-weight: bold;
    font-size: 1rem;
    text-align: center;
}
</style>

<div class="row">
<?php
if (count($qmp) == 0) {
    echo "<div class='p-3'>
    <h3 class='m-0 p-0'><i class='fa fa-exclamation-triangle text-warning'></i> Not Found</h3>
    <p class='m-0 p-0'>Please search any item...</p>
    </div>";
} else {
    foreach ($qmp as $row) {
        $filex = base_url('assets/product/img/'.$row->product_code.'.jpg?id='.time());
        
        // --- LOGIKA HITUNG DISKON UNTUK TAMPILAN ---
        $persen_disc = empty($row->discount) ? 0 : floatval($row->discount);
        $potongan = ($row->price * $persen_disc) / 100;
        $harga_final = $row->price - $potongan;
?>

    <div class="col-lg-2 col-md-4 col-xs-6 mb-3">
        <div class="card product-card-v2 h-100 p-0 border-0 d-flex flex-column">
            
            <div>
                <div class="p-2 text-center">
                    <img src="<?= $filex; ?>" class="product-image-v2" onerror="this.src='<?=base_url('assets/img/box.png');?>'" alt="Product Image">
                    
                    <h5 class="m-0 font-weight-bold pt-2" style="font-size: 0.9rem; color: #181818;">
                        <?= strtoupper($row->product_name) ?>
                    </h5>
                </div>
                
                <div class="text-center">
                    <p class="jetbrains m-0 mb-1" style="font-size: 0.7rem; color: #818181">
                        <?= strtoupper($row->supplier_code) . '-' . $row->product_code; ?>
                    </p>
                </div>
                
                <div class="px-3">
                    <div class="price-stock-row">
                        <div class="text-left">
                            <h5 class="m-0">Rp <?= number_format($harga_final); ?></h5>
                            <?php if($persen_disc > 0): ?>
                                <small class="text-danger" style="display:block; height:15px; line-height:15px;"><strike>Rp <?= number_format($row->price); ?></strike></small>
                            <?php else: ?>
                                <small style="display:block; height:15px;"></small> <?php endif; ?>
                        </div>
                        <span class="stock-pill"><?= $row->stock; ?></span>
                    </div>
                </div>
            </div>

            <div class="mt-auto px-3 pb-3">
                <div class="input-group inline-group">
                    <div class="input-group-prepend">
                        <button class="btn btn-sm btn-minus">-</button>
                    </div>
                    <input class="form-control form-control-sm quantity text-center" min="1" name="quantity"
                        value="1" id="<?= $row->product_code; ?>" type="number">
                    <div class="input-group-append">
                        <button class="btn btn-sm btn-plus">+</button>
                    </div>
                </div>

                <button class="add_cart btn btn-block add-btn-v2 m-0" 
                    data-product_code="<?= $row->product_code; ?>"
                    data-product_name="<?= $row->product_name; ?>" 
                    data-price="<?= $harga_final; ?>" 
                    <?= $row->stock < 1 ? 'disabled' : ''; ?>>
                    <?= lang('btn_add') ? lang('btn_add') : 'TAMBAH'; ?> 
                </button>
            </div>
            
        </div>
    </div>

    <?php }
} ?>
</div>

<script>
$(document).ready(function() {
    var cartid = $('#cartid').val();
    $.ajax({
        url: "<?= base_url('cart/show_cart?api=' . $this->id_t); ?>",
        method: "POST",
        data: {
            cartid: cartid,
            "<?= $this->security->get_csrf_token_name(); ?>": cv
        },
        success: function(data) {
            $('#detail_cart').html(data);
            if (typeof getAmount === 'function') getAmount();
        }
    });
});

$('.add_cart').click(function() {
    var cartid = $('#cartid').val();
    var product_code = $(this).data("product_code");
    var product_name = $(this).data("product_name");
    var price = $(this).data("price"); 
    var quantity = $('#' + product_code).val() || 1; 
    
    $.ajax({
        url: "<?= base_url('cart/add_to_cart?api=' . $this->id_t); ?>",
        method: "POST",
        dataType: 'json',
        data: {
            cartid: cartid,
            product_code: product_code,
            product_name: product_name,
            price: price,
            quantity: quantity,
            "<?= $this->security->get_csrf_token_name(); ?>": cv 
        },
        success: function(res) {
            if (res.success == true) {
                if (typeof reloadPage === 'function') { reloadPage(); } 
                else if (typeof loadCart === 'function') { loadCart(); } 
                else { if (typeof getAmount === 'function') getAmount(); }
            } else {
                if(typeof swal === 'function') swal("Gagal", res.message, "warning");
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
</script>
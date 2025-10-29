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

/* --- Gaya Baru untuk Tampilan V3 (Quantity Group di atas ADD) --- */
.product-card-v2 {
    /* Meniru tampilan minimalis putih */
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
    height: 100px; /* Tinggi gambar lebih pendek */
    object-fit: contain;
    padding: 10px;
}

.product-info-v2 {
    padding: 8px 10px;
}

.product-info-v2 h5 {
    font-size: 1rem;
    font-weight: 700;
    margin-bottom: 3px;
    line-height: 1.2;
}

.product-info-v2 p {
    font-size: 0.75rem;
    color: #8c8c8c;
    margin-bottom: 5px;
}

.price-stock-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 5px 0 10px 0;
}

.price-stock-row h5 {
    font-size: 1.2rem;
    font-weight: 700;
    color: #212529;
    margin: 0;
}

.stock-pill {
    /* Gaya untuk stok (Angka 8) */
    background-color: #f8f9fa;
    color: #495057;
    font-size: 0.9rem;
    font-weight: 600;
    padding: 5px 10px;
    border-radius: 5px;
}

.add-btn-v2 {
    /* Tombol ADD Biru Besar */
    padding: 10px 0;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 6px;
    background-color: #007bff !important; /* Biru Primer Bootstrap */
    border-color: #007bff;
    color: #fff !important;
}

/* Kuantitas Group Styling */
.input-group.inline-group {
    display: flex !important; /* Pastikan terlihat */
    border: none;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 15px; /* Jarak dari tombol ADD */
}

.input-group.inline-group .btn {
    /* Gaya tombol +/- */
    background-color: #e9ecef; /* Latar belakang abu-abu muda */
    border: none;
    color: #4a6cf7; /* Warna teks biru */
    font-weight: bold;
    border-radius: 8px;
    padding: 8px 15px; /* Padding lebih besar */
}

.input-group.inline-group .form-control {
    /* Gaya input tengah */
    border: none;
    box-shadow: none;
    background-color: #fff;
    font-weight: bold;
    font-size: 1rem;
    text-align: center;
}
/* Menyesuaikan border-radius untuk input group */
.input-group.inline-group .input-group-prepend button {
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
}

.input-group.inline-group .input-group-append button {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
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

    foreach ($qmp as $qmp) {
        $filex = base_url('assets/product/img/'.$qmp->product_code.'.jpg?id='.time());
        if (!file_exists($filex)) {
            $filex = base_url('assets/product/img/'.$qmp->product_code.'.jpg?id='.time());
        }

        $tags = $qmp->category_id;
        if ($tags == 'rokok') {
            $tags = 'indigo';
        } else {
            $tags = 'success';
        }
        
        $default_qty = 1; 
?>

    <div class="col-lg-2 col-md-4 col-xs-6 mb-3">
        <div class="card product-card-v2 h-100 p-0 border-0">
            <div class="row m-0 p-0">

                <div class="col-12 p-2 text-center">
                    <img src="<?= $filex; ?>" class="product-image-v2" alt="Product Image">
                    
                    <h5 class="m-0 font-weight-bold pt-2" style="font-size: 0.9rem; color: #181818;">
                        <?= strtoupper($qmp->product_name) ?>
                    </h5>
                </div>
                
                <div class="col-12 text-center">
                    <p class="jetbrains m-0 mb-1" style="font-size: 0.7rem; color: #818181">
                        <?= strtoupper($qmp->supplier_code) . '-' . $qmp->product_code; ?>
                    </p>
                </div>
                
                <div class="col-12 px-3">
                    <div class="price-stock-row">
                        <h5 class="m-0">
                            <?php echo 'Rp ' . number_format($qmp->price); ?>
                        </h5>
                        
                        <span class="stock-pill">
                            <?= $qmp->stock; ?>
                        </span>
                    </div>
                </div>

                <div class="col-12 px-3">
                    <div class="input-group inline-group">
                        <div class="input-group-prepend">
                            <button class="btn btn-sm btn-minus">
                                -
                            </button>
                        </div>
                        <input class="form-control form-control-sm quantity text-center" min="1" name="quantity"
                            value="1" id="<?= $qmp->product_code; ?>" type="number">
                        <div class="input-group-append">
                            <button class="btn btn-sm btn-plus">
                                +
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-0 px-3 pb-3">
                    <button class="add_cart btn btn-block add-btn-v2" 
                        data-product_code="<?= $qmp->product_code; ?>"
                        data-product_name="<?= $qmp->product_name; ?>" 
                        data-price="<?= $qmp->price; ?>"
                        <?= $qmp->stock < 1 ? 'disabled' : ''; ?>>
                        ADD
                    </button>
                </div>

            </div>
        </div>
    </div>

    <?php }
} ?>
</div>

<script>
$(document).ready(function() {
    var cartid = $('#cartid').val();
    // Memuat cart saat catalog.php dimuat
    $.ajax({
        url: "<?= base_url('cart/show_cart?api=' . $this->id_t); ?>",
        method: "POST",
        data: {
            cartid: cartid,
        },
        success: function(data) {
            $('#detail_cart').html(data);
            if (typeof getAmount === 'function') {
                 getAmount();
            }
        }
    });
});

function add(param) {
    console.log(param)
}

$('.add_cart').click(function() {
    var cartid = $('#cartid').val();
    var product_code = $(this).data("product_code");
    var product_name = $(this).data("product_name");
    var price = $(this).data("price");
    
    // Ambil kuantitas dari input group yang sekarang terlihat
    var quantity = $('#' + product_code).val() || 1; 
    
    console.log('click');
    $.ajax({
        url: "<?= base_url('cart/add_to_cart?api=' . $this->id_t); ?>",
        method: "POST",
        cache: false,
        dataType: 'json',
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

                // PERBAIKAN: Memastikan pemanggilan global untuk refresh total dan detail cart
                if (typeof window.reloadPage === 'function') {
                    window.reloadPage(); 
                } else if (typeof window.loadCart === 'function') {
                    window.loadCart(); 
                } else {
                    // Fallback minimal
                    if (typeof window.getAmount === 'function') window.getAmount(); 
                }
                
                $("#sku-status").text('');
            } else {

                $("#sku-status").text(res.message);
            }
        },
    });
});


// Event handler untuk plus/minus diaktifkan kembali
$('.btn-plus, .btn-minus').on('click', function(e) {
    const isNegative = $(e.target).closest('.btn-minus').is('.btn-minus');
    const input = $(e.target).closest('.input-group').find('input');
    if (input.is('input')) {
        input[0][isNegative ? 'stepDown' : 'stepUp']()
    }
});


// Mendefinisikan getAmount() sebagai fallback, asumsikan ini ada di home.php
function getAmount() {
    var cartid = $('#cartid').val();
    $.ajax({
        url: "<?= base_url('cart/get_amount?api=' . $this->id_t); ?>",
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
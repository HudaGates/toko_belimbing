<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cashier - TOKO BELIMBING</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/adminlte.min.css');?>">
    <link rel="stylesheet" href="<?=site_url('assets/lte/sweetalert/sweetalert.css');?>" />
    <style>
    /* ==========================================
       PERBAIKAN KARTU PRODUK (REVISI SEJAJAR)
       ========================================== */
    
    /* 1. Bikin tinggi semua kotak putih (produk) seragam */
    #product-container > .row > div > div,
    #product-container .card,
    #product-container .bg-white {
        display: flex !important;
        flex-direction: column !important;
        height: 100% !important;
    }

    /* 2. Dorong area QTY (- 1 +) ke paling bawah! 
          Ini kunci biar qty & tombol tambah rata sejajar semua */
    #product-container .card:has(.btn-light),
    #product-container .bg-white:has(.btn-light) {
        /* Opsional: kalau mau nargetin container utama */
    }
    #product-container *:has(> .btn-light),
    #product-container .row:has(.btn-light) {
        margin-top: auto !important; 
        padding-bottom: 5px !important;
    }

    /* 3. Tombol Tambah (Full Width & Ukuran Seragam) */
    #product-container .btn-primary {
        width: 100% !important; 
        height: 38px !important; 
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        font-weight: bold !important;
        border-radius: 6px !important;
        margin-top: 0 !important; /* Hapus auto dari sini */
    }
    
    /* Rapihkan sedikit tombol + dan - */
    #product-container .btn-light {
        height: 30px !important;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    /* ========================================== */
    /* SKALA ZOOM OTOMATIS BOOTSTRAP */
    html {
        /* Ukuran standar adalah 16px. Kita ubah jadi 12px (Setara dengan Zoom 75%) */
        font-size: 12px !important; 
    }

    /* Kunci Gambar Produk agar tidak raksasa */
    #product-container img {
        max-height: 80px !important;
        object-fit: contain;
    }
    /* Styling dasar dari sebelumnya */
    body {
        background-color: #f6f7fb;
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
    }

    /* Header */
    .cashier-header {
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .cashier-header h5 {
        margin: 0;
        font-weight: 600;
        color: #222;
    }

    .cashier-info {
        font-size: 13px;
        color: #666;
    }

/* --- CSS KUSTOM UNTUK MODAL LOGOUT (SweetAlert) --- */

/* Ikon Logout Hijau */
.logout-icon-container {
    background-color: #e5f5e5; /* Latar belakang hijau muda */
    border-radius: 50%;
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.logout-icon-container .fas {
    color: #007bff !important; /* Warna ikon hijau */
    font-size: 28px;
    /* Ikon panah keluar (fa-sign-out-alt) */
}

/* Modifikasi kotak modal SweetAlert */
.sweet-alert {
    border-radius: 15px !important;
    padding: 30px 20px 20px !important;
    text-align: center;
}

/* Judul dan Teks */
.sweet-alert h2 {
    font-weight: 600 !important;
    color: #333 !important;
    font-size: 1.5rem !important; /* Ukuran font untuk "Logout" */
    margin-top: 5px !important; /* Jarak antara ikon dan teks "Logout" */
}

.sweet-alert p {
    color: #6c757d !important;
    font-size: 1rem !important;
    margin-bottom: 25px !important;
}

/* Mengubah tampilan tombol */
.sweet-alert .sa-button-container {
    display: flex;
    flex-direction: column-reverse; /* Membalik urutan agar Yes di atas Cancel */
    width: 100%;
    gap: 10px;
}

.sweet-alert .btn-custom-logout-yes {
    background-color: #007bff !important; /* Biru */
    color: white !important;
    border-radius: 8px !important;
    border: none !important;
    padding: 12px 20px !important;
    font-weight: bold !important;
    box-shadow: none !important;
    order: 1; /* Menempatkan "Yes, Logout" di atas secara visual */
}

.sweet-alert .btn-custom-logout-cancel {
    background-color: transparent !important; /* Transparan/putih */
    color: #6c757d !important; /* Teks abu-abu */
    border-radius: 8px !important;
    border: none !important;
    padding: 12px 20px !important;
    font-weight: bold !important;
    box-shadow: none !important;
    order: 2; /* Menempatkan "Cancel" di bawah secara visual */
}

/* Hapus ikon default (warning/gagal) SweetAlert agar hanya ikon kustom yang muncul */
.sweet-alert .sa-icon.sa-warning {
    display: none !important;
}
.sweet-alert .sa-icon.sa-warning::before,
.sweet-alert .sa-icon.sa-warning::after {
    display: none !important;
}

    /* Cart Panel */
    .cart-panel {
        background: #fff;
        border-radius: 12px;
        padding: 10px;
        height: 100%;
        display: flex;
        flex-direction: column;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .cart-header {
        background: #f2f2f2;
        font-weight: 600;
        font-size: 12px;
        border-radius: 8px;
    }

    #detail_cart {
        flex: 1;
        overflow-y: auto;
        border: 1px solid #eee;
        border-radius: 8px;
        background-color: #fafafa;
        padding: 6px;
        margin-top: 6px;
    }

    /* Custom Total Amount Styling */
    .amount-display-box {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 8px 0;
        margin-bottom: 10px;
        font-size: 1.1rem;
        font-weight: bold;
        color: #212529;
    }
    
    .amount-display-box .total-label {
        font-size: 1.2rem;
        color: #6c757d;
    }
    
    .amount-display-box .amount-value {
        font-size: 1.4rem;
        color: #212529;
    }
    
    /* Tombol BAYAR (Custom style untuk meniru screenshot 2) */
    .btn-pay-custom {
        background-color: #007bff !important; /* Warna biru solid */
        border: none;
        border-radius: 0 !important;
        font-size: 1.5rem;
        padding: 15px 0;
        font-weight: 700;
    }

    /* Tombol Customer/History Container */
    .customer-history-box {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        padding: 10px;
        margin-top: 10px;
    }

    .btn-customer-custom {
        border-radius: 8px !important;
        font-size: 1rem;
        font-weight: 600;
        padding: 10px 15px;
        background-color: #4a82ff !important; /* Biru Primer */
        color: white !important;
        border: 1px solid #4a82ff !important;
    }

    .btn-history-custom {
        border-radius: 8px !important;
        font-size: 1rem;
        font-weight: 600;
        padding: 10px 15px;
        background-color: #f2f2f2 !important; /* Abu-abu terang */
        color: #495057 !important;
        border: 1px solid #f2f2f2 !important;
    }

    /* Styling Lainnya dari kode Anda */
    #product-container {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        padding: 12px;
        overflow-y: auto;
        height: 90%;
    }

    #tag-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-top: 5px;
    }
    
    .product-header-box {
        background: #ffffff;
        border-radius: 14px;
        padding: 14px 18px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .modern-input {
        border-radius: 8px !important;
        border: 1px solid #d8dbe2;
        transition: all 0.2s;
    }
    
    .modern-input:focus {
        border-color: #4a6cf7;
        box-shadow: 0 0 0 3px rgba(74, 108, 247, 0.2);
    }
    
    .footer-marquee {
        flex: 1;
        text-align: center;
        font-weight: 500;
        letter-spacing: 0.5px;
        padding: 10px 16px; 
    }
    </style>
    <script>
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    var serverTime = new Date(<?=date('Y, m, d, H, i, s, 0');?>);
    var clientTime = new Date();
    var Diff = serverTime.getTime() - clientTime.getTime();

    function displayServerTime() {
        var time = new Date(new Date().getTime() + Diff);
        var h = String(time.getHours()).padStart(2, '0');
        var m = String(time.getMinutes()).padStart(2, '0');
        var s = String(time.getSeconds()).padStart(2, '0');
        document.getElementById("clock").innerHTML = h + ":" + m + ":" + s;
    }
    </script>
</head>

<body onLoad="setInterval('displayServerTime()',1000);">
    <div class="container-fluid vh-100 d-flex flex-column">
        <div class="cashier-header">
            <div class="d-flex align-items-center">
                <img src="<?=base_url('assets/img/png-clipart-sale.png');?>"
                    style="width:50px;height:35px;margin-right:10px;">
                <div>
                    <h5>TOKO BELIMBING</h5>
                    <div class="cashier-info"><?=$qt->address?></div>
                </div>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                
                <div class="btn-group btn-group-sm mr-2 shadow-sm">
                    <a href="<?=base_url('language/switch_lang/indonesian')?>" class="btn <?= ($this->session->userdata('site_lang') == 'indonesian' || !$this->session->userdata('site_lang')) ? 'btn-primary font-weight-bold' : 'btn-light text-secondary' ?>" style="border-radius: 6px 0 0 6px;">ID</a>
                    <a href="<?=base_url('language/switch_lang/english')?>" class="btn <?= ($this->session->userdata('site_lang') == 'english') ? 'btn-primary font-weight-bold' : 'btn-light text-secondary' ?>" style="border-radius: 0 6px 6px 0;">EN</a>
                </div>
                <div>
                    <div><strong>Cashier 1:</strong> <?=$nama?></div>
                    <div><?=date('l, d-m-Y');?> | <span id="clock"></span></div>
                </div>
                <div class="logout-btn" onclick="logout()" style="cursor: pointer;">
                    <img src="<?=base_url('assets/img/logout.png');?>" style="width:40px;height:35px;">
                </div>
            </div>
        </div>

        <div class="row flex-grow-1 mt-2">
            <div class="col-md-4 d-flex flex-column">
                <div class="cart-panel">
                    <input id="cartid" type="hidden" value="<?=isset($qhc->id) ? $qhc->id : ''?>">

        <table class="table table-sm cart-table mb-2">
    <thead class="cart-header">
        <tr>
            <th style="width: 50%;"><?= lang('lbl_cart_id'); ?></th>
            <th style="width: 50%;"><?= lang('btn_clear'); ?></th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="bg-warning fw-bold text-center"><?=isset($qhc->id) ? $qhc->id : '-'?></td>
            <td onclick="<?=isset($qhc->status) && $qhc->status == 'done' ? '' : 'clearCart()'?>"
                class="bg-danger text-white text-center fw-bold" style="cursor:pointer;">
                <?=isset($qhc->status) && $qhc->status == 'done' ? lang('btn_done') : lang('btn_clear'); ?>
            </td>
        </tr>
    </tbody>
</table>

                    <div class="mb-2">
                        <label class="small fw-bold"><?= lang('lbl_customer'); ?></label>
                        <input id="customer_name" name="customer_name" class="form-control form-control-sm"
                            value="<?=isset($qhc->customer_name) ? $qhc->customer_name : ''?>">
                    </div>

                    <div id="detail_cart" class="flex-grow-1"></div>

                    <div class="mt-3">
                        <div class="amount-display-box">
                            <span class="total-label"><?= lang('lbl_total'); ?></span>
                            <div class="amount-value">
                                <span id="amount-display">Rp 0,00</span>
                                <input id="amount" type="hidden" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button onclick="closeOpenCart()" type="button"
                            class="btn btn-danger btn-modern w-50 <?=isset($qhc->status) && $qhc->status == 'done' ? '' : 'd-none'?>">Close</button>
                        
                        <button onclick="pay()" class="btn btn-primary w-100 btn-pay-custom"
                            <?=isset($qhc->status) && $qhc->status == 'done' ? 'disabled' : ''?>><?= lang('btn_pay'); ?></button>
                    </div>

                    <div class="customer-history-box mt-3">
                        <div class="d-flex gap-2">
                            <button class="btn w-50 btn-customer-custom" onclick="formcustomer()"><?= lang('btn_data_customer'); ?></button>
                            <button onclick="historysale()" class="btn w-50 btn-history-custom"><?= lang('btn_history'); ?></button>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-8 d-flex flex-column">
                <div class="product-header-box mb-2">
                    
                    <div class="row g-2 align-items-end">
                        
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-secondary mb-1">SKU</label>
                            <input id="input_sku" type="text" class="form-control form-control-sm modern-input" 
                                placeholder="<?= lang('placeholder_sku'); ?>" autofocus 
                                style="border: 1px solid #007bff; box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.2);"> 
                        </div>
                        
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small text-secondary mb-1"><?= lang('lbl_search'); ?></label>
                            <input id="search" oninput="search()" type="text" 
                                class="form-control form-control-sm modern-input" placeholder="<?= lang('placeholder_search'); ?>">
                        </div>

                        <div class="col-md-2 d-flex align-items-end justify-content-end">
    <button onclick="search('')" class="btn btn-outline-primary btn-sm shadow-sm" 
        style="border-radius: 8px; font-weight: 600; padding: 5px 12px; display: flex; align-items: center; gap: 5px;">
        <i class="fas fa-sync-alt"></i> <?= lang('btn_reload'); ?>
    </button>
</div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <div class="mb-2"> 
                            <span class="fw-semibold text-secondary">TAG</span>
                        </div>
                        
                        <div class="d-flex align-items-center flex-wrap">
                            <div id="tag-container" class="d-flex flex-wrap gap-2 w-100">
                                </div>
                        </div>
                    </div>
                </div>

                <div id="product-container" class="product-list-box flex-grow-1 text-center">
                    Loading ...
                </div>
            </div>
        </div>
        <div class="footer-bar mt-2">
            <div class="footer-marquee">
                <marquee>WELCOME BELIMBING STORE</marquee>
            </div>
        </div>

        <div class="modal fade" id="modalxl">
            <div class="modal-dialog modal-md">
                <div class="modal-content ">
                    <div id="modalcontent" class="modal-body">
                        TES
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="modallg">
            <div class="modal-dialog modal-xl">
                <div class="modal-content ">
                    <div id="modalcontentlg" class="modal-body">
                        TES
                    </div>
                </div>
            </div>
        </div>

    </div> 
    
    <script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery-ui.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables/jquery.dataTables.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables/dataTables.jqueryui.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/papaparse/papaparse.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-editor/js/dataTables.editor.min.js?id='.time());?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-editor/js/editor.bootstrap4.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-select/js/dataTables.select.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-buttons/js/dataTables.buttons.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/jszip/jszip.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/pdfmake/pdfmake.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/pdfmake/vfs_fonts.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-buttons/js/buttons.html5.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-buttons/js/buttons.print.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/moment/moment.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-responsive/js/dataTables.responsive.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/SearchBuilder-1.3.0/js/dataTables.searchBuilder.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/DateTime/js/dataTables.dateTime.min.js');?>"></script>
    <script src="<?=site_url('assets/lte/sweetalert/sweetalert.js')?>"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="text/javascript">
    cv = '<?=$this->security->get_csrf_hash(); ?>';

    var cartid = $('#cartid').val();
    $(document).ready(function() {
        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
        $("#loading").fadeOut("slow");

        // Memuat data awal: tag, produk, dan cart (Perbaikan Fungsi ADD)
        tag();
        search('');
        
        // PENTING: Hanya load cart jika cartid tersedia
        if(cartid && cartid !== '') {
            loadCart();
        }
    });

    $(function() {
        var availableTags = [
            <?php foreach ($qtc as $key) { ?> '<?=$key->customer_name?>',
            <?php }?>
        ];
        $("#customer_name").autocomplete({
            source: availableTags
        });
    });


    $("#input_sku").on('keyup', function(e) {
    if (e.key === 'Enter' || e.keyCode === 13) {
        
        // Validasi: Jika tidak ada ID keranjang, jangan teruskan proses tambah
        if(!cartid || cartid === '') {
            swal("Peringatan", "Data Keranjang Tidak Ditemukan! Silakan Logout lalu Login kembali.", "warning");
            return;
        }

        let sku = $("#input_sku").val().trim();
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/additem?api='.$this->id_t); ?>",
            data: "cartid=" + cartid + "&sku=" + sku +
                "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    console.log(res.success)
                    $("#modalxl").modal('hide');

                    reloadPage();

                    $("#sku-status").text('');
                    $("#input_sku").val(''); // Otomatis kosongkan input kalau sukses
                } else {
                    // Update teks kecilnya (opsional)
                    $("#sku-status").text(res.message);
                    
                    // ==========================================
                    // INI SAKLAR NOTIFIKASINYA BANG!
                    // ==========================================
                    swal(
                        "Gagal Ditambahkan!", 
                        res.message, // Ini akan otomatis nampilin pesan dari server (misal: "STOCK HABIS")
                        "warning"
                    );

                    // Otomatis kosongkan kolom SKU biar kasir ngga perlu hapus manual
                    $("#input_sku").val('');
                }
            },
            error: function(error) {
                $('#product-container').html(error);
            }
        });
    }
});

    $(window).resize(function() {
        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
    })

    function back() {
        swal({
                title: "Are you sure?",
                text: "Home Page",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Yes',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
            function() {
                window.location.href = "<?=base_url('sto/back?api='.$this->id_t); ?>";
            });

    }

   function logout() {
        // Menggunakan SweetAlert dengan konfigurasi yang meniru tampilan modern & Multi-bahasa
        swal({
            // Tetap pertahankan icon HTML-nya, tapi teksnya pakai bahasa dinamis
            title: "<div class='logout-icon-container'><i class='fas fa-sign-out-alt'></i></div><?= lang('swal_logout_title'); ?>", 
            text: "<?= lang('swal_logout_text'); ?>",
            type: "warning", 
            showCancelButton: true,
            confirmButtonText: "<?= lang('swal_logout_confirm'); ?>",
            cancelButtonText: "<?= lang('swal_logout_cancel'); ?>",
            confirmButtonClass: "btn-custom-logout-yes", 
            cancelButtonClass: "btn-custom-logout-cancel", 
            closeOnConfirm: false,
            html: true, 
        },
        function(isConfirm) {
            if (isConfirm) {
                window.location.href = "<?=base_url('action/logout?api='.$this->id_t); ?>";
            }
        });
    }

    function pilih(cat, device) {
        swal({
                title: "Are you sure?",
                text: "STO " + cat.toUpperCase(),
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-success',
                confirmButtonText: 'Yes',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
            function() {
                if (device == 'mobile') {
                    window.location.href = "<?= base_url('posting/start?pos='); ?>" + cat +
                        "<?= '&api=' . $this->id_t; ?>";
                } else {
                    window.location.href = "<?= base_url('postingpc/start?pos='); ?>" + cat +
                        "<?= '&api=' . $this->id_t; ?>";
                }


            });
    }

    function search() {
        // event.preventDefault()
        let product = document.getElementById('search').value
        $('#product-container').text('Loading...');
        console.log('tes')
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/search?api='.$this->id_t); ?>",
            data: "product=" + product + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'html',
            success: function(res) {
                if (res) {
                    $('#product-container').html(res);
                }
            },
            error: function(error) {
                $('#product-container').html(error);
            }
        });
    }

    // FUNGSI-FUNGSI PENTING UNTUK MEMPERBARUI KERANJANG
    function getAmount() {
        var cartid = $('#cartid').val();
        if(!cartid || cartid === '') return; // Mencegah error AJAX jika null

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

    function loadCart() {
        var cartid = $('#cartid').val();
        if(!cartid || cartid === '') return; // Mencegah error AJAX jika null

        $.ajax({
            url: "<?= base_url('cart/show_cart?api=' . $this->id_t); ?>",
            method: "POST",
            data: {
                cartid: cartid,
            },
            success: function(data) {
                $('#detail_cart').html(data);
                getAmount()
            }
        });
    }

    function reloadPage() {
        loadCart();
        // Bersihkan SKU setelah item ditambahkan
        $("#input_sku").val('').focus();
    }
    // AKHIR FUNGSI-FUNGSI PENTING


    function editDetail(id) {

        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/formeditdetail?api='.$this->id_t); ?>",
            data: "id=" + id + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'html',
            success: function(res) {
                if (res) {
                    $("#modalxl").modal('show');

                    $('#modalcontent').html(res);
                }
            },
            error: function(error) {
                $("#modalxl").modal('show');
            }
        });
    }

    function pay() {
        var customer_name = $('#customer_name').val();
        var cartid = $('#cartid').val();
        
        if(!cartid || cartid === '') {
            swal("Peringatan", "Keranjang tidak valid!", "warning");
            return;
        }

        var amount = $('#amount').val();
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/formpay?api='.$this->id_t); ?>",
            data: "cartid=" + cartid + "&amount=" + amount + "&customer_name=" + customer_name +
                "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'html',
            success: function(res) {
                if (res) {
                    $("#modalxl").modal('show');

                    $('#modalcontent').html(res);
                }
            },
            error: function(error) {
                $("#modalxl").modal('show');
            }
        });
    }

function clearCart() {
        var cartid = $('#cartid').val();
        if(!cartid || cartid === '') return;

        swal({
            title: "<?= lang('swal_clear_title'); ?>", // <-- Pastikan pakai ini
            text: "<?= lang('swal_clear_text'); ?>",   // <-- Pastikan pakai ini
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: "<?= lang('swal_clear_confirm'); ?>", // <-- Pastikan pakai ini
            cancelButtonText: "<?= lang('swal_clear_cancel'); ?>",   // <-- Pastikan pakai ini
            closeOnConfirm: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    type: "POST",
                    url: "<?=base_url('cashier/clearcart?api='.$this->id_t); ?>",
                    data: "cartid=" + cartid + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                    cache: false,
                    dataType: 'json',
                    success: function(res) {
                        if (res.success == true) {
                            swal("<?= lang('swal_clear_success_title'); ?>", "<?= lang('swal_clear_success_text'); ?>", "success");
                            setTimeout(function() {
                                location.reload();
                            }, 1000); 
                        } else {
                            swal("<?= lang('swal_clear_failed_title'); ?>", res.message || "<?= lang('swal_clear_failed_text'); ?>", "error");
                        }
                    },
                    error: function(error) {
                        swal("<?= lang('swal_error_title'); ?>", "<?= lang('swal_error_text'); ?>", "error");
                    }
                });
            }
        });
    }

    function tagsearch(tag) {
        // event.preventDefault()

        $('#product-container').text('Loading...');
        console.log('tes')
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/tagsearch?api='.$this->id_t); ?>",
            data: "tag=" + tag + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'html',
            success: function(res) {
                if (res) {
                    $('#product-container').html(res);
                }
            },
            error: function(error) {
                $('#product-container').html(error);
            }
        });
    }

    function tag() {
        // event.preventDefault()
        $('#tag-container').text('Loading...');
        console.log('tes')
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/tag?api='.$this->id_t); ?>",
            data: "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'html',
            success: function(res) {
                if (res) {
                    // Jika tag dimuat melalui AJAX, Anda mungkin perlu memastikan styling diterapkan di sini
                    $('#tag-container').html(res);
                } else {
                    // PERBAIKAN: Jika tidak dimuat via AJAX, gunakan hardcoded tags yang sudah di-style biru
                    $('#tag-container').html(`
                        <span class="tag-chip btn btn-sm" onclick="filterTag('ALAT MANDI')" style="background-color: #007bff; color: white; border-radius: 8px;">ALAT MANDI</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('MINUMAN')" style="background-color: #007bff; color: white; border-radius: 8px;">MINUMAN</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('PEMBALUT')" style="background-color: #007bff; color: white; border-radius: 8px;">PEMBALUT</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('PET FOOD')" style="background-color: #007bff; color: white; border-radius: 8px;">PET FOOD</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('ROKOK')" style="background-color: #007bff; color: white; border-radius: 8px;">ROKOK</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('SABUN')" style="background-color: #007bff; color: white; border-radius: 8px;">SABUN</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('SEMBAKO')" style="background-color: #007bff; color: white; border-radius: 8px;">SEMBAKO</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('SPAREPART')" style="background-color: #007bff; color: white; border-radius: 8px;">SPAREPART</span>
                    `);
                }
            },
            error: function(error) {
                 // PERBAIKAN: Fallback to hardcoded tags if AJAX fails, menggunakan style biru
                 $('#tag-container').html(`
                        <span class="tag-chip btn btn-sm" onclick="filterTag('ALAT MANDI')" style="background-color: #007bff; color: white; border-radius: 8px;">ALAT MANDI</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('MINUMAN')" style="background-color: #007bff; color: white; border-radius: 8px;">MINUMAN</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('PEMBALUT')" style="background-color: #007bff; color: white; border-radius: 8px;">PEMBALUT</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('PET FOOD')" style="background-color: #007bff; color: white; border-radius: 8px;">PET FOOD</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('ROKOK')" style="background-color: #007bff; color: white; border-radius: 8px;">ROKOK</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('SABUN')" style="background-color: #007bff; color: white; border-radius: 8px;">SABUN</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('SEMBAKO')" style="background-color: #007bff; color: white; border-radius: 8px;">SEMBAKO</span>
                        <span class="tag-chip btn btn-sm" onclick="filterTag('SPAREPART')" style="background-color: #007bff; color: white; border-radius: 8px;">SPAREPART</span>
                    `);
            }
        });
    }

    function printReceipt() {
        var cartid = $('#cartid').val();
        window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");
    }

    function historysale() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('cashier/historysale?api='.$this->id_t); ?>",
            cache: false,
            dataType: 'html',
            contentType: 'html',
            success: function(res) {
                $('#modalcontentlg').html(res);
                $("#modallg").modal('show');
            },
            error: function(error) {
                $("#modallg").modal('show');
            }
        });
    }

    function historysaleist() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('cashier/historysaleist?api='.$this->id_t); ?>",
            cache: false,
            dataType: 'html',
            contentType: 'html',
            success: function(res) {
                $('#modalcontentlg').html(res);
                $("#modallg").modal('show');
            },
            error: function(error) {
                $("#modallg").modal('show');
            }
        });
    }

    function skipcart() {
        var cartid = $('#cartid').val();
        if(!cartid || cartid === '') return;

        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/skipcart?api='.$this->id_t); ?>",
            data: "cartid=" + cartid + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    window.location.href = "<?=base_url('cashier?api='.$this->id_t); ?>";
                    getAmount()
                } else {
                    $("#sku-status").text(res.message);
                }
            },
            error: function(error) {
                $("#modalxl").modal('show');
            }
        });
    }

    function formcustomer() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('cashier/formcustomer?api='.$this->id_t); ?>",
            cache: false,
            dataType: 'html',
            contentType: 'html',
            success: function(res) {
                $('#modalcontentlg').html(res);
                $("#modallg").modal('show');
            },
            error: function(error) {
                $("#modallg").modal('show');
            }
        });
    }

    function truncate() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('cashier/truncate?api='.$this->id_t); ?>",
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    window.location.href = "<?=base_url('cashier?api='.$this->id_t); ?>";
                } else {
                    $("#sku-status").text(res.message);
                }
            },
            error: function(error) {
                $("#modalxl").modal('show');
            }
        });
    }

    function closeOpenCart() {
        window.location.href = "<?=base_url('cashier?api='.$this->id_t); ?>";
    }
    </script>

</body>

</html>
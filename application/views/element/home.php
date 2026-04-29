<section class="content-header" style="padding: 15px 15px 0 15px;">
    <div class="container-fluid">
        <div class="card shadow-sm border-0" style="border-radius: 12px;">
            <div class="card-body p-3">
                <div class="row align-items-center">
                    <div class="col-sm-8">
                        <div class="d-flex align-items-center">
                            <div id="icon-day" style="font-size: 2rem; margin-right: 15px;">
                                </div>
                            <div>
                                <h3 id="greeting" class="text-muted mb-1" style="font-size: 1rem; font-weight: 600;"></h3>
                                <h4 class="m-0 text-dark font-weight-bold" style="font-size: 1.3rem;">
                                    <?=$cu->nama;?>
                                </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 text-right">
                        <p class="mb-1 text-muted" style="font-size: 0.9rem; font-weight: 500;">
                            <?=gmdate('l, d F Y',time()+60*60*7);?>
                        </p>
                        <h4 id="clock" class="m-0 text-primary font-weight-bold" style="font-size: 1.4rem;">
                            <?=date('H:i:s');?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if($cu->user_group=='Admin'){ ?>
<section class="content" style="padding: 15px;">
    <div class="container-fluid">
        <div class="card shadow-sm border-0" style="border-radius: 15px; background: #ffffff;">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-3 px-4">
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <h4 class="card-title font-weight-bold text-dark mb-0">
                            <i class="fas fa-chart-pie mr-2 text-primary"></i> Dashboard Penjualan
                        </h4>
                    </div>
                    
                    <div class="col-md-8 d-flex justify-content-end align-items-center" style="gap: 12px;">
                        
                        <div class="input-group input-group-sm shadow-sm" style="width: 180px; border-radius: 6px;">
                            <!-- ZettBOT: Mengubah placeholder agar relevan dengan pencarian kasir/customer -->
                            <input type="text" id="search_keyword" class="form-control border-right-0" placeholder="Cari Kasir/Customer..." onkeyup="delayLoadDashboard()">
                            <div class="input-group-append">
                                <span class="input-group-text bg-white text-muted border-left-0"><i class="fas fa-search"></i></span>
                            </div>
                        </div>

                        <div class="d-flex align-items-center bg-white border shadow-sm p-1" style="border-radius: 6px;">
                            <input type="date" id="start_date" class="form-control form-control-sm border-0 text-muted" style="box-shadow: none; width: 130px; cursor: pointer;" onchange="setCustomDropdown()">
                            <span class="text-muted mx-1 font-weight-bold">-</span>
                            <input type="date" id="end_date" class="form-control form-control-sm border-0 text-muted" style="box-shadow: none; width: 130px; cursor: pointer;" onchange="setCustomDropdown()">
                            
                            <button class="btn btn-sm btn-primary ml-1 px-3 font-weight-bold" onclick="loadDashboard()" style="border-radius: 4px;">
                                <i class="fas fa-search mr-1"></i> Cari
                            </button>
                        </div>

                        <select id="filter_periode" class="form-control form-control-sm font-weight-bold shadow-sm" onchange="resetDates()" style="border-radius: 6px; border: 1px solid #007bff; color: #007bff; width: auto; cursor: pointer;">
                            <option value="hari_ini">Hari Ini</option>
                            <option value="minggu_ini">Minggu Ini</option>
                            <option value="bulan_ini" selected>Bulan Ini</option>
                            <option value="tahun_ini">Tahun Ini</option>
                            <option value="custom">📅 Custom</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="card-body px-4 pb-4">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card bg-info text-white shadow-sm" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="mb-1"><i class="fas fa-calendar-day mr-1"></i> Omset Hari Ini</h6>
                                <h3 id="omset_harian" class="font-weight-bold mb-0">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white shadow-sm" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="mb-1"><i class="fas fa-calendar-week mr-1"></i> Omset Minggu Ini</h6>
                                <h3 id="omset_mingguan" class="font-weight-bold mb-0">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark shadow-sm" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="mb-1"><i class="fas fa-calendar-alt mr-1"></i> Omset Bulan Ini</h6>
                                <h3 id="omset_bulanan" class="font-weight-bold mb-0">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-danger text-white shadow-sm" style="border-radius: 10px;">
                            <div class="card-body p-3">
                                <h6 class="mb-1"><i class="fas fa-calendar mr-1"></i> Omset Tahun Ini</h6>
                                <h3 id="omset_tahunan" class="font-weight-bold mb-0">Rp 0</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" style="max-height: 45vh; overflow-y: auto; border: 1px solid #dee2e6; border-radius: 6px;">
                    <table class="table table-hover table-bordered table-sm mb-0" style="font-size: 14px;">
                        <thead class="bg-light" style="position: sticky; top: 0; z-index: 2; box-shadow: 0 2px 2px -1px rgba(0,0,0,0.1);">
                            <tr>
                                <!-- ZettBOT: Penyesuaian Kolom Tabel menjadi 5 Kolom Sesuai Request -->
                                <th width="5%" class="text-center" style="background-color: #f8f9fa;">No</th>
                                <th width="20%" style="background-color: #f8f9fa;">Tanggal Trx</th>
                                <th width="25%" style="background-color: #f8f9fa;">Nama Kasir</th>
                                <th width="25%" style="background-color: #f8f9fa;">Nama Customer</th>
                                <th width="25%" class="text-right" style="background-color: #f8f9fa;">Total Transaksi</th>
                            </tr>
                        </thead>
                        <tbody id="tabel_laporan">
                            <tr><td colspan="5" class="text-center">Memuat data...</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
let typingTimer; // Wajib ada untuk jeda ngetik

// Kalau kalender diisi, otomatis pindah ke mode Custom
function setCustomDropdown() {
    $('#filter_periode').val('custom');
}

// Kalau dropdown dipilih selain Custom, kosongkan kalender
function resetDates() {
    let periode = $('#filter_periode').val();
    if(periode !== 'custom') {
        $('#start_date').val('');
        $('#end_date').val('');
        loadDashboard();
    }
}

// Jeda 0.5 detik saat ngetik biar server gak ngos-ngosan
function delayLoadDashboard() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(loadDashboard, 500);
}

// Fungsi utama penarik data
function loadDashboard() {
    let periode = $('#filter_periode').val();
    let start_date = $('#start_date').val();
    let end_date = $('#end_date').val();
    let keyword = $('#search_keyword').val(); // Menangkap ketikan pencarian

    // Cegah eksekusi kalau mode custom tapi tanggal kosong
    if(periode === 'custom' && (!start_date || !end_date)) {
        return; 
    }

    $('#tabel_laporan').html('<tr><td colspan="5" class="text-center py-5 text-muted"><i class="fas fa-circle-notch fa-spin fa-2x mb-2 text-primary"></i><br>Sedang menyinkronkan data...</td></tr>');
    
    $.ajax({
        url: "<?=base_url('home/get_dashboard_data?api='.$this->id_t);?>",
        type: "POST",
        data: { 
            periode: periode,
            start_date: start_date,
            end_date: end_date,
            keyword: keyword // Kirim kata kunci ke Controller
        },
        dataType: "json",
        success: function(res) {
            $('#omset_harian').text(res.harian);
            $('#omset_mingguan').text(res.mingguan);
            $('#omset_bulanan').text(res.bulanan);
            $('#omset_tahunan').text(res.tahunan);

            $('#tabel_laporan').html(res.html_tabel).hide().fadeIn('fast');
        },
        error: function() {
            $('#tabel_laporan').html('<tr><td colspan="5" class="text-center py-4 text-danger"><i class="fas fa-exclamation-triangle fa-2x mb-2"></i><br>Gagal mengambil data dari server.</td></tr>');
        }
    });
}

$(document).ready(function(){
    loadDashboard();
});
</script>

<?php }else{ ?>
<section class="content" style="padding: 15px;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0" style="border-radius: 15px;">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-2 px-4">
                        <h4 class="card-title font-weight-bold text-dark"><i class="fas fa-th-large mr-2 text-primary"></i> Menu Utama</h4>
                    </div>
                    <div class="card-body text-center pt-3 pb-5">
                        <?php foreach ($menu_child as $key) { ?>
                        <a class="btn btn-app bg-light text-dark shadow-sm m-2 border-0"
                            onclick="menuUser('<?=base_url($key->url); ?>','<?=$key->nav;?>');" 
                            style="width: 110px; height: 100px; border-radius: 12px; transition: all 0.3s;">
                            <i class="fas <?=$key->icon;?> text-<?=$thema;?>" style="font-size: 2rem; margin-bottom: 8px;"></i>
                            <p style="font-size: 0.85rem; font-weight: 600; white-space: normal; line-height: 1.2;"><?=strtoupper($key->nav);?></p>
                        </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php } ?>

<style>
    .btn-app:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0,0,0,0.1) !important;
        background-color: #ffffff !important;
    }
</style>
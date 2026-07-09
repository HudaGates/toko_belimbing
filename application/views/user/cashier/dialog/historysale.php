<div class="row ">
    <div class="col-9 text-left">
        <h4 class="font-weight-bold">History Sale</h4>
    </div>
    <div class="col-3 text-right">
        <button type="button" class="btn btn-danger btn-sm" onclick=" $('#modallg').modal('hide');">X</button>
    </div>
</div>
<div class="row">
    <div class="col-4 border" style="height: 50vh; overflow-y:scroll;">
        <small class="text-left font-weight-bold">Draft</small>
        <div class="list-group text-left pt-2">
            <?php
            $i = 1;
            foreach ($qhsd as $key) { ?>
            <a onclick="historysaledetail('<?=$key->id ?>')" id="list-history-sale-<?=$key->id ?>"
                class="list-group-item list-group-item-action list-history-sale">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?=$key->id ?> - <?=$key->customer_name ?></h5>
                    <small><?=$key->status ?></small>
                </div>
                <p class="mb-1"><?='Rp ' . number_format($key->total_amount) ?></p>
                <small><?=$key->update_time ?></small>
            </a>
            <?php }?>
        </div>
        <hr>
        <small class="text-left font-weight-bold">Done</small>
        <div class="list-group text-left">
            <?php
            $i = 1;
            foreach ($qhs as $key) { ?>
            <a onclick="historysaledetail('<?=$key->id ?>')" id="list-history-sale-<?=$key->id ?>"
                class="list-group-item list-group-item-action list-history-sale">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?=$key->id ?> - <?=$key->customer_name ?></h5>
                    <small><?=$key->status ?></small>
                </div>
                <p class="mb-1"><?='Rp ' . number_format($key->total_amount) ?></p>
                <small><?=$key->update_time ?></small>
            </a>
            <?php }?>
        </div>
    </div>
    
    <div class="col-8 d-flex flex-column" style="height: 50vh;">
        <div class="mb-2 text-left">
            <button type="button" class="btn btn-success btn-sm font-weight-bold" onclick="loadOmzetBulanan()">
                <i class="fa fa-bar-chart"></i> Omzet Bulanan
            </button>
        </div>
        
        <div class="flex-grow-1" style="overflow-y:auto; relative: position;">
            
            <div id="wrapper-tabel-omzet" class="card shadow-sm mb-2" style="display: none;">
                <div class="card-header bg-dark text-white p-2 d-flex justify-content-between align-items-center">
                    <h6 class="mb-0"><i class="fa fa-bar-chart"></i> Ringkasan Omzet Bulanan</h6>
                    <div>
                        <a href="<?= base_url('report/export_excel_omzet'); ?>" class="btn btn-sm btn-success py-0 mr-1" style="font-size: 11px;">
                            <i class="fa fa-file-excel-o"></i> Unduh Excel
                        </a>
                        <button class="btn btn-sm btn-light py-0" onclick="resetAreaKanan()" style="font-size: 11px;">Tutup</button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm table-bordered mb-0" style="font-size: 13px;">
                        <thead class="bg-secondary text-white text-center">
                            <tr>
                                <th>Periode Bulan</th>
                                <th>Total Transaksi</th>
                                <th>Total Omzet</th>
                            </tr>
                        </thead>
                        <tbody id="data_omzet_bulanan">
                            <tr>
                                <td colspan="3" class="text-center text-muted py-3">Memuat data omzet...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="container-modal-right">
                <div class="text-center pt-5 text-muted" id="placeholder-text">
                    <p>Pilih riwayat transaksi di sebelah kiri untuk melihat detail,<br>atau klik tombol <strong>Omzet Bulanan</strong> di atas.</p>
                </div>
            </div>

        </div>
    </div>
</div>
<div class="row pt-2">
    <div class="col">
        <button type="button" class="btn btn-outline-danger btn-sm"
            onclick=" $('#modallg').modal('hide');">BATAL</button>
    </div>
</div>

<script>
function loadOmzetBulanan() {
    $('#container-modal-right').hide();
    $('.list-history-sale').removeClass('active');
    
    $('#wrapper-tabel-omzet').show();
    $('#data_omzet_bulanan').html('<tr><td colspan="3" class="text-center text-muted py-3">Memuat data omzet...</td></tr>');

    $.ajax({
        url: "<?= base_url('report/get_omzet_ajax'); ?>",
        type: "POST",
        data: {
            "<?= $this->security->get_csrf_token_name(); ?>": cv
        },
        dataType: "JSON",
        success: function(data) {
            var html = '';
            var grand_total = 0;
            
            if(data.length > 0) {
                for(var i = 0; i < data.length; i++) {
                    grand_total += parseInt(data[i].omzet);
                    
                    html += '<tr>' +
                                '<td class="pl-3"><strong>' + data[i].bulan_tahun + '</strong></td>' +
                                '<td class="text-center">' + data[i].total_transaksi + ' Transaksi</td>' +
                                '<td class="text-right pr-3 text-success font-weight-bold">Rp ' + parseFloat(data[i].omzet).toLocaleString('id-ID') + '</td>' +
                            '</tr>';
                }
                html += '<tr class="bg-light font-weight-bold">' +
                            '<td colspan="2" class="text-right pr-3 text-dark">TOTAL OMZET KESELURUHAN:</td>' +
                            '<td class="text-right pr-3 text-primary">Rp ' + grand_total.toLocaleString('id-ID') + '</td>' +
                        '</tr>';
            } else {
                html = '<tr><td colspan="3" class="text-center">Belum ada data penjualan.</td></tr>';
            }
            $('#data_omzet_bulanan').html(html);
        },
        error: function() {
            $('#data_omzet_bulanan').html('<tr><td colspan="3" class="text-center text-danger">Gagal memuat data omzet.</td></tr>');
        }
    });
}

function resetAreaKanan() {
    $('#wrapper-tabel-omzet').hide();
    $('#container-modal-right').show();
    $('#container-modal-right').html('<div class="text-center pt-5 text-muted" id="placeholder-text"><p>Pilih riwayat transaksi di sebelah kiri untuk melihat detail,<br>atau klik tombol <strong>Omzet Bulanan</strong> di atas.</p></div>');
}

function historysaledetail(param) {
    $('#wrapper-tabel-omzet').hide();
    $('#container-modal-right').show();
    
    $.ajax({
        type: "POST",
        url: "<?=base_url('cashier/historysaledetail?api='.$this->id_t); ?>",
        data: "saleid=" + param + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(res) {
            $('#container-modal-right').html(res);
            $(".list-history-sale").removeClass('active');
            $("#list-history-sale-" + param).addClass('active');
        },
        error: function(error) {
            $("#modallg").modal('show');
        }
    });
}

function cancel() {
    $("#modallg").modal('hide');
}

function printReceiptForm() {
    var cartid = $('#cartid').val();
    window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");
}
</script>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cashier - TOKO BELIMBING</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/adminlte.min.css');?>">
    <link rel="stylesheet" href="<?=site_url('assets/lte/sweetalert/sweetalert.css');?>" />
    <style type="text/css">
    * {
        box-sizing: border-box;
    }

    html,
    body {
        height: 100% !important;
        width: 100%;
        padding: 0px;
        margin: 0px;
        font-family: 'Microsoft Sans Serif', sans-serif;
        overflow-x: auto;
        overflow-y: auto;
        text-align: center;
    }

    #loading {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background-color: #fff;
    }

    .link {
        background-color: #c9c;
    }

    .link:hover,
    .link:focus,
    .link:active {
        background-color: #ccc;
        cursor: pointer;
    }

    .autocomplete-suggestions {
        border: 1px solid #999;
        background: #FFF;
        overflow: auto;

    }

    .autocomplete-suggestion {
        padding: 2px 5px;
        white-space: nowrap;
        overflow: hidden;
    }

    .autocomplete-selected {
        background: #F0F0F0;
    }

    .autocomplete-suggestions strong {
        font-weight: normal;
        color: #3399FF;
    }

    .autocomplete-group {
        padding: 2px 5px;
    }

    .autocomplete-group strong {
        display: block;
        border-bottom: 1px solid #000;
    }
    </style>
    <script type="text/javascript">
    //set timezone
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    //buat object date berdasarkan waktu di server
    var serverTime = new Date(<?=date('Y, m, d, H, i, s, 0'); ?>);
    //buat object date berdasarkan waktu di client
    var clientTime = new Date();
    //hitung selisih
    var Diff = serverTime.getTime() - clientTime.getTime();
    //fungsi displayTime yang dipanggil di bodyOnLoad dieksekusi tiap 1000ms = 1detik
    function displayServerTime() {
        //buat object date berdasarkan waktu di client
        var clientTime = new Date();
        //buat object date dengan menghitung selisih waktu client dan server
        var time = new Date(clientTime.getTime() + Diff);
        //ambil nilai jam
        var sh = time.getHours().toString();
        //ambil nilai menit
        var sm = time.getMinutes().toString();
        //ambil nilai detik
        var ss = time.getSeconds().toString();
        //tampilkan jam:menit:detik dengan menambahkan angka 0 jika angkanya cuma satu digit (0-9)
        document.getElementById("clock").innerHTML = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" +
            sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
    }
    </script>
</head>

<body onLoad="setInterval('displayServerTime()',1000);">
    <table border="1" style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #fff;">
        <tr>
            <td style="height:5% " class=" bg-white">
                <table border="1" style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <td style="width:3%; height:100%" class="bg-white">
                            <img src="<?=base_url('assets/img/png-clipart-sale.png');?>"
                                style="width:50px;height:35px;vertical-align: middle;">
                        </td>
                        <td style="width:27%;padding: 0px;font-size: 150%;vertical-align: middle;color:#000">
                            <h5 class="m-0 font-weight-bold">TOKO BELIMBING</h5>
                            <p class="m-0 text-xs"><?=$qt->address?></p>
                        </td>
                        <td style="padding: 0px;font-size: 150%;vertical-align: middle;" class="text-bold;">
                            <table border="0"
                                style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>
                                    <td style="width: 15%; padding: 5px;font-size: 100%;vertical-align: middle;"
                                        class="text-bold">
                                        Cashier 1
                                    </td>
                                    <td style="width: 30%; padding: 0px;font-size: 100%;vertical-align: middle;"
                                        class="text-bold;">
                                        <?=$nama?>
                                    </td>

                                    <td style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                                        <?=date('l, d-m-Y');?>
                                    </td>
                                    <td style="width: 20%; padding: 5px;font-size: 100%;vertical-align: middle;"
                                        class="text-bold">
                                        <span id="clock"></span>
                                    </td>
                                </tr>

                            </table>
                        </td>
                        <td onclick="logout()" style="width: 40px;" class="bg-white">
                            <img src="<?=base_url('assets/img/logout.png');?>"
                                style="width:40px;height:35px;vertical-align: middle;">
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
        <tr>
            <td style="height:90%" class=" bg-white">
                <table border="1" style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <td style="width: 30%; padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                            <table border="0"
                                style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>
                                    <td style="height: 7%; padding: 0px;font-size: 100%;vertical-align: middle;"
                                        class="text-bold;">
                                        <table border="0"
                                            style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                            <tr style="background-color: #dedede;">
                                                <td style="width: 60%; font-size: 60%;">
                                                    CART ID
                                                </td>

                                                <td style="font-size: 60%;">
                                                    STATUS
                                                </td>
                                                <td style="font-size: 60%;">
                                                    SOURCE
                                                </td>
                                                <td style="font-size: 60%;">
                                                    CLEAR CART
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold" style="background-color: yellow;">
                                                    <?=$qhc->id?>
                                                    <input id="cartid" type="text" value="<?=$qhc->id?>" hidden>
                                                </td>
                                                <td class="font-weight-bold" style="background-color: lime;">

                                                    <?=strtoupper($qhc->status)?>
                                                    <!-- <input id="sourceid" type="text" value="<?=$qhc->status?>"> -->
                                                </td>
                                                <td class="font-weight-bold" style="background-color: lime;">
                                                    <?=strtoupper($qhc->cart_source)?>
                                                    <input id="sourceid" type="text" value="<?=$qhc->id?>" hidden>
                                                </td>
                                                <td onclick="<?=$qhc->status == 'done'?'':'clearCart()'?>"
                                                    class="font-weight-bold"
                                                    style="cursor: pointer; background-color: red;">
                                                    <?=$qhc->status == 'done'?'DONE':'CLEAR'?>
                                                </td>
                                            </tr>
                                            <tr>

                                                <td colspan="4">
                                                    <table border="1" style="width:100%;">
                                                        <tr>
                                                            <td
                                                                style="width: 15%; padding: 5px;font-size: 100%;vertical-align: middle; font-size: 60%;">
                                                                CUSTOMER
                                                            </td>
                                                            <td style="padding: 0px;font-size: 100%;vertical-align: middle;"
                                                                class="font-weight-bold text-sm">
                                                                <!-- 081234567891 | Prasetia Eko Nugroho | L | Sarwadadi -->
                                                                <div class="ui-widget">
                                                                    <!-- <label for="customer_name">Tags: </label> -->
                                                                    <input id="customer_name" name="customer_name"
                                                                        value="<?=$qhc->customer_name?>"
                                                                        style="width: 100%;">
                                                                </div>
                                                            </td>

                                                        </tr>
                                                        <!-- <tr>
                                                            <td
                                                                style="width: 15%; padding: 5px;font-size: 100%;vertical-align: middle; font-size: 60%;">
                                                                POINT
                                                            </td>
                                                            <td style="padding: 0px;font-size: 100%;vertical-align: middle;"
                                                                class="font-weight-bold text-sm">
                                                                30
                                                            </td>
                                                        </tr> -->
                                                    </table>
                                                </td>

                                            </tr>

                                        </table>
                                    </td>

                                </tr>
                                <tr>
                                    <td style="padding: 0px;font-size: 100%;vertical-align: top;" class="text-bold;">

                                        <div id="detail_cart" style="height: 500px; overflow-y: scroll;">

                                        </div>

                                    </td>

                                </tr>
                                <tr>
                                    <td style="height: 10%; background-color:#efefef;">
                                        <table border="1"
                                            style="height:100%;width: 100%;border-spacing: 4px;border-collapse: separate;">
                                            <tr>
                                                <td
                                                    style="width: 30%; padding: 5px;font-size: 130%;vertical-align: middle; font-weight: bold; text-align :right">
                                                    Jumlah
                                                </td>
                                                <td
                                                    style="padding: 5px;font-size: 150%;vertical-align: middle; font-weight: bold; background-color:blue; color: #fff">
                                                    <span id="amount-display" class="p-0"></span>
                                                    <input id="amount" type="number"
                                                        style="font-weight: bold; background-color:blue; color: #fff; border: 0"
                                                        readonly hidden>
                                                </td>
                                            </tr>
                                            <!-- <tr>
                                                <td style=" padding: 5px;font-size: 130%;vertical-align: middle; font-weight: bold; text-align :right
                                                    ">
                                                    Bayar
                                                </td>
                                                <td style="padding: 5px;font-size: 150%;vertical-align: middle; font-weight: bold"
                                                    class="text-bold;">
                                                    <input oninput="getMoneyChange()" id="cash" type="number">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td
                                                    style="width: 7%; padding: 5px;font-size: 130%;vertical-align: middle; font-weight: bold; text-align :right">
                                                    Kembalian
                                                </td>
                                                <td id="change"
                                                    style="padding: 5px;font-size: 150%;vertical-align: middle; font-weight: bold; background-color: limegreen"
                                                    class="text-bold">
                                                    -
                                                </td>
                                            </tr> -->

                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 10%;font-size:150%">
                                        <div class="row">

                                            <div class="col-4 px-2">
                                                <!-- <button onclick="printReceipt()" type="button"
                                                    class="btn btn-danger w-100 p-1 font-weight-bold"
                                                    style="font-size: 70%">CETAK</button> -->

                                                <button onclick="closeOpenCart()" type="button"
                                                    class="btn btn-danger w-100 p-1 font-weight-bold <?=$qhc->status == 'done'?'':'d-none'?>"
                                                    style="font-size: 70%">Close</button>
                                                <!-- <button onclick="skipcart()"
                                                    class="btn btn-primary w-100 p-1 font-weight-bold"
                                                    style="font-size: 70%">SIMPAN</button> -->
                                            </div>
                                            <div class="col-8 px-0 pr-3">

                                                <button onclick="pay()"
                                                    class="btn btn-primary w-100 h-100 p-1 font-weight-bold"
                                                    <?=$qhc->status == 'done'?'disabled':''?>
                                                    style="font-size: 110%">BAYAR</button>
                                            </div>
                                        </div>



                                    </td>
                                </tr>
                            </table>
                        </td>


                        <td style="padding: 0px;font-size: 100%;vertical-align: middle;" class="text-bold;">
                            <table border="0"
                                style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>

                                    <td style="height:5%;padding: 0px;font-size: 150%;vertical-align: middle;color:#000"
                                        class="text-bold;">

                                        <table border="1" class="text-left"
                                            style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                            <tr>

                                                <td style="width:30%;padding: 0px;font-size: 100%;vertical-align: middle;color:#000"
                                                    class="text-bold p-1">
                                                    SKU <span id="sku-status" style="color: red; font-size:80%;"></span>
                                                    <input id="input_sku" type="text" style="width: 100%;" autofocus>
                                                </td>

                                                <td style="width:30%;padding: 0px;font-size: 100%;vertical-align: middle;color:#000"
                                                    class="text-bold p-1">
                                                    SEARCH
                                                    <input id="search" oninput="search()" type="text"
                                                        style="width: 100%;">
                                                </td>
                                                <td style="width: 2%;" class="p-1">
                                                    <button onclick="search('')" class="btn p-0"
                                                        style="font-weight: bold; font-size:100%; ">Reload
                                                    </button>
                                                </td>



                                            </tr>
                                            <tr>
                                                <td colspan="3" style="padding: 5px;font-size: 100%;"
                                                    class="text-bold;">
                                                    <div class="row">
                                                        <div class="col-1 font-weight-bold">TAG</div>
                                                        <div class="col-11" id="tag-container"></div>
                                                    </div>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                                <tr>

                                    <td id='product-container'
                                        style="padding: 5px;font-size: 150%;vertical-align: top; text-align:center;background-color:#efefef; height: 90%"
                                        class="text-bold;">
                                        Loading ...

                                    </td>

                                </tr>
                            </table>
                        </td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
                <table border="1"
                    style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #fff;">
                    <tr>
                        <td style="height:10% " class=" bg-white">
                            <table border="1"
                                style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>

                                    <td style="width:30%;padding: 0px;font-size: 150%;vertical-align: middle;color:#000"
                                        class="text-bold;">
                                        <button class="btn btn-sm btn-primary text-xs" onclick="formcustomer()">DATA
                                            CUSTOMER</button>
                                        <button onclick="historysale()" class="btn btn-sm btn-primary text-xs">HISTORY
                                            SALE</button>
                                        <!-- <button onclick="historysaleist()"
                                            class="btn btn-sm btn-primary text-xs">OTP</button> -->

                                        <!-- <button onclick="truncate()" class="btn btn-sm btn-danger text-xs">TRUNCATE (for
                                            Development)</button> -->
                                    </td>
                                    <td style="padding: 0px;font-size: 150%;vertical-align: middle; background-color: #171718; color: #f5f5f7"
                                        class="text-bold; pt-2">
                                        <marquee behavior="" direction="left">WELLCOME BELIMBING STORE</marquee>

                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
    <div class="modal fade" id="modalxl">
        <div class="modal-dialog modal-md">
            <div class="modal-content ">
                <div id="modalcontent" class="modal-body">
                    TES
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <div class="modal fade" id="modallg">
        <div class="modal-dialog modal-xl">
            <div class="modal-content ">
                <div id="modalcontentlg" class="modal-body">
                    TES
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- <script src="<?=site_url('assets/lte/jquery/jquery-2.2.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script> -->

    <script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery-ui.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables/jquery.dataTables.min.js');?>"></script>
    <!-- jQuery -->
    <script src="<?=base_url('assets/lte/plugins/datatables/dataTables.jqueryui.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/papaparse/papaparse.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-editor/js/dataTables.editor.min.js?id='.time());?>">
    </script>
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
    <!-- Bootstrap 4 -->
    <script src="<?=base_url('assets/lte/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
    <!-- DataTables -->
    <script src="<?=base_url('assets/lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-responsive/js/dataTables.responsive.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/SearchBuilder-1.3.0/js/dataTables.searchBuilder.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/DateTime/js/dataTables.dateTime.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script type="text/javascript">
    cv = '<?=$this->security->get_csrf_hash(); ?>';

    var cartid = $('#cartid').val();
    $(document).ready(function() {
        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
        $("#loading").fadeOut("slow");

        tag();
        search();



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
            // Do something
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

                        location.reload();
                        getAmount()
                        $("#sku-status").text('');
                    } else {

                        $("#sku-status").text(res.message);
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
        swal({
                title: "Are you sure?",
                text: "Logout",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-success',
                confirmButtonText: 'Yes',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
            function() {
                window.location.href = "<?=base_url('action/logout?api='.$this->id_t); ?>";
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
    // search()


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
        $.ajax({
            type: "POST",
            url: "<?=base_url('cashier/clearcart?api='.$this->id_t); ?>",
            data: "cartid=" + cartid + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {

                    location.reload();
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
                    $('#tag-container').html(res);
                }
            },
            error: function(error) {
                $('#tag-container').html(error);
            }
        });
    }
    // tag()

    function getMoneyChange() {
        var cash = $('#cash').val();
        var amount = $('#amount').val();
        var change = cash - parseFloat(amount);

        console.log(change)
        $('#change').text(new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR"
        }).format(change));
    }

    function printReceipt() {

        var cartid = $('#cartid').val();
        window.open("<?=base_url('cashier/print_receipt');?>?cartid=" + cartid + "&api=<?=$this->id_t;?>", "_blank");

    }

    function historysale() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('cashier/historysale?api='.$this->id_t); ?>",
            // data: "cartid=" + cartid + "&amount=" + amount + "&customer_name=" + customer_name +"&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
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
            // data: "cartid=" + cartid + "&amount=" + amount + "&customer_name=" + customer_name +"&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
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
            // data: "cartid=" + cartid + "&amount=" + amount + "&customer_name=" + customer_name +"&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
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
        // var cartid = $('#cartid').val();
        $.ajax({
            type: "GET",
            url: "<?=base_url('cashier/truncate?api='.$this->id_t); ?>",
            // data: "cartid=" + cartid + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {

                    // location.reload();
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
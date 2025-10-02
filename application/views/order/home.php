<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Selamat Datang - TOKO BELIMBING</title>
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
        overflow-x: hidden;
        overflow-y: auto;
        text-align: center;
        font-size: 15px;
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

    .customnav {
        cursor: pointer;
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

<!-- <body onLoad="setInterval('displayServerTime()',1000);"> -->

<body>
    <table border="0" style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #fff;">
        <tr style="background-color: gold;">
            <td style="height:5%; " class=" ">
                <table border="0"
                    style="background-color: gold;height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #fff;">
                    <tr>
                        <!-- <td style="width:5% " class="  bg-white">
                            LOGO
                        </td> -->
                        <td style="text-align:left;" class="pt-2 ">
                            <marquee behavior="" direction="left">
                                <h5 class="m-0">SELAMAT DATANG DI TOKO BELIMBING</h5>
                            </marquee>
                        </td>
                        <!-- <td style=" " class="customnav  bg-white">
                            HISTORY
                        </td> -->
                    </tr>
                </table>
            </td>
        </tr>
        <tr style="background-color:gold;">
            <td style="height:5%; " class="">
                <table border="0"
                    style="background-color:gold; height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #fff;">
                    <tr>
                        <td style="width: 5%;" class="p-1">
                            No HP
                        </td>
                        <td style="width:30%;padding: 0px;font-size: 80%;vertical-align: middle;color:#000"
                            class="text-bold p-1 text-left">


                            <span><?=$phone?></span>
                            <button onclick="dialogphone()" class="btn btn-sm p-2 text-left bg-white text-dark"
                                style="font-weight: bold; font-size:100%; "><?=$phone == ''? 'Input':'Edit'?> Phone
                            </button>
                        </td>
                        <td style="width: 5%;" class="p-1">
                            Cart ID
                        </td>
                        <td style="width:30%;padding: 0px;font-size: 80%;vertical-align: middle;color:#000"
                            class="text-bold p-1 text-left">

                            <input id="cartid" type="text" value="<?=$cartid?>" hidden>
                            <span><?=$cartid?></span>

                        </td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr style="background-color:gold;">
            <td id="main_container" style="height:80%" class=" bg-white">
                <table border="0" style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                    <tr>

                        <td style="height:6%;padding: 0px;font-size: 150%;vertical-align: middle;color:#000"
                            class="text-bold;">

                            <table border="0" class="text-left"
                                style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>

                                    <!-- <td style="width:30%;padding: 0px;font-size: 100%;vertical-align: middle;color:#000"
                                        class="text-bold p-1">
                                        SKU <span id="sku-status" style="color: red; font-size:80%;"></span>
                                        <input id="input_sku" type="text" style="width: 100%;" autofocus>
                                    </td> -->
                                    <!-- <td style="width: 3%;" class="p-1">
                                        🔍
                                    </td> -->

                                    <td style="width:30%;padding: 0px;font-size: 60%;vertical-align: middle;color:#000"
                                        class="text-bold p-1">

                                        <input id="search" class="form-control" placeholder="Search..."
                                            oninput="search()" type="text" style="width: 100%;" autofocus>
                                    </td>
                                    <td style="width: 2%;" class="p-1">
                                        <button type="button" onclick="historysaledetail()" class="btn p-2 text-left"
                                            style="font-weight: bold; font-size:70%; border-color:goldenrod">🛒
                                            <?=$total_cart?>
                                        </button>
                                    </td>



                                </tr>
                                <!-- <tr>
                                    <td colspan="3" style="padding: 5px;font-size: 80%;" class="text-bold;">
                                        <div class="row">
                                            <div class="col-1 font-weight-bold">TAG</div>
                                            <div class="col-11" id="tag-container" style="overflow-x: scroll;"></div>
                                        </div>

                                    </td>
                                </tr> -->
                            </table>
                        </td>

                    </tr>
                    <tr>

                        <td id=''
                            style="padding: 5px;font-size: 150%;vertical-align: top; text-align:center;background-color:#efefef; "
                            class="text-bold;">
                            <div id="product-container" style="height: 72vh; overflow-y: scroll; overflow-x:hidden;">

                            </div>

                        </td>

                    </tr>
                </table>
            </td>
        </tr>
        <tr style="background-color:gold;">
            <td style="height: 10%;">
                <table border="0"
                    style="background-color:gold;height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <td onclick="location.reload()" style=" " class="customnav  ">
                            Home
                        </td>

                        <td onclick="history()" style=" " class="customnav  ">
                            Riwayat Pembelian
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
    var phone = '<?=$phone?>';
    cv = '<?=$this->security->get_csrf_hash(); ?>';

    var cartid = $('#cartid').val();
    $(document).ready(function() {
        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
        $("#loading").fadeOut("slow");

        tag();
        search();



    });






    $(window).resize(function() {
        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
    })



    function search() {
        // event.preventDefault()
        let product = document.getElementById('search').value
        $('#product-container').text('Loading...');
        console.log('tes')
        $.ajax({
            type: "POST",
            url: "<?=base_url('order/search'); ?>",
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
            url: "<?=base_url('order/formeditdetail'); ?>",
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
            url: "<?=base_url('order/formpay'); ?>",
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
            url: "<?=base_url('order/clearcart?api='); ?>",
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
            url: "<?=base_url('order/tagsearch?api='); ?>",
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
            url: "<?=base_url('order/tag?api='); ?>",
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
        window.open("<?=base_url('order/print_receipt');?>?cartid=" + cartid + "&api=1", "_blank");

    }


    function dialogphone() {
        $("#modallg").modal('show');
        $.ajax({
            type: "GET",
            url: "<?=base_url('order/dialogphone?p='.$phone); ?>",
            // data: "cartid=" + cartid + "&amount=" + amount + "&customer_name=" + customer_name +"&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            // dataType: 'html',
            // contentType: 'html',
            success: function(res) {


                $('#modalcontentlg').html(res);
                $("#modallg").modal('show');
            },
            error: function(error) {
                $("#modallg").modal('show');
            }
        });
    }




    function historysale() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('order/historysalehp?api='); ?>",
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

    function historysaledetail() {
        $.ajax({
            type: "GET",
            url: "<?=base_url('order/historysaledetail?saleid='); ?>" + cartid,
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
            url: "<?=base_url('order/skipcart?api='); ?>",
            data: "cartid=" + cartid + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(res) {
                if (res.success == true) {
                    window.location.href = "<?=base_url('order?api='); ?>";
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
            url: "<?=base_url('order/formcustomer?api='); ?>",
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

    function history() {
        // event.preventDefault()
        // let product = document.getElementById('search').value
        $('#product-container').text('Loading...');
        console.log('tes')
        $.ajax({
            type: "POST",
            url: "<?=base_url('order/historysalehp'); ?>",
            data: "phone=" + phone + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
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
    </script>

</body>

</html>
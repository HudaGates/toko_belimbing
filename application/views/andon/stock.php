<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Andon | Stock</title>
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/datatables-select/css/select.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
    <link rel="stylesheet"
        href="<?=base_url('assets/lte/plugins/datatables-buttons/css/buttons.dataTables.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/jquery/themes/blitzer/jquery-ui.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/jquery/dataTables.jqueryui.min.css');?>">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/datatables-editor/css/editor.bootstrap4.min.css');?>">
    <link rel="shortcut icon" href="<?=base_url('assets/img/logo.jpg');?>" type="image/x-icon" />
    <style type="text/css">
    * {
        font-family: "Microsoft Sans Serif", sans-serif !important;
    }

    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0px;
        margin: 0px;
        font-family: sans-serif;
        background-color: #000;
        color: #fff;
        text-align: center;
        font-weight: bold;
        font-size: 12px;

    }

    @media (max-width: 899px) {
        .header {
            font-size: 10px;
        }

        .content {
            font-size: 8px;

        }
    }

    @media (min-width: 900px) {
        .header {
            font-size: 18px;
        }

        .content {
            font-size: 12px;

        }
    }

    div.dataTables_filter {
        text-align: right;
        margin-bottom: 2px;
        color: black;
    }

    table,
    tr,
    td {
        padding: 0px;
        border-collapse: collapse;
        border-spacing: 0px;

    }

    /* #example td {
        max-height: 25px;
    } */

    .link:hover {
        background-color: #300bbb !important;
        cursor: pointer;
        color: black;
    }

    .dataTables_scrollBody {
        overflow-x: auto !important;
        overflow-y: auto !important;
    }

    .text-left {
        text-align: left;
    }

    .text-green {
        color: green;
    }

    .text-red {
        color: red;
    }

    .dataTables_wrapper .dataTables_processing {
        position: absolute;
        text-align: center;
        font-size: 1.2em;
        background: white;
        opacity: 0.7;
        width: 200px;
        height: 15px;
        padding: 2px;
        margin: auto;
    }

    .dt-button {
        background-color: #555 !important;
        color: #fff !important;
    }

    .fg-button {
        /* background-color: #444 !important;
        color: #fff !important; */
        border-radius: 1px !important;
    }

    select,
    input {
        border-radius: 1px !important;
        height: 100%;
        padding: 3px;
    }

    .dataTables_length {
        height: 100%;
    }

    label {
        color: #ccc !important;
    }

    .dataTables_info {
        color: #ccc !important;
    }

    #example td {
        padding:3px;
    }

    #example.display.dataTable>tbody>tr.selected>*,
    #example.display.dataTable>tbody>tr.odd.selected>*,
    #example.display.dataTable>tbody>tr.selected:hover>* {
        box-shadow: inset 0 0 0 9999px #002FD8;
    }


    /* The Modal (background) */
    .modal {
        display: none;
        /* Hidden by default */
        position: fixed;
        /* Stay in place */
        z-index: 1;
        /* Sit on top */
        left: 0;
        top: 0;
        width: 100%;
        /* Full width */
        height: 100%;
        /* Full height */
        overflow: auto;
        /* Enable scroll if needed */
        background-color: rgb(0, 0, 0);
        /* Fallback color */
        background-color: rgba(0, 0, 0, 0.4);
        /* Black w/ opacity */
    }

    /* Modal Content/Box */
    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 40%;
        /* Could be more or less, depending on screen size */
    }

    /* The Close Button */
    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .modal-header {
        font-size: 24px;
        margin: 0;
        text-align: left;
        /* background-color: #ccc; */
        height: 30px;
    }
    div.dataTables_length {
        display: none;
    }
    </style>

    <!-- Ionicons -->
    <script type="text/javascript">
    //set timezone
    <?php date_default_timezone_set('Asia/Jakarta'); ?>
    //buat object date berdasarkan waktu di server
    var serverTime = new Date(<?php print date('Y, m, d, H, i, s, 0'); ?>);
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
        $("#clock").text((sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" + sm : sm) + ":" + (ss.length ==
            1 ? "0" + ss : ss));
    }
    </script>
</head>

<body onLoad="setInterval('displayServerTime()',500);">
    <table style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;">
        <tr>
            <td>
                <table
                    style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;border-color:#fff;border:none">
                    <tr>
                        <td style="height: 80px;padding: 1px;" class="header">
                            <table border="1"
                                style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>
                                    <td style="height: 60px;width: 120px;background:url('<?=base_url('assets/img/logo-dark.jpg');?>');background-repeat: no-repeat;background-size:98% 98%;background-position: center;cursor: pointer;"
                                        onclick="filter('','')">&nbsp;
                                    </td>
                                    <td style="font-size:200%; ">
                                        <h3 id="title-andon" style="margin:0">MONITORING STOCK PART</h3>
                                        <p style="margin:0; font-size: 0.5em;">PT. FUJI SEAT INDONESIA</p>
                                    </td>
                                    <td style="padding: 0px;;width: 12%;">
                                        <table
                                            style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;margin: 0px;">
                                            <td
                                                style="font-size: 90%; height:30px;width: 14%; background-color:#333; color:#fff; cursor: pointer;">
                                                LOCATION
                                            </td>
                                            <tr>
                                                <td style="padding: 0px; font-size: 110%;">
                                                    SERVICE PART
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 0px;width: 12%;">
                                        <table
                                            style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;margin: 0px;">
                                            <tr>
                                                <td
                                                    style="font-size: 90%; height:30px;width: 14%; background-color:#333; color:#fff; cursor: pointer;">
                                                    WORKING DATE
                                                </td>
                                            </tr>
                                            <tr>
                                                <td id="working_date" style="padding: 0px; font-size: 120%;">
                                                    <?=gmdate('Y-m-d',time()+60*60*7);?></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="padding: 0px;width: 12%;">
                                        <table
                                            style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;margin: 0px;">
                                            <tr>
                                                <td
                                                    style="font-size: 90%; height:30px;width: 14%; background-color:#333; color:#fff; cursor: pointer;">
                                                    DISP. INTVL
                                                    <select onchange="handleInterval()" name="inputInterval"
                                                        id="inputInterval"
                                                        style="padding: 0 !important; height: 80%; border-radius: 2px;">
                                                        <option value="5">5s</option>
                                                        <option value="10">10s</option>
                                                        <option value="15">15s</option>
                                                        <option value="25" selected>25s</option>
                                                        <option value="60">60s</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 0px; font-size: 80%;">
                                                    <progress id="progress" class="progress" value="0"></progress>
                                                    <p id="progressVal" style="margin:0;"></p>

                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="content" id="refresh">
                            <table border="1"
                                style="width: 100%;height: 100%;border-spacing: 3px;border-collapse: separate;color: black;">
                                <tr style="font-size: 150%">
                                    <td style="height:30px;width: 14%; background-color:#FF3B30; color:#000; cursor: pointer;"
                                        onclick="filter('need_order')">
                                        NEED ORDER
                                    </td>
                                    <td style="width:14%;background-color:#FFCC00; color:#000;cursor: pointer;"
                                        onclick="filter('on_delivery')">
                                        ON DELIVERY
                                    </td>
                                    <td style="width: 14%;background-color:#00E75C; color:#000;cursor: pointer;"
                                        onclick="filter('aman')">
                                        AMAN
                                    </td>
                                    <td style="width: 14%;background-color:#32ADE6; color:#000;cursor: pointer;">
                                        MIS PACKING
                                    </td>

                                </tr>
                                <tr style="font-size: 400%">
                                    <td id="need_order"
                                        style="background-color:#000;color: #FF3B30; height:100px; border:1px solid #FF3B30;font-size: 150%;border-radius: 1px;cursor: pointer;"
                                        onclick="filter('10','Need Order')">
                                        <?= $need_order; ?>
                                    </td>
                                    <td id="on_delivery"
                                        style="background-color:#000;color: #FFCC00; border:1px solid #FFCC00;font-size: 150%;border-radius: 1px;cursor: pointer;"
                                        onclick="filter('10','On Delivery')">
                                        <?= $on_delivery; ?>
                                    </td>
                                    <td id="aman"
                                        style="background-color:#000;color: #00E75C; border:1px solid #00E75C; font-size: 150%;border-radius: 1px;cursor: pointer;"
                                        onclick="filter('10','Aman')">
                                        <?= $aman; ?>
                                    </td>
                                    <td id="mis"
                                        style="background-color:#000;color: #32ADE6; border:1px solid #32ADE6;font-size: 150%;border-radius: 1px;">
                                        <?= $mis; ?>
                                    </td>


                                </tr>
                                <tr>
                                    <td colspan="7"
                                        style="vertical-align: top;background-color: #000;padding: 3px;margin: auto;border-radius: 3px">
                                        <table border="0" id="example" class="table display nowrap pageResize"
                                            style="width: 100%;height: auto;border:0px solid #000;border-color:#ccc;">
                                            <thead>
                                                <tr class="text-bold">
                                                    <th style="width: 1%;height: 20px;text-align: center;">
                                                        &nbsp;No
                                                    </th>
                                                    <th>
                                                        Part No FSI
                                                    </th>
                                                    <th>
                                                        Part Name
                                                    </th>
                                                    <th>
                                                        Model
                                                    </th>
                                                    <th>
                                                        Status Part
                                                    </th>
                                                    <th>
                                                        Supplier Code
                                                    </th>
                                                    <th>
                                                        Stock Awal
                                                    </th>
                                                    <th>
                                                        On Delivery
                                                    </th>
                                                    <th>
                                                        PO Qty
                                                    </th>
                                                    <th>
                                                        Stock Akhir
                                                    </th>
                                                    <th>
                                                        Status
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>

                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: #111;color: yellow;border:none;vertical-align: middle;">
                            <marquee style="font-size:130%;vertical-align: middle;padding-top:3px;padding-bottom: 3px;">
                                <i><?=$qp->pesan;?></i>
                            </marquee>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
    <!-- The Modal -->
    <div id="myModal" class="modal" role="dialog">

        <!-- Modal content -->

        <div class="modal-content" style="background-color:#000">
            <div class="modal-header">Form Order Part</div>

            <!-- <span class="close">&times;</span> -->
            <!-- <hr> -->
            <div id="content" style="text-align: left; margin-top: 10px">

            </div>
        </div>

    </div>
    <script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery-ui.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables/jquery.dataTables.min.js');?>"></script>
    <!-- jQuery -->
    <script src="<?=base_url('assets/lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables/dataTables.jqueryui.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-editor/js/dataTables.editor.min.js?id='.time());?>">
    </script>
    <script src="<?=base_url('assets/lte/plugins/datatables-select/js/dataTables.select.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-buttons/js/dataTables.buttons.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/jszip/jszip.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-buttons/js/buttons.html5.min.js');?>"></script>
    <!-- DataTables -->
    <script type="text/javascript">
    cv = '<?= $this->security->get_csrf_hash(); ?>';
    table = $('#example').DataTable({
        dom: '<"top"Blf>rt<"bottom"ip><"clear">',
        ajax: {
            url: "<?= base_url('andon/aData?table=' . $table); ?>",
            type: "POST",
            data: function(d) {
                d.csrf_sysx_name = cv;
            },

        },
        processing: true,
        "language": {
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="text-green">Processing ...</span> '
        },
        //if sqlserver serverside false
        serverSide: true,
        scrollY: true,
        scrollX: true,
        paging: true,
        autoWidth: true,
        pageResize: true,
        lengthMenu: [
            [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, -1],
            [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, "All"]
        ],
        pageLength: 15,
        responsive: true,
        order: [
            [10, 'desc'],

        ],
        columns: [
            {
                data: null,
                orderable: false,
                searchable:false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                data: "part_no_fsi",
                className: 'text-left',
            },
            {
                data: "part_name",
                className: 'text-left',
            },
            {
                data: "model",
                className: 'text-left',
            },
            {
                data: "status_part",
                className: 'text-left',
            },
            {
                data: "supplier_code",
                className: 'text-left',
            },
            {
                data: "stock"
            },
            {
                data: "on_delivery"
            },
            {
                data: "po_qty"
            },
            {
                data: "stock_akhir"
            },
            {
                data: "status",
                orderable: true,
                render: function(a, b, data) {
                    if (data.status == 'Need Order') {
                        var color = '#FF3B30';
                    } else if (data.status == 'On Delivery') {
                        var color = '#FFCC00';
                    } else if (data.status == 'Aman') {
                        var color = '#00E75C';
                    } else {
                        var color = 'blue';
                    }
                    return '<div style="color:' + color + '">' + a + '</div>';


                }
            },
            {
                data: null,
                orderable: false,
                searchable:false,
                render: function(data, type, row, meta) {
                    if (data.status == 'On Delivery') {
                        return `<button style="padding:1px;margin:0px;width:100%" onclick='print_l("${data.part_no_fsi}", "tbl_stock_part")'>Label</button>`;
                    } else if (data.status == 'Need Order') {
                        return `<button style="padding:1px;margin:0px;width:100%" onclick='form_releasedaily("${data.part_no_fsi}")'>Release</button>`;
                    } else {
                        return null;
                    }

                }
            }
        ],

        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        buttons: [{
                extend: 'excel',
                text: '<span class="text-dark">Excel</span>',
                titleAttr: 'Export Excel',
                className: 'btn-space'

            },
            {
                extend: 'selectAll',
                className: 'btn-space text-green',
            },
            'selectNone',
            {
                text: 'Refresh',
                titleAttr: 'Refresh',
                action: function() {
                    table.columns('').search('').draw();
                }
            },
            {
                extend: "selected",
                text: "Label",
                className: 'dt-button buttons-select-none btn-print',
                titleAttr: 'Label',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].part_no_fsi);
                    }
                    print_l(id, 'tbl_stock_part');
                }

            },
        ],
        rowCallback: function(row, data, index) {
            $(row).find('td').css('background-color', '#000');
            $(row).find('td').css('color', 'white');
            $(row).find('td').css('border', '1px solid #bbb');

        }

    });

    $('#example tbody tr').removeClass('selected');
    $('#example tbody').on('click', 'tr', function() {
        $(this).toggleClass('link');
    });
    $(window).resize(function() {
        var tinggi = ($(window).height() - 420);
        $('#example tbody').css('height', tinggi);
    })

    function filter(col, val) {
        table.columns('').search('').draw();
        table.columns(col).search(val).draw();
    }
    $(document).ready(function() {
        handleInterval()
        doesConnectionExist();
        // selesai();
    });
    $.ajaxSetup({
        cache: false
    });

    // function selesai() {
    //     setTimeout(function() {
    //         doesConnectionExist();
    //         selesai();
    //     }, 5000);
    // }

    function doesConnectionExist() {
        var cari = $('.dataTables_filter input').val();
        var le = $('.dataTables_length select').val();
        $.ajax({
            async: true,
            type: "POST",
            url: "<?=base_url("andon/resultstock?=".$this->sha1->generate(rand(10000,100000000)));?>",
            cache: false,
            dataType: 'json',
            data: "cari=" + cari + "&<?=$this->security->get_csrf_token_name(); ?>=" + cv,
            success: function(data) {
                $("#working_date").text(dateNow());
                if (cari == '') {
                    table.ajax.reload();
                }
                $('#need_order').text(data.need_order);
                $('#on_delivery').text(data.on_delivery);
                $('#aman').text(data.aman);
                $('#mis').text(data.mis);
            }
        });
    }

    setTimeout(function() {
        location.reload();
    }, (10 * 60) * 1000);

    var count = 0;
    var progressBars = document.getElementById("progress");
    var progressVal = document.getElementById("progressVal");
    var tHnd = setInterval(function() {

        if (count >= interval) {
            location.reload();
            count = 0;
        }

        // console.log(count);

        progressBars.setAttribute("max", interval);
        progressBars.value = count;
        progressVal.innerHTML = count + '/' + interval + 's';
        count++;
    }, 1000);


    function handleInterval() {
        var inputInterval = document.getElementById('inputInterval').value;
        interval = inputInterval;
    }

    function dateNow() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();
        console.log(today);
        today = yyyy + '-' + mm + '-' + dd;
        return today;
    }

    function print_l(id, tablex) {
        window.open("<?=base_url('s_print/');?>" + tablex + "?id=" + id + "&api=andon",
            "_blank");
    }

    function form_releasedaily(data) {
        $.ajax({
            type: "POST",
            url: "<?=base_url('andon/formorderpart?api=andon'); ?>",
            data: "part_no_fsi=" + data + "&view=andon&<?=$this->security->get_csrf_token_name();?>=" + cv,
            cache: false,
            success: function(data) {
                $("#content").html(data);
                modal.style.display = "block";
                // $("#myModal").modal('show');

            }
        });
    }


    // Get the modal
    var modal = document.getElementById("myModal");


    // When the user clicks on <span> (x), close the modal
    function closeModal() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
    </script>

</body>

</html>
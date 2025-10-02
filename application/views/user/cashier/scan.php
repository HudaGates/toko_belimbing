<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Posting | Scan</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/jquery/themes/blitzer/jquery-ui.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/adminlte.min.css');?>">
    <link rel="stylesheet" href="<?=site_url('assets/lte/sweetalert/sweetalert.css');?>" />
    <style type="text/css">
    html,
    body {
        height: 100% !important;
        width: 100%;
        padding: 0px;
        margin: 0px;
        font-family: sans-serif;
        overflow-x: auto;
        overflow-y: auto;
        font-size: 12px;
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

    #modal-kotak {
        margin: auto;
        width: 100%;
        position: fixed;
        z-index: 1002;
        display: none;
        background: none;
    }

    #atas {
        padding: 5px;
        height: 100%;
        position: relative;
        text-align: center;
        margin: auto;

    }

    #bawah {
        background: #fff;
    }

    #tombol-tutup {
        background: #ccc;
        border-radius: 5px;
    }

    #tombol-tutup,
    #tombol {
        height: 30px;
        width: 100px;
        color: #e74c3c;
        border: 0px;
        font-weight: 900;
    }

    #bg {
        opacity: .80;
        position: fixed;
        display: none;
        top: 0%;
        left: 0%;
        width: 100%;
        height: 100%;
        background-color: #000;
        z-index: 1001;
        opacity: 0.8;
        color: black;

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

<body onLoad="setInterval('displayServerTime()',100);" class="hold-transition sidebar-collapse layout-top-nav">
    <div id="loading">
        <div class="d-flex justify-content-center">
            <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem; z-index: 20;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand p-0 navbar-dark navbar-<?=$qt->thema;?>">
            <table border="1"
                style="height:100%;width: 100%;border-spacing: 0px;border-collapse: collapse;border-color: #fff;">
                <tr>
                    <td style="width:50px;" class="bg-white">
                        <img src="<?=base_url('assets/img/logo.jpg');?>"
                            style="width:50px;height:35px;vertical-align: middle;">
                    </td>
                    <td style="height:5%;padding: 0px;font-size: 150%;vertical-align: middle;background-color: blue; color:white;"
                        class="text-bold;">
                        POSTING PART
                    </td>
                    <td onclick="logout()" style="width: 40px;" class="bg-white">
                        <img src="<?=base_url('assets/img/logout.png');?>"
                            style="width:40px;height:35px;vertical-align: middle;">
                    </td>
                </tr>
            </table>
        </nav>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header" style="padding-top:0px !important;padding-bottom:0px !important;">
                <div id="bg"></div>
                <div id="modal-kotak">
                    <div id="atas" style="overflow: auto;height: 360px;">
                    </div>
                </div>
                <div class="container-fluid">
                    <div class="row mb-1">
                        <div class="col-sm-8 text-left pl-0">
                            <?=$this->nama;?>,
                            <i><?=gmdate('Y-m-d',time()+60*60*7);?>&nbsp;<span id="clock"><?=date('H:i:s');?></span></i>
                        </div>
                        <div class="col-sm-4 pl-0">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#" onclick="back()">Home</a></li>
                                <li class="breadcrumb-item"><a
                                        href="<?=base_url('posting?api='.$this->id_t);?>">Area</a>
                                </li>

                                <li class="breadcrumb-item"><a
                                        href="<?=base_url('posting/start?api='.$this->id_t.'&pos='.$pos_level);?>">Scan</a>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>
            <!-- Main content -->
            <!-- Main content -->
            <section class="content p-1" id="content">
                <!-- Default box -->
                <div class="card" style="height:100% !important">
                    <div class="card-header p-0 mb-0">
                        <div class="p-0 text-bold text-lg"> <?= $qe->event_name; ?>
                            <hr class="m-0">
                        </div>
                        <div class="p-0">
                            <table border="1" class="p-0 m-0"
                                style="height:100%;width: 100%; border-collapse: separate;border-spacing: 2px !important;border-color: #fff;">
                                <tr>
                                    <td colspan="2">
                                        <?=form_open('posting/scan?api='.$this->id_t, 'id="mydata" '); ?>
                                        <input id="pos_level" type="hidden" name="pos_level" value="<?=$pos_level; ?>">
                                        <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name"
                                            value="<?=$this->security->get_csrf_hash(); ?>">

                                        <input id="qrcode" name="qrcode" type="text" class="form-control text-center"
                                            autocomplete="off" onfocus="this.value=''">
                                        <?=form_close();?>

                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" id="scanstatus"
                                        style="font-weight: bold;background-color: #eee; font-size: 1rem;">
                                        <?= $scanstatus; ?>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <div class="card-body p-1" style="overflow:scroll;">

                        <table
                            style="height:100%;width: 100%; border-collapse: separate;border-spacing: 2px !important;border-color: #fff;">

                            <tr>
                                <td style="vertical-align:top" class="text-sm">


                                    <table border="0"
                                        style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;font-size: 11px;font-weight: bold;border-color: #ccc;border:1px solid #ccc;text-align:left;">
                                        <tr>
                                            <td class="tb"
                                                style="height: 2%; padding-left: 5px; padding-top: 5px; width: 50%; letter-spacing: 1px; font-size: 90%;">
                                                AREA
                                            </td>
                                            <td class="tb"
                                                style="height: 2%; padding-left: 5px; padding-top: 5px; letter-spacing: 1px; font-size: 90%;">
                                                SUPPLIER
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb" style="height: 8%; padding: 5px; padding-top: 0;">
                                                <div
                                                    style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-size: 180%;  font-weight: bold; background-color: blue; color:white;">
                                                    <?=$pos_level;?>
                                                </div>

                                            </td>
                                            <td class="tb" style="padding: 5px; padding-top: 0;">
                                                <div
                                                    style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-size: 180%;  font-weight: bold; background-color: blue; color:white;">
                                                    <?=$supplier;?>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb"
                                                style="height: 2%; padding-left: 5px; letter-spacing: 1px; font-size: 90%;">
                                                VARIANT
                                            </td>
                                            <td class="tb"
                                                style="height: 2%; padding-left: 5px; letter-spacing: 1px; font-size: 90%;">
                                                MODEL
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb" style="height: 8%; padding: 5px; padding-top: 0;">
                                                <div
                                                    style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-size: 180%;  font-weight: bold; background-color: blue; color:white;">
                                                    <?=$variant;?>
                                                </div>

                                            </td>
                                            <td class="tb" style="padding: 5px; padding-top: 0;">
                                                <div
                                                    style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-size: 180%;  font-weight: bold; background-color: blue; color:white;">
                                                    <?=$model;?>
                                                </div>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td class="tb"
                                                style="height: 2%; padding-left: 5px; letter-spacing: 1px; font-size: 90%;">
                                                PART NO
                                            </td>
                                            <td class="tb"
                                                style="height: 2%; padding-left: 5px; letter-spacing: 1px; font-size: 90%;">
                                                RACK NO
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="tb" style="height: 8%; padding: 5px; padding-top: 0;">
                                                <div
                                                    style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-size: 180%;  font-weight: bold; background-color: blue; color:white;">
                                                    <?=$part_no;?>
                                                </div>

                                            </td>
                                            <td class="tb" style="padding: 5px; padding-top: 0;">
                                                <div
                                                    style="padding: 5px; border: 1px solid #ccc; border-radius: 3px; font-size: 180%;  font-weight: bold; background-color: blue; color:white;">
                                                    <?=$rack_no;?>
                                                </div>
                                            </td>
                                        </tr>



                                        <tr>
                                            <td colspan="2" style="vertical-align: top">
                                                <table border="1"
                                                    style="width: 100%;border-spacing: 0px;border-collapse: collapse;font-size: 11px;font-weight: bold;border-color: #ccc;border:1px solid #ccc;text-align:center;">
                                                    <tr>
                                                        <td colspan="5"
                                                            style="text-align: left;height: 14px;border:1px solid #fff">
                                                            History Scan Posting</td>
                                                    </tr>
                                                    <tr class=" text-sm"
                                                        style="background-color: blue; color:white;height: 20px">
                                                        <td>No</td>
                                                        <td>Part No</td>
                                                        <td>Model</td>
                                                        <td>Rack&nbsp;No</td>
                                                        <td>Posting Date</td>
                                                    </tr>
                                                    <?php if(!empty($data_posting)){
                      $i=1; foreach ($data_posting as $key) { ?>
                                                    <tr>
                                                        <td style="height: 20px;"><?=$i++;?></td>
                                                        <td><?=$key->part_no;?></td>
                                                        <td><?=$key->model;?></td>
                                                        <td><?=$key->rack_no;?></td>
                                                        <td><?=$key->posting_date;?></td>
                                                    </tr>
                                                    <?php } }else{ ?>
                                                    <tr>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <?php } ?>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer text-sm">
            <div class="float-right d-none d-sm-block p-0 m-0">
                <b>Version</b> <?=$qt->version;?>
            </div>
            <strong>Copyright &copy; <?=$qt->year;?> <a href=""><?=$qt->owner;?></a></strong>
        </footer>
    </div>
    <script src="<?=base_url('assets/lte/jquery/jquery-2.2.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery-ui.js')?>"></script>
    <script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery.dataTables.min.js')?>"></script>
    <script type="text/javascript">
    cv = '<?=$this->security->get_csrf_hash(); ?>';

    function loaded(b) {
        var audioCtx = new(window.AudioContext || window.webkitAudioContext)();
        var source = audioCtx.createBufferSource();
        var xhr = new XMLHttpRequest();
        xhr.open('GET', b);
        xhr.responseType = 'arraybuffer';
        xhr.addEventListener('load', function(r) {
            audioCtx.decodeAudioData(
                xhr.response,
                function(buffer) {
                    source.buffer = buffer;
                    source.connect(audioCtx.destination);
                    source.loop = false;
                });
            playsound();
        });
        xhr.send();
        var playsound = function() {
            source.start(0);
        };
    }

    $('#mydata').submit(function(e) {
        e.preventDefault();
        var fa = $(this);
        $.ajax({
            url: fa.attr('action'),
            type: 'post',
            data: fa.serialize(),
            dataType: 'json',
            success: function(data) {
                $("#scanstatus").text(data.status);
                if (data.status == 'SUCCESS') {
                    $("#scanstatus").css({
                        "background-color": "green",
                        "color": "white"
                    });
                    var b = '<?=base_url('mp3/ok');?>.mpeg';
                    loaded(b);
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else if (data.status == 'MIS POSTING') {
                    $("#scanstatus").css({
                        "background-color": "red",
                        "color": "white"
                    });
                    var b = '<?=base_url('mp3/error');?>.mpeg';
                    loaded(b);
                    setTimeout(function() {
                        window.location.href =
                            "<?=base_url('posting/mis?pos='.$pos_level.'&api='.$this->id_t); ?>";
                    }, 700);
                } else if (data.status == 'LOGOUT') {
                    setTimeout(function() {
                        window.location.href =
                            "<?=base_url('action/logout?api='.$this->id_t);?>"
                    }, 300);
                } else {
                    $("#scanstatus").css({
                        "background-color": "red",
                        "color": "white"
                    });
                    var b = '<?=base_url('mp3/error');?>.mpeg';
                    loaded(b);
                }
                $("#qrcode").focus();

            }
        });

    });

    $(document).ready(function() {
        $("#qrcode").focus();
        $('#mytable').DataTable({
            "dom": '<"top">rt<"bottom"ip><"clear">',
            "processing": true,
            "serverSide": false,
            "bSort": false,
            "pageLength": 10,
            "order": [],
            "scrollY": true,
            "scrollX": false,
            "scrollCollapse": true,
            "paging": true,
            "fixedColumns": false,
            "AutoWidth": true,
            "LengthChange": false,
            "bLengthChange": false,
            "bInfo": true,
        });

        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
        $("#loading").fadeOut("slow");

        var mis_posting = "<?=$mis_posting;?>";
        $("#qrcode").focus();

        if (mis_posting != '') {
            window.location.href = "<?=base_url('posting/mis?pos='.$pos_level.'&api='.$this->id_t); ?>";
        }
    });
    $("*").click(function() {
        $("#qrcode").focus();
    });

    $(window).resize(function() {
        var tinggi = ($(window).height() - 130);
        $('#content').css('height', tinggi);
    })
    $('#part_no').autocomplete({

        source: function(request, response) {
            $("#part_no").css({
                "color": "black",
                "font-size": "14px"
            });
            $.getJSON("searchpart?query=" + request.term +
                "&<?= $this->security->get_csrf_token_name(); ?>=" + cv +
                "&store=<?= $store."&event_name=".$qe->event_name."&api=".$this->id_t; ?>",
                function(data) {
                    //console.log(data);
                    response($.map(data, function(value, key) {
                        //console.log(value);
                        return {
                            value: value.value
                        };
                    }));
                });
        },
        width: 300,
        max: 20,
        delay: 100,
        minLength: 1,
        autoFocus: true,
        cacheLength: 1,
        scroll: true,
        highlight: false,
        select: function(event, ui) {
            var part_no = ui.value;
        }
    });

    function tutup() {
        $("#atas").html();
        $('#modal-kotak , #bg').fadeOut("slow");
        $("#qrcode").focus();
    }

    function back() {
        swal({
                title: "Are you sure?",
                text: "Back Page",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Yes',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
            function() {
                window.location.href = "<?=base_url('posting?api='.$this->id_t); ?>";
            });
    }

    function home() {
        swal({
                title: "Are you sure?",
                text: "Back Home",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Yes',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
            function() {
                window.location.href = "<?=base_url('home?api='.$this->id_t); ?>";
            });
    }

    function logout() {
        swal({
                title: "Are you sure logout?",
                text: "Finish this session",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: 'btn-danger',
                confirmButtonText: 'Yes',
                closeOnConfirm: false,
                //closeOnCancel: false
            },
            function() {
                window.location.href = "<?=base_url('action/logout?api='.$this->id_t); ?>";
            });
    }

    function cekmis() {
        $.ajax({
            type: "POST",
            url: "<?=base_url('posting/cekmis?pos='.$pos_level.'&api='.$this->id_t); ?>",
            data: "<?=$this->security->get_csrf_token_name();?>=" + cv,
            cache: false,
            dataType: 'json',
            success: function(data) {
                if (data.status == true) {
                    window.location.href =
                        "<?=base_url('posting/mis?pos='.$pos_level.'&api='.$this->id_t); ?>";
                }
            },
            error: function(error) {
                window.location.reload();
            }
        });
    }
    setInterval(function() {
        cekmis();
    }, 3000);
    </script>

</body>

</html>
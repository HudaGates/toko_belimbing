<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title><?=$qt->title;?> | Scan</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="shortcut icon" href="<?= base_url('assets/img/logo.jpg'); ?>" type="image/x-icon" />
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/jquery/themes/blitzer/jquery-ui.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/adminlte.min.css');?>">
    <link rel="stylesheet" href="<?=site_url('assets/lte/sweetalert/sweetalert.css');?>" />
    <style type="text/css">
    :root {
        color-scheme: dark;
    }

    html,
    body {
        height: 100%;
        width: 100%;
        padding: 0px;
        margin: 0px;
        font-family: sans-serif;
        text-align: center;
        font-weight: bold;
        font-size: 12px;
        letter-spacing: -0.05rem !important;

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
            font-size: 20px;
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

    }

    .link:hover {
        background-color: #300bbb !important;
        cursor: pointer;
        color: black;
    }

    .dataTables_scrollBody {
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }

    .text-left {
        text-align: left;
    }

    .text-green {
        color: #444;
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

    .table-data tr {
        background-color: #222 !important;
        color: #fff;
        height: 30px;
    }

    .table-data tr:nth-child(even) {
        background-color: #333 !important;
        color: #fff;
    }



    /* BLINK */


    @keyframes invalid {
        from {
            background-color: #FF3B30;
            color: #dedede;
        }

        to {
            background-color: inherit;
            color: #dedede;
        }
    }

    .red {
        background-color: #FF3B30 !important;
        color: #111 !important;

    }


    .yellow {
        background-color: #FF9F0A !important;
        color: #111 !important;
    }

    .green {
        background-color: #30D158 !important;
        color: #111 !important;
    }

    .grey {
        background-color: #bebebe !important;
        color: #111 !important;

        background-image: radial-gradient(circle at center,
                black 0.06rem,
                transparent 0);
        background-size: 0.25rem 0.25rem;
        background-repeat: round;
    }

    .success {
        background-color: #081C0D;
        color: #30D158;

        background-image: radial-gradient(circle at center,
                black 0.06rem,
                transparent 0);
        background-size: 0.25rem 0.25rem;
        background-repeat: round;
    }

    .halftone {
        background-image: radial-gradient(circle at center,
                black 0.06rem,
                transparent 0);
        background-size: 0.25rem 0.25rem;
        background-repeat: round;
    }

    .invalid {
        -webkit-animation: invalid 1s infinite;
        /* Safari 4+ */
        -moz-animation: invalid 1s infinite;
        /* Fx 5+ */
        -o-animation: invalid 1s infinite;
        /* Opera 12+ */
        animation: invalid 0.5s infinite;
        /* IE 10+ */
    }

    /* CSS UNTUK PART PO */
    table#part-po tr:nth-child(even) {
        background-color: #111;
        color: #dedede;
        height: 30px;
        font-size: 150%;

    }

    table#part-po tr:nth-child(odd) {
        background-color: #111;
        height: 30px;
        font-size: 150%;

    }

    table#part-po thead {
        position: sticky;
        top: 0;
    }


    .table-responsive {
        height: 100%;
        overflow: auto;
        position: sticky;
        top: 0;
        background-color: #fff;
    }

    #blink {
        text-align: center;
        background: red;
        color: #F00;
        margin: 0 auto;
        padding: 15px;
        border: 1px solid red;
        width: 80%;
        box-shadow: 5px 10px 5px red;
        border-radius: 15px;
    }

    #blink span {
        font-size: 2em;
        font-weight: bold;
        display: block;
        font-family: arial;
    }

    .link:hover {
        background-color: #30bbbb !important;
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

    .bg-lime {
        background-color: lime !important;
        color: black !important;
    }

    .blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 0;
        }
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
    <table
        style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;background-color: #000;color: #fff;">
        <tr>
            <td>
                <table
                    style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;border-color:#777;border:none">
                    <tr>
                        <td style="height: 80px;padding: 1px;" class="header">
                            <table border="1"
                                style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;">
                                <tr>
                                    <td style="height: 60px;width: 100px;background:url('<?=base_url('assets/img/logo.jpg');?>');background-repeat: no-repeat;background-size:98% 98%;background-position: center;cursor: pointer;"
                                        onclick="back()">&nbsp;
                                    </td>
                                    <td
                                        style="background-color: #222; color: #dedede;line-height: normal;padding: 5px;">
                                        <span style="font-size:210%;line-height: 100%"><?=strtoupper($qt->title);?> WITH
                                            LAMP
                                        </span><br><?=$qt->owner;?>
                                    </td>

                                    <td style="padding: 0px;width: 30%; background-color: #222; color: #dedede">
                                        <table border="1"
                                            style="width: 100%;height: 100%;border-spacing: 0px;border-collapse: collapse;margin: 0px;">
                                            <tr>
                                                <td
                                                    style="padding: 0px; font-size: 2.3rem; text-align: center; font-weight: normal">
                                                    <?=gmdate('d/m/Y',time()+60*60*7);?> <span
                                                        id="clock"><?=gmdate('H:i:s',time()+60*60*7);?></span><span
                                                        style="font-size: 50%;"> WIB</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 2rem; font-weight: bold;">
                                                    POS-POSTING1
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td class="content" style="height: 90%; padding: 1px;padding-top: 1px; padding-bottom: 1px">
                            <table border="1"
                                style="height:100%;width:100%;border-collapse: collapse;border-spacing: 5px;">

                                <tr>
                                    <td style="height: 10%; background-color: #222;">
                                        <table border="1"
                                            style="height:100%;width:100%;text-align: left;font-weight: bold; border-collapse: separate;border-spacing: 4px;border-color: #999;">

                                            <tr height="12%">
                                                <td
                                                    style="width: 15%; padding: 5px;vertical-align: middle; border:1px solid #777; background-color: #111; color: #FFD60A;">

                                                    <?=form_open('posting/scan?api='.$this->id_t, 'id="mydata" '); ?>
                                                    <input id="pos_level" type="hidden" name="pos_level"
                                                        value="<?=$pos_level; ?>">
                                                    <input id="csrf_sysx_name" type="hidden" name="csrf_sysx_name"
                                                        value="<?=$this->security->get_csrf_hash(); ?>">

                                                    <input id="qrcode" name="qrcode" type="text" class=" text-center"
                                                        autocomplete="off" style="font-size: 40px; width: 100%;"
                                                        onfocus="this.value=''">
                                                    <?=form_close();?>
                                                </td>
                                                <td id="scanstatus"
                                                    style="width: 40%;font-size: 250%; background-color: #ccc; padding: 5px; font-weight: bold; text-align: center;color: #000;background-image: radial-gradient(circle at center,black 0.06rem,transparent 0);background-size: 0.25rem 0.25rem;background-repeat: round;">
                                                    <div class="blink_me text-bold"><?=$scanstatus;?></div>
                                                </td>

                                                <td style="padding: 5px;width: 5%;">

                                                    <button onclick="location.reload()" class="btn btn-block"
                                                        style="font-size: 2.5rem;font-weight: bold;height: 100%; background-color: green; color: #fff;">
                                                        ⟲
                                                    </button>
                                                </td>
                                            </tr>

                                        </table>
                                    </td>
                                </tr>


                                <tr>
                                    <td style="height: 85%; width:30%; background-color: #000;">
                                        <table
                                            style="height:100%;width:100%;border-collapse: separate;border-spacing: 3px; ">

                                            <tr>
                                                <td
                                                    style="height: 15%;padding: 0px; padding-left: 0px; vertical-align: top; border:1px solid #777; ">
                                                    <table
                                                        style="width: 100%; height: 100%; border-collapse: collapse;border-spacing: 0px; text-align: left;">
                                                        <tr>
                                                            <td
                                                                style="height: 25px; padding: 0px 0px 0px 5px; font-size: 1.3rem; background-color: #333; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                MODEL
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="halftone"
                                                                style="padding: 3px; font-weight: bold; font-size:350%;text-align: center;line-height: 100%; background-color: blue;">
                                                                <?=$model;?>

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td
                                                    style="height: 15%;padding: 0px; padding-left: 0px; vertical-align: top; border:1px solid #777; ">
                                                    <table
                                                        style="width: 100%; height: 100%; border-collapse: collapse;border-spacing: 0px; text-align: left;">
                                                        <tr>
                                                            <td
                                                                style="height: 25px; padding: 0px 0px 0px 5px; font-size: 1.3rem; background-color: #333; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                VARIANT
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="halftone"
                                                                style="padding: 3px; font-weight: bold; font-size:350%;text-align: center;line-height: 100%; background-color: blue;">
                                                                <?=$variant;?>

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width: 50%; padding: 0px; border:1px solid #777; ">
                                                    <table border="0"
                                                        style="width: 100%; height: 100%; border-collapse: collapse;border-spacing: 0px; text-align: left;">
                                                        <tr>
                                                            <td
                                                                style="height: 25px; padding: 0px 0px 0px 5px; font-size: 1.3rem; background-color: #333; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                SUPPLIER
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="halftone"
                                                                style="padding: 3px; padding-left: 55px; font-weight: bold; font-size:350%;text-align: left;line-height: 100%; background-color: blue;">
                                                                <?=$supplier;?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                            </tr>
                                            <tr>
                                                <td
                                                    style="height: 15%;padding: 0px; padding-left: 0px; vertical-align: top; border:1px solid #777; ">
                                                    <table
                                                        style="width: 100%; height: 100%; border-collapse: collapse;border-spacing: 0px; text-align: left;">
                                                        <tr>
                                                            <td
                                                                style="height: 25px; padding: 0px 0px 0px 5px; font-size: 1.3rem; background-color: #333; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                PART NO
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="halftone"
                                                                style="padding: 3px; font-weight: bold; font-size:350%;text-align: center;line-height: 100%; background-color: blue;">
                                                                <?=$part_no;?>

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="2"
                                                    style="height: 15%;padding: 0px; padding-left: 0px; vertical-align: top; border:1px solid #777; ">
                                                    <table
                                                        style="width: 100%; height: 100%; border-collapse: collapse;border-spacing: 0px; text-align: left;">
                                                        <tr>
                                                            <td
                                                                style="height: 25px; padding: 0px 0px 0px 5px; font-size: 1.3rem; background-color: #333; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                PART NAME
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="halftone"
                                                                style="padding: 3px; padding-left: 55px; font-weight: bold; font-size:350%;text-align: left;line-height: 100%; background-color: blue;">
                                                                <?=$part_name;?>

                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>


                                            </tr>
                                            <tr>
                                                <td colspan="3"
                                                    style="padding: 0px; border:1px solid #777; background-color: #111; color: #bebebe;">
                                                    <table class="class="
                                                        style="width: 100%; height: 100%; border-collapse: collapse;border-spacing: 0px;">
                                                        <!-- <tr>
                                                            <td
                                                                style="height: 25px; padding: 0px 0px 0px 5px; font-size: 1.3rem; text-align: left; background-color: #333; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                List Part
                                                            </td>
                                                        </tr> -->
                                                        <tr>
                                                            <td
                                                                style="width: 60%; padding: 4px; font-size: 1.3rem; text-align: left; background-color: #000; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                <table style="width: 100%; height: 100%;">
                                                                    <tr>
                                                                        <td style="width: 100%;">
                                                                            <table border="1"
                                                                                style="width: 100%; height: 100%; border:1px solid #777; text-align:center; background-color: #000; color: #dedede;">
                                                                                <tr>
                                                                                    <td colspan="5"
                                                                                        style="background-color: #444; height: 10%; font-size: 1.7rem; font-weight: bold;">
                                                                                        RACK
                                                                                        <?=$rack_actual;?>
                                                                                    </td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                    <td style="font-size: 2.5rem;">
                                                                                        TES
                                                                                    </td>
                                                                                </tr>

                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td
                                                                style=" padding: 4px; font-size: 1.3rem; text-align: left; background-color: #000; color: #dedede; font-weight: bold; letter-spacing: 0.5px;">
                                                                <table style="width: 100%; height: 100%;">
                                                                    <tr>
                                                                        <td style="width: 100%;">
                                                                            <table border="1"
                                                                                style="width: 100%; height: 100%; border:1px solid #777; text-align:center; background-color: #000; color: #dedede;">
                                                                                <tr>
                                                                                    <td colspan="5"
                                                                                        style="background-color: #444; height: 10%; font-size: 1.7rem;">
                                                                                        IMAGE PART
                                                                                    </td>

                                                                                </tr>
                                                                                <tr>
                                                                                    <td
                                                                                        style="background-image: url(<?= base_url('assets/part/img/'.$part_no.'.jpg?id='.time());?>); background-size: 100% 100%;">

                                                                                    </td>

                                                                                </tr>

                                                                            </table>
                                                                        </td>

                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>

                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>


                            </table>


                        </td>
                    </tr>
                </table>

            </td>

        </tr>
        <tr>
            <td style="height: 5%;border: 0px;">
                <marquee
                    style="font-size:200%;vertical-align: middle;padding-top:3px;padding-bottom: 3px; color: yellow;">
                    <i><?= $qp->pesan ? $qp->pesan : 'RUNNING TEXT';?></i>
                </marquee>
            </td>
        </tr>
    </table>

    <script src="<?=site_url('assets/lte/jquery/jquery-2.2.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery-ui.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery.dataTables.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>
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
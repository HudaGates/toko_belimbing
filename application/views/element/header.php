<?php
 if(!file_exists($cu->web_path)){
     $gambar=base_url().'/assets/img/default.jpg';
  }else{
     $gambar=$cu->web_path.'?id='.time();
  }
  ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$title;?> | Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet"
        href="<?=base_url('assets/lte/plugins/datatables-buttons/css/buttons.dataTables.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/datatables-select/css/select.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/jquery/themes/blitzer/jquery-ui.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/jquery/dataTables.jqueryui.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/ionicons-2.0.1/css/ionicons.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/sweetalert/sweetalert.css') ?>" />
    <link rel="stylesheet"
        href="<?=base_url('assets/lte/plugins/SearchBuilder-1.3.0/css/searchBuilder.jqueryui.min.css');?>">

    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/datatables-editor/css/editor.bootstrap4.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/DateTime/css/dataTables.dateTime.min.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/adminlte.min.css');?>">
    <link rel="shortcut icon" href="<?=$logo;?>" type="image/x-icon" />
    <link href="<?= base_url('assets/fonts/sfpro/stylesheet.css'); ?>" rel="stylesheet" type="text/css" />
    <style type="text/css">
    html,
    body {
        font-family: 'SF Pro Display', sans-serif !important;
        height: 100%;
        width: 100%;
        font-size: 12pt;
    }

    .sweet-alert .show {
        display: block !important;
    }

    .has-error .help-block {
        color: #a94442;
    }

    .dataTables_paginate {
        padding: 0px 0px 0px 0px !important;
    }

    .paginate_button {
        padding: 1px !important;
    }

    .dis-none {
        display: none;
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

    .cursor {
        cursor: pointer;
    }
    </style>
    <script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js')?>"></script>
    <script src="<?=base_url('assets/lte/jquery/jquery-ui.js')?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables/jquery.dataTables.min.js');?>"></script>
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
    <script src="<?=base_url('assets/lte/plugins/bootstrap/js/bootstrap.bundle.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/datatables-responsive/js/dataTables.responsive.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/SearchBuilder-1.3.0/js/dataTables.searchBuilder.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/plugins/DateTime/js/dataTables.dateTime.min.js');?>"></script>
    <script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>

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
        document.getElementById("clock").innerHTML = (sh.length == 1 ? "0" + sh : sh) + ":" + (sm.length == 1 ? "0" +
            sm : sm) + ":" + (ss.length == 1 ? "0" + ss : ss);
    }
    </script>
</head>

<body class="sidebar-mini layout-fixed sidebar-collapse accent-<?=$thema;?> text-sm"
    onload="setInterval('displayServerTime()',1000);">
    <div id="loading">
        <div class="d-flex justify-content-center">
            <div class="spinner-grow text-primary" role="status" style="width: 3rem; height: 3rem; z-index: 20;">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>
    <div class="wrapper">
        
        <nav class="main-header navbar navbar-expand navbar-dark navbar-<?=$thema;?> text-sm border-bottom-0">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"
                        onclick="menu('<?=base_url('action/contact');?>','Contact');">Contact</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"
                        onclick="window.open('<?=base_url("home?api=".$this->id_t);?>', '_blank');" title="New Tab"><i
                            class="fa fa-plus"></i></a>
                </li>
            </ul>

            <form class="form-inline ml-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search"
                        aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="reset">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link brand-image img-circle elevation-1" data-widget="dropdown" href="#"
                        onclick="logout()" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </a>

                </li>
                <li class="nav-item">
                    <a class="nav-link brand-image img-circle elevation-1" data-widget="control-sidebar"
                        data-slide="true" href="#" role="button" title="Thema">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-<?=$thema;?> elevation-0">
            <div class="brand-link navbar-<?=$thema;?> text-sm" style="padding: 4px">
                <div class="row">
                    <div class="col-3">
                        <img src="<?=$logo.'?id='.time();?>" class="brand-image img-circle elevation-2"
                            style="height: 60px !important; width: 50px !important; margin: 0 !important;">
                    </div>
                    <div class="col-9 brand-text">
                        <div class=" font-weight-bold text-white" style="font-size: 0.9rem;">&nbsp;<?=$detail;?></div>
                        <div class="m-0 brand-text" style="font-size: 0.6rem;">&nbsp;<?=$owner;?></div>
                    </div>

                </div>


            </div>

            <div class="sidebar" style="background-color: #222;">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?=$gambar;?>" class="img-circle elevation-0" alt="<?=$cu->nama; ?>">
                    </div>
                    <div class="info">
                        <h5 class="m-0 font-weight-normal text-white"><?=$cu->nama; ?></h5>

                        <a style="font-size: 0.8rem;" href="#" class="d-block"><?= $cu->user_level;?></a>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item has-treeview">
                            <a href="" class="nav-link"
                                onclick="$('.nav-link.1').removeClass('active'); $(this).addClass('active');">
                                <i class="nav-icon fas fa-house-user"></i>
                                <p>
                                    Home
                                </p>
                            </a>
                        </li>

                        <?php
                        // ==============================================================
                        // JURUS FILTER MENU: Tulis nama menu yang mau disembunyikan di sini
                        // ==============================================================
                        $hidden_menus = [
                            'Data Title', 'Data Group', 'Data Area', 'Data Level', 
                            'Data Menu', 'Data IP Address', 'Data Pesan Andon', 'Master Rack'
                        ];

                        foreach ($menu_parent as $row1) { 
                            // Cegat jika nama menu ada di daftar sembunyi
                            if (in_array($row1->nav, $hidden_menus)) { continue; }
                        ?>
                        
                        <li class="nav-item has-treeview <?=$row1->parent;?>">
                            <?php if($row1->url!="-"){ 
                                if($row1->parent=='andon'){ ?>
                            <a class="nav-link 1 <?=$row1->parent;?>"
                                onclick="window.open ('<?=site_url($row1->url.'?api='.$this->id_t)?>','_blank');"></i>
                                <i class="nav-icon fas <?=$row1->icon;?> text-bold"></i>
                                <p><?=$row1->nav;?></p>
                                <?php }else{?>
                                <a class="nav-link 1 <?=$row1->parent;?>"
                                    onclick=" $('.nav-link.1').removeClass('active'); $('.nav-link.1.<?=$row1->parent;?>').addClass('active'); menu('<?=base_url($row1->url); ?>','<?=$row1->nav;?>','<?=$row1->tabel;?>','<?=$row1->menuid;?>');">
                                    <i class="nav-icon fas <?=$row1->icon;?> text-bold"></i>
                                    <p><?=$row1->nav;?></p>

                                    <?php }
                }else{?>
                                    <a class="nav-link 1 <?=$row1->parent;?>" href="#"
                                        onclick="$('.nav.nav-treeview.show').hide();$('.nav.nav-treeview').removeClass('show'); $('.nav.nav-treeview.<?=$row1->parent;?>').addClass('show'); $('.nav-link.1').removeClass('active'); $('.nav-link.1.<?=$row1->parent;?>').addClass('active');">
                                        <i class="nav-icon fas <?=$row1->icon;?> text-bold"></i>
                                        <p><?=$row1->nav;?>
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                        <?php }?>
                                    </a>
                                    <ul class="nav nav-treeview <?=$row1->parent;?>">
                                        <?php foreach ($menu_child as $row2) { 
                                            // Cegat juga jika nama anak menu ada di daftar sembunyi
                                            if (in_array($row2->nav, $hidden_menus)) { continue; }
                                            
                                            if($row1->parent==$row2->parent) { 
              if($row2->parent=='andon'){ ?>
                                        <li class="nav-item <?=$row2->child;?>">
                                            <a class="nav-link 2"
                                                onclick="window.open ('<?=base_url($row2->url.'?api='.$this->id_t)?>','_blank');">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p> <?=$row2->nav;?></p>
                                            </a>
                                        </li>
                                        <?php }elseif($row2->parent=='user'){ ?>
                                        <li class="nav-item <?=$row2->child;?>">
                                            <a class="nav-link 2"
                                                onclick="menuUser('<?=base_url($row2->url); ?>','<?=$row2->nav;?>');">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p> <?=$row2->nav;?></p>
                                            </a>
                                        </li>
                                        <?php }else{?>
                                        <li class="nav-item <?=$row2->child;?>">
                                            <a class="nav-link 2"
                                                onclick="$('.nav-link.1').removeClass('active'); $('.nav-link.1.<?=$row1->parent;?>').addClass('active');$('.nav-link.2').removeClass('active'); $(this).addClass('active'); menu('<?=base_url($row2->url); ?>','<?=$row2->nav;?>','<?=$row2->tabel;?>','<?=$row2->menuid;?>');">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p><?=$row2->nav;?></p>
                                            </a>
                                        </li>
                                        <?php }} } ?>
                                    </ul>
                        </li>
                        <?php } ?>
                        <li class="nav-item has-treeview profile">
                            <a class="nav-link 1 profile"
                                onclick="$('.nav.nav-treeview').hide();$('.nav-item.has-treeview').removeClass('menu-open'); $('.nav-link.1').removeClass('active'); $('.nav-link.1.profile').addClass('active');menu('<?=base_url('profile'); ?>','Profile','tbl_user','profile-');">
                                <i class="nav-icon fas fa-user-shield text-bold"></i>
                                <p>Profile</p>
                            </a>
                        </li>
                    </ul>
                </nav>
                </div>
            </aside>
        <div class="content-wrapper" id="content" style="display: flex;flex-direction: column; background-color: #eee;">
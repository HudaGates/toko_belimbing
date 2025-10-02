<!-- Content Header (Page header) -->
<section class="content-header"
    style="padding-top:0px !important;padding-bottom:0px !important; padding: 0 !important; ">
    <div class="container-fluid">
        <div class="row mb-1">
            <div class="col-sm-12 px-1">
                <table border="0" style="width: 100%; border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <td id="icon-day" rowspan="2"
                            style="height: auto;width:1%; font-size: 1.5rem; letter-spacing: 1px; margin: 0; color:#000; text-align: center; font-weight: bold; line-height: 1px;">

                        </td>
                        <td style="width:20%;  letter-spacing: 1px; margin: 0; color:#000;">
                            <h3 id="greeting"
                                style="margin: 0; font-size: 0.7rem; line-height: 6px; font-weight: bold;"></h3>
                        </td>
                        <td rowspan="2" style="padding-right: 0px; width: 20%; text-align:right;">
                            <table border="0" style="width: 100%; border-spacing: 0px;border-collapse: collapse;">
                                <tr>
                                    <td style="line-height: 12px;">
                                        <?=gmdate('l, d F Y',time()+60*60*7);?>
                                    </td>
                                </tr>
                                <tr>
                                    <td id="clock" style="font-weight: bold; font-size: 1.1rem; line-height: 16px;">
                                        <?=date('H:i:s');?>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                    <tr>
                        <td style=" color:#000; font-size: 1.1rem; font-weight: bold; line-height: 10px;">
                            <?=$cu->nama;?>
                        </td>
                    </tr>
                </table>

            </div>

        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<?php if($cu->user_group=='Admin'){ ?>
<section class="content bg-light"
    style="background:url('<?=$bg;?>');background-repeat: no-repeat;background-size:100% 100%;padding-bottom: 0px;display: flex;justify-content: center;align-items: center;"
    id="bg">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 text-center">
                <span class="nav-link brand-image img elevation-5 bg-<?=$thema;?>"
                    style="width: 200px;margin: auto; border-radius:10px; ">
                    <h1 style="line-height: 90%;"><?=$title;?></h1>
                    <?=$detail;?>
                </span>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<?php }else{ ?>
<section class="content bg-light">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Menu Home</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body text-center">
                        <?php foreach ($menu_child as $key) { ?>
                        <a class="btn btn-app bg-<?=$thema;?> "
                            onclick="menuUser('<?=base_url($key->url); ?>','<?=$key->nav;?>');" style="width:100px;">
                            <!--<span class="badge bg-success">&nbsp;</span>-->
                            <i class="fas <?=$key->icon;?>"></i>
                            <p><?=strtoupper($key->nav);?></p>
                        </a>
                        <?php } ?>

                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<?php } ?>
<script type="text/javascript">
var tinggi = ($(window).height() - 137);
if (tinggi < 150) {
    var tinggi = 150;
}
$('#bg').css('height', tinggi);
$(window).resize(function() {
    var tinggi = ($(window).height() - 137);
    if (tinggi < 150) {
        var tinggi = 150;
    }
    $('#bg').css('height', tinggi);
})
</script>
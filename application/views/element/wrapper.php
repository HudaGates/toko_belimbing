<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header"
    style="padding-top:0px !important;padding-bottom:0px !important; padding: 0 !important; background-color: #eee; color: #111;">
    <div class="container-fluid">
        <div class="row mb-0 px-2 pt-1">
            <div class="col-sm-12 ">
                <table border="0" style="width: 100%; border-spacing: 0px;border-collapse: collapse;">
                    <tr>
                        <td id="icon-day" rowspan="2"
                            style="height: auto;width:1%; font-size: 1.5rem; letter-spacing: 1px; margin: 0; text-align: center; font-weight: bold; line-height: 1px;">

                        </td>
                        <td style="width:20%;  letter-spacing: 1px; margin: 0; ">
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
                                    <td id="clock" style="font-weight: bold; font-size: 1.3rem; line-height: 18px;">
                                        <?=date('H:i:s');?>
                                    </td>
                                </tr>
                            </table>
                        </td>

                    </tr>
                    <tr>
                        <td style=" font-size: 1.1rem; font-weight: bold; line-height: 10px;">
                            <?= isset($cu->nama) ? $cu->nama : 'Admin'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" style="line-height: 8px; padding: 0;">
                            <ol class="breadcrumb float-sm-left">
                                <li class="breadcrumb-item"><a href="">Home</a></li>
                                <li class="breadcrumb-item active"><a href="#"
                                        onclick="menu('<?=$url;?>','<?=$nav;?>','<?=$table;?>','<?=$menuid;?>')"><?=$nav;?></a>
                                </li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- <div class="col-sm-12">
                
            </div> -->
        </div>
    </div><!-- /.container-fluid -->
</section>
<script>
function getDayGreeting() {
    let today = new Date()
    let curHr = today.getHours()
    if (curHr < 12) {
        $("#greeting").text('GOOD MORNING');
        $("#icon-day").text('🌞');

        // console.log('SELAMAT PAGI');
    } else if (curHr < 15) {
        $("#greeting").text('GOOD AFTERNOON');
        $("#icon-day").text('🌤️');
        // console.log('SELAMAT PAGI');
    } else if (curHr < 18) {
        $("#greeting").text('GOOD AFTERNOON');
        $("#icon-day").text('🌇');

    } else {
        $("#greeting").text('GOOD NIGHT');
        $("#icon-day").text('🌙');
        // console.log('SELAMAT MALAM');
    }


}
getDayGreeting();
</script>
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
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0 d-flex justify-content-center align-items-center" 
                     style="border-radius: 15px; min-height: 65vh; background: #ffffff;">
                    <div class="text-center p-5">
                        <div class="mb-4">
                            <div class="d-inline-flex justify-content-center align-items-center bg-primary text-white" 
                                 style="width: 80px; height: 80px; border-radius: 50%; font-size: 2rem; box-shadow: 0 4px 10px rgba(0,123,255,0.3);">
                                <i class="fas fa-store"></i>
                            </div>
                        </div>
                        <h1 class="font-weight-bold text-dark mb-2" style="font-size: 2.2rem;"><?=$title;?></h1>
                        <p class="text-muted mb-4" style="font-size: 1.1rem; max-width: 600px; margin: auto;">
                            <?=$detail;?>
                        </p>
                        <span class="badge badge-light text-primary px-4 py-2" style="font-size: 1rem; border-radius: 20px; border: 1px solid #cce5ff;">
                            <i class="fas fa-shield-alt mr-1"></i> Administrator Panel
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

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
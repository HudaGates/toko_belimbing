<div class="row " style="max-height: 40px">

    <?php 
                      $i=1;
                      if(!count($qcp)<1){
                        foreach ($qcp as $key) {
                      
                       ?>
    <div class="col-auto">
        <button onclick="tagsearch('<?=$key->category_id;?>')" class="btn btn-sm w-100 font-sm"
            style="font-weight: bold; color:#171718; background-color: #32D74B"><?=strtoupper($key->category_id);?></button>

    </div>
    <?php }}else{
        echo '<p>Not found !</p>';
    } ?>
</div>
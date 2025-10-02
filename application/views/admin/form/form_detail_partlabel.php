  <?php if($id==''){
    $bg='text-red';
  }else{
    $bg='text-green';
  }
  ?>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="form-group">
          <label for="exampleInputEmail1">Part Detail</label>
          <input id="part_detail" type="text" name="part_detail" class="form-control <?=$bg;?> text-bold"  value="<?=$part_detail;?>" disabled>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Qty/Kbn</label>
          <input id="qty_kbn" type="text" name="qty_kbn" class="form-control <?=$bg;?>"  value="<?=$qty_kbn;?>" disabled>
    </div>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="form-group">
          <label for="exampleInputEmail1">Lot No / Lot Seq</label>
          <input type="hidden" id="id" name="id" value="<?=$id;?>"/>
          <input type="hidden" id="lot_no" name="lot_no" value="<?=$lot_no;?>"/>
          <input type="hidden" id="lot_seq" name="lot_seq" value="<?=$lot_seq;?>"/>
          <input id="lot_no1" type="text" name="lot_no1" class="form-control <?=$bg;?>"  value="<?=$lot_no.' / '.$lot_seq;?>" disabled>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Qty Lot Prod</label>
          <input id="lot_prod" type="text" name="lot_prod" class="form-control <?=$bg;?>"  value="<?=$lot_prod;?>" disabled>
    </div>
  </div>
  
      
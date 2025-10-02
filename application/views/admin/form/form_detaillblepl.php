<?php $remain=$qm->total_prod-$qm->qty_print; ?>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="form-group">
          <label for="exampleInputEmail1">Job No</label>
          <input id="job_no" type="text" name="job_no" class="form-control"  value="<?=$qm->job_no;?>" readonly>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Customer</label>
          <input id="customer_code" type="text" name="customer_code" class="form-control"  value="<?=$qm->customer_code;?>" readonly>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Qty/Kbn</label>
          <input id="qty_kbn" type="text" name="qty_kbn" class="form-control"  value="<?=$qm->qty_kbn;?>" readonly>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Total Prod(box)</label>
          <input id="total_prod" type="text" name="total_prod" class="form-control"  value="<?=$qm->total_prod;?>" readonly>
    </div>
    
  </div>
  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="form-group">
          <label for="exampleInputEmail1">Part Name</label>
          <input id="part_name" type="text" name="part_name" class="form-control"  value="<?=$qm->part_name;?>" readonly>
    </div>
    
    <div class="form-group">
          <label for="exampleInputEmail1">Rack</label>
          <input id="rack_no" type="text" name="rack_no" class="form-control"  value="<?=$qm->store.' '.$qm->rack_no;?>" readonly>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Lot No / Lot Seq</label>
          <input type="hidden" id="id" name="id" value="<?=$id;?>"/>
          <input type="hidden" id="lot_no" name="lot_no" value="<?=$lot_no;?>"/>
          <input type="hidden" id="lot_seq" name="lot_seq" value="<?=$lot_seq;?>"/>
          <input id="lot_no1" type="text" name="lot_no1" class="form-control"  value="<?=$lot_no.' / '.$lot_seq;?>" readonly>
    </div>
    <div class="form-group">
          <label for="exampleInputEmail1">Remain Prod(box)</label>
          <input id="remain" type="text" name="remain" class="form-control"  value="<?=$remain;?>" readonly>
    </div>
  </div>
  <div class="col-12">
    <div class="form-group col-6">
        <label for="exampleInputEmail1">Input Qty Print(box)</label>
        <input id="qty_print" type="number" name="qty_print" class="form-control" min="1" max="<?=$remain;?>" required>
    </div>
</div>
  
      
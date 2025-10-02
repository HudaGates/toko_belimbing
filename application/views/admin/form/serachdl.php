
<label for="exampleInputEmail1">Select Line</label>
<select class="form-control" name="line" id="line"  required="required">
  <option value=""></option>
  <?php foreach($qsh as $key){ ?>
  <option value="<?=$key->ln;?>"><?=$key->ln;?></option>
  <?php } ?>
</select>
                                        
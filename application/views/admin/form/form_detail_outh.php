<div class="modal-header bg-<?= $this->qt->thema; ?>">
  <h4 class="modal-title">UPDATE OTORISASI <?=strtoupper($dm->username);?> </h4>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>

</div>
<div class="modal-body">
  <div class="box">
    <h4><u>Menu <?=$qm->parent.' '.$qm->nav;?></u></h4>
    <?= form_open('otorisasi/subformdetail?api=' . $this->id_t, 'id="mydata"'); ?>
    <input type="hidden" name="csrf_sysx_name" value="<?= $this->security->get_csrf_hash(); ?>">
    <input type="hidden" name="id" value="<?= $id; ?>">
    <div class="box-body">
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">View Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="customRadio1" name="view_level" value="no" <?php if ($dm->view_level == 'no') {
              echo 'checked';
            } ?>>
            <label for="customRadio1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="customRadio2" name="view_level" value="yes" <?php if ($dm->view_level == 'yes') {
                echo 'checked';
              } ?>>
            <label for="customRadio2" class="custom-control-label">YES</label>
          </div>
        </div>
        <div class="col-sm-3">
          <label for="inputPassword3">Add Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="add_level1" name="add_level" value="no" <?php if ($dm->add_level == 'no') {
            echo 'checked';
          } ?>>
            <label for="add_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="add_level2" name="add_level" value="yes" <?php if ($dm->add_level == 'yes') {
            echo 'checked';
          } ?>>
            <label for="add_level2" class="custom-control-label">YES</label>
          </div>
        </div>
      </div>
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">Edit Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="edit_level1" name="edit_level" value="no" <?php if ($dm->edit_level == 'no') {
              echo 'checked';
            } ?>>
            <label for="edit_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="edit_level2" name="edit_level" value="yes" <?php if ($dm->edit_level == 'yes') {
              echo 'checked';
            } ?>>
            <label for="edit_level2" class="custom-control-label">YES</label>
          </div>
        </div>
        <div class="col-sm-3">
          <label for="inputPassword3">Delete Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="delete_level1" name="delete_level" value="no" <?php if ($dm->delete_level == 'no') {
                  echo 'checked';
                } ?>>
            <label for="delete_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="delete_level2" name="delete_level" value="yes" <?php if ($dm->delete_level == 'yes') {
                  echo 'checked';
                } ?>>
            <label for="delete_level2" class="custom-control-label">YES</label>
          </div>
        </div>
      </div>
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">Import Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="import_level1" name="import_level" value="no" <?php if ($dm->import_level == 'no') {
                  echo 'checked';
                } ?>>
            <label for="import_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="import_level2" name="import_level" value="yes" <?php if ($dm->import_level == 'yes') {
                  echo 'checked';
                } ?>>
            <label for="import_level2" class="custom-control-label">YES</label>
          </div>
        </div>
        <div class="col-sm-3">
          <label for="inputPassword3">Print Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="print_level1" name="print_level" value="no" <?php if ($dm->print_level == 'no') {
                echo 'checked';
              } ?>>
            <label for="print_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="print_level2" name="print_level" value="yes" <?php if ($dm->print_level == 'yes') {
                echo 'checked';
              } ?>>
            <label for="print_level2" class="custom-control-label">YES</label>
          </div>
        </div>
      </div>
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">Export Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="export_level1" name="export_level" value="no" <?php if ($dm->export_level == 'no') {
                  echo 'checked';
                } ?>>
            <label for="export_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="export_level2" name="export_level" value="yes" <?php if ($dm->export_level == 'yes') {
                  echo 'checked';
                } ?>>
            <label for="export_level2" class="custom-control-label">YES</label>
          </div>
        </div>
        <div class="col-sm-3">
          <label for="inputPassword3">Delete All</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="del_all1" name="del_all" value="no" <?php if ($dm->del_all == 'no') {
        echo 'checked';
      } ?>>
            <label for="del_all1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="del_all2" name="del_all" value="yes" <?php if ($dm->del_all == 'yes') {
        echo 'checked';
      } ?>>
            <label for="del_all2" class="custom-control-label">YES</label>
          </div>
        </div>
      </div>
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">Other Level</label>
        </div>
        <div class="col-sm-3">
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="other_level1" name="other_level" value="no" <?php if ($dm->other_level == 'no') {
                echo 'checked';
              } ?>>
            <label for="other_level1" class="custom-control-label">NO</label>
          </div>
          <div class="custom-control custom-radio">
            <input class="custom-control-input" type="radio" id="other_level2" name="other_level" value="yes" <?php if ($dm->other_level == 'yes') {
                echo 'checked';
              } ?>>
            <label for="other_level2" class="custom-control-label">YES</label>
          </div>
        </div>
      </div>
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">Field Level</label>
          <code>(column1,,column2,,et.seq)</code>

        </div>
        <div class="col-sm-9">
          <textarea id="field_level" name="field_level" class="form-control" row borders="3" placeholder="Enter ..."><?= $dm->field_level; ?></textarea>
        </div>
      </div>
      <div class="form-group row border">
        <div class="col-sm-3">
          <label for="inputPassword3">Value Level</label>
          <code>(value1|=,,value2|=,,et.seq)</code>
        </div>
        <div class="col-sm-9">
          <textarea id="value_level" name="value_level" class="form-control" row borders="3" placeholder="Enter ..."><?= $dm->value_level; ?></textarea>
        </div>
      </div>

    </div>

    <div class="box-footer width-border">
      <button type="submit" class="btn btn-success" id="save"> Submit </button>
      <button type="button" class="btn btn-danger exit" data-dismiss="modal" aria-label="Close">Cancel</button>
    </div>

    <?= form_close(); ?>
  </div>
</div>
<script type="text/javascript">
  $('#mydata').submit(function(e) {
    e.preventDefault();
    var fa = $(this);
    $.ajax({
      url: fa.attr('action'),
      type: 'post',
      data: fa.serialize(),
      dataType: 'json',
      success: function(response) {
        if (response.success == true) {
          $('.form-group').removeClass('has-error')
            .removeClass('has-success');
          $('.text-danger').remove();
          fa[0].reset();

          swal({
            title: "Update Success",
            type: "success",
            timer: 2000,
            showConfirmButton: false
          });
          $("#myModal1").modal('hide');

        } else {
          $.each(response.messages, function(key, value) {
            var element = $('#' + key);
            element.closest('div.form-group')
              .removeClass('has-error')
              .addClass(value.length > 0 ? 'has-error' : 'has-success')
              .find('.text-danger')
              .remove();
            element.after(value);
          });
        }
      }
    });
  });
</script>
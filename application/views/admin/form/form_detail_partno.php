  <label for="exampleInputEmail1">Pilih Part No & Customer</label>
  <select id="id_part_no" class="form-control" name="id_part_no" required="required">
  <?php foreach ($data_part as $key) { ?>
    <option value="<?=$key->id;?>"><?=$key->part_no .' ('.$key->customer_code.' - '.$key->process.' - '.$key->level.')';?></option>
    <?php } ?>
  </select>
<script  type="text/javascript">
$("#id_part_no").click(function(){
    var id_part_no = $("#id_part_no").val();
    var prod_pic = $("#prod_pic").val();
    $.ajax({
        type: "POST",
        url : "<?=base_url('planning/form_detail_partlabel?api='.$id_t); ?>",
        data: "id_part_no="+id_part_no+"&prod_pic="+prod_pic+"&<?=$this->security->get_csrf_token_name();?>="+cv,
        cache:false,
        success: function(data){
            $('#detail').html(data);
        }
    });
});
</script>
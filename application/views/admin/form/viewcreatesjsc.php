<table class="table table-sm table-bordered" style="width: 100%">
  <tr>
    <th class="text-center" style="width: 1%">No</th>
    <th style="width: 20%">Part_No</th>
    <th class="text-center" style="width: 7%">Delv.<br>(box)</th>
    <th class="text-center" style="width: 7%">Delv<br>(pcs)</th>
    <th class="text-center" style="width: 7%">Total<br>(pcs)</th>
    <th>Part_Name</th>
    <th class="text-center" style="width: 7%">Qty/Kbn<br>(pcs)</th>
    <th class="text-center" style="width: 15%">
      <button class="btn btn-outline-success rounded-pill ms-n3 btnaddform" type="button" title="Add Row">
            <i class="fa fa-plus"></i>
    </th>
  </tr>
  <tbody class="formtambah">
    <?php $k=0; if(!empty($data_table)){ foreach ($data_table as $key) {
            $k=$k+1;
           $rec_qtybox=$key->rec_qtybox;
           if($rec_qtybox<=0){
            $rec_qtybox=$key->delv_qtybox;
           } ?>
          <tr  class="add">
            <td class="text-center">
              <?=$k;?>
            </td>
            <td>
              <input id="id[]" type="hidden" name="id[]" value="<?=$k;?>"/>
              <input id="part_no<?=$k;?>" type="text" class="form-control text-center" name="part_no[]" class="form-control" autocomplete="off" style="padding:0px;" required="required" onclick="partscdetail(<?=$k;?>)" oninput="partscdetail(<?=$k;?>)" onkeypress="partdetail(<?=$k;?>)" value="<?=$key->part_no;?>">              
            </td>   
            <td>
              <input id="delv_qtybox<?=$k;?>" type="number" class="form-control text-center" name="delv_qtybox[]" class="form-control" style="padding:0px;"  required="required" value="<?=$key->delv_qtybox;?>" min="0" max="150" onclick="this.select()" oninput="cekinput(<?=$k;?>)">
              
            </td>
            <td>
              <input id="delv_qtypcs<?=$k;?>" type="number" class="form-control text-center" name="delv_qtypcs[]" class="form-control" style="padding:0px;"  required="required" value="<?=$key->delv_qtypcs;?>" min="0" max="<?=$key->qty_kbn-1;?>" onclick="this.select()"  oninput="cekinput(<?=$k;?>)"  value="0">
              
            </td>
            <td  class="text-center">
               <input  id="total_delv<?=$k;?>" type="number" class="form-control text-center" name="total_delv[]" class="form-control" style="padding:0px;" value="<?=($key->delv_qtybox*$key->qty_kbn)+$key->delv_qtypcs;?>"  disabled>
            </td>
            <td  class="text-center">
               <input  id="part_name<?=$k;?>" type="text" class="form-control text-center" name="part_name[]" class="form-control" style="padding:0px;" value="<?=$key->part_name;?>"  disabled>
            </td>
             <td  class="text-center">
               <input  id="qty_kbn<?=$k;?>" type="number" class="form-control text-center" name="qty_kbn[]" class="form-control" style="padding:0px;" value="<?=$key->qty_kbn;?>"  disabled>
            </td>
            <td  class="text-center">
              <button class="btn btn-outline-danger rounded-pill ms-n3" type="button" title="Remove" onclick="removescview('<?=$table;?>','<?=$key->id;?>')">
                <i class="fa fa-trash"></i>
              </button>
            </td>
          </tr>
        <?php } $baris=$k+$baris; } 
        for($i=$k+1;$i<=$baris;$i++) { ?>
         <tr class="add">
          <td class="text-center">
            <?=$i;?>
          </td>
          <td>
            <input id="id[]" type="hidden" name="id[]" value="<?=$i;?>"/>
            <input id="part_no<?=$i;?>" type="text" class="form-control text-center" name="part_no[]" class="form-control" autocomplete="off" style="padding:0px;" required="required" onclick="partscdetail(<?=$i;?>)" oninput="partscdetail(<?=$i;?>)" onkeypress="partdetail(<?=$i;?>)">
          </td>
          <td class="text-center">
            <input id="delv_qtybox<?=$i;?>" type="number" class="form-control text-center" name="delv_qtybox[]" class="form-control" style="padding:0px;"  required="required" onclick="this.select()"  min="0" max="150" oninput="cekinput(<?=$i;?>)">
          </td>
          <td class="text-center">
            <input id="delv_qtypcs<?=$i;?>" type="number" class="form-control text-center" name="delv_qtypcs[]" class="form-control" style="padding:0px;"  required="required" onclick="this.select()"  min="0" oninput="cekinput(<?=$i;?>)" value="0">
          </td>
          <td>
            <input  id="total_delv<?=$i;?>" type="number" class="form-control text-center" name="total_delv[]" class="form-control" style="padding:0px;"  required="required" disabled>
          </td>
          <td>
            <input  id="part_name<?=$i;?>" type="text" class="form-control text-center" name="part_name[]" class="form-control" style="padding:0px;"  required="required" disabled>
          </td>
          <td>
            <input  id="qty_kbn<?=$i;?>" type="number" class="form-control text-center" name="qty_kbn[]" class="form-control" style="padding:0px;"  required="required" disabled>
          </td>
          <td class="text-center">
            <button  class="btn btn-outline-danger rounded-pill ms-n3 btnhapusform" type="button" title="Remove row (hapus baris dari paling bawah)">
                  <i class="fa fa-trash"></i>
             </button>
          </td>
        </tr>
      <?php } ?>
    </tbody>
</table>
<script type="text/javascript">
  $(document).ready(function(e){
    $('.btnaddform').click(function(e){
      $("#print").prop( "disabled", true );
      $("#save").prop( "disabled", false );
      e.preventDefault();     
      var num = $('.add').length + 1;
      $('.formtambah').append(`
            <tr class="add">
              <td class="text-center">
                `+num+`
              </td>
              <td>
                <input id="id[]" type="hidden" name="id[]" value="`+num+`"/>
                <input id="part_no`+num+`" type="text" class="form-control text-center" name="part_no[]" class="form-control" style="padding:0px;" required="required" onclick="partscdetail(`+num+`)" oninput="partscdetail(`+num+`)"  onkeypress="partdetail(`+num+`)">
              </td>
              <td class="text-center">
                <input id="delv_qtybox`+num+`" type="number" class="form-control text-center" name="delv_qtybox[]" class="form-control" style="padding:0px;"  required="required" onclick="this.select()" min="0" max="150" oninput="cekinput('`+num+`')">
              </td>
              <td class="text-center">
                <input id="delv_qtypcs`+num+`" type="number" class="form-control text-center" name="delv_qtypcs[]" class="form-control" style="padding:0px;"  required="required" onclick="this.select()" min="0" oninput="cekinput('`+num+`')"  value="0">
              </td>
              <td>
                <input  id="total_delv`+num+`" type="number" class="form-control text-center" name="total_delv[]" class="form-control" style="padding:0px;"  disabled>
              </td>
              <td>
                <input  id="part_name`+num+`" type="text" class="form-control text-center" name="part_name[]" class="form-control" style="padding:0px;"  disabled>
              </td>
              <td>
                <input  id="qty_kbn`+num+`" type="number" class="form-control text-center" name="qty_kbn[]" class="form-control" style="padding:0px;"  disabled>
              </td>
              <td class="text-center">
                <button  class="btn btn-outline-danger rounded-pill ms-n3 btnhapusform" type="button" title="Remove row">
                      <i class="fa fa-trash"></i>
                 </button>
              </td>
            </tr>
          `);
      });
      
});
      
$(document).on('click','.btnhapusform',function(e){
  e.preventDefault();
  $(this).parents('tr').remove();
});
//Tambah Form Input
function partscdetail(id){
  $('#part_no'+id).autocomplete({
    source: function (request, response) {

        $.getJSON("master/searchpartsc?query=" + request.term +"&api=<?=$this->id_t;?>"+"&<?=$this->security->get_csrf_token_name();?>="+cv+"&sc=<?=$sc;?>", function (data) {
          //console.log(data);
            response($.map(data, function (value, key) {
                //console.log(value);
                return {
                    value: value.value
                };
            }));
        });
    },
    width: 300,
    max: 20,
    delay: 100,
    minLength: 1,
    autoFocus: true,
    cacheLength: 1,
    scroll: true,
    highlight: false,
    select: function(event, ui) {
      var part_no = ui.value;
     }
  });
  $( "#part_no"+id ).autocomplete( "option", "appendTo", "#myModal" );
   

}
function partdetail(id){
  var part_no = $("#part_no"+id).val();
    $.ajax({
        type: "POST",
        url : "<?=base_url('master/pilihpart?api='.$this->id_t); ?>",
        data: "part_no="+part_no+"&<?=$this->security->get_csrf_token_name();?>="+cv+"&sc=<?=$sc;?>",
        cache:false,
        dataType:'json',
        success: function(data){
          $("#part_name"+id).val(data.part_name);
          $("#qty_kbn"+id).val(data.qty_kbn);
          var qty_kbn = parseInt(data.qty_kbn)-1;
          $("#delv_qtypcs"+id).attr({
             "max" : qty_kbn,        
             "min" : 0          
          });
        }
    });  
}
function cekinput(k) {
    var qty_kbn = parseInt($("#qty_kbn"+k).val());
    var delv_qtybox = parseInt($("#delv_qtybox"+k).val());
    var delv_qtypcs = parseInt($("#delv_qtypcs"+k).val());
    var total = (delv_qtybox * qty_kbn) + delv_qtypcs;
    $("#total_delv"+k).val(total);
  }
</script>
  
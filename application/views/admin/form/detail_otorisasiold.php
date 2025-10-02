   <div class="modal-header  bg-<?=$this->qt->thema;?>">
      <h4 class="modal-title">Update Privileges <?=$username;?></h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" style="overflow: auto">
        <p style="padding:0px;margin:0px">Format Field: <code>column1,,column2,,et.seq</code></p>
        <p style="padding:0px;">Format Value: <code>value1|=,,value2|=,,et.seq</code></p>
        <table id="example1" class="table table-hover table-bordered nowrap compact" style="width:100%;font-size: 14px;border-color: #999">
        <thead >
          <tr>
            <th class="text-center">ID</th>
            <th class="text-left">DAFTAR MENU</th>
            <th class="text-center">VIEW</th>
            <th class="text-center">ADD</th>
            <th class="text-center">EDIT</th>
            <th class="text-center">DELETE</th>
            <th class="text-center">IMPORT</th>
            <th class="text-center">PRINT</th>
            <th class="text-center">EXPORT</th>
            <th class="text-center">CLEAR</th>
            <th class="text-center">FIELD</th>
            <th class="text-center">VALUE</th>
          </tr>
        </thead>          
        <tbody>
          <?php $cek=1; foreach($data_menu as $row){ ?>
          <tr> 
            <td class="text-center"><?=$row->orders;?></td>
            <td class="text-left  <?php if($row->child=='-'){ echo 'text-bold text-green';} ?>"><?=$row->parent.' '.$row->nav; ?></td>
              
              <?php foreach($data_level as $row1){ if($row->username==$row1->username){ ?>
              
              <td class="text-center">
                <?php if($row->view_level=="yes"){ ?>
                <span id="viewuncheck<?=$row->id.$row1->id;?>" onClick="viewuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="viewcheck<?=$row->id.$row1->id;?>" onClick="viewcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }else{ ?>
                <span id="viewcheck<?=$row->id.$row1->id;?>" onClick="viewcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"  class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="viewuncheck<?=$row->id.$row1->id;?>" onClick="viewuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>

              <td class="text-center">
                <?php if($row->add_level=="yes" and $row->tabel!="-"){ ?>
                <span id="adduncheck<?=$row->id.$row1->id;?>" onClick="adduncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="addcheck<?=$row->id.$row1->id;?>" onClick="addcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->add_level=="no" and $row->tabel!="-"){ ?>
                <span id="addcheck<?=$row->id.$row1->id;?>" onClick="addcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="adduncheck<?=$row->id.$row1->id;?>" onClick="adduncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>

              <td class="text-center">
                <?php if($row->edit_level=="yes" and $row->tabel!="-"){ ?>
                <span id="edituncheck<?=$row->id.$row1->id;?>" onClick="edituncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="editcheck<?=$row->id.$row1->id;?>" onClick="editcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->edit_level=="no" and $row->tabel!="-"){ ?>
                <span id="editcheck<?=$row->id.$row1->id;?>" onClick="editcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="edituncheck<?=$row->id.$row1->id;?>" onClick="edituncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>

              <td class="text-center">
                <?php if($row->delete_level=="yes" and $row->tabel!="-"){ ?>
                <span id="deleteuncheck<?=$row->id.$row1->id;?>" onClick="deleteuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="deletecheck<?=$row->id.$row1->id;?>" onClick="deletecheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->delete_level=="no" and $row->tabel!="-"){ ?>
                <span id="deletecheck<?=$row->id.$row1->id;?>" onClick="deletecheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="deleteuncheck<?=$row->id.$row1->id;?>" onClick="deleteuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>
               <td class="text-center">
                <?php if($row->import_level=="yes" and $row->tabel!="-"){ ?>
                <span id="importuncheck<?=$row->id.$row1->id;?>" onClick="importuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="importcheck<?=$row->id.$row1->id;?>" onClick="importcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->import_level=="no" and $row->tabel!="-"){ ?>
                <span id="importcheck<?=$row->id.$row1->id;?>" onClick="importcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="importuncheck<?=$row->id.$row1->id;?>" onClick="importuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>
               <td class="text-center">
                <?php if($row->print_level=="yes" and $row->tabel!="-"){ ?>
                <span id="printuncheck<?=$row->id.$row1->id;?>" onClick="printuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="printcheck<?=$row->id.$row1->id;?>" onClick="printcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->print_level=="no" and $row->tabel!="-"){ ?>
                <span id="printcheck<?=$row->id.$row1->id;?>" onClick="printcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="printuncheck<?=$row->id.$row1->id;?>" onClick="printuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>
               <td class="text-center">
                <?php if($row->export_level=="yes" and $row->tabel!="-"){ ?>
                <span id="exportuncheck<?=$row->id.$row1->id;?>" onClick="exportuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="exportcheck<?=$row->id.$row1->id;?>" onClick="exportcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->export_level=="no" and $row->tabel!="-"){ ?>
                <span id="exportcheck<?=$row->id.$row1->id;?>" onClick="exportcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="exportuncheck<?=$row->id.$row1->id;?>" onClick="exportuncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>
               <td class="text-center">
                <?php if($row->del_all=="yes" and $row->tabel!="-"){ ?>
                <span id="delalluncheck<?=$row->id.$row1->id;?>" onClick="delalluncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                <span id="delallcheck<?=$row->id.$row1->id;?>" onClick="delallcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }elseif($row->del_all=="no" and $row->tabel!="-"){ ?>
                <span id="delallcheck<?=$row->id.$row1->id;?>" onClick="delallcheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                <span id="delalluncheck<?=$row->id.$row1->id;?>" onClick="delalluncheck('<?=$row->id;?>','<?=$row1->id;?>','<?=$row->menuid;?>','<?=$row1->username;?>');"></span>
                <?php }?>
              </td>
              <td class="text-center">
                <?php if($row->tabel!="-"){ ?>
                  <div class="input-group text-sm">                   
                    <input type="text" class="form-control" name="field<?=$row->menuid;?>" id="field<?=$row->menuid;?>"  value="<?=$row->field_level;?>" style="width: 250px !important">
                      <div class="input-group-prepend">
                        <a  class="btn btn-outline-success" onclick="field_level('<?=$row->menuid;?>','<?=$row1->username;?>');" title="save">></a>
                      </div>
                      <!-- /btn-group -->
                  </div>
                <?php }?>
              </td>
              <td class="text-center">
                <?php if($row->tabel!="-"){ ?>
                  <div class="input-group text-sm">
                    <input type="text" class="form-control" name="value<?=$row->menuid;?>" id="value<?=$row->menuid;?>" value="<?=$row->value_level;?>" style="width: 250px !important">
                    <div class="input-group-prepend">
                         <a  class="btn btn-outline-success" onclick="value_level('<?=$row->menuid;?>','<?=$row1->username;?>');" title="save">></a>
                      </div>
                      <!-- /btn-group -->
                  </div>
                <?php }?>
              </td>
              <?php } } $cek=$row->menuid; if($cek!=$row->menuid){ ?>                
          </tr>
        <?php }} ?> 
        </tbody>
      </table>
    </div>
<script type="text/javascript">
 var tinggi = ($(window).height()-340);
  if(tinggi<150){
    var tinggi=150;
  }
$(document).ready(function() {
$('#example1').DataTable({
          "ordering": false,
          "pageLength" :10,
          "lengthMenu":[ [10,15,20, 25, 50, -1], [10,15,20, 25, 50, "All"] ],
          "scrollCollapse":true,
          "paging":true,
          "fixedColumns":false,
          "autoWidth": true,
          "lengthChange": true,
        });

});
$(window).resize(function(){
    var tinggi = ($(window).height()-340);
    if(tinggi<150){
      var tinggi=150;
    }
    $('#example1').closest('.dataTables_scrollBody').css('height',tinggi);
  })
 function viewcheck(id,id1,menuid,username){
          $.ajax({
              type: "POST",
              url : "<?=base_url('otorisasi/viewcheck?api='.$this->id_t); ?>",
              data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
              cache:false,
              success: function(data){
                   $("#viewcheck"+id+id1).hide();
                   $("#viewuncheck"+id+id1).html(data);
                   $("#viewuncheck"+id+id1).show();
              }
          });
      }
 
 function viewuncheck(id,id1,menuid,username){
          $.ajax({
              type: "POST",
              url : "<?=base_url('otorisasi/viewuncheck?api='.$this->id_t); ?>",
              data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
              cache:false,
              success: function(data){
                   $("#viewuncheck"+id+id1).hide();
                   $("#viewcheck"+id+id1).html(data);
                   $("#viewcheck"+id+id1).show();
                    //detail_otorisasi(username);
                   
              }
          });
      }

 function addcheck(id,id1,menuid,username){
          $.ajax({
              type: "POST",
              url : "<?=base_url('otorisasi/addcheck?api='.$this->id_t); ?>",
              data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
              cache:false,
              success: function(data){
                   $("#addcheck"+id+id1).hide();
                   $("#adduncheck"+id+id1).html(data);
                   $("#adduncheck"+id+id1).show();
              }
          });
      }

  function adduncheck(id,id1,menuid,username){
      //alert('addun'+menuid+username);
          $.ajax({
              type: "POST",
              url : "<?=base_url('otorisasi/adduncheck?api='.$this->id_t); ?>",
              data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
              cache:false,
              success: function(data){
                   $("#adduncheck"+id+id1).hide();
                   $("#addcheck"+id+id1).html(data);
                   $("#addcheck"+id+id1).show();
              }
          });
      }

    function editcheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/editcheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#editcheck"+id+id1).hide();
                       $("#edituncheck"+id+id1).html(data);
                       $("#edituncheck"+id+id1).show();
                  }
              });
          }
   
     function edituncheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/edituncheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#edituncheck"+id+id1).hide();
                       $("#editcheck"+id+id1).html(data);
                        $("#editcheck"+id+id1).show();
                  }
              });
          }
     
       function deletecheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/deletecheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#deletecheck"+id+id1).hide();
                       $("#deleteuncheck"+id+id1).html(data);
                       $("#deleteuncheck"+id+id1).show();
                  }
              });
          }
    
      function deleteuncheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/deleteuncheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#deleteuncheck"+id+id1).hide();
                       $("#deletecheck"+id+id1).html(data);
                       $("#deletecheck"+id+id1).show();
                  }
              });
          }

       function importcheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/importcheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#importcheck"+id+id1).hide();
                       $("#importuncheck"+id+id1).html(data);
                       $("#importuncheck"+id+id1).show();
                  }
              });
          }
    
      function importuncheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/importuncheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#importuncheck"+id+id1).hide();
                       $("#importcheck"+id+id1).html(data);
                       $("#importcheck"+id+id1).show();
                  }
              });
          }
         function printcheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/printcheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#printcheck"+id+id1).hide();
                       $("#printuncheck"+id+id1).html(data);
                       $("#printuncheck"+id+id1).show();
                  }
              });
          }
    
      function printuncheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/printuncheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#printuncheck"+id+id1).hide();
                       $("#printcheck"+id+id1).html(data);
                       $("#printcheck"+id+id1).show();
                  }
              });
          }
         function exportcheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/exportcheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#exportcheck"+id+id1).hide();
                       $("#exportuncheck"+id+id1).html(data);
                       $("#exportuncheck"+id+id1).show();
                  }
              });
          }
    
      function exportuncheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/exportuncheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#exportuncheck"+id+id1).hide();
                       $("#exportcheck"+id+id1).html(data);
                       $("#exportcheck"+id+id1).show();
                  }
              });
          }
         function delallcheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/delallcheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#delallcheck"+id+id1).hide();
                       $("#delalluncheck"+id+id1).html(data);
                       $("#delalluncheck"+id+id1).show();
                  }
              });
          }
    
      function delalluncheck(id,id1,menuid,username){
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/delalluncheck?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  success: function(data){
                       $("#delalluncheck"+id+id1).hide();
                       $("#delallcheck"+id+id1).html(data);
                       $("#delallcheck"+id+id1).show();
                  }
              });
          }
    function field_level(menuid,username){
            var val=$("#field"+menuid).val();
            $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/field_level?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&value="+val+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  dataType: 'json',
                   success: function(data){
                            if(data.status == "error") {
                               swal({
                                  title: "Error!",
                                  text: ""+data.msg,
                                  type: "warning",
                                  timer: 1500,
                                  showConfirmButton: false
                                });
                            }else{
                              swal({
                                  title: "Submit Success",
                                  text: "",
                                  type: "success",
                                  timer: 1000,
                                  showConfirmButton: false
                                });
                              
                            }
                       }
              });
          }
    function value_level(menuid,username){
              var val=$("#value"+menuid).val();
              $.ajax({
                  type: "POST",
                  url : "<?=base_url('otorisasi/value_level?api='.$this->id_t); ?>",
                  data: "menuid="+menuid+"&username="+username+"&value="+val+"&<?=$this->security->get_csrf_token_name(); ?>="+cv,
                  cache:false,
                  dataType: 'json',
                   success: function(data){
                            if(data.status == "error") {
                               swal({
                                  title: "Error!",
                                  text: ""+data.msg,
                                  type: "warning",
                                  timer: 1500,
                                  showConfirmButton: false
                                });
                            }else{
                              swal({
                                  title: "Submit Success",
                                  text: "",
                                  type: "success",
                                  timer: 1000,
                                  showConfirmButton: false
                                });
                              
                            }
                       }
              });
          }
</script>

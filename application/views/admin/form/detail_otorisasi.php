   <div class="modal-header  bg-<?= $this->qt->thema; ?>">
     <h4 class="modal-title">Update Privileges <?= $username; ?></h4>
     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
   <div class="modal-body" style="overflow: auto">
     <table id="example1" class="table table-hover table-bordered nowrap compact" style="width:100%;font-size: 14px;border-color: #999">
       <thead>
         <tr>
           <th class="text-center">ID</th>
           <th class="text-left">DAFTAR MENU</th>
           <th class="text-center">VIEW</th>
           <th class="text-center">ACTION</th>
         </tr>
       </thead>
       <tbody>
         <?php $cek = 1;
          foreach ($data_menu as $row) { ?>
           <tr>
             <td class="text-center"><?= $row->orders; ?></td>
             <td class="text-left  <?php if ($row->child == '-') {
                                      echo 'text-bold text-green';
                                    } ?>">
                                    <?php if ($row->child == '-') { echo $row->parent; }else{ echo $row->parent. ' ' . $row->nav; } ?></td>

             <?php foreach ($data_level as $row1) {
                if ($row->username == $row1->username) { ?>
                 <td class="text-center">
                   <?php if ($row->view_level == "yes") { ?>
                     <span id="viewuncheck<?= $row->id . $row1->id; ?>" onClick="viewuncheck('<?= $row->id; ?>','<?= $row1->id; ?>','<?= $row->menuid; ?>','<?= $row1->username; ?>');" class="btn btn-sm btn-flat"><i class="fas fa-check text-green"></i></span>
                     <span id="viewcheck<?= $row->id . $row1->id; ?>" onClick="viewcheck('<?= $row->id; ?>','<?= $row1->id; ?>','<?= $row->menuid; ?>','<?= $row1->username; ?>');"></span>
                   <?php } else { ?>
                     <span id="viewcheck<?= $row->id . $row1->id; ?>" onClick="viewcheck('<?= $row->id; ?>','<?= $row1->id; ?>','<?= $row->menuid; ?>','<?= $row1->username; ?>');" class="btn btn-sm btn-flat"><i class="fa fa-times text-red"></i></span>
                     <span id="viewuncheck<?= $row->id . $row1->id; ?>" onClick="viewuncheck('<?= $row->id; ?>','<?= $row1->id; ?>','<?= $row->menuid; ?>','<?= $row1->username; ?>');"></span>
                   <?php } ?>
                 </td>

                 <td class="text-center">
                   <?php if ($row->tabel !== "-") { ?>
                     <button class="btn btn-sm  btn-outline-success" onclick="formdetail('<?= $row->idb; ?>');" title="Edit"><i class="fas fa-pencil-alt"></i> DETAIL</button>
                   <?php  } ?>
                 </td>


               <?php }
              }
              $cek = $row->menuid;
              if ($cek != $row->menuid) { ?>
           </tr>
       <?php }
            } ?>
       </tbody>
     </table>
   </div>
   <script type="text/javascript">
     var tinggi = ($(window).height() - 340);
     if (tinggi < 150) {
       var tinggi = 150;
     }
     $(document).ready(function() {
       $('#example1').DataTable({
         "ordering": false,
         "pageLength": 10,
         "lengthMenu": [
           [10, 15, 20, 25, 50, -1],
           [10, 15, 20, 25, 50, "All"]
         ],
         "scrollCollapse": true,
         "paging": true,
         "fixedColumns": false,
         "autoWidth": true,
         "lengthChange": true,
       });

     });
     $(window).resize(function() {
       var tinggi = ($(window).height() - 340);
       if (tinggi < 150) {
         var tinggi = 150;
       }
       $('#example1').closest('.dataTables_scrollBody').css('height', tinggi);
     })

     function viewcheck(id, id1, menuid, username) {
       $.ajax({
         type: "POST",
         url: "<?= base_url('otorisasi/viewcheck?api=' . $this->id_t); ?>",
         data: "menuid=" + menuid + "&username=" + username + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
         cache: false,
         success: function(data) {
           $("#viewcheck" + id + id1).hide();
           $("#viewuncheck" + id + id1).html(data);
           $("#viewuncheck" + id + id1).show();
         }
       });
     }

     function viewuncheck(id, id1, menuid, username) {
       $.ajax({
         type: "POST",
         url: "<?= base_url('otorisasi/viewuncheck?api=' . $this->id_t); ?>",
         data: "menuid=" + menuid + "&username=" + username + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
         cache: false,
         success: function(data) {
           $("#viewuncheck" + id + id1).hide();
           $("#viewcheck" + id + id1).html(data);
           $("#viewcheck" + id + id1).show();
           //detail_otorisasi(username);

         }
       });
     }

     function formdetail(id) {
       $.ajax({
         async: true,
         type: "POST",
         url: "<?= base_url('otorisasi/formdetail?api=' . $this->id_t); ?>",
         data: "id=" + id + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
         cache: false,
         success: function(data) {
           $("#view1").html(data);
           $("#myModal1").modal('show');

         }

       });
     }

   </script>
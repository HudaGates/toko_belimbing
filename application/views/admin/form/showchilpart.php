<div class="modal-header">
  Detail Parent Part #<?= $q->part_no_child ?>
  <button type="button" class="close exit" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
<div class="modal-body">
<div class="border-info p-1">

<table id="example4"  class="table table-hover table-striped table-bordered compact text-center" style="width:100%;font-size: 14px">
    <thead>
        <tr class="bg-gray">
            <th>no</th>
            <th>part_no_fg</th>
            <th>part_no_parent</th>
            <th>part_no_child</th>
            <th>store</th>
            <th>process</th>
            <th>line</th>
            <th>Calc</th>
            <th>qty_kbn</th>
            <th>stock_prod</th>
            <th>stock_store</th>
            <th>total_prod</th>
            <th>total_print</th>
        </tr>
    </thead>
    <tbody>
        <?php $i=1; foreach ($qsh as $key) {  ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $key->part_no_fg ?></td>
            <td><?= $key->part_no_parent ?></td>
            <td><?= $key->part_no_child ?></td>
            <td><?= $key->store ?></td>
            <td><?= $key->process ?></td>
            <td><?= $key->line ?></td>
            <td><?= $key->seq_calc ?></td>
            <td><?= $key->qty_kbn ?></td>
            <td><?= $key->stock_prod ?></td>
            <td><?= $key->stock_store ?></td>
            <td><?= $key->total_prod ?></td>
            <td><?= $key->qty_print ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
</div>
</div>
<script>
$(document).ready(function() {
    var table3 = $('#example4').DataTable({
        dom: '<"top"Blf>rt<"bottom"ip><"clear">',
        buttons:[
        {
              extend: 'excel',
              text: '<span class="text-dark"><i class="fa fa-file-excel text-info mr-1"></i> Excel</span>',
              titleAttr: 'Export Excel',
              className: 'btn-space'
             
          }
        ],
        scrollCollapse: true,
        paging:true, 
        autoWidth: true,
        pageResize: true,
        lengthMenu: [ [10,15,20, 25, 50, -1], [10,15,20, 25, 50, "All"] ],
        pageLength:15,
        
        responsive: false,
        order: [],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        colReorder: false,
    });
});

</script>
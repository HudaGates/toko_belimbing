<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 pr-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-handshake fa-lg mr-1"></i><?= $nav; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pl-2 pr-2 pt-1 pb-1">
                        <!-- start form -->
                        <div class="row">
                            <table border=0 style="width: 100%">
                                <tr>
                                    <td class="p-1" style="width: 16%; ">
                                        <div onclick="filter('SUBMIT PR')" class="p-1 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        SUBMITED
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpr_count->submit ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-primary"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-arrow-up"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 16%; ">
                                        <div onclick="filter('On Going')" class="p-1 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        ON GOING
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpr_count->ongoing ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-warning"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-globe"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 16%; ">
                                        <div onclick="filter('Reject')" class="p-1 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        REJECT
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpr_count->reject ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-danger"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-times"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 16%; ">
                                        <div onclick="filter('Approve')" class="p-1 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        APPROVE
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpr_count->approve ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-success"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-check"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 16%; ">
                                        <div onclick="filter('Publish')" class="p-1 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        PUBLISH
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpr_count->publish ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-info"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-globe"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 20%; ">
                                        <div onclick="filter('Close')" class="p-1 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        CLOSE
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpr_count->close ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-success"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-clipboard-check"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                        </div>
                        <!-- end form -->
                        <hr class="my-2">
                        <table id="example" class="table table-hover table-bordered nowrap compact  text-sm"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
                                    foreach ($data_field as $row) { 
                                        if($row->name!='comment' and $row->name!='approval'){
                                        echo "<th>" . strtoupper($row->name) . "</th>";
                                    }} ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <?php
                                    foreach ($data_field as $row) {
                                        if($row->name!='comment' and $row->name!='approval'){
                                        echo "<th>" . strtoupper($row->name) . "</th>";
                                    }} ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <div class="col-lg-7 pl-0">
                <div class="card">
                    <div class="card-header">
                        <h3 id="title_t_r" class="card-title"><i class="fas fa-copy"></i> Detail PR </h3>
                    </div>
                        <!-- start form -->
                    <div class="card-body  pl-2 pr-2 pt-1 pb-1" id="form_approval">
                    </div>
                    <!-- end form -->
                    <div class="card-body  pl-2 pr-2 pt-0 pb-1">
                        <table id="example1" class="table table-hover table-bordered nowrap compact  text-sm"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>SUPPLIER_CODE</th>
                                    <th>PART_NO</th>
                                    <th>PART_DETAIL</th>
                                    <th class="p-1">UNIT</th>
                                    <th class="p-1">QTY_PACK</th>
                                    <th>QTY_PR</th>
                                    <th>QTY_ORDER</th>
                                    <th>QTY_PO</th>
                                    <th>STOCK</th>
                                    <th>MIN_STOCK</th>
                                    <th>PO_NO</th>
                                    <th>DELV.DATE</th>
                                    <th>STATUS</th>
                                    <th>PR_NO</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>SUPPLIER_CODE</th>
                                    <th>PART_NO</th>
                                    <th>PART_DETAIL</th>
                                    <th>UNIT</th>
                                    <th>QTY_PACK</th>
                                    <th>QTY_PR</th>
                                    <th>QTY_ORDER</th>
                                    <th>QTY_PO</th>
                                    <th>STOCK</th>
                                    <th>MIN_STOCK</th>
                                    <th>PO_NO</th>
                                    <th>DELV.DATE</th>
                                    <th>STATUS</th>
                                    <th>PR_NO</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="modal fade" id="myModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                <div class="modal-content" id="view">

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="myModal1">
            <div class="modal-dialog modal-xl  modal-dialog-scrollable">
                <div class="modal-content" id="view1">

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript" language="javascript" class="init">
var editor;
var editor1;
var tinggi = ($(window).height() - 495);
  if(parseInt(tinggi)<150){
    var tinggi=150;
  }
$(window).resize(function(){
    var tinggi = ($(window).height()-495);
    if(parseInt(tinggi)<150){
      var tinggi=150;
    }
    if (parseInt($('#example').css('height')) < tinggi) {
            $('.dataTables_scrollBody').css('height', tinggi);
            $('.dataTables_scrollBody').css('max-height', tinggi);
        }
  }) 
function buttonEO(pr_no) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('procurement/prvlgEO?api=' . $this->id_t); ?>",
        data: "pr_no=" + pr_no +
            "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        dataType: 'json',
        success: function(res) {
            return res.edit;
        }
    });


}
$('#example1 tfoot th').each(function() {
    var title = $(this).text();
    if (title != '') {
        $(this).html(
            '<input type="text" placeholder="Search" class="form-control input-xs text-sm" style="height: 25px !important;"/>'
        );
    }

});

editor1 = new $.fn.dataTable.Editor({
    ajax: {
        url: "<?= base_url('Ajax/tData?table=' . $table1 . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
        type: "POST",
        data: function(d) {
            d.csrf_sysx_name = cv;
        }

    },
    table: "#example1",
    fields: [
        {
            label: "id:",
            name: "id",
            type: "hidden"
        },
        {
            label: "price:",
            name: "price",
            type: "hidden"
        },
        {

            label: "pr_no:",
            name: "pr_no",
            type: 'readonly',
            attr: {
                disabled: true
            }
        },
        {

            label: "part_no:",
            name: "part_no",
            type: 'readonly',
            attr: {
                disabled: true
            }
        },
        {

            label: "qty_pr:",
            name: "qty_pr",
            type: 'readonly',
            attr: {
                disabled: true
            }
        },
         {

            label: "unit:",
            name: "satuan",
            type: 'readonly',
            attr: {
                disabled: true
            }
        },
         {

            label: "qty_pack:",
            name: "qty_packing",
            type: 'readonly',
            attr: {
                disabled: true
            }
        },
        {

            label: "qty_order:",
            name: "qty_order",
        },


    ]
});

// Activate an inline edit on click of a table cell
$('#example1').on('click', 'tbody td.editable:not(:first-child)', function(e) {
    editor1.inline(this, {
        onBlur: 'submit',
        submit: 'allIfChanged'
    });


});

table1 = $('#example1').DataTable({
    dom: '<"top"Blf>rt<"bottom"ip><"clear">',
    ajax: {
        url: "<?= base_url('Ajax/tData?table=' . $table1 . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
        type: "POST",
        data: csfrData,

    },
    processing: true,
    "language": {
        'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="text-green">Processing ...</span> '
    },
    //if sqlserver serverside false
    serverSide: true,
    scrollY: tinggi-90,
    scrollX: true,
    paging: true,
    autoWidth: true,
    pageResize: true,
    lengthMenu: [
        [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, -1],
        [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, "All"]
    ],
    pageLength: 15,

    responsive: false,
    order: [
        [1, 'desc']
    ],
    columns: [
        {
            data: null,
            defaultContent: '',
            className: 'select-checkbox',
            orderable: false,
            searchable: false,

        },
        {
            data: "supplier_code",
        },
        {
            data: "part_no",
            orderable: false,            
        },
        {
            data: "part_detail",
            orderable: false,
        },
        {
            data: "satuan",
            orderable: false,
        },
        {
            data: "qty_packing",
            orderable: false,
        },
        {
            data: "qty_pr",
        },
        {
            data: "qty_order",
            className: 'editx'
        },
        {
            data: "qty_po",
        },
        {
            data: "stock",
        },
        {
            data: "min_stock",
        },        
        {
            data: "po_no",
        },
        {
            data: "delv_date",
        },
        {
            data: "status",
        },
         {
            data: "pr_no",
        },
    ],
    select: {
        style: 'os',
        selector: 'td:first-child'
    },
    colReorder: true,
    buttons: [{
            extend: "edit",
            text: "<span class='text-green'>Set Order</span>",
            editor: editor1,
            formButtons: [{
                    text: '<span class="btn btn-outline-danger">Cancel</span>',
                    action: function() {
                        this.close();
                    }
                },
                '<span class="btn btn-outline-success">Submit</span>',
            ]
        },
        {
            extend: "selectedSingle",
            text: '<i class="fas fa-search text-green"></i>',
            titleAttr: 'Print Document',
            action: function() {
                var idx = table.cell('.selected', 0).index();
                var data = table.row(idx.row).data();
                showpr(data.pr_no);
            }
        },
        {
          extend: 'excel',
          text: '<span class="text-dark"><i class="fa fa-file-excel text-success mr-1"></i></span>',
          titleAttr: 'Export Excel',
          className: 'btn-space'
         
        },
        {
            extend: 'selectAll',
            className: 'btn-space text-green'
        },
        'selectNone',
    ],



    initComplete: function() {
        // Apply the search
        this.api().columns().every(function() {
            var that = this;

            $('input', this.footer()).on('keyup change clear', function() {
                if (that.search() !== this.value) {
                    that
                        .search(this.value)
                        .draw();
                }
            });
        });
    }

});

table1.on('select', function(e, dt, type, indexes) {
    var username = "<?= $this->username; ?>";
    var idx = table.cell('.selected', 0).index();
    var data = table.row(idx.row).data();
    $.ajax({
        type: "POST",
        url: "<?= base_url('procurement/prvlgEO?api=' . $this->id_t); ?>",
        data: "pr_no=" + data.pr_no +
            "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        dataType: 'json',
        success: function(res) {
            //console.log(data.pictl_time);
            if (data.pictl_by == username && res.edit == true) {
                table1.button(0).enable();
                $(".editx").removeClass('readonly');
                $(".editx").addClass('editable');
            } else {
                table1.button(0).disable();
                $(".editx").removeClass('editable');
                $(".editx").addClass('readonly');
            }
        }
    });


});

// use a global for the submit and return data rendering in the examples
$(document).ready(function() {
    detailpr('x.x');

    $('#example tfoot th').each(function() {
        var title = $(this).text();
        if (title != '') {
            $(this).html(
                '<input type="text" placeholder="Search" class="form-control input-xs text-sm" style="height: 25px !important;"/>'
            );
        }

    });

    editor = new $.fn.dataTable.Editor({
        ajax: {
            url: "<?= base_url('Ajax/tData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
            type: "POST",
            data: function(d) {
                d.csrf_sysx_name = cv;
            }

        },
        table: "#example",
        fields: [
            <?php foreach ($data_field as $row) {
                    if ($row->name == 'id') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "hidden"
            },
            <?php } elseif ($row->name == 'update_by') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "hidden",
            },
            <?php } elseif ($row->name == 'update_time') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "hidden",
            },
            <?php } elseif ($row->type == 'text') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "text",
            },
            <?php } elseif ($row->type == 'char') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "select",
            },
            <?php } elseif ($row->type == 'year') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: 'YYYY',

            },
            <?php } elseif ($row->type == 'date') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: 'YYYY-MM-DD',

            },
            <?php } elseif ($row->type == 'datetime') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: 'YYYY-MM-DD HH:mm:ss',
                fieldInfo: 'style date with 24 hour clock',
                opts: {
                    minutesIncrement: 1,
                    secondsIncrement: 1
                }

            },
            <?php } elseif ($row->type == 'time') { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
                type: "datetime",
                format: 'HH:mm:ss',
                fieldInfo: '24 hour clock format with seconds',
                opts: {
                    minutesIncrement: 1,
                    secondsIncrement: 1
                }

            },
            <?php } else { ?> {
                label: "<?= $row->name; ?>:",
                name: "<?= $row->name; ?>",
            },
            <?php }
                } ?>

        ]
    });

    table = $('#example').DataTable({
        dom: '<"top"B>lfrt<"bottom"ip><"clear">',
        ajax: {
            url: "<?= base_url('Ajax/tData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
            type: "POST",
            data: csfrData,

        },
        processing: true,
        "language": {
            'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="text-green">Processing ...</span> '
        },
        //if sqlserver serverside false
        serverSide: true,
        scrollY: tinggi,
        scrollX: true,
        paging: true,
        autoWidth: true,
        pageResize: true,
        lengthMenu: [
            [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, -1],
            [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, "All"]
        ],
        pageLength: 15,

        responsive: false,
        order: [
            [1, 'desc']
        ],
        columns: [{
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false,
                searchable: false,

            },
            <?php foreach ($data_field as $row) {
             if($row->name!='comment' and $row->name!='approval'){    
                if ($row->name == 'update_time') {
                    ?> {
                    data: "<?= $row->name; ?>"
                },
                <?php } elseif ($row->name == 'update_by') { ?> {
                    data: "<?= $row->name; ?>"
                },
                <?php } else { ?> {
                    data: "<?= $row->name; ?>",
                    className: 'editable'
                },
                <?php } }
                } ?>
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            {
              extend: 'excel',
              text: '<span class="text-dark"><i class="fa fa-file-excel text-success mr-1"></i></span>',
              titleAttr: 'Export Excel',
              className: 'btn-space'
             
            },
            {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            'selectNone',
            <?php if ($get_o->delete_level == 'yes') { ?> 
            {
                extend: "remove",
                text: '<i class="fas fa-trash text-red"></i>',
                titleAttr: 'Delete Row',
                editor: editor,
                formButtons: [{
                        text: '<span class="btn btn-outline-danger">Cancel</span>',
                        action: function() {
                            this.close();
                        }
                    },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } ?> {
                extend: "selectedSingle",
                text: '<i class="fas fa-print text-green"></i>',
                titleAttr: 'Print Document',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    print_l(data.id, '<?= $table; ?>');
                }
            },
            {
              text: '<span class="text-dark"><i class="fa fa-spinner fa-rotate-90 text-success mr-1"></i></span>',
              titleAttr: 'Refresh All',
              action: function() {
                  table.columns('').search('').draw();
              }
          }
        ],

        initComplete: function() {
            // Apply the search
            this.api().columns().every(function() {
                var that = this;

                $('input', this.footer()).on('keyup change clear', function() {
                    if (that.search() !== this.value) {
                        that
                            .search(this.value)
                            .draw();
                    }
                });
            });
        }

    });

    table.on('deselect', function(e, dt, type, indexes) {
        detailpr('x.x');
    });
    table.on('select', function(e, dt, type, indexes) {
        var idx = table.cell('.selected', 0).index();
        var data = table.row(idx.row).data();
        openpr(data.id, data.pr_no, data.status, data.picshop_by, data.picshop_time, data.remark,
            data.role_code);
    });

});



function openpr(id, pr_no, status, picshop_by, picshop_time, remark, role_code) {
    var pr_no = pr_no;
    var role_code = role_code;
    detailpr(pr_no);
    formapprv(pr_no, role_code);
    $("#title_t_r").html('<i class="fas fa-copy"></i> Detail PR ' + pr_no);
}

function detailpr(val) {
    table1.columns(14).search(val).draw();

}

function filter(val) {
    table.columns(5).search(val).draw();
}

function showpr(pr_no) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('procurement/showpr?api=' . $this->id_t); ?>",
        data: "pr_no=" + pr_no + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}
function loadtask(pr_no,role_code){
$.ajax({
        type: "POST",
        url : "<?=base_url('procurement/formapprv?api='.$this->id_t); ?>",
        data: "pr_no="+pr_no+"&role_code="+role_code+"&<?=$this->security->get_csrf_token_name();?>="+cv,
        cache:false,
        success: function(data){
            $("#task").html(data);
            
        }
    });
}
function formapprv(pr_no, role_code) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('procurement/formapprv?api=' . $this->id_t); ?>",
        data: "pr_no=" + pr_no + "&role_code=" + role_code +
            "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $("#form_approval").html(data);
        }
    });
}
</script>
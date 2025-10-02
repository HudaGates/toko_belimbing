<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-5 pr-1">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cart-plus fa-lg mr-1"></i><?= $nav; ?></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body pl-2 pr-2 pt-1 pb-1">
                        <!-- start form -->
                        <div class="row">
                            <table border=0 style="width: 100%">
                                <tr>
                                    <td class="p-1" style="width: 25%; ">
                                        <div onclick="filter('Create')" class="p-2 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        CREATE
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpo_count->createx ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-primary"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-arrow-up"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 25%; ">
                                        <div onclick="filter('Publish')" class="p-2 rounded"
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
                                                        <?= $qpo_count->publish ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-warning"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-globe"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 25%; ">
                                        <div onclick="filter('Delivery')" class="p-2 rounded"
                                            style="border: #dedede 1px solid; cursor: pointer">
                                            <table border=0 style="width: 100%; border-collapse: collapse;">
                                                <tr>
                                                    <td colspan=2 class="p-0 m-0" style="font-size: 0.8rem;">
                                                        DELIVERY
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td class="p-0 m-0 text-bold"
                                                        style="width: 60%; font-size: 1.6rem;">
                                                        <?= $qpo_count->delivery ?>
                                                    </td>
                                                    <td rowspan="2" class="p-0 m-0 text-center text-info"
                                                        style="width: 40%; font-size: 1.4rem;">
                                                        <i class="fa fa-truck"></i>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                    <td class="p-1" style="width: 25%; ">
                                        <div onclick="filter('Close')" class="p-2 rounded"
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
                                                        <?= $qpo_count->close ?>
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
                        <hr class="mt-1 mb-2">
                        <table id="example" class="table table-hover table-bordered nowrap compact  text-sm"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php
                                    foreach ($data_field as $row) {
                                        echo "<th>" . strtoupper($row->name) . "</th>";
                                    } ?>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <?php
                                    foreach ($data_field as $row) {
                                        echo "<th>" . strtoupper($row->name) . "</th>";
                                    } ?>
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
                        <h3 id="title_t_r" class="card-title"><i class="fas fa-copy"></i> Detail Order</h3>
                    </div>
                    <div class="card-body p-2 ">
                        <!-- start form -->
                        <div class="row card-body border ml-0 mr-0 pb-2 pt-2">                    
                            <div class="col-lg-6 p-1" id="summary">
                                <table border=0
                                    style="width: 100%; height: 100%; font-size: 0.8rem; border: 0px #dedede solid;border-collapse: collapse;border-spacing: 0px;">
                                    <tr>
                                        <td style="width: 20%;">
                                            NO
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-po" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            DATE
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-po-date" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            STATUS
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-po-status" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            BY
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-po-by" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-lg-6 p-1">
                                <table border=0
                                    style="width: 100%; height: 100%; font-size: 0.8rem; border: 0px #dedede solid">
                                    <tr>
                                        <td style="width: 20%;">
                                            SUBTOTAL
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-subtotal" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            DISCOUNT
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-discount" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            PPN (11%)
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-ppn" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            EXT
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-ext" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <b>TOTAL</b>
                                        </td>
                                        <td style="font-size: 0.8rem">
                                            <div id="d-total" class="border">
                                                <h6 class="p-1 m-0">-</h6>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- end form -->
                        <hr class="mt-2 mb-2">
                        <table id="example1" class="table table-hover table-bordered nowrap compact  text-sm"
                            style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>DELV.DATE</th>
                                    <th>SUPPLIER_CODE</th>
                                    <th>PART_NO</th>
                                    <th>PART_DETAIL</th>
                                    <th>UNIT</th>
                                    <th>QTY_PACK</th>
                                    <th>QTY_PO</th>
                                    <th>QTY_DELV</th>
                                    <th>QTY_REC</th>
                                    <th>PRICE</th>
                                    <th>TOTAL_PRICE</th>                                 
                                    <th>PO_NO</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th></th>
                                    <th>DELV.DATE</th>
                                    <th>SUPPLIER_CODE</th>
                                    <th>PART_NO</th>
                                    <th>PART_DETAIL</th>
                                    <th>UNIT</th>
                                    <th>QTY_PACK</th>
                                    <th>QTY_PO</th>
                                    <th>QTY_DELV</th>
                                    <th>QTY_REC</th>
                                    <th>PRICE</th>
                                    <th>TOTAL_PRICE</th>                                 
                                    <th>PO_NO</th>
                                    <th>STATUS</th>
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
    fields: [{
            label: "id:",
            name: "id",
            type: "hidden"
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

            label: "qty_po:",
            name: "qty_po",
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
    scrollY: tinggi-70,
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
        {
            data: "delv_date",
        },        {
            data: "supplier_code",
        },
        {
            data: "part_no",
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
            data: "qty_po",
            orderable: false,
            className: 'text-right',
            render: $.fn.dataTable.render.number(',')
        },
        {
            data: "qty_delv",
            className: 'text-right',
            render: $.fn.dataTable.render.number(',')
        },
        {
            data: "qty_rec",
            className: 'text-right',
            render: $.fn.dataTable.render.number(',')
        },
        
        {
            data: "price",
            orderable: false,
        },
        {
            data: "total_price",
            orderable: false,
            className: 'text-right',
            render: $.fn.dataTable.render.number(',')
        },
        {
            data: "po_no",
            orderable: false,
        },
        {
            data: "status",
        }
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
        {
            extend: "selected",
            text: "<i class='fas fa-tags text-green'>SKM</i>",
            className: 'btn btn-print',
            titleAttr: 'Print Label SKM',
            action: function() {
                var id = [];
                var data = table1.rows('.selected').data();
                for (var i = 0; i < data.length; i++) {
                    id.push(data[i].id);
                }
                print_l(id, 'label_skm');
            }
        },
        {
              text: '<span class="text-dark"><i class="fa fa-spinner fa-rotate-90 text-success mr-1"></i></span>',
              titleAttr: 'Refresh All',
              action: function() {
                  table.row('.selected').remove().draw(false);
                  table1.columns('').search('').draw();
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
table1.on('select', function(e, dt, type, indexes) {
    var idx = table.cell('.selected', 0).index();
    if(idx){
        var data = table.row(idx.row).data();
        var myarr = data.po_no.split("/");
        var xx = myarr[1].split("-");
        if(data.publish_date!=null && xx[0]=='SKM'){
            table1.button(3).enable();
        }else{
            table1.button(3).disable();
        }
    }
    
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
        dom: '<"top"Blf>rt<"bottom"ip><"clear">',
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
            <?php }
                } ?>
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            {   
                extend:"selectedSingle",
                text: "<span class='text-green'>SJ</span> <sup><i class='fa fa-plus text-purple'></i></sup>",
                className: 'btn btn-cs text-green',
                titleAttr: 'Create Surat Jalan',
                action: function() {
                     var idx = table.cell('.selected', 0).index();
                     var data = table.row(idx.row).data();
                    formsj(data.po_no);
                }
            },
            {
                extend: "selectedSingle",
                text: '<i class="fas fa-print text-green"></i>',
                titleAttr: 'Print PO/SKM',
                action: function() {
                    var id =[];
                  var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                      id.push(data[i].id);
                    }
                  print_l(id,'<?=$table;?>');
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
            <?php if ($get_o->delete_level == 'yes') { ?> {
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
            <?php } ?> 

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
        var username ="<?=$this->username;?>";
        var idx = table.cell('.selected', 0).index();
        var data = table.row(idx.row).data();
        if(data.publish_date!=null){
            table.button(1).enable();
        }else if(username==data.po_by && data.publish_date==null){
            table.button(0).disable();
            table.button(1).enable();
        }else if(username==data.supplier_code && data.publish_date!=null){
            table.button(0).disable();
            table.button(1).enable();
        }else{
            table.button(0).disable();
            table.button(1).disable();
        }
        //console.log(data.id)
        openpo(data.id, data.po_no, data.po_date, data.status, data.po_by, data.sub_total,
            data.discount, data.ppn, data.ext, data.total, );
    });

});


function openpo(id, po_no, po_date, status, po_by, subtotal, discount, ppn, ext, total) {
    // Create our number formatter.
    var to_idr = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
    });
    detailpr(po_no);
    
    $("#d-po").html(`<h6 class="p-1 m-0">${po_no}</h6> `);
    $("#d-po-status").html(`<h6 class="p-1 m-0">${status}</h6> `);
    $("#d-po-by").html(`<h6 class="p-1 m-0">${po_by.toUpperCase()}</h6> `);
    $("#d-po-date").html(`<h6 class="p-1 m-0">${po_date}</h6> `);
    $("#d-status").html(`<h6 class="p-1 m-0">${status.toUpperCase()}</h6> `);
    // right
    $("#d-subtotal").html(`<h6 class="p-1 m-0">${to_idr.format(subtotal)}</h6> `);
    $("#d-discount").html(`<h6 class="p-1 m-0">${to_idr.format(discount)}</h6> `);
    $("#d-ppn").html(`<h6 class="p-1 m-0">${to_idr.format(ppn)}</h6> `);
    $("#d-ext").html(`<h6 class="p-1 m-0">${to_idr.format(ext)}</h6> `);
    $("#d-total").html(`<h5 class="p-1 m-0 text-bold">${to_idr.format(total)}</h5> `);

}

function detailpr(val) {
    table1.columns(12).search(val).draw();
}

function filter(val) {
    table.columns(5).search(val).draw();
}

function formsj(po_no) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('procurement/formsj?api=' . $this->id_t); ?>",
        data: "po_no=" + po_no+"&menuid=<?=$menuid;?>&<?= $this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');
        }
    });
}
</script>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body p-1">
                        <table id="example" class="display nowrap compact table-sm compact table-striped table-bordered"
                            style="width:100%;font-size: 12px">
                            <thead>
                                <tr>
                                    <th></th>
                                    <?php foreach($data_field as $row){ 
                              if ($row->name != 'password') {
                                echo "<th>".strtoupper($row->name)."</th>";
                              }} ?>
                                </tr>
                            </thead>
                            <tfoot style="height: 24px;">
                                <tr>
                                    <th></th>
                                    <?php foreach($data_field as $row){ 
                              if ($row->name != 'password') {
                                echo "<th>".strtoupper($row->name)."</th>";
                              }} ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal fade" id="myModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">>
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content" id="view">

                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->

<script type="text/javascript" language="javascript" class="init">
var editor;
var editstock;
var tinggi = ($(window).height() - 425);
if (parseInt(tinggi) < 150) {
    var tinggi = 150;
}
$(window).resize(function() {
    var tinggi = ($(window).height() - 425);
    if (parseInt(tinggi) < 150) {
        var tinggi = 150;
    }
    if (parseInt($('#example').css('height')) < tinggi) {
        $('.dataTables_scrollBody').css('height', tinggi);
        $('.dataTables_scrollBody').css('max-height', tinggi);
    }
})

function selectColumns(editor, csv, header) {
    var selectEditor = new $.fn.dataTable.Editor();
    var fields = editor.order();

    for (var i = 1; i < fields.length; i++) {
        var field = editor.field(fields[i]);
        if (field.name() != 'update_by' && field.name() != 'update_time') {
            selectEditor.add({
                label: field.label(),
                name: field.name(),
                type: 'select',
                options: header,
                def: header[i]
            });
        }


    }

    selectEditor.create({
        title: 'Map CSV fields',
        buttons: 'Import ' + csv.length + ' records',
        message: 'Select the CSV column you want to use the data from for each field.',
        onComplete: 'none'
    });

    selectEditor.on('submitComplete', function(e, json, data, action) {
        // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
        editor.create(csv.length, {
            title: 'Confirm import',
            buttons: 'Submit',
            message: 'Click the <i>Submit</i> button to confirm the import of ' + csv.length +
                ' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
        });

        for (var i = 1; i < fields.length; i++) {
            var field = editor.field(fields[i]);
            var mapped = data[field.name()];
            if (field.name() != 'update_by' && field.name() != 'update_time') {
                for (var j = 0; j < csv.length; j++) {
                    field.multiSet(j, csv[j][mapped]);
                }
            }
        }

    });
}
// use a global for the submit and return data rendering in the examples
$(document).ready(function() {
    $('#example tfoot th').each(function() {
        var title = $(this).text();
        if (title != '') {
            $(this).html(
                '<input type="text" placeholder="Search" class="form-control form-control-sm input-sm" style="height: 24px !important;"/>'
            );
        }

    });
    editstock = new $.fn.dataTable.Editor({
        ajax: {
            url: "<?= base_url('Ajax/tData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
            type: "POST",
            data: function(d) {
                d.csrf_sysx_name = cv;
            }

        },
        table: "#example",
        fields: [{
                label: "id:",
                name: "id",
                type: "hidden"
            },
            {
                label: "PartNoFsi:",
                name: "part_no_fsi",
                type: "readonly"
            },
            {
                label: "Stock:",
                name: "stock",
                type: "text"
            },
        ]
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
    var uploadEditor = new $.fn.dataTable.Editor({
        fields: [{
            label: 'CSV file:',
            name: 'csv',
            type: 'upload',
            ajax: function(files) {
                // Ajax override of the upload so we can handle the file locally. Here we use Papa
                // to parse the CSV.
                Papa.parse(files[0], {
                    header: true,
                    skipEmptyLines: true,
                    complete: function(results) {
                        if (results.errors.length) {
                            console.log(results);
                            uploadEditor.field('csv').error(
                                'CSV parsing error: ' + results.errors[0]
                                .message);
                        } else {
                            selectColumns(editor, results.data, results.meta
                                .fields);
                        }
                    }
                });
            }
        }]
    });
    <?php if ($get_o->edit_level == 'yesx') { ?>
    // Activate an inline edit on click of a table cell
    $('#example').on('click', 'tbody td.editable:not(:first-child)', function(e) {
        editor.inline(this, {
            onBlur: 'submit',
            submit: 'allIfChanged'
        });
    });
    <?php } ?>

    $.fn.dataTable.ext.errMode = 'none';
    var table = $('#example').on('error.dt', function(e, settings, techNote, message) {
        swal({
            title: "",
            text: "" + message,
            type: "error",
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Close',
            showConfirmButton: true
        });
    }).DataTable({
        dom: '<"top"QBlf>rt<"bottom"ip><"clear">',
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
            <?php if ($get_o->add_level == 'yes') {
              if ($table == 'tbl_report_production') { ?> {
                text: 'Add Data',
                className: 'btn btn-cs text-green',
                titleAttr: 'Add Manual Seat',
                action: function() {
                    formreprod('<?= $table; ?>');
                }
            },
            <?php } elseif ($table == 'tbl_delvtosubcont') { ?> {
                text: 'Receiving',
                className: 'btn btn-cs text-green',
                titleAttr: 'Reciving Part',
                action: function() {
                    formrecsjsc('<?= $table; ?>');
                }
            },
            <?php } elseif ($table == 'view_finish_setting') { ?> {
                extend: "selectedSingle",
                text: 'Finish Setting',
                className: 'btn btn-cs text-green',
                titleAttr: 'Finish Setting',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    formfinishset(data.order_no);
                }
            },
            <?php } elseif ($table == 'tbl_h_stopart') { ?> {
                extend: "create",
                text: "<span class='text-green'>New</span>",
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
            {
                text: 'Docking',
                className: 'btn btn-cs text-green',
                titleAttr: 'Docking STO Part',
                action: function() {
                    formdockingpart('<?= $table; ?>');
                }
            },
            <?php } elseif ($table == 'tbl_h_stomat') { ?> {
                extend: "create",
                text: "<span class='text-green'>New</span>",
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
            {
                text: 'Docking',
                className: 'btn btn-cs text-green',
                titleAttr: 'Docking STO Mat',
                action: function() {
                    formdockingmat('<?= $table; ?>');
                }
            },
            <?php } elseif ($table == 'tbl_h_beritaacara') {
                ?> {
                extend: "selectedSingle",
                text: 'Judge',
                className: 'btn btn-cs text-green',
                titleAttr: 'Judge Stock Problem',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    if (data.status == 'Open') {
                        formjudgeba(data.id, '<?= $table; ?>');
                    }
                }
            },
            <?php } elseif ($table == 'tbl_delvtoyoska') {
                if ($get_o->value_level != '') { ?> {
                text: 'Cretae DN',
                className: 'btn btn-cs text-green',
                titleAttr: 'Create Delivery Note',
                action: function() {
                    formcreatesjsc('<?= $table; ?>');
                }
            },
            <?php } ?>

            <?php } else { ?> {
                extend: "create",
                text: "<span class='text-green'>New</span>",
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
            <?php }
            }
            if ($get_o->edit_level == 'yes') { 
             if($table=='tbl_stock_part'){ ?> {
                extend: "selectedSingle",
                text: "<span class='text-green'>Order Part</span>",
                titleAttr: 'Order Part',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    if (data.status == 'Need Order') {
                        formorderpart(data.part_no_fsi, '<?= $table; ?>');
                    }
                }
            },
            {
                extend: "edit",
                text: "<span class='text-green'>Edit Stock</span>",
                editor: editstock,
                formTitle: '<h3>Form Edit Stock</h3>',
                formButtons: [{
                        text: '<span class="btn btn-outline-danger">Cancel</span>',
                        action: function() {
                            this.close();
                        }
                    },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php }else{ ?> {
                extend: "edit",
                text: "<span class='text-green'>Edit</span>",
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
            <?php } }
            if ($get_o->delete_level == 'yes') { ?> {
                extend: "remove",
                text: "<span class='text-red'>Delete</span>",
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
            <?php }
            if ($get_o->export_level == 'yes') { ?> {
                extend: 'collection',
                text: "<span class='text-green'>Export</span>",
                buttons: [
                    'copy',
                    'excel',
                ]
            },
            <?php }
            if ($get_o->import_level == 'yes') { 
              if($table=='tbl_stock_part'){ ?> {
                text: 'Upload Stock',
                className: 'text-green',
                titleAttr: 'Update Stock Part',
                action: function() {
                    formuploadstock('<?= $table; ?>');
                }
            },
            <?php }else{ ?> {
                text: "<span class='text-green'>Import CSV</span>",
                action: function() {
                    uploadEditor.create({
                        title: "CSV file import <a href='<?= base_url() ?>formatexcel/<?= $table; ?>.csv' class='btn btn-outline-info' title='Download Format file csv'><span class='fa fa-file-excel-o fa-lg'></span>Download format file</a>"
                    });
                    uploadEditor.field('csv').input().val('');

                }
            },
            <?php } } ?> {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            'selectNone',
            <?php if ($get_o->print_level == 'yes') {
              if ($table == 'tbl_history_sale') { ?> {
                extend: "selectedSingle",
                text: "<i class='fas fa-print text-green'></i>",

                titleAttr: 'Print Selected',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    print_l(data.id, '<?= $table; ?>');
                }
            },
            {

                text: '<i class="fas fa-print text-green"></i> Bulanan',
                titleAttr: 'Print Laporan Bulanan',
                action: function() {
                    formprintreportmonthly()
                }
            },
            {

                text: '<i class="fas fa-print text-green"></i> Harian',
                titleAttr: 'Print Laporan Harian',
                action: function() {
                    formprintreportdaily()
                }
            },
            <?php } elseif ($table == 'tbl_history_sale') { ?> {
                text: 'Reprint SJ',
                className: 'btn btn-cs text-green',
                titleAttr: 'Print SJ',
                action: function() {
                    form_reprint_sj('<?= $table; ?>');
                }
            },
            <?php } elseif ($table == 'tbl_delvtosubcont') { ?> {
                text: 'Print SJ',
                className: 'btn btn-cs text-green',
                titleAttr: 'Print SJ',
                action: function() {
                    print_sjsc('<?= $table; ?>');
                }
            },
            <?php } elseif ($table == 'tbl_history_sale') { ?> {
                text: 'Print Report',
                className: 'btn btn-sm btn-cs text-green',
                titleAttr: 'Print Report',
                action: function() {
                    // print_sjsc('<?= $table; ?>');
                    formprintreport()
                    console.log('tes')
                }
            },

            <?php } elseif ($table == 'tbl_delvtoyoska') { ?> {
                extend: "selectedSingle",
                text: "Print DN",
                titleAttr: 'Re-Print DN',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    if (data.sj_date != null) {
                        print_l(data.id, '<?= $table; ?>');
                    }
                }
            },
            <?php } elseif ($table == 'tbl_stock_part') { ?> {
                extend: "selectedSingle",
                text: "Print Label",
                titleAttr: 'Print Label',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    if (data.status == 'On Delivery') {
                        print_l(data.part_no_fsi, '<?= $table; ?>');
                    }
                }
            },
            <?php }
            }
            if ($get_o->del_all == 'yesx') {  ?> {
                text: '<i class="fas fa-trash-alt  text-red"></i>',
                className: 'btn btn-default',
                titleAttr: 'Clear All',
                action: function() {
                    del_all('<?= $table; ?>');
                }
            }
            <?php } ?>
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

});

function formorderpart(part_no_fsi, table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formorderpart?api=' . $this->id_t); ?>",
        data: "part_no_fsi=" + part_no_fsi + "&table=" + table +
            "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function form_reprint_sj(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('s_print/form_reprint_sj?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function print_sjsc(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('s_print/form_print_sjsc?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function print_labelsc(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('s_print/form_print_labelsc?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formjudgeba(id, table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formjudgeba?api=' . $this->id_t); ?>",
        data: "id=" + id + "&table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formuploadstock(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formuploadstock?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv +
            "&val=<?=$get_o->value_level; ?>",
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formcreatesjsc(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formcreatesjsc?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv +
            "&val=<?= $get_o->value_level; ?>",
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formdockingpart(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formdockingpart?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formdockingmat(table) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formdockingmat?api=' . $this->id_t); ?>",
        data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formfinishset(order_no) {
    $.ajax({
        type: "POST",
        url: "<?= base_url('master/formfinishset?api=' . $this->id_t); ?>",
        data: "order_no=" + order_no + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formprintreportmonthly() {
    $.ajax({
        type: "POST",
        url: "<?= base_url('report/formprintreportmonthly?api=' . $this->id_t); ?>",
        data: "<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formprintreportdaily() {
    $.ajax({
        type: "POST",
        url: "<?= base_url('report/formprintreportdaily?api=' . $this->id_t); ?>",
        data: "<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}
</script>
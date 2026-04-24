 
 <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!--<div class="card-header">
                <h3 class="card-title">Master <?= $nav; ?></h3>
              </div>
               /.card-header -->
                        <div class="card-body p-2">
                            <table id="example" class="display nowrap compact table-sm compact table-striped"
                                style="width:100%;white-space:nowrap; font-size: 13px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php
                      foreach ($data_field as $row) {
                        if ($row->name != 'password' and $row->name != 'idcard'  and $row->name != 'email' and $row->name != 'sign') {
                          echo "<th>" . strtoupper($row->name) . "</th>";
                        }
                      } ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <?php
                      foreach ($data_field as $row) {
                        if ($row->name != 'password' and $row->name != 'idcard'  and $row->name != 'email' and $row->name != 'sign') {
                          echo "<th>" . strtoupper($row->name) . "</th>";
                        }
                      } ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="modal fade" id="myModal" data-toggle="modal" data-backdrop="static"
                        data-keyboard="false">
                        <div class="modal-dialog modal-lg modal-dialog-scrollable">
                            <div class="modal-content" id="view">

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div class="modal fade" id="myModal1">
                        <div class="modal-dialog modal-lg  modal-dialog-scrollable">
                            <div class="modal-content" id="view1">

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
var tinggi = ($(window).height() - 425);
if (parseInt(tinggi) < 150) {
    var tinggi = 150;
}
$(window).resize(function() {
    var tinggi = ($(window).height() - 425);
    if (parseInt(tinggi) < 150) {
        var tinggi = 150;
    }
    if (parseInt($('#example').css('height')) >= tinggi) {
        $('.dataTables_scrollBody').css('height', tinggi);
        $('.dataTables_scrollBody').css('max-height', tinggi);
    }
});

function selectColumns(editor, csv, header) {
    var selectEditor = new $.fn.dataTable.Editor();
    var fields = editor.order();

    for (var i = 0; i < fields.length; i++) {
        var field = editor.field(fields[i]);

        selectEditor.add({
            label: field.label(),
            name: field.name(),
            type: 'select',
            options: header,
            def: header[i]
        });
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

        for (var i = 0; i < fields.length; i++) {
            var field = editor.field(fields[i]);
            var mapped = data[field.name()];

            for (var j = 0; j < csv.length; j++) {
                field.multiSet(j, csv[j][mapped]);
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
                '<input type="text" placeholder="Search" class="form-control input-sm" style="height: 25px !important;"/>'
            );
        }

    });

    editor = new $.fn.dataTable.Editor({
        ajax: {
            url: "<?= base_url('Ajax/sData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
            type: "POST",
            data: function(d) {
                // INI DIA KUNCI AJAIBNYA (Dibuat otomatis ngikutin server)
                d['<?= $this->security->get_csrf_token_name(); ?>'] = cv;
            }

        },
        table: "#example",
        responsive: true,
        fields: [
            {
                label: "id:",
                name: "id",
                type: "hidden"
            },
            {
                label: "username:",
                name: "username",
                type: "text",
            },
            {
                label: "password:",
                name: "password",
                type: "text",
            },
            {
                label: "nama:",
                name: "nama",
                type: "text",
            },
            {
                label: "nik:",
                name: "nik",
                type: "text",
            },
            {
                label: "shift:",
                name: "shift",
                type: "select",
            },
            {
                label: "Image:",
                name: "image",
                type: "upload",
                display: function(file_id) {
                    return '<a href="' + editor.file('files', file_id).web_path +
                        '?id=<?=time();?>' +
                        '"  target="_blank" title="View File"><img src="' + editor.file('files',
                            file_id).web_path + '?id=<?=time();?>" style="width:150px;height:100px"/></a>';
                },
                clearText: "Clear",
                noImageText: 'No image',
            },
            {
                label: "user_level:",
                name: "user_level",
                type: "select",
            }

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
                    delimiter: ';',
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
    <?php if ($get_o->edit_level == 'yess') { ?>
    // Activate an inline edit on click of a table cell
    $('#example').on('click', 'tbody td.editable:not(:first-child)', function(e) {
        editor.inline(this, {
            onBlur: 'submit',
            submit: 'allIfChanged'
        });
    });
    <?php } ?>

    var table = $('#example').DataTable({
        dom: '<"top"QBlf>rt<"bottom"ip><"clear">',
        ajax: {
            url: "<?= base_url('Ajax/sData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
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
            [10, 15, 20, 25, 50, -1],
            [10, 15, 20, 25, 50, "All"]
        ],
        pageLength: 15,

        responsive: false,
        order: [],
        columns: [{
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false,
                searchable: false,
            },
            <?php 
            foreach ($data_field as $row) {
              if ($row->name != 'password' and $row->name != 'idcard'  and $row->name != 'email' and $row->name != 'sign') {
                if ($row->name == 'image') { ?> {
                data: "image",
                render: function(file_id) {
                    if (file_id) {
                        return file_id ?
                            '<a href="' + editor.file('files', file_id).web_path +
                            '?id=<?=time();?>' +
                            '"  target="_blank" title="View File"><image src="' +
                            editor.file('files', file_id).web_path +
                            '?id=<?=time();?>" style="width:50px;"></a>' :
                            null;
                    }
                },
                defaultContent: "No image",
                title: "IMAGE",
            },

            <?php } elseif ($row->name == 'sign') { ?> {
                data: "sign",
                render: function(file_id) {
                    if (file_id) {
                        return file_id ?
                            '<a href="' + editor.file('files', file_id).web_path +
                            '"  target="iframe_a" onclick="filex()" title="View File"><image src="' +
                            editor.file('files', file_id).web_path +
                            '" style="width:50px;"></a>' :
                            null;
                    }
                },
                defaultContent: "No image",
                title: "SIGN",
            },
            <?php } elseif ($row->name == 'user_group') { ?> {
                data: "<?= $row->name; ?>"
            },
            <?php } elseif ($row->name == 'user_area') { ?> {
                data: "<?= $row->name; ?>"
            },
            <?php } elseif ($row->name == 'registrasi') { ?> {
                data: "<?= $row->name; ?>"
            },
            <?php } elseif ($row->name == 'log_in') { ?> {
                data: "<?= $row->name; ?>"
            },
            <?php } elseif ($row->name == 'log_out') { ?> {
                data: "<?= $row->name; ?>"
            },
            <?php } else { ?> {
                data: "<?= $row->name; ?>",
                className: 'editable'
            },

            <?php }
              }
            } ?>
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            <?php if ($get_o->add_level == 'yes') { ?> {
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
            if ($get_o->edit_level == 'yes') { ?> {
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
            <?php }
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
                    'csv',
                    'pdf',
                    'print'
                ]
            },
            <?php }
            if ($get_o->import_level == 'yes') { ?>,

            {
                text: "<span class='text-green'>Import CSV</span>",
                action: function() {
                    uploadEditor.create({
                        title: "CSV file import <a href='<?= base_url() ?>formatexcel/<?= $table; ?>.csv' class='btn btn-outline-info' title='Download Format file csv'><span class='fa fa-file-excel-o fa-lg'></span>Download format file</a>"
                    });
                }
            },
            <?php } ?> {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            'selectNone',
            <?php if ($get_o->print_level == 'yes') { ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print ID Card',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, '<?=$table;?>');
                }
            },
            <?php } if ($this->user_level == 'Administrator') { ?> {
                extend: "selectedSingle",
                text: "<i class='fa  fa-cog text-orange'></i>",
                className: 'btn btn-print',
                titleAttr: 'Privilege',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    privilege(data.id, data.username);
                }
            },
            <?php } if ($get_o->del_all == 'yesx') {  ?> {
                text: '<i class="fas fa-trash-alt  text-red"></i>',
                className: 'btn btn-default',
                titleAttr: 'Clear',
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

function privilege(id, user) {
    $.ajax({
        async: true,
        type: "POST",
        url: "<?= base_url('otorisasi?api=' . $this->id_t); ?>",
        data: "id=" + id + "&user=" + user + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
        cache: false,
        success: function(data) {
            $("#view").html(data);
            $("#myModal").modal('show');

        }

    });
}
    </script>
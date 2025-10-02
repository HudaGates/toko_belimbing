    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Update <?=$nav;?></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-1">
                            <input type="hidden" name="idx" id="idx">
                            <table id="example" class="display nowrap compact table-sm compact table-striped"
                                style="width:100%;font-size: 13px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php foreach($data_field as $row){ if($row->name!='id' AND $row->name!='password' AND $row->name!='idcard' AND $row->name!='sign' AND $row->name!='email'){
                                echo "<th>".strtoupper($row->name)."</th>";
                                }
                              } ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>

                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
var tinggi = ($(window).height() - 470);
if (tinggi < 150) {
    var tinggi = 150;
}

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
        message: 'Select the CSV column you want to use the data from for each field.'
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
    var cv = '<?=$this->security->get_csrf_hash(); ?>';
    editor = new $.fn.dataTable.Editor({
        ajax: {
            url: "<?=base_url('Ajax/pData?api='.$id_t);?>",
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
                label: "Nama:",
                name: "nama"
            },
            {
                label: "NIK:",
                name: "nik"
            },
            {
                label: "Username:",
                name: "username"
            },
            {
                label: "Password:",
                name: "password",
                type: "password"
            },
            {
                label: "Shift:",
                name: "shift",
                type: "select",
            },
            {
                label: "Image:",
                name: "image",
                type: "upload",
                display: function(file_id) {
                    return '<img src="' + editor.file('files', file_id).web_path + '"/>';
                },
                clearText: "Clear",
                noImageText: 'No image',
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
                    complete: function(results) {
                        if (results.errors.length) {
                            console.log(results);
                            uploadEditor.field('csv').error(
                                'CSV parsing error: ' + results.errors[0]
                                .message);
                        } else {
                            uploadEditor.close();
                            selectColumns(editor, results.data, results.meta
                                .fields);
                        }
                    }
                });
            }
        }]
    });



    var table = $('#example').DataTable({
        dom: '<"top"Blf>rt<"bottom"ip><"clear">',
        ajax: {
            url: "<?=base_url('Ajax/pData?api='.$id_t);?>",
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
            <?php foreach($data_field as $row){ if($row->name!='id' AND $row->name!='password' AND $row->name!='idcard' AND $row->name!='sign' AND $row->name!='email'){
              if($row->name!='image'){ ?> {
                data: "<?=$row->name;?>"
            },
            <?php }else{ ?> {
                data: "image",
                render: function(file_id) {
                    return file_id ?
                        '<img src="' + editor.file('files', file_id).web_path +
                        '" style="width:30px;"/>' :
                        null;
                },
                defaultContent: "No image",
                title: "Image"
            },
            <?php } } } ?>
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [

            {
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
            {
                text: "<span class='text-green'>Print</span>",
                className: 'dt-button buttons-select-none btn-print',
                titleAttr: 'Print Label',
                action: function() {
                    var id = $('#idx').val();
                    print_l(id);
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
    $(".btn-print").attr("disabled", true);
    $('#example').on('click', '.select-checkbox', function() {
        var selectedRows = table.rows({
            selected: true
        }).count();
        if (selectedRows === 0) {
            $(".btn-print").removeAttr("disabled");
            var id = table.row(this).id().replace("row_", "");
        } else {
            $(".btn-print").attr("disabled", true);
            $(".btn-print").addClass("text-muted");
            var id = '';
        }


        $('#idx').val(id);

    });

});

$(window).resize(function() {
    var tinggi = ($(window).height() - 470);
    if (tinggi < 150) {
        var tinggi = 150;
    }
    $('#example').closest('.dataTables_scrollBody').css('height', tinggi);
})

function print_l(id) {
    swal({
            title: "Are you sure?",
            text: "Print",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes',
            closeOnConfirm: true,
            //closeOnCancel: false
        },
        function() {
            window.open("<?=base_url('s_print/'.$table);?>?id=" + id + "&api=<?=$id_t;?>", "_blank");

        });
}
    </script>
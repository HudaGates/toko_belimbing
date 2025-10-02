    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example" class="table table-hover table-bordered nowrap compact" style="width:100%;font-size: 14px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <?php foreach ($data_field as $row) {
                                            echo "<th>" . strtoupper($row->name) . "</th>";
                                        } ?>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <?php foreach ($data_field as $row) {
                                            echo "<th>" . strtoupper($row->name) . "</th>";
                                        } ?>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <div class="modal fade" id="myModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content" id="view">

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <div class="modal fade" id="myModal1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content" id="view1">

                            </div>
                            <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    <!-- /.content -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <script type="text/javascript" language="javascript" class="init">
        var editor;
        var tinggi = ($(window).height() - 445);
        if (parseInt(tinggi) < 150) {
            var tinggi = 150;
        }
        $(window).resize(function() {
            var tinggi = ($(window).height() - 445);
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
                message: 'Select the CSV column you want to use the data from for each field.'
            });

            selectEditor.on('submitComplete', function(e, json, data, action) {
                // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
                editor.create(csv.length, {
                    title: 'Confirm import',
                    buttons: 'Submit',
                    message: 'Click the <i>Submit</i> button to confirm the import of ' + csv.length + ' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
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
                    $(this).html('<input type="text" placeholder="Search" class="form-control input-sm" style="height: 2 5px !important;"/>');
                }

            });
            editor = new $.fn.dataTable.Editor({
                ajax: {
                    url: "<?= base_url('Ajax/plData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
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
                        <?php } elseif ($row->name == 'file') { ?> {
                                label: "File:",
                                name: "file",
                                type: "upload",
                                display: function(file_id) {
                                    return '<img src="' + editor.file('files', file_id).web_path + '"/>';
                                },
                                clearText: "Clear",
                                noImageText: 'No File',
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
                        <?php } elseif ($row->name == 'source_current') { ?> {
                                label: "<?= $row->name; ?>:".toUpperCase(),
                                name: "<?= $row->name; ?>",
                                type: "select",
                                options: [{
                                        label: "tbl_planning",
                                        value: "tbl_planning"
                                    },
                                    {
                                        label: "tbl_planning_special",
                                        value: "tbl_planning_special"
                                    }
                                ]
                            },
                        <?php } elseif ($row->name == 'airbag') { ?> {
                                label: "<?= $row->name; ?>:".toUpperCase(),
                                name: "<?= $row->name; ?>",
                                type: "select",
                                options: [{
                                        label: "NO",
                                        value: "NO"
                                    },
                                    {
                                        label: "VFC(R)",
                                        value: "VFC"
                                    },
                                    {
                                        label: "VFD(L)",
                                        value: "VFD"
                                    }
                                ]
                            },
                        <?php } elseif ($row->name == 'source_plan') { ?> {
                                label: "<?= $row->name; ?>:".toUpperCase(),
                                name: "<?= $row->name; ?>",
                                type: "select",
                                options: [{
                                        label: "",
                                        value: ""
                                    },
                                    {
                                        label: "tbl_planning",
                                        value: "tbl_planning"
                                    },
                                    {
                                        label: "tbl_planning_special",
                                        value: "tbl_planning_special"
                                    }

                                ]
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
                            delimiter: ';',
                            skipEmptyLines: true,
                            complete: function(results) {
                                if (results.errors.length) {
                                    console.log(results);
                                    uploadEditor.field('csv').error('CSV parsing error: ' + results.errors[0].message);
                                } else {
                                    uploadEditor.close();
                                    selectColumns(editor, results.data, results.meta.fields);
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

            // Upload Editor - triggered from the import button. Used only for uploading a file to the browser

            var table = $('#example').DataTable({
                dom: '<"top"QBlf>rt<"bottom"ip><"clear">',
                ajax: {
                    url: "<?= base_url('Ajax/plData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
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
                    [10, 15, 20, 25, 50, 100, 500, 1000, 5000, 10000, -1],
                    [10, 15, 20, 25, 50, 100, 500, 1000, 5000, 10000, "All"]
                ],
                pageLength: 15,

                responsive: false,
                order: [
                    [1, 'desc']
                ],
                columns: [{
                        data: null,
                        defaultContent: '',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            return '<input type="checkbox">';
                        }
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
                        if ($table == 'tbl_history_partlabel') { ?> {
                                text: 'Create Label',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Create Part Label',
                                action: function() {
                                    form_create_partlabel();
                                }
                            },
                        <?php } elseif ($table == 'tbl_order_customer') { ?> {
                                text: 'Reguler',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Reguler Order',
                                action: function() {
                                    form_reguler_order('<?= $table; ?>');
                                }
                            },
                            {
                                text: 'Add Order',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Add Order',
                                action: function() {
                                    form_add_order('<?= $table; ?>');
                                }
                            },
                        <?php } elseif ($table == 'tbl_po_partnp') { ?> {
                                text: 'Up PO',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Upload PO',
                                action: function() {
                                    form_upload_ponp('<?= $table; ?>');
                                }
                            },
                        <?php } elseif ($table == 'tbl_release_order') { ?> {
                                text: 'Up SO',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Upload PO',
                                action: function() {
                                    form_upload_so('<?= $table; ?>');
                                }
                            },
                            {
                                text: 'Re-Email',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Re-email',
                                action: function() {
                                    formreemail('');
                                }
                            },
                        <?php } elseif ($table == 'tbl_calc_material') { ?> {
                                text: 'Calc Order',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Calculation Order',
                                action: function() {
                                    form_calc('<?= $table; ?>');
                                }
                            },
                            {
                                text: 'Release Order',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Release Order',
                                action: function() {
                                    release('<?= $table; ?>')
                                }
                            },
                            {
                                text: 'Re-Email',
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Re-email',
                                action: function() {
                                    reemail('<?= $table; ?>');
                                }
                            },
                        <?php }
                    } else { ?> {
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
                    if ($get_o->import_level == 'yess') { ?> {
                            text: 'Import Excel',
                            titleAttr: 'Import Planning',
                            action: function() {
                                formupload('<?= $table; ?>');
                            }
                        },
                    <?php } ?> {
                        extend: 'selectAll',
                        className: 'btn-space text-green'
                    },
                    'selectNone',
                    <?php if ($get_o->print_level == 'yes') {
                        if ($table == 'tbl_history_partlabel') { ?> {
                                extend: "selectedSingle",
                                text: "<i class='fas fa-print text-green'></i>",
                                className: 'btn btn-print',
                                titleAttr: 'Print Label',
                                action: function() {
                                    var idx = table.cell('.selected', 0).index();
                                    var data = table.row(idx.row).data();
                                    print_l(data.id, '<?= $table; ?>');
                                }
                            },
                            {
                                extend: "selectedSingle",
                                text: '<i class="fas fa-print text-green"></i>',
                                titleAttr: 'Print All Label',
                                action: function() {
                                    var idx = table.cell('.selected', 0).index();
                                    var data = table.row(idx.row).data();
                                    print_l(data.id + '_all', '<?= $table; ?>');
                                }
                            },
                        <?php } elseif ($table == 'tbl_order_customer') { ?> {
                                text: "<i class='fas fa-print text-green'></i>",
                                className: 'btn btn-cs text-green',
                                titleAttr: 'Create SJ',
                                action: function() {
                                    form_print_sj();
                                }
                            },
                        <?php } elseif ($table == 'tbl_release_order') { ?> {
                                extend: "selectedSingle",
                                text: "<i class='fas fa-print text-green'></i>",
                                className: 'btn btn-print',
                                titleAttr: 'Print Label',
                                action: function() {
                                    var idx = table.cell('.selected', 0).index();
                                    var data = table.row(idx.row).data();
                                    print_l(data.id, '<?= $table; ?>');
                                }
                            },
                        <?php }
                    }
                    if ($get_o->del_all == 'yes') {  ?> {
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

        function form_reguler_order(table) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/regulerorder?api=' . $this->id_t); ?>",
                data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_add_order(table) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/addorder?api=' . $this->id_t); ?>",
                data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_create_partlabel() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/form_create_partlabel?api=' . $this->id_t); ?>",
                data: "<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_print_sj() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/form_print_sj?api=' . $this->id_t); ?>",
                data: "<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function formreemail() {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/formreemail?api=' . $this->id_t); ?>",
                data: "<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_upload_po(table) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/formuploadpo?api=' . $this->id_t); ?>",
                data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_upload_ponp(table) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/formuploadponp?api=' . $this->id_t); ?>",
                data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_upload_so(table) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/formuploadso?api=' . $this->id_t); ?>",
                data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function form_calc(table) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/formcalc?api=' . $this->id_t); ?>",
                data: "table=" + table + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                success: function(data) {
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');

                }
            });
        }

        function print_sj(lotid) {
            swal({
                    title: "Are you sure print?",
                    text: "Surat Jalan Lotid " + lotid,
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Yes',
                    closeOnConfirm: true,
                    //closeOnCancel: false
                },
                function() {
                    window.open("<?= base_url('s_print/reprintsj'); ?>?lotid=" + lotid + "&api=<?= $this->id_t; ?>", "_blank");

                });
        }

        function release(table1) {
            $("#view").html('<div class="modal-body text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>');
            $("#myModal").modal('show');
            swal({
                    title: "Are you sure?",
                    text: "Release Order to Supplier!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Yes',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {

                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('planning/release?api=' . $this->id_t); ?>",
                        data: "table1=" + table1 + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                        cache: false,
                        dataType: 'json',
                        success: function(data) {

                            if (data.success == false) {
                                $("#view").html('<div class="modal-header"><h4 class="text-red">Error !!</h4><button type="button" class="close exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div><div class="modal-body text-center">' + data.messages + ' </div>');
                            } else {

                                if (data.email == true) {
                                    swal({
                                        title: "Release Order Success",
                                        type: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    $("#myModal").modal('hide');
                                    $('#example').DataTable().ajax.reload();
                                } else {
                                    $("#view").html('<div class="modal-header"><h4 class="text-red">Koneksi Email Error !!</h4><button type="button" class="close exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div><div class="modal-body text-center">' + data.email + ' </div>');
                                }

                            }
                        }
                    });
                });
        }

        function reemail(table1) {
            $("#view").html('<div class="modal-body text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>');
            $("#myModal").modal('show');
            swal({
                    title: "Are you sure?",
                    text: "Re-Email Release Order to Supplier!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'Yes',
                    closeOnConfirm: true,
                    closeOnCancel: true
                },
                function() {


                    $.ajax({
                        type: "POST",
                        url: "<?= base_url('planning/r_email?api=' . $this->id_t); ?>",
                        data: "table1=" + table1 + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                        cache: false,
                        dataType: 'json',
                        success: function(data) {

                            if (data.success == false) {
                                $("#view").html('<div class="modal-header"><h4 class="text-red">Error !!</h4><button type="button" class="close exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div><div class="modal-body text-center">' + data.messages + ' </div>');
                            } else {
                                $("#view").html('<div class="modal-body text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>');
                                if (data.email == true) {
                                    swal({
                                        title: "Release Order Success",
                                        type: "success",
                                        timer: 2000,
                                        showConfirmButton: false
                                    });
                                    $("#myModal").modal('hide');
                                } else {
                                    $("#view").html('<div class="modal-header"><h4 class="text-red">Koneksi Email Error !!</h4><button type="button" class="close exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div><div class="modal-body text-center">' + data.email + ' </div>');
                                }
                            }
                        }
                    });
                });
        }
    </script>
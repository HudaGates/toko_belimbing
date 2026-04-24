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
                <div class="modal fade" id="myModal">
                    <div class="modal-dialog modal-lg">
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
var tinggi = ($(window).height() - 410);
if (parseInt(tinggi) < 150) {
    var tinggi = 150;
}
$(window).resize(function() {
    var tinggi = ($(window).height() - 410);
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
                '<input type="text" placeholder="Search" class="form-control form-control-sm m-0" style="height: 24px !important; border: 0; border-radius: 0;"/>'
            );
        }

    });

    editor = new $.fn.dataTable.Editor({
        ajax: {
            url: "<?=base_url('Ajax/mData?table='.$table.'&api='.$this->id_t.'&menuid='.$menuid);?>",
            type: "POST",
            data: function(d) {
                d.csrf_sysx_name = cv;
            }

        },
        table: "#example",
        fields: [
            <?php foreach($data_field as $row){
            $nm=explode('_',$row->name);
          if($row->name=='id'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "hidden"
            },
            <?php }elseif($row->name=='update_by'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "hidden",
            },
            <?php }elseif($row->name=='update_time'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "hidden",
            },
            <?php }elseif($row->type=='text'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "text",
            },
            <?php }elseif($row->type=='char'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
            },

            <?php }elseif($row->type=='year'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: 'YYYY',

            },
            <?php }elseif($row->type=='date'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "datetime",
                def: function() {
                    return new Date();
                },
                format: 'YYYY-MM-DD',

            },
            <?php }elseif($row->type=='datetime'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
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
            <?php } elseif ($nm[0] == 'img') { ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "upload",
                display: function(file_id) {
                    return '<a href="' + editor.file('files', file_id).web_path +
                        '?id=<?=time();?>' +
                        '"  target="_blank" title="View File"><img src="' + editor.file('files',
                            file_id).web_path +
                        '?id=<?=time();?>" style="width:150px;height:100px"/></a>';
                },
                clearText: "Clear",
                noImageText: 'No image',
            },

            <?php }elseif($nm[0]=='file'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "upload",
                display: function(file_id) {

                    return file_id ?
                        '<a href="' + editor.file('files', file_id).web_path +
                        '?id=<?=time();?>' +
                        '"  target="_blank" title="View File"><iframe src="' + editor.file(
                            'files',
                            file_id).web_path +
                        '?id=<?=time();?>"  style="width:150px;height:100px"/></a>' :
                        null;
                },
                clearText: "Clear",
                noImageText: 'No File',
            },
            <?php }elseif($row->type=='time'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "datetime",
                format: 'HH:mm:ss',
                fieldInfo: '24 hour clock format with seconds',
                opts: {
                    minutesIncrement: 1,
                    secondsIncrement: 1
                }

            },
            <?php }elseif($table=='tbl_master_customer' and $row->name=='gender'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
                options: [{
                        label: "Male",
                        value: "m"
                    },
                    {
                        label: "Female",
                        value: "f"
                    }
                ]
            },
            <?php }elseif($row->name=='surat_jalan'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
                options: [{
                        label: "NO",
                        value: "NO"
                    },
                    {
                        label: "YES",
                        value: "YES"
                    }
                ]
            },
            <?php }elseif($row->name=='label_unique'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
                options: [{
                        label: "NO",
                        value: "NO"
                    },
                    {
                        label: "YES",
                        value: "YES"
                    }

                ]
            },
            <?php }elseif($row->name=='dn_inlabel'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
                options: [{
                        label: "NO",
                        value: "NO"
                    },
                    {
                        label: "YES",
                        value: "YES"
                    }

                ]
            },
            <?php }elseif($row->name=='shearing'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
                options: [{
                        label: "NO",
                        value: "NO"
                    },
                    {
                        label: "YES",
                        value: "YES"
                    }

                ]
            },
            <?php }elseif($row->name=='type_order'){ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "select",
                options: [{
                        label: "PO",
                        value: "PO"
                    },
                    {
                        label: "SKM",
                        value: "SKM"
                    }

                ]
            },

            <?php }elseif($row->name=='status'){ ?> {
                label: "STATUS BARANG:",
                name: "status",
                type: "select",
                def: "Active",
                options: [
                    { label: "Active", value: "Active" },
                    { label: "Non-Active", value: "Non-Active" }
                ]
            },

            <?php }else{ ?> {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
            },
            <?php }} ?>

        ]
    });
    <?php if($table=='tbl_master_title'){ ?>
    editor.on('initEdit', function() {
        editor.field('title').disable();
    });
    <?php } ?>
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
    <?php if($get_o->edit_level=='yesx'){ ?>
    // Activate an inline edit on click of a table cell
    $('#example').on('click', 'tbody td.editable:not(:first-child)', function(e) {
        editor.inline(this, {
            onBlur: 'submit',
            submit: 'allIfChanged'
        });
    });
    <?php }?>
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
            url: "<?=base_url('Ajax/mData?table='.$table.'&api='.$this->id_t.'&menuid='.$menuid);?>",
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
        order: [],
        columns: [{
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false,
                searchable: false,
            },
            <?php foreach($data_field as $row){ if ($row->name != 'password') {
              $nm=explode('_',$row->name);  
              if($row->name=='update_time'){
              ?> {
                data: "<?=$row->name;?>"
            },
            <?php }elseif($row->name=='update_by'){ ?> {
                data: "<?=$row->name;?>"
            },
            <?php }elseif($row->name=='file_spis'){ ?> {
                data: "<?=$row->name;?>",
                className: "text-center",
                mRender: function(a, b, data) {
                    return '<a href="<?=base_url('assets/part/pdf/');?>' + data.part_no_fsi +
                        'P1.pdf?id=<?=time();?>"  target="_blank" title="View File"><iframe src="<?=base_url('assets/part/pdf/');?>' +
                        data.part_no_fsi +
                        'P1.pdf?id=<?=time();?>" style="height:50px;width:75px"></a>';
                    // return file_id ?
                    //     '<a href="' + editor.file('files', file_id).web_path +
                    //     '?id=<0?=time();?>' +
                    //     '"  target="_blank" title="View File"><iframe src="' + editor.file('files',
                    //         file_id).web_path + '?id=<0?=time();?>" style="height:50px;width:75px"/></a>' :
                    //     null;

                },
                defaultContent: "No File",
                title: "<?=$row->name;?>",
            },
            <?php }elseif($row->name=='file_spps'){ ?> {
                data: "<?=$row->name;?>",
                className: "text-center",
                mRender: function(a, b, data) {
                    if (data.customer == 'ADM') {
                        var pt = 'P2D';
                    } else {
                        var pt = 'P2T';
                    }
                    return '<a href="<?=base_url('assets/part/pdf/');?>' + data.part_no_fsi +
                        pt +
                        '.pdf?id=<?=time();?>"  target="_blank" title="View File"><iframe src="<?=base_url('assets/part/pdf/');?>' +
                        data.part_no_fsi + pt +
                        '.pdf?id=<?=time();?>" style="height:50px;width:75px"></a>';
                    // return file_id ?
                    //     '<a href="' + editor.file('files', file_id).web_path +
                    //     '?id=<0?=time();?>' +
                    //     '"  target="_blank" title="View File"><iframe src="' + editor.file('files',
                    //         file_id).web_path + '?id=<0?=time();?>" style="height:50px;width:75px"/></a>' :
                    //     null;

                },
                defaultContent: "No File",
                title: "<?=$row->name;?>",
            },
            <?php } elseif ($nm[0]== 'img') { ?> {
                data: "<?=$row->name;?>",
                className: 'editable text-center',
                mRender: function(a, b, data) {

                    return '<a href="<?=base_url('assets/product/img/');?>' + data
                        .product_code +
                        '.jpg?id=<?=time();?>"  target="_blank" title="View File"><image src="<?=base_url('assets/product/img/');?>' +
                        data.product_code + '.jpg?id=<?=time();?>" style="width:50px;"></a>';
                    // return file_id ?
                    //           '<a href="' + editor.file('files', file_id).web_path +
                    //           '?id=<c?=time();?>' +
                    //           '"  target="_blank" title="View File"><image src="' +
                    //           editor.file('files', file_id).web_path +
                    //           '?id=<c?=time();?>" style="width:50px;"></a>' :
                    //           null;
                },
                defaultContent: "No image",
                title: "<?=$row->name;?>",
            },
            <?php } elseif($row->name=='status'){ ?> {
                // INI OBAT KHUSUS UNTUK KOLOM STATUS BANG!
                data: "status",
                defaultContent: "Active",
                className: 'editable'
            },
            <?php }else{ ?> {
                // INI KOLOM TEKS BIASA LAINNYA
                data: "<?=$row->name;?>",
                defaultContent: "", // Anti-error kalau data telat
                className: 'editable'
            },
            <?php } }} ?>
        ],
        select: {
            style: 'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            <?php if($get_o->add_level=='yes'){ ?> {
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
            <?php }if($get_o->edit_level=='yes'){ ?> {
                text: 'Update STGE LBL',
                className: 'dt-button buttons-select-none text-green',
                titleAttr: 'Calculation',
                action: function() {
                    form_upd_stge_lbl('<?=$table;?>');
                }
            },
            <?php } if($get_o->edit_level=='yes'){ ?> {
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
            <?php } if($get_o->delete_level=='yes'){ ?> {
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
            <?php } if($get_o->export_level=='yes'){?> {
                extend: 'excel',
                text: "<span class='text-green'>Export</span>",
                title: '',
            },
            <?php } if($get_o->import_level=='yes'){ ?>
            // {
            //     text: "<span class='text-green'>Import Excel</span>",
            //     titleAttr: 'Import Excel',
            //     action: function () {
            //         formupload('<?=$table;?>');
            //     }
            // },
            {
                text: "<span class='text-green'>Import CSV</span>",
                action: function() {
                    uploadEditor.create({
                        title: "CSV file import <a href='<?=base_url()?>formatexcel/<?=$table;?>.csv' class='btn btn-outline-info' title='Download Format file csv'><span class='fa fa-file-excel-o fa-lg'></span>Download format file</a>"
                    });
                    uploadEditor.field('csv').input().val('');

                }
            },
            <?php } ?> {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            'selectNone',
            <?php if($get_o->print_level=='yes'){
            if($table=='tbl_master_kanban'){ ?> {
                extend: "selectedSingle",
                text: "<i class='fas fa-print text-green'></i>",
                titleAttr: 'Print Kanban',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    print_l(data.id, '<?=$table;?>');
                }
            },
            <?php }elseif($table=='tbl_master_product'){ ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'dt-button buttons-select-none btn-print',
                titleAttr: 'Print Label',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, '<?=$table;?>');
                }
            },
            <?php }elseif($table=='tbl_master_matrixroute'){ ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'dt-button buttons-select-none btn-print',
                titleAttr: 'Print Dies',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, 'tbl_jig');
                }
            },
            {
                extend: "selected",
                text: "<i class='fas fa-print text-orange'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print Machine',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, 'tbl_machine');
                }
            },
            <?php }elseif($table=='tbl_master_toolroom'){ ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print Rack',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, '<?=$table;?>');
                }
            },
            <?php }elseif($table=='tbl_master_rack'){ ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print Rack In',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id + '_IN', '<?=$table;?>');
                }
            },
            {
                extend: "selected",
                text: "<i class='fas fa-print text-warning'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print Rack Out',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id + '_OUT', '<?=$table;?>');
                }
            },

            <?php }elseif($table=='tbl_master_machine'){ ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print Label',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, '<?=$table;?>');
                }
            },
            <?php }elseif($table=='tbl_master_operator'){ ?> {
                extend: "selected",
                text: "<i class='fas fa-print text-green'></i>",
                className: 'btn btn-print',
                titleAttr: 'Print Label',
                action: function() {
                    var id = [];
                    var data = table.rows('.selected').data();
                    for (var i = 0; i < data.length; i++) {
                        id.push(data[i].id);
                    }
                    print_l(id, '<?=$table;?>');
                }
            },
            <?php }} if($get_o->other_level=='yes'){
              if($table=='tbl_master_plc'){ ?> {
                extend: "selectedSingle",
                text: '<i class="fas fa-network-wired  text-green"></i>',
                className: 'btn btn-default plc',
                titleAttr: 'Test PLC',
                action: function() {
                    var idx = table.cell('.selected', 0).index();
                    var data = table.row(idx.row).data();
                    var deskripsi = data.deskripsi;
                    if (deskripsi.substring(0, 3) == 'JIG') {
                        formtestplc(data.id, data.ip_address, data.deskripsi, data.line);
                    } else {
                        $('.plc').addClass('disabled')
                    }
                }
            },
            <?php } } if($get_o->del_all=='yes'){  ?> {
                text: '<i class="fas fa-trash-alt  text-red"></i>',
                className: 'dt-button buttons-select-none',
                titleAttr: 'Clear All',
                action: function() {
                    del_all('<?=$table;?>');
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

function form_upd_stge_lbl(table) {
    $.ajax({
        type: "POST",
        url: "<?=base_url('master/form_upd_stge_lbl?api='.$this->id_t); ?>",
        data: "table=" + table + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function formtestplc(id, ip, deskripsi, line) {
    $.ajax({
        type: "POST",
        url: "<?=base_url('master/formtestplc?api='.$this->id_t); ?>",
        data: "<?=$this->security->get_csrf_token_name();?>=" + cv + "&id=" + id + "&ip=" + ip + "&deskripsi=" +
            deskripsi + "&line=" + line,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');
        }
    });
}

function formupload(table) {
    $.ajax({
        type: "POST",
        url: "<?=base_url('importexcel?api='.$this->id_t); ?>",
        data: "table=" + table + "&<?=$this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        success: function(data) {
            $(".modal-content").html(data);
            $("#myModal").modal('show');

        }
    });
}

function print_kbnseq(id, tablex, total_kbn) {
    swal({
            title: "Print Kanban",
            text: "Please input seq no, max  " + total_kbn,
            type: "input",
            cancelButtonClass: 'btn-danger',
            showCancelButton: true,
            confirmButtonClass: 'btn-success',
            confirmButtonText: 'Submit',
            closeOnConfirm: false,
            inputPlaceholder: "Seq. No",
        },
        function(inputValue) {
            var number = /^[0-9]+$/;
            if (inputValue === false) return false;

            if (inputValue === "") {
                swal.showInputError("Please Input Seq. No!");
                return false
            } else if (!inputValue.match(number)) {
                swal.showInputError("only number");
                return false
            } else if (inputValue < 1) {
                swal.showInputError("Min 1");
                return false
            } else if (parseInt(inputValue) > parseInt(total_kbn)) {
                swal.showInputError("Max " + total_kbn);
                return false
            } else {
                window.open("<?=base_url('s_print/');?>" + tablex + "?id=" + id + "&seq=" + inputValue +
                    "&api=<?=$this->id_t;?>", "_blank");
            }

        });

}

function imageExists(image_url) {

    var http = new XMLHttpRequest();

    http.open('HEAD', image_url, false);
    http.send();

    return http.status != 404;

}
</script>
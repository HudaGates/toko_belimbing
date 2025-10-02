<div class="modal-header pb-1 pt-1">
    <h4 class="modal-title"><i class="fa fa-globe text-info text-lg text-bold" aria-hidden="true"></i> Form Release
        Order Material</h4>
    <button class="close text-red" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body p-2">
    <div class="card card-body p-1 pb-0">
        <span class="text-md text-bold ml-1">PR Date : <?= $pr_date; ?> Remark : <?= $remark; ?></span>
        <span class="pt-1">
            <ul class="list-group list-group-horizontal">
                <li class="list-group-item border-0"><i class="fa fa-check text-green"></i> Calculation</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Select & Update Qty Order</li>
                <li class="list-group-item border-0"><i class="fa fa-hand-point-right text-info" aria-hidden="true"></i>
                    Release Order</li>
            </ul>
        </span>
    </div>
    <div id="result">

    </div>


    <table id="example2" class="table table-hover table-bordered nowrap compact text-sm" style="width: 100%;">
        <thead>
            <tr>
                <th rowspan="2"></th>
                <th rowspan="2">ID</th>
                <th rowspan="2">Remark</th>
                <th rowspan="2">Calc Date</th>
                <th rowspan="2">Delv. Date</th>
                <th rowspan="2">PO NO</th>
                <th rowspan="2">Supplier Code</th>
                <th rowspan="2">Material Spec</th>
                <th rowspan="2">Part No</th>
                <th rowspan="2">W. Coil</th>
                <th rowspan="2">W. Day</th>
                <th colspan="4" class="text-center p-0">
                    <div class="bg-success" style="width:100%">Satuan (day)</div>
                </th>
                <th rowspan="2">W. Order</th>
                <th rowspan="2">Kbn Order</th>
            </tr>
            <tr>
                <th>Stock Total</th>
                <th>Stock Min</th>
                <th>PO Remain</th>
                <th>Stock Order</th>
            </tr>

        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Remark</th>
                <th>Calc Date</th>
                <th>Delv. Date</th>
                <th>PO NO</th>
                <th>Supplier Code</th>
                <th>Material Spec</th>
                <th>Part No</th>
                <th>W. Coil</th>
                <th>W. Day</th>
                <th>Stock Total</th>
                <th>Stock Min</th>
                <th>PO Remain</th>
                <th>Stock Order</th>
                <th>W. Order</th>
                <th>Kbn Order</th>
            </tr>
        </tfoot>
    </table>
</div>
<script type="text/javascript" language="javascript" class="init">
var editor2;
cv = '<?= $this->security->get_csrf_hash(); ?>';
$('#example2 tfoot th').each(function() {
    var title = $(this).text();
    if (title != '') {
        $(this).html(
            '<input type="text" placeholder="Search" class="form-control input-sm" style="height: 25px !important;"/>'
        );
    }

});

editor2 = new $.fn.dataTable.Editor({
    ajax: {
        url: "<?= base_url('Ajax/plData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
        type: "POST",
        data: function(d) {
            d.csrf_sysx_name = cv;
        }

    },
    table: "#example2",
    fields: [{
            label: "id:",
            name: "id",
            type: "hidden"
        },
        {
            label: "remark:",
            name: "remark",
            type: "select",
            options: [{
                    "label": "OK",
                    "value": "OK"
                },
                {
                    "label": "RELEASE",
                    "value": "RELEASE"
                },
            ]
        },
        {
            label: "calc_date:",
            name: "calc_date",
            type: "readonly",
        },
        {
            label: "delv_date:",
            name: "delv_date",
            type: "readonly",
        },
        {
            label: "po_no:",
            name: "po_no",
            type: "readonly",
        },
        {
            label: "supplier_code:",
            name: "supplier_code",
            type: "readonly",
        },
        {
            label: "material_spec:",
            name: "material_spec",
            type: "readonly",
        },
        {
            label: "part_no:",
            name: "part_no",
            type: "readonly",
        },
        {
            label: "weight_coil:",
            name: "weight_coil",
            type: "readonly",
        },
        {
            label: "weight_day:",
            name: "weight_day",
            type: "readonly",
        },
        {
            label: "stock_total:",
            name: "stock_total",
            type: "readonly",
        },
        {
            label: "stock_min:",
            name: "stock_min",
            type: "readonly",
        },
        {
            label: "po_remain:",
            name: "po_remain",
            type: "readonly",
        },
        {
            label: "stock_order:",
            name: "stock_order",
            type: "readonly",
        },
        {
            label: "weight_order:",
            name: "weight_order",
            type: "readonly",
        },
        {
            label: "kbn_order:",
            name: "kbn_order",
        }
    ]
});

// Activate an inline edit on click of a table cell
$('#example2').on('click', 'tbody td.editable:not(:first-child)', function(e) {
    editor2.inline(this, {
        onBlur: 'submit',
        submit: 'allIfChanged'
    });
});

table2 = $('#example2').DataTable({
    dom: '<"top"Blf>rt<"bottom"ip><"clear">',
    ajax: {
        url: "<?= base_url('Ajax/plData?table=' . $table . '&api=' . $this->id_t . '&menuid=' . $menuid); ?>",
        type: "POST",
        data: function(d) {
            d.csrf_sysx_name = cv;
        },

    },
    processing: true,
    "language": {
        'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="text-green">Processing ...</span> '
    },
    //if sqlserver serverside false
    serverSide: true,
    scrollY: 360,
    scrollX: true,
    paging: true,
    autoWidth: true,
    pageResize: true,
    lengthMenu: [
        [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, -1],
        [10, 15, 20, 25, 50, 500, 1000, 5000, 10000, "All"]
    ],
    pageLength: 50,
    responsive: false,
    order: [
        [1, 'asc']
    ],
    columns: [{
            data: null,
            defaultContent: '',
            className: 'select-checkbox',
            orderable: false,
            searchable: false,

        },
        {
            data: "id",
        },
        {
            data: "remark",
        },
        {
            data: "calc_date",
        },
        {
            data: "delv_date",
        },
        {
            data: "po_no",
        },
        {
            data: "supplier_code",
        },
        {
            data: "material_spec",
        },
        {
            data: "part_no",
        },
        {
            data: "weight_coil",
        },
        {
            data: "weight_day",
        },
        {
            data: "stock_total",
        },
        {
            data: "stock_min",
        },
        {
            data: "po_remain",
        },
        {
            data: "stock_order",
        },
        {
            data: "weight_order",
        },
        {
            data: "kbn_order",
        }
    ],
    select: {
        style: 'os',
        selector: 'td:first-child'
    },
    buttons: [{
            extend: "edit",
            text: "<span class='text-green'>Judgement</span>",
            editor: editor2,
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
            extend: 'excel',
            text: '<span class="text-dark"><i class="fa fa-file-excel text-success mr-1"></i></span>',
            titleAttr: 'Export Excel',
            className: 'btn-space'

        },
        {
            extend: 'selectAll',
            className: 'btn-space text-green',
        },
        'selectNone',
        {
            extend: "selected",
            text: '<span class="text-dark"><i class="fa fa-file-excel text-success mr-1"></i>Release</span>',
            titleAttr: 'Release',
            action: function() {
                var id = [];
                var data = table2.rows('.selected').data();
                for (var i = 0; i < data.length; i++) {
                    id.push(data[i].id);
                }
                release(id);
            }
        },
        {
            extend: "selected",
            text: 'Re-Email',
            titleAttr: 'Re-email',
            action: function() {
                var id = [];
                var data = table2.rows('.selected').data();
                for (var i = 0; i < data.length; i++) {
                    id.push(data[i].id);
                }
                reemail(id);
            }
        },
        {
            text: '<span class="text-dark"><i class="fa fa-spinner fa-rotate-90 text-success mr-1"></i></span>',
            titleAttr: 'Refresh',
            action: function() {
                $('#example2').DataTable().ajax.reload();
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
table2.columns(1).search('').draw();

function release(id) {
    $("#result").html('');
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
            $("#result").html(
                '<div class="modal-body text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>'
            );
            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/release?api=' . $this->id_t); ?>",
                data: "id=" + id +
                    "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                dataType: 'json',
                success: function(data) {

                    if (data.success == false) {
                        $("#result").html(
                            '<div class="modal-header"><h4 class="text-red">Error !!</h4><div class="modal-body text-center">' +
                            data.messages + ' </div>');
                    } else {

                        if (data.email == true) {
                            $("#result").html(
                                '<div class="modal-header"><h4 class="text-green">Success Release order !!</h4> </div>'
                            );
                            $('#example2').DataTable().ajax.reload();
                        } else {
                            $("#result").html(
                                '<div class="modal-header"><h4 class="text-red">Koneksi Email Error !!</h4><div class="modal-body text-center">' +
                                data.email + ' </div>');
                        }

                    }
                }
            });
        });
}

$('#mydata').submit(function(e) {
    e.preventDefault();
    var fa = $(this);
    $("#save").attr('disabled', true);
    $("#hasilx").html(
        '<div class="box text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i></div>');
    $.ajax({
        url: fa.attr('action'),
        type: 'post',
        data: fa.serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success == true) {
                $('.form-group').removeClass('has-error')
                    .removeClass('has-success');
                $('.text-danger').remove();
                fa[0].reset();

                if (response.email == true) {
                    swal({
                        title: "Release Order Success",
                        type: "success",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $("#myModal").modal('hide');
                } else {
                    $("#view").html(
                        '<div class="modal-header"><h4 class="text-red">Koneksi Email Error !!</h4><button type="button" class="close exit" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></div><div class="modal-body text-center">' +
                        response.email + ' </div>');
                }

            } else {
                $("#save").attr('disabled', false);
                $.each(response.messages, function(key, value) {
                    var element = $('#' + key);
                    element.closest('div.form-group')
                        .removeClass('has-error')
                        .addClass(value.length > 0 ? 'has-error' : 'has-success')
                        .find('.text-danger')
                        .remove();
                    element.after(value);
                });
            }
        }
    });
});

function reemail(id) {
    $("#result").html('');
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
            $("#result").html(
                '<div class="modal-body text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>'
            );

            $.ajax({
                type: "POST",
                url: "<?= base_url('planning/r_email?api=' . $this->id_t); ?>",
                data: "id=" + id + "&<?= $this->security->get_csrf_token_name(); ?>=" + cv,
                cache: false,
                dataType: 'json',
                success: function(data) {

                    if (data.success == false) {
                        $("#result").html(
                            '<div class="modal-header"><h4 class="text-red">Error !!</h4><div class="modal-body text-center">' +
                            data.messages + ' </div>');
                    } else {
                        $("#result").html(
                            '<div class="modal-body text-center"><i class="fa fa-spinner fa-spin fa-3x fa-fw text-center"></i><span class="text-green">processing...</span> </div>'
                        );
                        if (data.email == true) {
                            $("#result").html(
                                '<div class="modal-header"><h4 class="text-green">Success Re-Email Release order !!</h4> </div>'
                            );
                        } else {
                            $("#result").html(
                                '<div class="modal-header"><h4 class="text-red">Koneksi Email Error !!</h4><div class="modal-body text-center">' +
                                data.email + ' </div>');
                        }
                    }
                }
            });
        });
}

$(document).ready(function() {
    $('#example2').DataTable().ajax.reload();
    // table2.columns.adjust().draw();
});
</script>
    
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-body">                
                <table id="example" class="table table-hover table-bordered nowrap  compact" style="width:100%;font-size: 14px">
                    <thead>
                        <tr>
                            <th></th>
                           <?php foreach($data_field as $row){ 
                              echo "<th>".strtoupper($row->name)."</th>";
                            } ?>
                            <th>Part Name</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                           <th></th>
                            <?php foreach($data_field as $row){ 
                                echo "<th>".strtoupper($row->name)."</th>";
                              } ?>
                              <th>Part Name</th>
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
        
<script type="text/javascript"> 
    var editor; 
    var tinggi = ($(window).height() - 375);
    if(parseInt(tinggi)<150){
      var tinggi=150;
    }
  $(window).resize(function(){
      var tinggi = ($(window).height()-375);
      if(parseInt(tinggi)<150){
        var tinggi=150;
      }
       if (parseInt($('#example').css('height')) >= tinggi) {
            $('.dataTables_scrollBody').css('height', tinggi);
            $('.dataTables_scrollBody').css('max-height', tinggi);
        }
    });
function selectColumns ( editor, csv, header ) {
  var selectEditor = new $.fn.dataTable.Editor();
  var fields = editor.order();

 for ( var i=1 ; i<fields.length ; i++ ) {
    var field = editor.field( fields[i] );
    if(field.name()!='update_by' && field.name()!='update_time'){
      selectEditor.add( {
        label: field.label(),
        name: field.name(),
        type: 'select',
        options: header,
        def: header[i]
      } );
    }
  }

  selectEditor.create({
    title: 'Map CSV fields',
    buttons: 'Import '+csv.length+' records',
    message: 'Select the CSV column you want to use the data from for each field.'
  });

  selectEditor.on('submitComplete', function (e, json, data, action) {
    // Use the host Editor instance to show a multi-row create form allowing the user to submit the data.
    editor.create( csv.length, {
      title: 'Confirm import',
      buttons: 'Submit',
      message: 'Click the <i>Submit</i> button to confirm the import of '+csv.length+' rows of data. Optionally, override the value for a field to set a common value by clicking on the field below.'
    } );

    for ( var i=1 ; i<fields.length ; i++ ) {
      var field = editor.field( fields[i] );
      var mapped = data[ field.name() ];
     if(field.name()!='update_by' && field.name()!='update_time'){
          for ( var j=0 ; j<csv.length ; j++ ) {
            field.multiSet( j, csv[j][mapped] );
          }
        }
    }
  } );
}
    // use a global for the submit and return data rendering in the examples
$(document).ready(function() {
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!=''){
            $(this).html( '<input type="text" placeholder="Search" class="form-control input-sm" style="height: 2 5px !important;"/>' );
        }
        
    } );
  var cv='<?=$this->security->get_csrf_hash(); ?>';
    editor = new $.fn.dataTable.Editor( {
      
        ajax: {
            url: "<?=base_url('Ajax/sData?table='.$table.'&api='.$this->id_t.'&menuid='.$menuid);?>",
            type: "POST",
            data: function ( d ) {
               d.csrf_sysx_name  = cv;
             }
  
        },
        responsive: true,
        table: "#example",
        fields: [ {
                label: "Doc Name:",
                name: "tbl_master_document.doc_name",
            }, {
                label: "Doc no:",
                name: "tbl_master_document.doc_no"
            }, {
                label: "Revision:",
                name: "tbl_master_document.revision"
            }, {
                label: "Active date:",
                name: "tbl_master_document.active_date",
                type:  'datetime',
                def:   function () { return new Date(); },
                format: 'YYYY-MM-DD',
            }, {
                label: "Remark:",
                name: "tbl_master_document.remark",
                type:"text",
            }, {
                label: "Adjust date:",
                name: "tbl_master_document.adjust_date",
                type: "datetime",
                def:   function () { return new Date(); },
                format: 'YYYY-MM-DD',
            }, {
                label: "Seq sj:",
                name: "tbl_master_document.seq_sj"
            },
            {
              label: "File:",
              name: "tbl_master_document.file",
              type: "upload",
              display: function ( file_id ) {
                  return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
              },
              clearText: "Clear",
              noImageText: 'No File',
          },
          {
                label: "Part No:",
                name: 'tbl_master_document.part_no',
                type: 'datatable',
                optionsPair: {
                    value: 'part_no',
                },
                config: {
                    pageLength:5,
                    columns: [
                        {
                            title: 'Part No',
                            data: 'part_no'
                        },
                        {
                            title: 'Item',
                            data: 'item'
                        }
                    ]
                }
            }
        ]
    } );
    var uploadEditor = new $.fn.dataTable.Editor( {
    fields: [ {
      label: 'CSV file:',
      name: 'csv',
      type: 'upload',
      ajax: function ( files ) {
        // Ajax override of the upload so we can handle the file locally. Here we use Papa
        // to parse the CSV.
        Papa.parse(files[0], {
          header: true,
          delimiter: ';',
          skipEmptyLines: true,
          complete: function (results) {
            if ( results.errors.length ) {
              console.log( results );
              uploadEditor.field('csv').error( 'CSV parsing error: '+ results.errors[0].message );
            }
            else {
              uploadEditor.close();
              selectColumns( editor, results.data, results.meta.fields );
            }
          }
        });
      }
    } ]
  } );
    <?php if($get_o->edit_level=='yes'){ ?>
    // Activate an inline edit on click of a table cell
     $('#example').on( 'click', 'tbody td.editable:not(:first-child)', function (e) {
       editor.inline(this, {
            onBlur: 'submit',
            submit: 'allIfChanged'
        } );
    } );
     <?php }?>
     //ad function in field input
    $('input', editor.field('tbl_master_document.doc_name').node()).on('keyup', function () {
      var str =  $('input', editor.field('tbl_master_document.doc_name').node()).val();
        $('input', editor.field('tbl_master_document.doc_no').node()).val(str);
      }); 
     // Upload Editor - triggered from the import button. Used only for uploading a file to the browser
    function upload(){
        view_json('<?=$table;?>');
    }
    var csfrData = {};
    csfrData['<?=$this->security->get_csrf_token_name(); ?>'] = '<?=$this->security->get_csrf_hash(); ?>';

    var table=$('#example').DataTable( {
        dom: '<"top"QBlf>rt<"bottom"ip><"clear">',
        ajax: {
            url: "<?=base_url('Ajax/sData?table='.$table.'&api='.$this->id_t.'&menuid='.$menuid);?>",
            type: "POST",
            data: csfrData,
  
        },
        processing: true, 
            "language": {
              'processing': '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="text-green">Processing ...</span> '
            },
        //if sqlserver serverside false
        serverSide: true,
        scrollY:tinggi,
        scrollX:true,
        paging:true, 
        autoWidth: true,
        pageResize: true,
        lengthMenu: [ [10,15,20, 25, 50, -1], [10,15,20, 25, 50, "All"] ],
        pageLength:15,
        
        responsive: false,
        order: [],
        columns: [
            {
                data: null,
                defaultContent: '',
                className: 'select-checkbox',
                orderable: false,
                searchable: false,
            },
            <?php foreach($data_field as $row){ 
              if($row->name=='update_time'){
              ?>
              { data: "tbl_master_document.<?=$row->name;?>"},
            <?php }elseif($row->name=='update_by'){ ?>
                { data: "tbl_master_document.<?=$row->name;?>"},
            <?php }elseif($row->name=='file'){ ?>,
                {
                data: "tbl_master_document.file",
                render: function ( file_id ) {
                      
                       if(file_id){
                        if(editor.file( 'files', file_id ).ext!='pdf'){  
                        return file_id ?                     
                        '<a href="'+editor.file( 'files', file_id ).web_path+'"  target="iframe_a" onclick="file()" title="View File"><image src="'+editor.file( 'files', file_id ).web_path+'" style="width:50px;"></a>' :
                        null;
                       } else {
                        return file_id ?
                        '<a href="'+editor.file( 'files', file_id ).web_path+'"   target="iframe_a" onclick="file()" title="View File"><i class="fas fa-file-pdf text-lg text-red"></i></a>' :
                        null;

                       }}
                        
                    },
                    defaultContent: "No File",
                    title: "File",
                },
            <?php }else{ ?>
                { data: "tbl_master_document.<?=$row->name;?>", className: 'editable'},
             <?php } } ?>,
              { data: "tbl_master_seat.item" }
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            <?php if($get_o->add_level=='yes'){ ?>,
            { 
              extend: "create",
              text: "<span class='text-green'>New</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } if($get_o->edit_level=='yes'){ ?>,
            { 
              extend: "edit",
              text: "<span class='text-green'>Edit</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
           },
            <?php } if($get_o->delete_level=='yes'){ ?>,
            { 
              extend: "remove",
              text: "<span class='text-red'>Delete</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } if($get_o->export_level=='yes'){?>,
            {
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
            <?php } if($get_o->import_level=='yes'){ ?>,
            /*{
                text: 'Import Excel',
                action: function () {
                    upload();
                }
            }*/
            {
              text: "<span class='text-green'>Import CSV</span>",
              action: function () {
                uploadEditor.create( {
                  title: "CSV file import <a href='<?=base_url()?>formatexcel/<?=$table;?>.csv' class='btn btn-outline-info' title='Download Format file csv'><span class='fa fa-file-excel-o fa-lg'></span>Download format file</a>"
                } );
                uploadEditor.field('csv').input().val('');
              }
            },
            <?php } ?>,
            {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            'selectNone',
          <?php if($get_o->print_level=='yes'){ ?>  ,
            {
                 extend: "selectedSingle",
                 text: "<i class='fas fa-print text-green'></i>",
                 className: 'btn btn-print',
                 titleAttr: 'Print Label',
                action: function () {
                  var idx = table.cell('.selected', 0).index();
                  var data = table.row( idx.row ).data();
                    print_l(data.id);
                }
            },
             <?php } if($get_o->print_level=='yes'){ ?> , 
            {
                 text: '<i class="fas fa-print text-green"></i>',
                 className: 'btn btn-default',
                 titleAttr: 'Print All Label',
                action: function () {
                    print_all('<?=$table;?>');
                }
            },
             <?php } if($table=='tbl_master_plc'){ ?>  ,
            {
                 extend: "selectedSingle",
                 text: '<i class="fas fa-network-wired  text-green"></i>',
                 className: 'btn btn-default plc',
                 titleAttr: 'Test PLC',
                  action: function () {
                  var idx = table.cell('.selected', 0).index();
                  var data = table.row( idx.row ).data();
                  var deskripsi=data.deskripsi;
                    if(deskripsi.substring(0,3)=='JIG'){
                      formtestplc(data.id,data.ip_address,data.deskripsi,data.line);
                    }else{
                      $('.plc').addClass('disabled')
                    }
                  }
            },
            <?php }if($get_o->del_all=='yes'){  ?>,
               {
                text: '<i class="fas fa-trash-alt  text-red"></i>',
                className: 'btn btn-default',
                titleAttr: 'Clear',
                action: function () {
                    del_all('<?=$table;?>');
                }
            }
             <?php } ?>
        ],

         initComplete: function () {
            // Apply the search
            this.api().columns().every( function () {
                var that = this;
 
                $( 'input', this.footer() ).on( 'keyup change clear', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );
        }

    } );
    
});
function testxx(){
  alert('test');
}
function view_json(table){
            $.ajax({
                type: "POST",
                url : "<?=base_url('master/view_json'); ?>",
                data: csfrData,
                cache:false,
                success: function(data){
                    $("#view").show();
                    $("#myModal").modal('show');
                }
            });
        };

    function formtestplc(id,ip,deskripsi,line){
        $.ajax({
                type: "POST",
                url : "<?=base_url('master/formtestplc?api='.$this->id_t); ?>",
                data: "<?=$this->security->get_csrf_token_name();?>="+cv+"&id="+id+"&ip="+ip+"&deskripsi="+deskripsi+"&line="+line,
                cache:false,
                success: function(data){
                    $(".modal-content").html(data);
                    $("#myModal").modal('show');
                    
                }
            });
    }
</script>




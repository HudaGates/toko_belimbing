    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!-- /.card-header -->
              <div class="card-header">
                <table style="width: 100%;border-spacing:0px;border-collapse: collapse !important;">
                  <tr>
                    <td class="text-lg text-bold">
                      INPUT SLIP ORDER  <small><code><i>(Tips Pindah baris gunakan Tombol Tabs)</i></code></small>
                    </td>
                    <td style="width: 100px;text-align: right">
                      Pilih Shop
                    </td>
                    <td style="width: 250px">
                    <select class="form-control text-bold" name="shop" id="shop" onchange="forminput()" style="padding: 1px !important">
                        <option value=""></option>
                        <option value="1">Assy 1</option>
                        <option value="2">Assy 2</option>
                        <option value="s">Special Production</option>
                    </select>
                    </td>
                    <td onclick="formcalcjust()" style="width: 50px;text-align: center;cursor:pointer;"  title="Judgement Slip Order"> 
                    <i class="fas fa-cogs text-lg"></i>
                  </td>
                </tr>
              </table>
              </div>

              <div class="card-body text-center"  id="forminput">
                 <input type="hidden" name="idx" id="idx">
                  <table id="example" class="table table-hover table-bordered nowrap compact" style="width:100%;font-size: 14px">
                      <thead>
                          <tr>
                              <th></th>
                               <?php foreach($data_field as $row){ 
                                  echo "<th>".strtoupper($row->name)."</th>";
                                } ?>
                          </tr>
                      </thead>
                      <tfoot>
                          <tr>
                             <th></th>
                              <?php foreach($data_field as $row){ 
                                  echo "<th>".strtoupper($row->name)."</th>";
                                } ?>
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
 <script type="text/javascript">
    var editor; 
    var tinggi = ($(window).height() - 430);
    if(parseInt(tinggi)<150){
      var tinggi=150;
    }
  $(window).resize(function(){
      var tinggi = ($(window).height()-430);
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
      selectEditor.add( {
        label: field.label(),
        name: field.name(),
        type: 'select',
        options: header,
        def: header[i]
      } );
      

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
          for ( var j=0 ; j<csv.length ; j++ ) {
            field.multiSet( j, csv[j][mapped] );
          }
    }
  } );
}
    // use a global for the submit and return data rendering in the examples
$(document).ready(function() {
    $('#example tfoot th').each( function () {
        var title = $(this).text();
        if(title!=''){
            $(this).html( '<input type="text" placeholder="Search" class="form-control input-sm" style="height: 25px !important;"/>' );
        }
        
    } );
 var cv='<?=$this->security->get_csrf_hash(); ?>';
    editor = new $.fn.dataTable.Editor( {
        ajax: {
            url: "<?=base_url('Ajax/plData?table='.$table.'&api='.$id_t.'&menuid='.$menuid);?>",
            type: "POST",
            data: function ( d ) {
               d.csrf_sysx_name  = cv;
             }
  
        },
        table: "#example",
        fields: [ 
          <?php foreach($data_field as $row){
              if($row->name=='suffix'){ ?>,
            {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "text"
            },
          <?php }else{ ?>,
             {
                label: "<?=$row->name;?>:",
                name: "<?=$row->name;?>",
                type: "hidden",
            },
             
            <?php }  } ?>
            
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

  <?php if($e_level=='yes'){ ?>
  // Activate an inline edit on click of a table cell
   $('#example').on( 'click', 'tbody td.editable:not(:first-child)', function (e) {
     editor.inline(this, {
          onBlur: 'submit',
          submit: 'allIfChanged'
      } );
  } );
   <?php }?>
     
     // Upload Editor - triggered from the import button. Used only for uploading a file to the browser
    
    var table=$('#example').DataTable( {
        dom: '<"top"Blf>rt<"bottom"ip><"clear">',
        ajax: {
            url: "<?=base_url('Ajax/plData?table='.$table.'&api='.$id_t.'&menuid='.$menuid);?>",
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
        lengthMenu: [ [10,15,20, 25, 50,100,500,1000, -1], [10,15,20, 25, 50,100,500,1000, "All"] ],
        pageLength:15,
        
        responsive: false,
        order: [[1,'desc']],
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
            <?php foreach($data_field as $row){ 
              if($row->name=='suffix'){
              ?>
              { data: "<?=$row->name;?>", className: 'editable'},
            <?php }else{ ?>
                 { data: "<?=$row->name;?>"},
             <?php } } ?>
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            <?php if($a_level=='yes'){ ?>,
            { 
              extend: "create",
              text: "<span class='text-green'>New</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } if($e_level=='yes'){ ?>,
            { 
              extend: "edit",
              text: "<span class='text-green'>Edit</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
           },
            <?php } if($d_level=='yes'){ ?>,
            { 
              extend: "remove",
              text: "<span class='text-red'>Delete</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } if($ex_level=='yes'){?>,
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
            <?php } if($i_level=='yes'){ ?>,
            {
                text: 'Import Excel',
                titleAttr: 'Import Planning',
                action: function () {
                    formupload('<?=$table;?>');
                }
            },
            <?php } ?>,
            {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            
            <?php if($del_all=='yes'){  ?>,
               {
                text: '<i class="fas fa-trash-alt  text-red"></i>',
                className: 'btn btn-default',
                titleAttr: 'Clear All',
                action: function () {
                    del_all('<?=$table;?>');
                }
            },
             <?php } ?>,
             'selectNone',
          <?php if($p_level=='yes'){ ?> , 
            {
                 extend: "selectedSingle",
                 text: "<i class='fas fa-print text-green'></i>",
                 className: 'btn btn-print',
                 titleAttr: 'Print Kanban',
                action: function () {
                  var idx = table.cell('.selected', 0).index();
                  var data = table.row( idx.row ).data();
                    print_l(data.lotid);
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
function formcalcjust(){
      var cv='<?=$this->security->get_csrf_hash(); ?>';
          $.ajax({
              type: "POST",
              url : "<?=base_url('sliporder/formcalcjust?api='.$id_t); ?>",
              data: "<?=$this->security->get_csrf_token_name(); ?>="+cv,
              cache:false,
              success: function(data){
                    $("#view").html(data);
                    $("#myModal").modal('show');
              }
          });
      }
function forminput(){
      var shop = $("#shop").val();
      if(shop!=''){
        var cv='<?=$this->security->get_csrf_hash(); ?>';
          $.ajax({
              type: "POST",
              url : "<?=base_url('sliporder/forminput?api='.$id_t); ?>",
              data: "<?=$this->security->get_csrf_token_name(); ?>="+cv+"&shop="+shop,
              cache:false,
              success: function(data){               
                $("#forminput").html(data);
              }
          });
      }
      
      }

</script>     





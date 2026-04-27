    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <!--<div class="card-header">
                <h3 class="card-title">Master <?=$nav;?></h3>
              </div>
               /.card-header -->
              <div class="card-body">
                <table id="example" class="table table-hover table-bordered compact" style="width:100%;font-size: 14px">
                    <thead>
                        <tr>
                            <th></th>
                              <?php 
                              if($this->user_level=='Administrator'){
                                echo '<th style="width:30px;paddding:0px;text-align:center">ACTION</th>';
                              }
                              foreach($data_field as $row){ 
                                echo "<th>".strtoupper($row->name)."</th>";
                              } ?>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                           <th></th>
                           <?php 
                            if($this->user_level=='Administrator'){
                              echo '<th>ACTION</th>';
                            }
                            foreach($data_field as $row){ 
                                echo "<th>".strtoupper($row->name)."</th>";
                              } ?>
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

  for ( var i=0 ; i<fields.length ; i++ ) {
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

    for ( var i=0 ; i<fields.length ; i++ ) {
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
    editor = new $.fn.dataTable.Editor( {
        ajax: {
            url: "<?=base_url('Ajax/sData?table='.$table.'&api='.$this->id_t.'&menuid='.$menuid);?>",
            type: "POST",
            data: function ( d ) {
               d.csrf_sysx_name  = cv;
             }
  
        },
        table: "#example",
        fields: [ 
          <?php foreach($data_field as $row){ if($row->name!='menuid'){
                    if($row->name=='id'){ ?>
                    {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "hidden"
                    },
                  <?php }elseif($row->name=='update_by'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "hidden",
                    },
                  <?php }elseif($row->name=='image'){ ?>
                     {
                        label: "Logo:",
                        name: "image",
                        type: "upload",
                        display: function ( file_id ) {
                            return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
                        },
                        clearText: "Clear",
                        noImageText: 'No image',
                    },
                  <?php }elseif($row->name=='bg'){ ?>
                     {
                        label: "Background:",
                        name: "bg",
                        type: "upload",
                        display: function ( file_id ) {
                            return '<img src="'+editor.file( 'files', file_id ).web_path+'"/>';
                        },
                        clearText: "Clear",
                        noImageText: 'No image',
                    },
                  <?php }elseif($row->name=='update_time'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "hidden",
                    },
                  <?php }elseif($row->name=='tabel_name'){ ?>
                     {
                        label: "TABEL NAME:",
                        name: "<?=$row->name;?>",
                        type: "text",
                    },
                     <?php }elseif($row->type=='text'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "text",
                    },
                    <?php }elseif($row->type=='char'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "select",
                    },
                  <?php }elseif($row->type=='year'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "datetime",
                        def:   function () { return new Date(); },
                        format: 'YYYY',
                       
                    },
                   <?php }elseif($row->name=='shift'){ ?>
                      {
                        label: "<?=$row->name;?>:".toUpperCase(),
                        name: "<?=$row->name;?>",
                        type: "select",
                        options: [
                            { label: "1",value: "1" },
                            { label: "2",value: "2" },
                            { label: "3",value: "3" }
                        ]
                    },
                  <?php }elseif($row->name=='status'){ ?>
                      {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "select",
                        options: [
                            { label: "",value: "" },
                            { label: "Open",value: "Open"},
                            { label: "Close",value: "Close"}
                        ]
                    },
                  <?php }elseif($row->name=='thema'){ ?>
                      {
                        label: "<?=$row->name;?>:".toUpperCase(),
                        name: "<?=$row->name;?>",
                        type: "select",
                        options: [
                            { label: "Primary",value: "primary" },
                            { label: "Secondary",value: "secondary" },
                            { label: "Info",value: "info" },
                            { label: "Success",value: "success" },
                            { label: "warning",value: "warning" },
                            { label: "Danger",value: "danger" }
                        ]
                    },
                  <?php }elseif($row->name=='login_methode'){ ?>
                      {
                        label: "<?=$row->name;?>:".toUpperCase(),
                        name: "<?=$row->name;?>",
                        type: "select",
                        options: [
                            { label: "scan",value: "scan" },
                            { label: "manual",value: "manual" },
                            { label: "-",value: "-" }
                        ]
                    },
                  <?php }elseif($row->type=='date'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "datetime",
                        def:   function () { return new Date(); },
                        format: 'YYYY-MM-DD',
                       
                    },
                  <?php }elseif($row->type=='datetime'){ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                        type: "datetime",
                        def:   function () { return new Date(); },
                        format: 'YYYY-MM-DD HH:mm:ss',
                        fieldInfo: 'style date with 24 hour clock',
                        opts: {
                            minutesIncrement: 1,
                            secondsIncrement: 1
                        }
                       
                    },
                   <?php }elseif($row->type=='time'){ ?>
                     {
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
                    <?php }else{ ?>
                     {
                        label: "<?=$row->name;?>:",
                        name: "<?=$row->name;?>",
                    },

              <?php } } } ?>
            
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
          skipEmptyLines: true,
          delimiter: ';',
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
    
    var table=$('#example').DataTable( {
        dom: '<"top"Blf>rt<"bottom"ip><"clear">',
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
             <?php if($this->user_level=='Administrator'){ ?>         
            {
              data:'id',
              orderable: false,
              searchable: false,
              className:'text-center',
              render:function(data,type,row,meta){
                  var tabel_name = row['tabel_name'];
                  return type==='display'?
                  '<button class="btn btn-sm  btn-outline-success" onclick="execute('+data+',\'' + tabel_name + '\');" title="execute"><i class="fas fa-play-circle"></i></button>':data;
              }
            },
          <?php } ?>
            <?php foreach($data_field as $row){
              if($row->name=='image'){?>
                {
                data: "image",
                render: function ( file_id ) {
                    return file_id ?
                        '<img src="'+editor.file( 'files', file_id ).web_path+'" style="width:30px;"/>' :
                        null;
                    },
                    defaultContent: "No image",
                    title: "IMAGE"
                },
              <?php }elseif($row->name=='bg'){ ?>
                {
                data: "bg",
                render: function ( file_id ) {
                    return file_id ?
                        '<img src="'+editor.file( 'files', file_id ).web_path+'" style="width:100px;"/>' :
                        null;
                    },
                    defaultContent: "No image",
                    title: "Background"
                },
              <?php }elseif($row->name=='durasi'){ ?>
                { data: "<?=$row->name;?>"},
               <?php }elseif($row->name=='menuid'){ ?>
                { data: "<?=$row->name;?>"},
               <?php }elseif($row->name=='finishot'){ ?>
                { data: "<?=$row->name;?>"},
              <?php }else{ ?>
                { data: "<?=$row->name;?>", className: 'editable'},
              
             <?php } } ?>
        ],
        select: {
            style:    'os',
            selector: 'td:first-child'
        },
        colReorder: true,
        buttons: [
            <?php if($get_o->add_level=='yes'){ ?>
            { 
              extend: "create",
              text: "<span class='text-green'>New</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } if($get_o->edit_level=='yes'){ ?>
            { 
              extend: "edit",
              text: "<span class='text-green'>Edit</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
           },
            <?php } if($get_o->delete_level=='yes'){ ?>
            { 
              extend: "remove",
              text: "<span class='text-red'>Delete</span>",
              editor: editor,
              formButtons: [
                    { text: '<span class="btn btn-outline-danger">Cancel</span>', action: function () { this.close(); } },
                    '<span class="btn btn-outline-success">Submit</span>',
                ]
            },
            <?php } if($get_o->export_level=='yes'){?>
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
            <?php } if($get_o->import_level=='yes'){ ?>
              {
                text: "<span class='text-green'>Import CSV</span>",
                action: function () {
                  uploadEditor.create( {
                    title: "CSV file import <a href='<?=base_url()?>formatexcel/<?=$table;?>.csv' class='btn btn-outline-info' title='Download Format file csv'><span class='fa fa-file-excel-o fa-lg'></span>Download format file</a>"
                  } );
                  uploadEditor.field('csv').input().val('');
                }
              },
            <?php } ?>
            {
                extend: 'selectAll',
                className: 'btn-space text-green'
            },
            'selectNone',
          <?php if($get_o->print_level=='yes'){ ?>  
            {
                text: "<span class='text-green'>Print</span>",
                 className: 'btn btn-print',
                 titleAttr: 'Print Label',
                action: function () {
                  var idx = table.cell('.selected', 0).index();
                  var data = table.row( idx.row ).data();
                  print_l(data.id);
                }
            },
            {
                text: '<i class="fas fa-print text-green"></i>',
                 className: 'btn btn-default',
                 titleAttr: 'Print All Label',
                action: function () {
                    print_all('<?=$table;?>');
                }
            },
            <?php }if($get_o->del_all=='yes'){  ?>
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
function execute(id,tabel_name){
  swal({
          title: "Are you sure?",
          text: "You will execute backup "+tabel_name,
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: 'btn-danger',
          confirmButtonText: 'Yes',
          closeOnConfirm: false,
          //closeOnCancel: false
        },
        function(){
           
          $.ajax({  
                type: "POST",
                url : "<?=base_url('backup/execute?api='.$this->id_t); ?>",
                data: "tabel_name="+tabel_name+"&id="+id+"&<?=$this->security->get_csrf_token_name();?>="+cv,
                dataType: 'json',
                cache:false,
                success: function(data){
                  if(data.status==true){
                     swal({
                        title: "Execute Success",
                        text: "",
                        type: "success",
                        timer: 1200,
                        showConfirmButton: false
                      });
                    $('#example').DataTable().ajax.reload();
                  }else{
                    swal({
                        title: ""+data.status,
                        text: "",
                        type: "warning",
                        timer: 2000,
                        showConfirmButton: false
                      });
                  }
                },
                // ==========================================
                // PENANGKAP ERROR (BIAR GAK NGE-GHOSTING)
                // ==========================================
                error: function(xhr, status, error) {
                    swal(
                        "Gagal Dieksekusi!", 
                        "Tabel " + tabel_name + " tidak ditemukan di database, atau settingan database gudang belum benar.", 
                        "error"
                    );
                }
                // ==========================================
              });
        } );            
    }
</script>




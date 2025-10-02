</div>

<!-- content-wrapper -->
<footer class="main-footer text-sm" style="padding: 5px !important;">
    <div class="float-right d-none d-sm-block">
        <b>Version</b> <?=$version;?>
    </div>
    <strong>Copyright &copy; <?=$year;?> <a href=""><?=$owner;?></a>.</strong> All rights
    reserved.
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<div class="modal fade" id="file">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body" style="display: flex;justify-content: center;align-items: center;">
                <iframe src="#" name="iframe_a" height="700px" width="100%" title="Iframe Example"></iframe>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- ./wrapper -->

<!-- overlayScrollbars -->
<!-- AdminLTE App -->
<script src="<?=base_url('assets/lte/dist/js/adminlte.min.js');?>"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url('assets/lte/dist/js/demo.js');?>"></script>

<!-- page script -->
<script type="text/javascript">
cv = '<?=$this->security->get_csrf_hash(); ?>';
var csfrData = {};
csfrData['<?=$this->security->get_csrf_token_name(); ?>'] = cv;
$.ajaxSetup({
    data: csfrData
});
var clientTime = new Date();
l = clientTime.getTime() + 1800000;
<?php if($cu->user_group=='Admin'){ ?>
document.addEventListener("click", function() {
    addwektu();
});
document.addEventListener("mouseover", function() {
    addwektu();
});
<?php } ?>

function addwektu() {
    var clientTime = new Date();
    var n = clientTime.getTime();
    var diff = l - n;
    if (diff > 0) {
        l = clientTime.getTime() + 1800000;
    }
    //console.log(l+'-'+n+'='+diff);
}

function logo() {
    setInterval(function() {
        var clientTime = new Date();
        var n = clientTime.getTime();
        var diff = l - n;
        if (diff <= 0) {
            window.location.href = "<?=base_url('action/losttime?api='.$this->id_t);?>"
        }
        //console.log(l+'-'+n+'='+diff);
    }, 1000);

}
$(window).load(function() {
    <?php if($cu->user_group=='Admin'){ ?>
    addwektu();
    logo();
    <?php } ?>
    $("#loading").fadeOut("slow");
})

//disbale klik
document.addEventListener("contextmenu", function(e) {
    e.preventDefault();
}, true);

function logout() {
    swal({
            title: "Are you sure logout?",
            text: "Finish this session",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes',
            closeOnConfirm: false,
            //closeOnCancel: false
        },
        function() {
            window.location.href = "<?=base_url('action/logout?api='.$this->id_t); ?>";
        });
}

function menu(url, nav, table, menuid) {
    document.title = nav;
    $.ajax({
        type: "POST",
        url: url + "?api=<?=$this->id_t;?>",
        data: "nav=" + nav + "&url=" + url + "&table=" + table + "&menuid=" + menuid +
            "&<?=$this->security->get_csrf_token_name();?>=" + cv,
        cache: false,
        success: function(data) {
            $('#content').html(data);

        }

    });
}

function menuUser(url, nav) {
    swal({
            title: "Are you sure?",
            text: "Process " + nav,
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes',
            closeOnConfirm: false,
            //closeOnCancel: false
        },
        function() {
            window.location.href = url + "?api=<?=$this->id_t;?>";
        });
}

function del_all(table, bk) {
    swal({
            title: "Are you sure?",
            text: "You will clear all data",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn-danger',
            confirmButtonText: 'Yes',
            closeOnConfirm: false,
            //closeOnCancel: false
        },
        function() {

            $.ajax({
                type: "POST",
                url: "<?=base_url('master/del_all?api='.$this->id_t); ?>",
                data: "table=" + table + "&bk=" + bk + "&<?=$this->security->get_csrf_token_name();?>=" +
                    cv,
                cache: false,
                success: function(data) {
                    swal({
                        title: "Delete Success",
                        text: "",
                        type: "success",
                        timer: 1200,
                        showConfirmButton: false
                    });
                    $('#example').DataTable().ajax.reload();
                }

            });
        });
}

function print_l(id, tablex) {
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
            window.open("<?=base_url('s_print/');?>" + tablex + "?id=" + id + "&api=<?=$this->id_t;?>", "_blank");

        });
}

function filex() {
    $("#file").modal('show');
}



function getDayGreeting() {
    let today = new Date()
    let curHr = today.getHours()
    if (curHr < 12) {
        $("#greeting").text('GOOD MORNING');
        $("#icon-day").text('🌞');

        // console.log('SELAMAT PAGI');
    } else if (curHr < 15) {
        $("#greeting").text('GOOD AFTERNOON');
        $("#icon-day").text('🌤️');
        // console.log('SELAMAT PAGI');
    } else if (curHr < 18) {
        $("#greeting").text('GOOD AFTERNOON');
        $("#icon-day").text('🌇');

    } else {
        $("#greeting").text('GOOD NIGHT');
        $("#icon-day").text('🌙');
        // console.log('SELAMAT MALAM');
    }


}
getDayGreeting();
</script>
</body>

</html>
<!DOCTYPE html>
<html>
<head>
  <title></title>
<link rel="stylesheet" href="<?=base_url('assets/lte/bootstrap/css/bootstrap.min.css');?>">
<link rel="stylesheet" href="<?=base_url('assets/lte/sweetalert/sweetalert.css') ?>"/>
</head>
<body>
</body>
<script src="<?=base_url('assets/lte/sweetalert/sweetalert.js')?>"></script>
<script type="text/javascript">
  swal({
          title: "Access Denied!",
          text: "Error Privileges",
          type: "error",
          timer: 1500,
          showConfirmButton: false
        },
        function(){
           window.location.href ="<?=base_url('action/logout?api='.$id_t);?>"

        } );      
</script>
</html>
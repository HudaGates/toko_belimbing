<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$title;?> | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=base_url('assets/lte/plugins/fontawesome-free/css/all.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=base_url('assets/lte/ionicons-2.0.1/css/ionicons.min.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=base_url('assets/lte/dist/css/adminlte.min.css');?>">
  <!-- Google Font: Source Sans Pro -->
  <link rel="shortcut icon" href="<?=$logo;?>" type="image/x-icon" />
  <style type="text/css">
    
    .has-error .form-control {
      border-color: #a94442;
      -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
              box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
    }
    
    .has-error .form-control-feedback {
      color: #a94442;
    }
    
  </style>
</head>
<body class="hold-transition login-page" style="background:url('<?=$bg;?>');background-repeat: no-repeat;background-size:100% 100%;vertical-align: middle;">
<div class="login-box">
  <div class="login-logo">
    <a href="" class="nav-link brand-image img-circle elevation-5 bg-<?=$thema;?> text-center border border-<?=$thema;?>" style="margin: auto;width: 120px;">
        <span class="text-xl text-bold "><?=$title;?></span>
        
      </a>
  </div>
  <!-- /.login-logo -->
  <div class="card border border-<?=$thema;?>">
    <h5 class="bg-<?=$thema;?> text-center p-2">
      <?=$detail;?></h5>
    <?=form_open('action/login', 'id="mydata" '); ?>
      <div class="card-body login-card-body">
         <p class="mb-1 text-lg"><span class="fas fa-user-lock text-green"></span> Please Log In</p>
         <hr style="border-color: #ccc">      
          <div class="form-group mb-3">
            <span>Username</span>
            <input id="username" name="username" type="text" class="form-control" autocomplete="off" placeholder="Username">
          </div>
          <div class="form-group mb-3">
            <span>Password</span>
            <input id="password"  name="password" type="password" class="form-control" placeholder="*****" required="required" autocomplete="off">
          </div>
          <div class="form-group mb-3">
            <button type="submit" class="btn btn-block btn-outline-success">Submit</button>
          </div>
        </div>
      <?=form_close(); ?>
      <!-- /.social-auth-links -->
      <p class="mb-0 text-center text-sm bg-<?=$thema;?>" style="padding: 10px;">
        <a href="" class="text-center">Copy Right &copy; <?=$year;?> - <?=$owner;?></a>
      </p>
    </div>
    <!-- /.login-card-body -->
</div>
<!-- /.login-box -->
</body>

<!-- jQuery -->
<script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js')?>"></script>
<script src="<?=base_url('assets/lte/dist/js/adminlte.min.js');?>"></script>

<!-- AdminLTE App -->
<script type="text/javascript"> 
  var csfrData = {};
    csfrData['<?=$this->security->get_csrf_token_name(); ?>'] = '<?=$this->security->get_csrf_hash(); ?>';
    $.ajaxSetup({
    data: csfrData
    });
  $(window).load(function() { 
      $("#username").focus();
    })

    $('#mydata').submit(function(e){
        e.preventDefault();
         var fa = $(this);            
          $.ajax({
            url: fa.attr('action'),
            type: 'post' ,
            data: fa.serialize(),
            dataType: 'json',
            success: function(response) {
              if(response.success == true) {
                window.location.href ="<?=base_url('home');?>?api="+response.id_t
              }else{
                $.each(response.messages,function(key, value){
                  var element = $('#' + key);
                  element.closest('div.form-group')
                  .removeClass('has-error')
                  .addClass(value.length > 0 ? 'has-error' : 'success')
                  .find('.text-danger')
                  .remove();
                  element.after(value);
                });
                $("#username").focus();
              }
            }
         });

      });
  setTimeout(function () { 
      location.reload();
    }, (5 * 60) * 1000);
</script>
</body>
</html>

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
<body class="hold-transition login-page" style="background:url('<?='.'.$bg;?>');background-repeat: no-repeat;background-size:100% 100%;vertical-align: middle;">
<div class="login-box" style="vertical-align: top">
  <div class="login-logo">
    <a href="" class="nav-link brand-image img-circle elevation-5 bg-<?=$thema;?> text-center border border-<?=$thema;?>" style="margin: auto;width: 120px;">
        <span class="text-xl text-bold "><?=$title;?></span>
        
      </a>
  </div>
   <div class="card border border-<?=$thema;?>">
         <h5 class="bg-<?=$thema;?> text-center p-2">
      <?=$detail;?></h5>
             
          <p class="mb-1 text-center">
            <br>
            <button id="tampiluser" class="btn btn-outline-success btn-lg">Log In <?=$user_level;?></button>
          </p>
            <div id="login">
              <?=form_open('action/login', 'id="mydata" '); ?>
                <div class="card-body login-card-body">
                  <p class="mb-1 text-lg"><span class="fas fa-user-lock text-green"></span>  Log In </p>
                  <hr style="border-color: #ccc"> 
                  <div class="form-group mb-3 text-center">
                    <span>Input Password</span>
                    <input id="username" type="hidden" class="form-control text-center" name="username" />
                    <input id="password" type="password" class="form-control text-center" name="password"  required="required" autocomplete="off" />
                  </div>
                  
                </div>
                <div class="row">
                  <div class="col-6 text-center">
                    <a href="" class="btn btn-outline-danger">Cancel</a>
                  </div>
                  <!-- /.col -->
                  <div class="col-6 text-center">
                    <button type="submit" class="btn btn-outline-success">Submit</button>
                  </div>
                <!-- /.col -->
                  </div>
              <?=form_close(); ?>
              
            </div>
            <div class="pilihuser" style="height: 300px;display:inherit;width: 100%">
              <div class="text-center" style="width: 100%;padding-left: 20px;padding-right: 20px;overflow-y: auto;">
                <p class="text-lg text-bold">SELECT USER</p>
                <?php foreach ($data_user as $key) {?>
                <span class="btn btn-outline-success btn-block text-center" onclick="pilihuser('<?=$key->username;?>')"><?=$key->nama;?></span>
                 <?php } ?>
               </div>
            </div> 
            
          <p class="mb-0">
            &nbsp;
          </p>
          <p class="mb-0 text-center text-sm bg-<?=$thema;?>" style="padding: 10px;border-top: 1px solid #999;">
            <a href="" class="text-center">Copy Right &copy; <?=$year;?> - <?=$owner;?></a>
          </p>
        </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="<?=base_url('assets/lte/jquery/jquery-2.1.3.min.js')?>"></script>

<!-- AdminLTE App -->
<script type="text/javascript"> 
  var csfrData = {};
    csfrData['<?=$this->security->get_csrf_token_name(); ?>'] = '<?=$this->security->get_csrf_hash(); ?>';
    $.ajaxSetup({
    data: csfrData
    });
  $(window).load(function() { 
      $("#login").hide();
      $(".pilihuser").hide();
      $("#tampiluser").click(function(){
        $(".pilihuser").show();
        $("#tampiluser").hide();
      });    
    })
    //----------------------
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
                  .addClass(value.length > 0 ? 'has-error' : 'has-success')
                  .find('.text-danger')
                  .remove();
                  element.after(value);
                });
                $("#password").focus();
              }
            }
         });

      });
    //-----------------------------
    function pilihuser(username){
            $("#login").show();
            $(".pilihuser").hide();
            $("#tampiluser").attr('disabled', true);
            $("#password").focus();
            $("#username").val(username);
    }
    setTimeout(function () { 
      location.reload();
    }, (5 * 60) * 1000);
  </script>
  </body>
</html>

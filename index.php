<?php 
include("includes/config.inc.php"); 
if (isset($_SESSION['login']) && $_SESSION['login'] !="") {
  header("location: home.php?token=".$_SESSION['token']);
  exit;
}
$token = md5(uniqid(rand(), true));
    $_SESSION['token'] = $token;
    $_SESSION['token_time']=time();
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
    session_destroy();
    $token = md5(uniqid(rand(), true));
    $_SESSION['token'] = $token;
    $_SESSION['token_time']=time();
    header("location: index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=SITE_PAGE_TITLE?> | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
    function formSubmit(){
    if($("#txtusername").val() == "" ){
            $("#txtusername").focus();
            alert("Please Enter Username");
            return false;
        }
    if($("#txtpassword").val() == "" ){
            $("#txtpassword").focus();
            alert("Please Enter Password");
            return false;
        }
    }
    // get Modal form
    function getModal(){
        $.post("ajaxrequest/forget_password.php",
        function(data){
            $("#forgetPwd").html(data);
        });
    }
    function getPassword(){
      var mobile = document.getElementById("mobile").value;
      if(mobile == ""){
        alert("Please Enter Your Mobile No.");
      }
      else{
        $.post("ajaxrequest/send_password.php",
        {
            mobile : $("#mobile").val()
        },
        function(data){
            $("#dvmsg").html(data);
        });
      }
    }
  </script>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="http://indiantruckers.com/"><b>Indian</b>Truckers</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <div id="msg"><!-- msg -->
      <!-- Show alert Message -->
    </div> <!-- end msg -->
    <p class="login-box-msg">Sign in to start your session</p>
    <?php if(isset($_GET["login-failed"])){?>
      <div class='alert alert-danger alert-dismissible' role='alert'>
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
        <strong><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                </strong> <?= $_GET["login-failed"];?>
      </div>   
    <?php } ?>
    <form name="login" method="post" action="login.php" onsubmit="return formSubmit(this);">
      <div class="form-group has-feedback">
        <input name="txtusername" type="text" class="form-control" id="txtusername" placeholder="Enter User Name" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" />
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input placeholder = "Enter Password" class = "form-control" name = "txtpassword" type = "password" id = "txtpassword" value="<?php if (isset($_COOKIE["member_password"])){ echo $_COOKIE["member_password"];
        } ?>" />
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
        <div class="col-xs-8">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> >
              Remember Me
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          
          <input type="submit" name= "submit" class="btn btn-primary btn-block btn-flat"  value="LogIn" id="submit" />
        </div>
        <!-- /.col -->
      </div>
    </form>
    <a data-toggle="modal" data-target="#myModal" onclick="getModal();" href="#">I forgot my password</a><br>
  </div>
  <!-- /.login-box-body -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
      <div class="modal-content" id="forgetPwd">
        
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->
</div>
<!-- /.login-box -->

<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="assets/plugins/iCheck/icheck.min.js"></script>
<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>

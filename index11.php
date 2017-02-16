<?php 
include("includes/config.inc.php"); 
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
<!Doctype html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<!--bootstrap css-->
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/custom.css">
<title><?=SITE_PAGE_TITLE?></title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script language="javascript">
// base64 = new Nibbler({
//     dataBits: 8,
//     codeBits: 6,
//     keyString: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
//     pad: '='
// });
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
    $.post("ajaxrequest/send_password.php",
    {
        mobile : $("#mobile").val()
    },
    function(data){
        location.reload();
        $('#myModal').fadeOut();
        $("#msg").html(data);
    });
}
</script>
</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--open of the header-->
	<div class="container-fluid" id="header">
    	<div class="row">
            <div class="col-md-6">
                <img src="images/indian_truckers.png" class="img-responsive" alt="Indian Truckers" title="Indian Truckers">
            </div>
            <div class="col-md-6">
            	
            </div>
        </div>
    </div>
    <!--end of the header-->

<!--open of the content-->
<div class="row" id="content">
    <div class="col-md-12" id="msg">

    </div>
	<div class="col-md-12" id="logindv">
    	<div class="panel panel-default" id="emplogin-panel">
          <!-- Default panel contents -->
          <!--<div class="panel-heading"><strong>User Login</strong></div>-->
            <div id="dvMsg"><!-- dvMsg -->
            <?php if(isset($_GET["login-failed"])){?>
             <div class='alert alert-danger alert-dismissible' role='alert'>
                <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                <strong><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
                </strong> <?= $_GET["login-failed"];?>
              </div>   
            <?php } ?>    
            </div><!-- dvMsg -->
            <form name="login" method="post" action="login.php" onsubmit="return formSubmit(this);">
              <div class="form-group">
                <label for="Username">Username</label>
                <input name="txtusername" type="text" class="form-control" id="txtusername" placeholder="Enter User Name" value="<?php if(isset($_COOKIE["member_login"])) { echo $_COOKIE["member_login"]; } ?>" />
              </div>
              <div class="form-group">
                <label for="Password">Password</label>
                <input placeholder = "Enter Password" class = "form-control" name = "txtpassword" type = "password" id = "txtpassword" />
              </div>
              <div class="checkbox">
                <label>
                  <input type="checkbox" name="remember" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> > Remember Me 
                </label>
              </div>
              <div class="form-group">
                <label>
                  <a data-toggle="modal" data-target="#myModal" onclick="getModal();" href="#">Forgot Password</a>
                </label>
              </div>
              <input type="submit" name= "submit" class="btn btn-default" onClick="sendLoginDetails();" value="LogIn" id="submit" />
            </form>
        </div>
    </div>
</div>
<!--end of the content-->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content" id="forgetPwd">
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
</div>
<!--end wraper-->
<!--Javascript-->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
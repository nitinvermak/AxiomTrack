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
if(isset($_POST['submit']))
{
	$email = mysql_real_escape_string($_POST['email']);
	if($email != NULL)
	{
		$sql = "SELECT Password FROM tbluser WHERE emailid = '$email'";
		$result = mysql_query($sql);
		$resultArr = mysql_fetch_assoc($result);
		$pass = $resultArr['Password'];
		// send password
		$to      = 'sndchrs440@gmail.com';
		$subject = 'Indian Truckers';
		$message = 'Hello from web';
		$headers = 'From: sndchrs440@gmail.com' . "\r\n" .
			'Reply-To: sndchrs440@gmail.com' . "\r\n" .
			'X-Mailer: PHP/' . phpversion();
		
		mail($to, $subject, $message, $headers);
		echo $to.'<br>'.$subject.'<br>'.$message.'<br>'.$headers;
		//end
	}
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
<script type="text/javascript" src="js/Nibbler.js"></script>
<script language="javascript">
base64 = new Nibbler({
    dataBits: 8,
    codeBits: 6,
    keyString: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/',
    pad: '='
});
function formvalid()
{
    if (document.login.txtusername.value=='')
    {
        alert("Please enter User Name");
        document.login.txtusername.focus()
        return false;
    }
    if (document.login.txtpassword.value=='')
    {
        alert("Please enter Password");
        document.login.txtpassword.focus()
        return false;
    }   
//  alert(base64.encode(document.login.txtpassword.value));
//alert(base64.encode(document.login.txtpassword.value));
    document.login.txtpassword.value=base64.encode(document.login.txtpassword.value);
    return true;
}
</script>
<style>
#email{
border-radius:0px;
max-width:400px;
}
.panel-warning{
max-width:600px;
}
</style>
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
	<div class="col-md-12">
   <div class="panel panel-warning">
  	<div class="panel-heading">Forgot Your Password</div>
  		<div class="panel-body">
		<p>Enter the Email address of your account to reset your password.</p>
        <form method="post">
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="text" name="email" class="form-control" id="email" placeholder="Email">
                <p class="help-block"></p>
            </div>
            <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Submit">
        </form>
      </div>
      
    </div>

   
	</div>
</div>
<!--end of the content-->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
</body>
</html>
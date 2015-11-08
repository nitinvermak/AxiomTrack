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
    	<center>
        <form name="login" action="login.php" method="post" onSubmit="formvalid()">
        <input type="hidden" name="submitForm" value="yes" />
        <input type="hidden" name="encpassword" value="" />
         <table>
             <tr>
                 <td><strong>Username</strong></td>
                 <td><input name="txtusername" type="text" class="form-control" id="txtusername" value="Enter User Name" onBlur="if(this.value=='') this.value='Enter User Name'" onFocus="if(this.value =='Enter User Name' ) this.value=''"/></td>
             </tr>
             <tr>
                 <td><strong>Password</strong></td>
                 <td> <input value="Enter Password" class="form-control" onBlur="if(this.value=='') this.value='Enter Password'" onFocus="if(this.value =='Enter Password' ) this.value=''" name="txtpassword" type="password" id="txtpassword" /></td>
             </tr>
             <tr>
               <td></td>
               <td><a href="">Forgot Password</a></td>
             </tr>
             <tr>
                 <td></td>
                 <td><input type="submit" class="btn btn-default" value="Submit" id="submit" /></td>
             </tr>
         </table>  
         </form> 
        </center>
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
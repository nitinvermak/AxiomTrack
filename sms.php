<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php");

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
	{
		session_destroy();
		header("location: index.php?token=".$token);
	}
if (isset($_SESSION) && $_SESSION['login']=='') 
	{
		session_destroy();
		header("location: index.php?token=".$token);
	}
$error =0;

if(isset($_POST['send']))
{
	//Your authentication key
	$authKey = "2763A765rdm1CXD561227a2";
	
	//Multiple mobiles numbers separated by comma
	$mobileNumber = $_POST['mobileno'];
	$messageText = $_POST['message'];
	//Sender ID,While using route4 sender id should be 6 characters long.
	$senderId = "Indtrk";
	
	//Your message to send, Add URL encoding here.
	$message = urlencode($messageText);
	
	//Define route 
	$route = "4";
	//Prepare you post parameters
	$postData = array(
		'authkey' => $authKey,
		'mobiles' => $mobileNumber,
		'message' => $message,
		'sender' => $senderId,
		'route' => $route
	);
	
	//API URL
	$url="http://sms.bulk24sms.com/sendhttp.php";
	
	// init the resource
	$ch = curl_init();
	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_POST => true,
		CURLOPT_POSTFIELDS => $postData
		//,CURLOPT_FOLLOWLOCATION => true
	));
	
	
	//Ignore SSL certificate verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	
	
	//get response
	$output = curl_exec($ch);
	
	//Print error if any
	if(curl_errno($ch))
	{
		echo 'error:' . curl_error($ch);
	}
	
	curl_close($ch);
	$msg = $output;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="http://code.jquery.com/jquery.min.js"></script>
<script>
function chkcontactform(obj)
{
	if(obj.mobileno.value == "")
		{
			alert("Please Provide Mobile No.");
			obj.mobileno.focus();
			return false;
		}
	if(obj.message.value == "")
		{
			alert("Please Provide Message");
			obj.message.focus();
			return false;
		}
}
</script>
</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h1>Send Sms</h1>
        <hr>
    </div>
    <div class="col-md-12">  
    <div class="col-md-12" id="contactform"> <!--open of the single form-->
    <?php 
	 if($msg)
	 {
	 	echo "<span style='color:green; font-weight:bold;'>Message Sent Successfully !</span>";	
	 }
	?>
    <form method="post" name="smsform" action="" onSubmit="return chkcontactform(this)">
    	<div class="form-group">
            <label for="To">Mobile No.</label>
            <input type="text" name="mobileno" id="mobileno" class="form-control text_box" />
        </div>
        <div class="form-group">
            <label for="Message">Message</label>
            <textarea cols="16" rows="3" name="message" id="message" class="form-control txt_area"></textarea>
        </div>
        <input type="submit" name="send" id="send" value="Send SMS" class="btn btn-primary btn-sm" />
    </form>
    </div>
        
        
       
    </div> 
    <!--end single sim  form--> 
    
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</html>
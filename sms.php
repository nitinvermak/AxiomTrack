<?php 
if(isset($_POST['send']))
	{
		//Your authentication key
$authKey = "2763ATQcZ7iGJNUK55f2c2d8";

//Multiple mobiles numbers separated by comma
/*$mobileNumber = mysql_real_escape_string($_POST['mobileno']);*/
$mobileNumber = "8800446686";
echo $mobileNumber;

//Sender ID,While using route4 sender id should be 6 characters long.
$senderId = "Indtrk";

//Your message to send, Add URL encoding here.
/*$message = urlencode(mysql_real_escape_string($_POST['message']));*/
$message = urlencode("Test message");
echo $message;
//Define route 
$route = "default";
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

echo $output;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<div>
	<form method="post" name="smsform" action="">
    <table width="200" border="0">
  <tr>
    <td>To</td>
    <td><input type="text" name="mobileno" id="mobileno" /></td>
  </tr>
  <tr>
    <td>Message</td>
    <td><textarea cols="16" rows="3" name="message" id="message"></textarea></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="send" id="send" value="Send SMS" /></td>
  </tr>
</table>

    </form>

</div>
</body>
</html>

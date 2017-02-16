<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");

$customerId = mysql_real_escape_string($_POST['cust_id']);
$name = mysql_real_escape_string($_POST['name']);
$email = mysql_real_escape_string($_POST['email']);
$mobile = mysql_real_escape_string($_POST['mobile']);
$user_name = mysql_real_escape_string($_POST['user_name']);
$password = mysql_real_escape_string($_POST['password']);
$id = mysql_real_escape_string($_POST['id']);
$hashAndSalt = password_hash($password, PASSWORD_BCRYPT);
if($user_name != NULL && $hashAndSalt != NULL)
{
	$checkUsers = mysql_query("select * from users where username='$username'");
	if(mysql_num_rows($checkUsers)<=0)
	{
		$query = mysql_query("insert into users set name = '$name', companyId = '$id', 
							  customerId='$customerId', email = '$email', username = '$user_name',
							  password = '$hashAndSalt', mobile ='$mobile', created_at = Now()");		
		echo "<span style='color:green; font-weight:bold'>User added successfully</span>";
	}
	else
	{
		echo "<span style='color:red; font-weight:bold'>User already exists</span>";
	}
}
else
{
	echo "<span style='color:red; font-weight:bold'>Username or Password required</span>";
}
?>

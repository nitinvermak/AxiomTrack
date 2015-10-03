<?php 

//if (isset($_Get))
//{
//error_reporting(-1);
//include("../xss.php");
if (isset($_SESSION['token']) && $_GET['token'] == $_SESSION['token'])
   {
   }
else
{
//echo $_SESSION['token']."<br />";
//echo $_POST['token']."<br />";
header("location:index.php?logout=1");
}
//}
//echo (time()-$_SESSION['token_time'])."<br />";
if (isset($_SESSION['token']) && isset($_SESSION['token_time']))
{
	if((time()-$_SESSION['token_time'])>2000)
	{
	$token = md5(uniqid(rand(), true));
	$_SESSION['token'] = $token;
	$_SESSION['token_time']=time();
	}
	else
	$token=$_SESSION['token'] ;
}
$use_sts = true;
if ($use_sts && isset($_SERVER['HTTPS'])) {
    header('Strict-Transport-Security: max-age=500');
} elseif ($use_sts && !isset($_SERVER['HTTPS'])) {
    header('Status-Code: 301');
//    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

function gettransporter($id)
{
  $sql="select companyname from tblusers where user_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['companyname'])
  return $result['companyname'];
  else
  return NULL;
  
}

?>
<?php
include("includes/config.inc.php"); 
$msg="";
if(isset ($_REQUEST['submitForm']) && $_REQUEST['submitForm']=='yes')
{
	$emp_username=mysql_real_escape_string($_REQUEST['txtusername']);
	$emp_password=mysql_real_escape_string($_REQUEST['txtpassword']);
	$userArr=mysql_query("select * from tbluser where User_ID='$emp_username' and Password='$emp_password' ");
		if(mysql_num_rows($userArr)>0)
		{
		  $resultUser=mysql_fetch_assoc($userArr);
		  $_SESSION['user_id']=$resultUser['id'];
		  $_SESSION['login']=getusercategory($resultUser['User_Category']);
		  $_SESSION['sess_username']=$resultUser['User_ID'];
		  $_SESSION['name']=$resultUser['First_Name']." ".$resultUser['Last_Name'];
		  $_SESSION['user_category_id']=$resultUser['User_Category'];
		  $token = md5(uniqid(rand(), true));
		  $_SESSION['token'] = $token;
		  $_SESSION['token_time']=time();
		  
			 /* if ($resultUser['User_Category']==1)
			  {*/
			  	$sql= mysql_query("Select * from tblmodulename");
				$result = mysql_fetch_assoc($sql);
				$_SESSION['permission'] = array("moduleId" => $result["moduleId"], "moduleCategory"=>$result["moduleCatId"]);
			  	header("location: home.php?token=".$token);
			 /* }
			  else
			  {
			     header("location: index.php");
			  }*/
		  } 
		  else
		  {
		  ?>
		  <script language="javascript" >
		    alert("Invalid Login or Password. Please try again!");
			window.location.href = "index.php";
			</script>
		    <?php
		} 
} 
?>
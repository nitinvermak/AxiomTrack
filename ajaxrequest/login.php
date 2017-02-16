<?php
include("../includes/config.inc.php"); 

$userName = mysql_real_escape_string($_POST['userName']);
$password = mysql_real_escape_string($_POST['password']);

$sql_login_chk = "SELECT * FROM `tbluser` 
				  WHERE `User_ID`='$userName' 
				  AND `Password`='$password' 
				  AND `User_Status` = 'A'";				  
$result = mysql_query($sql_login_chk);
if (mysql_num_rows($result)>0) {
	$row = mysql_fetch_assoc($result);
	$_SESSION['user_id'] = $row['id'];
	$_SESSION['login']=getusercategory($row['User_Category']);
	$_SESSION['sess_username']=$row['User_ID'];
	$_SESSION['name']=$row['First_Name']." ".$row['Last_Name'];
	$_SESSION['user_category_id']=$row['User_Category'];
	$_SESSION['branch'] = $row['branch_id'];
	$token = md5(uniqid(rand(), true));
	$_SESSION['token'] = $token;
	$_SESSION['token_time'] = time();
	if ( ($row['User_Category'] == 9) || ($row['User_Category'] == 5) || ($row['User_Category'] == 8)){
		$sql= mysql_query("Select * from tblmodulename");
		$result = mysql_fetch_assoc($sql);
		$_SESSION['permission'] = array(
											"moduleId" => $result["moduleId"], 
											"moduleCategory"=>$result["moduleCatId"]
										);
		// header("location: pending_works.php?token=".$token);
		echo ("<SCRIPT LANGUAGE='JavaScript'>
				    window.location.href='pending_works.php?token=$token';
			   </SCRIPT>");
	}
	else{
		$sql= mysql_query("Select * from tblmodulename");
		$result = mysql_fetch_assoc($sql);
		$_SESSION['permission'] = array(
											"moduleId" => $result["moduleId"], 
											"moduleCategory"=>$result["moduleCatId"]
										);
		// header("location: home.php?token=".$token);
		echo ("<SCRIPT LANGUAGE='JavaScript'>
				    window.location.href='home.php?token=$token';
			   </SCRIPT>");

	}
}
else{
	
	echo "<div class='alert alert-danger alert-dismissible' role='alert'>
	        <button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
	        <strong><span class='glyphicon glyphicon-exclamation-sign' aria-hidden='true'></span>
	        </strong> Invalid Username or Password !
	      </div>";
}
?>

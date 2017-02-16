<?php
include("includes/config.inc.php"); 
$msg="";
if(isset ($_POST['submit']))
{
	$userName = mysql_real_escape_string($_POST['txtusername']);
	$password = mysql_real_escape_string($_POST['txtpassword']);
	// echo $userName;
	// echo "<br>";
	// echo $password;
	// exit();
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
		$ip = $_SERVER['REMOTE_ADDR'];
		$userId = $_SESSION['user_id'];
		// Save Login History
		$sql = "INSERT INTO `userloginhistory` SET `userId`= '$userId', `lastlogin`= Now(), 
				`ipAddress`='$ip'";
		$result = mysql_query($sql);
		// echo $sql;
		// exit();
		// Username and Password Remember
		if(!empty($_POST["remember"])) {
				setcookie ("member_login",$userName,time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["member_login"])) {
					setcookie ("member_login","");
				}
				if(isset($_COOKIE["member_password"])) {
					setcookie ("member_password","");
				}
			}
		if ( ($row['User_Category'] == 9) || ($row['User_Category'] == 5) || ($row['User_Category'] == 8)){
			$sql= mysql_query("Select * from tblmodulename");
			$result = mysql_fetch_assoc($sql);
			$_SESSION['permission'] = array(
												"moduleId" => $result["moduleId"], 
												"moduleCategory"=>$result["moduleCatId"]
											);
			header("location: pending_works.php?token=".$token);
			// echo ("<SCRIPT LANGUAGE='JavaScript'>
			// 		    window.location.href='pending_works.php?token=$token';
			// 	   </SCRIPT>");
		}
		else{
			$sql= mysql_query("Select * from tblmodulename");
			$result = mysql_fetch_assoc($sql);
			$_SESSION['permission'] = array(
												"moduleId" => $result["moduleId"], 
												"moduleCategory"=>$result["moduleCatId"]
											);
			header("location: home.php?token=".$token);
			// echo ("<SCRIPT LANGUAGE='JavaScript'>
			// 		    window.location.href='home.php?token=$token';
			// 	   </SCRIPT>");

		}
	}
	else{
		$msg = "Invalid Username or Password !";
		header("location: index.php?login-failed=".$msg);
		
	}
} 
?>
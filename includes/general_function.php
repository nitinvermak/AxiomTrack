<?php

/**
 * doquery function executes the SQL statement on a classic Mysql library.
 * It comes with a wrapper code to handle and report SQL errors and also 
 * show a better error output on the page.
 * @subpackage Database Helpers
 */

function doquery($sql,$ln=0,$die_on_error=1)
{
	global $debugprinting;
	global $debug_dump;
	global $last_mysql_error;
	global $last_mysql_errno;
	
	global $query_counter;
	$query_counter++;
	if($debugprinting)
	{
		echo "\n<!-- $query_counter: doquery($sql) ";
		
		global $debug_query_tracking;
		if(isset($debug_query_tracking) && $debug_query_tracking)
		{
			global $start_tracking;
			if(!isset($start_tracking))
			{
				$start_tracking = time();
				$fp = fopen("/var/www/backup/query-dump.txt","w");
			}
			else
			{
				$fp = fopen("/var/www/backup/query-dump.txt","a");
			}
			$secs = time() - $start_tracking;
			fwrite($fp,"\n $secs : $sql");
			fclose($fp);
		}
	}

//	#memory error occured here. TODO.
//	#$debug_dump .= "<font class=query>doquery($sql) /* line $ln */</font>\n";		
	
	$ts = microtime_float();
	$result = mysql_query($sql);
	$te = microtime_float();
	
	if($debugprinting)
	{
		global $total_query_time;
		if(!isset($total_query_time)) $total_query_time = 0;
		$diff = $te-$ts;
		echo "took " . $diff . "ms, ($te, $ts) $total_query_time(ms) -->\n";
		$total_query_time += ($te - $ts);
	}
	if($last_mysql_errno = mysql_errno())
	{
		$errstr = $last_mysql_error = mysql_error();
		global $debug_dump;
		$e_out = "<font color=red>$errstr</font> at line $ln (" . session_id() . ")<br/>";
		
	//	#$e_out = "\n<hr/>\n" . var_export(debug_backtrace(),true);
		$debug_dump .= $e_out;
		
		global $bLocalSite;
		
		if($debugprinting || $bLocalSite)
		{
			$erl = "";
			$erl .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"/css/v2.css\" />";
			$erl .= "<div class='sql_error'>" . $errstr . "</div>";
			$erl .= "<div class='sql'>$sql</div>";
			$erl .= "<pre class='backtrace'>";
			if(0 && isset($_SESSION["testcase"]))
				$erl .= var_export(debug_backtrace(),true);
			$erl .= "</pre>";
			echo $erl;
		}
		
		$errstr .= "\nSQL: $sql\nCALL STACK\n";
		$errstr .= var_export(debug_backtrace(),true) . "\nSESSION\n";
		$errstr .= var_export($_SESSION,true) . "\nGET\n";
		$errstr .= var_export($_GET,true) . "\nPOST\n";
		$errstr .= var_export($_POST,true) . "\nSERVER\n";
		$errstr .= var_export($_SERVER,true) . "\n";

		$errstr = quotemeta($errstr);
		//logthis("v2-doquery-FAILED",$errstr);
		//@mail("sarup@think-byte.com","DoQuery Failed (v2)",$errstr);
		if($die_on_error)
		
			exit;
		else
			return false;
	}
	
	return $result;
}

/**
 * To run query using the mysqli library
 * @subpackage Database Helper
 * @param string $sql SQL to execute
 * @param integer $ln Line number of the caller
 * @param boolean $die_on_error if the call should die on failure to execute the query
 * @return boolean
 */
function doqueryi($sql,$ln=0,$die_on_error=1)
{
	global $mysqli;
	global $debugprinting;
	global $debug_dump;
	global $last_mysql_error;
	global $last_mysql_errno;
	if($debugprinting)
		echo "<!-- doqueryi ($sql) -->\n";
	
	$debug_dump .= "<font class=query>doquery($sql) /* line $ln */</font>\n";		
	
	$result = mysqli_query($mysqli,$sql);
	if($last_mysql_errno=mysqli_errno($mysqli))
	{
		$errstr =$last_mysql_error =  mysqli_error($mysqli);
		
		$e_out = "<font color=red>$errstr</font> at line $ln (" . session_id() . ")<br/>";
		$debug_dump .= $e_out;
		mysqli_rollback($mysqli);
		if($debugprinting)
		{
			echo "<div class='sql_error'>" . $errstr . "</div>";
			echo "<div class='sql'>$sql</div>";
			echo "<pre class='backtrace'>";
			debug_print_backtrace();
			echo "</pre>";
		}
		$errstr = quotemeta($errstr);
		logthis("v2-doquery-FAILED",$errstr);
		if($die_on_error)
			exit;
		else
			return false;
	}
	return $result;
}

/**
 * Returns the row object after calling mysql_fetch_object
 * Support debug hooks.
 * @subpackage Database Helper
 * @param result resource $rl
 * @param integer $line Caller line number
 * @param string $file  caller file name
 * @return object
 */

function dofetch($rl,$line="(noline)",$file="(nofile)")
{
	global $debugprinting;
	$rs = mysql_fetch_object($rl);

	if($debugprinting && function_exists("debugprint"))
		debugprint("<!-- FETCH DUMP ($file:$line)\n" . var_export($rs,true) . "\n-->");

	return $rs;
}

function dofetcharray($rl,$line="(noline)",$file="(nofile)")
{
	global $debugprinting;
	$rs = mysql_fetch_array($rl);
	if($debugprinting)
	{
		echo "<!-- FETCHARRAY DUMP ($file:$line)\n";
		print_r($rs);
		echo "\n-->";
	}
	return $rs;
}

function dofetcharrayi($rl,$line="(noline)",$file="(nofile)")
{
	global $debugprinting;
	global $mysqli;
	
	$rs = mysqli_fetch_array($rl);
	if($debugprinting)
	{
		echo "<!-- FETCHARRAY DUMP ($file:$line)\n";
		print_r($rs);
		echo "\n-->";
	}
	return $rs;
}


function getRandomText()
{
//	#first guess the para size
	$max_words = rand(500,1000);
//	#then loop to get words and append to sentence
	$sentence = "";
	for($wc=0; $wc<$max_words; $wc++)
	{
		$sentence .= getRandomWord() . " ";
	}
	return $sentence;
}

function getRandomWord($min_length = -1)
{
//	#choose word length
	if($min_length==-1)
		$max_chars = rand(1,10);
	else
		$max_chars = rand($min_length,10);
	
	$char = "";
	for($cc=0; $cc<$max_chars; $cc++)
	{
		$char .= chr( rand ( ord ( "a" ) , ord ( "z" ) ) );
		$cc++;
	}
	
	return $char;
}

function debug($data)
{
	echo "<pre>";
	print_r($data);
	echo "</pre>";
}

//#added jslert function to report critical ui errors on the face of the bloody user!
function jsalert($msg)
{
	?>
	<script type="text/javascript">
	alert("<?=$msg?>");
	</script>
	<?php
}

function highthis($s)
{
	echo "<b>" . $s . "</b>";
}

function cleanvarp($var,$el)
{

	return isset($_POST[$var]) ? $_POST[$var] : $el;
}

function cleanvarg($var,$el)
{
	return isset($_GET[$var]) ? $_GET[$var] : $el;
}

function cleanvars($var,$el)
{
	return isset($_SESSION[$var]) ? $_SESSION[$var] : $el;
}

//#:generic fuction to scan either GET or POST automatically
function cleanvar($var,$el)
{
	return isset($_REQUEST[$var]) ? $_REQUEST[$var] : $el;
}

//#for upload the reated while board or audio/video and image files.
/*function upload_file($filename,$destination,$id)
{

	     $ext=explode('.',$_FILES[$filename]['name']);  // get the extention of image	 
		 $name=$ext[0].$id.".$ext[1]";		
		 $name=$ext[0].$id.".$ext[1]";
		 move_uploaded_file($_FILES[$filename]['tmp_name'],$destination.$name)or die("can't Uploaded");
		 chmod($destination.$name,0777);
	     return $ext;	
	
}
*/
function upload_file($filename,$destination,$tbl_field="")
{
	echo $_FILES[$filename]['name'];
//	die;
	if($_FILES[$filename]['name']!='')
	{
		 $ext=explode('.',$_FILES[$filename]['name']);  // get the extention of image	
		 $name=$ext[0]."_".date("YmdHis").".$ext[1]";
		 echo $destination.$name;
		 echo '</br>';
		 echo '....';
		 echo $filename;
		 echo $_FILES[$filename]['tmp_name'];
		 
		 move_uploaded_file($_FILES[$filename]['tmp_name'],$destination.$name)or die("can't Uploaded");
		 chmod($destination.$name,0777);
		 $sql_edit_part=$name ;
	}	
	 
	 return $sql_edit_part;
}




/**
 * created a random string. 
 * In advanced mode, it will create a mixed case string with numbers
 */
function fnRandomChar ($var_MaxLength = 8,$advanced=false,$loweruppper=0)
{ 
  $var_Password = ""; 
  $var_Possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  if($advanced)
  {
  	$var_Possible .= strtolower($var_Possible);
	$var_Possible .= "0123456789";
	$var_MaxLength =16;
  }
  else if($loweruppper)
  {
  	$var_Possible .= strtolower($var_Possible);
	$var_Possible .= "0123456789";
  }
  $i=0;
  while(($i < $var_MaxLength)&&(strlen($var_Possible) > 0))
  { 
    $i++;
   $var_Character = substr($var_Possible, mt_rand(0, strlen($var_Possible)-1), 1);
    $var_Possible = preg_replace("/$var_Character/", "", $var_Possible); 
    $var_Password .= $var_Character;
  } 
 return $var_Password; 
}

/**
  * here defining a function who runs a query sent in it's parameter.and return a table containing all resultset
  */
function run_query($sql)
{
	$result=doquery($sql);
	?><title>viceAmt</title>
	<table border="1">
		<tr>
		<?php
			$i=0;
			$numfld=mysql_num_fields($result);
			while ($i < $numfld) 
			{
				$fieldList = mysql_fetch_field($result, $i);
				?>
				<th><?=$fieldList->name?></th>
				
				<?php
				$i++;						
			}
		?>
		</tr>
		<?php
			if(mysql_num_rows($result)>0)
			{
				while($rs=dofetcharray($result))
				{
					?>
					<tr>
					<?php
						$i=0;
						while($i < $numfld) 
						{
							?>
							<td><?=$rs[$i]?></td>
							<?php
							$i++;
						}
					?>
					</tr>
					<?php
				}
			}
			else
				echo "No result found!";
		?>
	</table>
	<?php
} 

function microtime_float()
{
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

/* function for display date format */
function new_date_format($date)
{
return($date);
}

/* function for protect user page */
function protect_user()
{
  if(!isset($_SESSION['emp_id']))
  {
  $path=SITE_WS_PATH."index.php";
  header("location:$path");
  }
}

/* function for fetch single field from  any table */
function db_scalar($sql)
{
	$rs=doquery($sql);
	$data=dofetcharray($rs);
	return($data[0]);
}

/* function for set message */
function set_message($msg)
{
	$_SESSION['msg']=$msg;
}


/* function for display message */
function display_message()
{
	echo $_SESSION['msg'];
	unset($_SESSION['msg']);
}

/* function for check permission */

function check_permission()
{
	$page_name = basename($_SERVER['PHP_SELF']);
	$permission_id = db_scalar("select gr_page_per_id from mst_page inner join tbl_group_page on gr_page_page_id=page_id 
	where page_name='$page_name' and gr_page_group_id='".$_SESSION['group_id']."'");
	
		if($permission_id=='')
		{	header("location:".SITE_WS_PATH."plan/error_page.php");
			exit;
		}
		/*if($permission_id==1)
		{
		$display=1;
		} else if($permission_id==2 && $id!='')
		{
		$display=2;
		} else if($permission_id==3)
		{
		$display=3;
		} else { $display=0; }*/
		
	return($permission_id);
}

/**
 * change_password
 * change_password function is use to change the password.
 * It has all authentication validation for user to change the password
 * show a better error output on the page.
 * parameter passed old password and New password
 * returns message password change or there is some authentication problem
 * sub function used database execution functions
 */
 function change_password($old_pwd,$new_pwd)
 {
 	$sql = "select emp_email,emp_password from tbl_employee where emp_id=".$_SESSION['emp_id']; 	
	$rs	 = doquery($sql);
	$data= dofetcharray($rs);
	@extract($data);
	if($emp_password!=$old_pwd)
	{
		return 0;
	}
	else
	{
		$sql_update = "update tbl_employee set emp_password='".$new_pwd."' where emp_id=".$_SESSION['emp_id'];
		$rs_update  = doquery($sql_update);
		return 1;
	}
 }
 
 /**
 * file_count
 * file_count function is use to keep track on new uploaded files.
 * This function retuns the total count the total number of new uploaded files related to the user.
 */
 function file_count()
 {
 	$sql = " SELECT count( a.`doc_name` ) AS cnt
			 FROM
			  tbl_doc_repository a inner join tbl_employee b on b.emp_id=a.uploaded_by
			 WHERE 
			  a.status = 'new'";	
	if($_SESSION['group']!='Administrator')
	{
		$sql .=" and (b.emp_circle=".$_SESSION['circle_id']." || b.emp_hub=".$_SESSION['circle_id']." || b.emp_lob=".$_SESSION['lob_id']." || b.emp_zone =".$_SESSION['zone_id'].")";
	}
	//print $sql;
	$cnt = db_scalar($sql);
	return($cnt);
 }
 
  /**
 *	open_issue_count
 * open_issue_count function is use show the total number of open issues related to the logged in user.
 * This function retuns the total count of the open issues related to the particular  user
 *.
 */
 function open_issue_count()
 {
 	$sql = " SELECT count(*) as cnt
					FROM tbl_issue a
					INNER JOIN tbl_issue_assign b ON a.issue_id = b.issue_id ";
					if($_SESSION['group']!='Administrator')
					{
						$sql .= "WHERE (
						a.assigned_by =".$_SESSION['emp_id']." || b.assigned_to =".$_SESSION['emp_id']."
						)
						AND a.status_id =1
						GROUP BY a.issue_id ";
					}
					else
					{
						$sql .="where a.status_id =1";
					}
					 
					$sql .=" ORDER BY cnt DESC
					LIMIT 1
					 ";
		$cnt = db_scalar($sql);
		return($cnt);
 }
 
 
 /**
 * close_issue_count
 * open_issue_count function is use show the total number of closed issues related to the logged in user.
 * This function retuns the total count of the open closed related to the particular  user
 *.
 */

function close_issue_count()
 {
 $sql = " SELECT count(*) as cnt
					FROM tbl_issue a
					INNER JOIN tbl_issue_assign b ON a.issue_id = b.issue_id ";
					if($_SESSION['group']!='Administrator')
					{
						$sql .= "WHERE (
						a.assigned_by =".$_SESSION['emp_id']." || b.assigned_to =".$_SESSION['emp_id']."
						)
						AND a.status_id =2
						GROUP BY a.issue_id ";
					}
					else
					{
						$sql .="where a.status_id =2";
					}
					 
					$sql .=" ORDER BY cnt DESC
					LIMIT 1
					 ";
		$cnt = db_scalar($sql);
		return($cnt);
 }
 
 
 /*
function ontime_circle_activity :
this function is use to count the total activities which 
are in proceess/completed ontime inside the circles.
return value is total count of activities.
 */
 function ontime_circle_activity()
 {
 	$sql = "SELECT count(*) as count
				FROM `tbl_project_activity_log` a
				INNER JOIN tbl_employee b ON a.prj_al_user_id = b.emp_id
				INNER JOIN mst_lob c ON c.lob_id = b.emp_lob
				INNER JOIN tbl_project_plan d ON d.plan_id = a.prj_al_plan_plan_id
				INNER JOIN mst_plan_status e ON e.status_id = a.prj_al_plan_status_id
				WHERE (a.`prj_al_plan_completion_date` <= a.`prj_al_plan_end_date`
				AND a.project_al_delete_status = 'false'
				AND d.plan_delete_status = 'No'
				AND d.plan_status = 'Active'";
				if($_SESSION['group']!='Administrator')
				{
					$sql .= " AND a.prj_al_user_id = '".$_SESSION['emp_id']."'";
				}
				$sql .= " AND c.activity_under = 'circle')
				AND a.`prj_al_id` = (
				SELECT max( `prj_al_id` )
				FROM `tbl_project_activity_log`
				WHERE prj_al_plan_plan_id = a.prj_al_plan_plan_id )  ";
				//print $sql;
	$cnt = db_scalar($sql);
	return($cnt);
	
 }
 /*
function delay_circle_activity :
this function is use to count the total activities which 
are in proceess/completed and running by delay inside the circles.
return value is total count of activities.
 */
 function delay_circle_activity()
 {
 	$sql = "SELECT count(*) as count
				FROM `tbl_project_activity_log` a
				INNER JOIN tbl_employee b ON a.prj_al_user_id = b.emp_id
				INNER JOIN mst_lob c ON c.lob_id = b.emp_lob
				INNER JOIN tbl_project_plan d ON d.plan_id = a.prj_al_plan_plan_id
				INNER JOIN mst_plan_status e ON e.status_id = a.prj_al_plan_status_id
				WHERE (a.`prj_al_plan_completion_date` > a.`prj_al_plan_end_date`
				AND a.project_al_delete_status = 'false'
				AND d.plan_delete_status = 'No'
				AND d.plan_status = 'Active'";
				if($_SESSION['group']!='Administrator')
				{
				$sql .= " AND a.prj_al_user_id = '".$_SESSION['emp_id']."'";
				}
				$sql .= " AND c.activity_under = 'circle')
				AND a.`prj_al_id` = (
				SELECT max( `prj_al_id` )
				FROM `tbl_project_activity_log`
				WHERE prj_al_plan_plan_id = a.prj_al_plan_plan_id ) ";
	$cnt = db_scalar($sql);
	return($cnt);
	
 }
/*
function ontime_hub_activity :
this function is use to count the total activities which 
are in proceess/completed ontime inside the hubs.
return value is total count of activities.
 */
 function ontime_hub_activity()
 {
 	$sql = "SELECT count(*) as count
				FROM `tbl_project_activity_log` a
				INNER JOIN tbl_employee b ON a.prj_al_user_id = b.emp_id
				INNER JOIN mst_lob c ON c.lob_id = b.emp_lob
				INNER JOIN tbl_project_plan d ON d.plan_id = a.prj_al_plan_plan_id
				INNER JOIN mst_plan_status e ON e.status_id = a.prj_al_plan_status_id
				WHERE (a.`prj_al_plan_completion_date` <= a.`prj_al_plan_end_date`
				AND a.project_al_delete_status = 'false'
				AND d.plan_delete_status = 'No'
				AND d.plan_status = 'Active'";
				if($_SESSION['group']!='Administrator')
				{
				$sql .= " AND a.prj_al_user_id = '".$_SESSION['emp_id']."'";
				}
				$sql .= " AND c.activity_under = 'hub')
				AND a.`prj_al_id` = (
				SELECT max( `prj_al_id` )
				FROM `tbl_project_activity_log`
				WHERE prj_al_plan_plan_id = a.prj_al_plan_plan_id )  ";
	$cnt = db_scalar($sql);
	return($cnt);
	
 }
 /*
function delay_circle_activity :
this function is use to count the total activities which 
are in proceess/completed and running by delay inside the hubs.
return value is total count of activities.
 */
 function delay_hub_activity()
 {
 	$sql = "SELECT count(*) as count
				FROM `tbl_project_activity_log` a
				INNER JOIN tbl_employee b ON a.prj_al_user_id = b.emp_id
				INNER JOIN mst_lob c ON c.lob_id = b.emp_lob
				INNER JOIN tbl_project_plan d ON d.plan_id = a.prj_al_plan_plan_id
				INNER JOIN mst_plan_status e ON e.status_id = a.prj_al_plan_status_id
				WHERE (a.`prj_al_plan_completion_date` > a.`prj_al_plan_end_date`
				AND a.project_al_delete_status = 'false'
				AND d.plan_delete_status = 'No'
				AND d.plan_status = 'Active'";
				if($_SESSION['group']!='Administrator')
				{
				$sql .= " AND a.prj_al_user_id = '".$_SESSION['emp_id']."'";
				}
				$sql .= " AND c.activity_under = 'hub')
				AND a.`prj_al_id` = (
				SELECT max( `prj_al_id` )
				FROM `tbl_project_activity_log`
				WHERE prj_al_plan_plan_id = a.prj_al_plan_plan_id ) ";
	$cnt = db_scalar($sql);
	return($cnt);
	
 }
 /**
 * forget_password
 * forget_password function is use to send the password to user if user forgets his/her password.
 * It does form and user validation then process the changing of password
 * show a better error output on the page.
 * parameter passed emailid & userid passed from the form
 * returns true if the password found Successfully and sends the password in mail account of the user
 * return false if the password not found
 */
 function forget_password($emailid,$userid)
 {
 	//print "email ". $emailid." user ".$userid;
	if($emailid==''&&$userid=='')
	{
	 	$flag=1;
		return($flag);
	}
	if($emailid!='')
	{
		if (!eregi("^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]{1,})*\.([a-z]{2,}){1}$", $emailid))
		{ 
			$flag=2; //for invalid email id  
			return($flag);
		} 
	}
	if($userid!='')
	{
		if(!eregi("^([0-9a-z.-_])+$", $userid))
		{ 
			$flag=3; //for not a alphanumeric username  
			return($flag);
		} 
	}
	$sql = "select emp_password,emp_email from tbl_employee where emp_email='".$emailid."' or emp_username='".$userid."'";
	$rs	 =  doquery($sql);
	$num_rows = num_count($rs);
	if($num_rows>0)
	{
		$data = dofetcharray($rs);
		return($data);
	}
	else
	{
		$flag=4;
		return($flag);
	}
 }


// This function is used to count total numbers of records in result set
function num_count($res)
{
	$num = mysql_num_rows($res);
	return($num);
}

function max_id()
{
	$max_id = mysql_insert_id();
	return($max_id);
}


function getdepartment($id)
{
  $sql="select dept_name from department where dept_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['dept_name'])
  return $result['dept_name'];
  else
  return NULL;
}
function getSimNo($id)
{
  $sql="SELECT `sim_no` FROM `tblsim` WHERE `id` = ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['sim_no'])
  return $result['sim_no'];
  else
  return 'N/A';
}
function getEstimateId($vid)
{
  $sql="SELECT `estimateId` FROM `devicepayment` WHERE `vehicleId` = ".$vid;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['estimateId'])
  return $result['estimateId'];
  else
  return '0';
}
function getpaymentStatus($val)
{
	if($val == 0)
	{
		echo "Pending";
	}
	else{
		echo "Received";
	}
}
function getcountry($id)
{
  $sql="select Country_name from tblcountry where Country_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Country_name'])
  return $result['Country_name'];
  else
  return NULL; 
}
function getcity($id)
{
  $sql="select State_name from tblstate where State_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['State_name'])
  return $result['State_name'];
  else
  return NULL;
}
function getcities($id)
{
  $sql="select City_Name from tbl_city_new where City_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['City_Name'])
  return $result['City_Name'];
  else
  return 'N/A';
}
function BranchLogin($id)
{
  //return 'asdasd'; 		
  $sql = "select branchId from userbranchmapping where userId = ".$id;
  $rs = mysql_query($sql);
/*  $result = mysql_fetch_assoc($rs);*/
  $auth_branch= '';
  while($row =  mysql_fetch_array($rs)){
  	if ($auth_branch){
		$auth_branch = $auth_branch.','.$row['branchId'];
	}else{
		$auth_branch = $row['branchId'];		
	}
  }
  if($auth_branch == 0){
  	return $auth_branch;	
  }else{
  	return "(".$auth_branch.")";;
  
  }
}
function UserActivityLog($userId, $ipAddress, $pageName, $detailsString)
{
	$detailsString = str_replace("'", " ", $detailsString);
	$sql = "Insert into tbluseractivitylog set userId = '$userId', timeStamp = Now(), ipAddress = '$ipAddress', 
			pageName = '$pageName', detailsString = '$detailsString'";
	/*echo $sql;*/
	$result = mysql_query($sql);
}
function getcityname($id)
{
  $sql="select City_Name from tbl_city_new where City_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['City_Name'])
  return $result['City_Name'];
  else
  return NULL;
}
function getarea($id)
{
  $sql="select Area_name from tbl_area_new where area_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Area_name'])
  return $result['Area_name'];
  else
  return 'N/A';
}
function getpincode($id)
{
  $sql="select Pincode from tbl_pincode where pincode_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Pincode'])
  return $result['Pincode'];
  else
  return NULL;
}
function getdistrict($id)
{
	 $sql="select District_name from tbl_district where District_id=".$id;
  	 $rs=mysql_query($sql);
  	 $result=mysql_fetch_assoc($rs);
  	 if($result['District_name'])
  	 return $result['District_name'];
  	 else
  	 return NULL;
}
function sendConfigSms($model, $mobile, $cmd)
{
	if($model != NULL)
	{
		$sql = "SELECT * FROM `tbldevicecommand` where modelId =".$model;
		$result = mysql_query($sql);
		$resultArr = mysql_fetch_assoc($result);
		/*echo $sql.'ahsfjasf';*/
	//	die();
		sendSms($mobile, $resultArr['ipCmd']);
		sleep(15);
		sendSms($mobile, $resultArr['timeZoneCmd']);
		sleep(5);
		sendSms($mobile, $resultArr['dataIntervelCmd']);
		sleep(5);
		sendSms($mobile, $resultArr['apnCmd']);
	}
	else
	{
		
	}
}
// Send message when configure new vehicle
function SendAlert($id){
	if($id != NULL)
	{
		$sql = "SELECT C.Mobile as clientMob, D.Contact_No as techMob, A.vehicle_no as vehicleNo
				FROM tempvehicledata as A 
				INNER JOIN tbl_customer_master as B 
				ON A.customer_Id = B.cust_id
				INNER JOIN tblcallingdata as C 
				ON B.callingdata_id = C.id
				INNER JOIN tbluser as D 
				ON A.techinician_name = D.id
				WHERE A.id =".$id;
		$result = mysql_query($sql);
		$resultArr = mysql_fetch_assoc($result);
		$mob = $resultArr['clientMob'].','.$resultArr['techMob'];
		$vehicle = $resultArr['vehicleNo'];
		$msg = "Vehicle No. ".$vehicle." Added Successfully !";
		sendSms($mob, $msg);
	}
}
// send message when configure repair vehicle
function SendAlertRepair($id){
	if($id != NULL)
	{
		$sql = "SELECT C.Mobile as clientMobile, D.Contact_No as techMob, A.vehicleId as vehicleNo
				FROM tempvehicledatarepair as A 
				INNER JOIN tbl_customer_master as B
				ON A.customerId = B.cust_id
				INNER JOIN tblcallingdata as C 
				ON B.callingdata_id = C.id 
				INNER JOIN tbluser as D 
				ON A.techinicianId = D.id 
				WHERE A.id = ".$id;
		$result = mysql_query($sql);
		$resultArr = mysql_fetch_assoc($result);
		$mob = $resultArr['clientMobile'].','.$resultArr['techMob'];
		$vehicleNo = getVehicleNumber($resultArr['vehicleNo']); 
		$msg = "Vehicle No. " .$vehicleNo. " Repair Successfully !";
		sendSms($mob, $msg);
	}
}
// This function send message when assign ticket to technician
function sendTicketAlert($technician_id, $mssg)
{
	if($technician_id !=NULL)
	{
		$sql = "SELECT 	Contact_No FROM `tbluser` where id =".$technician_id;
		$result = mysql_query($sql);
		$resultArr = mysql_fetch_assoc($result);
		//echo $resultArr['Contact_No'];
		sendSms($resultArr['Contact_No'], $mssg);
	}
}
function sendTicketConfirmation($callingDataId, $msgClnt)
{
	if($callingDataId !=NULL)
	{
		$sql = "SELECT `Mobile` FROM tblcallingdata WHERE `id`= ".$callingDataId;
		$result = mysql_query($sql);
		$resultArr = mysql_fetch_assoc($result);
		//echo $resultArr['Contact_No'];
		sendSms($resultArr['Mobile'], $msgClnt);
	}
}
// End function
function sendSms($mobileno, $message)
{
	$authKey = "2763A765rdm1CXD561227a2";
	//Multiple mobiles numbers separated by comma
	$mobileNumber = $mobileno;
	$messageText = $message;
	//Sender ID,While using route4 sender id should be 6 characters long.
	$senderId = "Indtrk";
	
	//Your message to send, Add URL encoding here.
	$message = urlencode($message);
	
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
	
	$_SESSION['ticket_msg'] = $output."<br />";
}
function getPassword($mobile)
{
	$sql = "SELECT `Password`, `Contact_No` FROM `tbluser` WHERE `Contact_No`= '$mobile'";
	$result = mysql_query($sql);
	$row = mysql_fetch_assoc($result);
	if($row){
		$msg = "Your Password is: ".$row['Password'];
		$mobile = $row['Contact_No'];
		// echo $msg;
		// exit();
		sendSms($mobile, $msg);
		echo '<div class="alert alert-success alert-dismissible login-alert" role="alert">
          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<strong>Success !</strong> Password Sent to your Mobile. Please check your Mobile.!
			  </div>';
		}
		else{
			echo '<div class="alert alert-danger alert-dismissible login-alert" role="alert">
	          		<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<strong><span class="glyphicon glyphicon-info-sign"></span></strong> Invalid Mobile Number !
				  </div>';
		}
}
function getOraganization($id)
{
  $sql="select Company_Name from tblcallingdata where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Company_Name'])
  return $result['Company_Name'];
  else
  return 'N/A';
}
function get_device_received_amt($vid)
{
  $sql="SELECT SUM(`deviceamt`) AS amt FROM `devicepayment` WHERE `vehicleId`=".$vid;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['amt'])
  return $result['amt'];
  else
  return '0';
}
function getCust($id)
{
  $sql="SELECT A.callingdata_id as callingId, B.Company_Name as CompanyName 
		FROM tbl_customer_master as A 
		INNER JOIN tblcallingdata as B 
		ON A.callingdata_id = B.id
		WHERE A.cust_id = ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['CompanyName'])
  return $result['CompanyName'];
  else
  return 'N/A';
}
function getCustomerName($id)
{
  $sql="SELECT CONCAT(B.First_Name,' ', B.Last_Name) as name
		FROM tbl_customer_master as A 
		INNER JOIN tblcallingdata as B 
		ON A.callingdata_id = B.id
		WHERE A.cust_id = ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['name'])
  return $result['name'];
  else
  return 'N/A';
}
function getCustContact($id)
{
  $sql="SELECT  B.Mobile as mobile
		FROM tbl_customer_master as A 
		INNER JOIN tblcallingdata as B 
		ON A.callingdata_id = B.id
		WHERE A.cust_id = ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['mobile'])
  return $result['mobile'];
  else
  return 'N/A';
}
function getCustomerType($id)
{
  $sql="select customer_type from tbl_customer_type where customer_type_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['customer_type'])
  return $result['customer_type'];
  else
  return 'N/A';
}
function getVehicleNumber($id)
{
  $sql="SELECT vehicle_no FROM tbl_gps_vehicle_master where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['vehicle_no'])
  return $result['vehicle_no'];
  else
  return 'N/A';
}
function getDealer($id)
{
  $sql="SELECT `Company_Name` FROM tbldealer WHERE `id` =".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Company_Name'])
  return $result['Company_Name'];
  else
  return 'N/A';
}

function getVehicleNo($vehicleNo)
{
	if($vehicleNo == NULL)
	{
		echo 'N/A';
	}
	else
	{
		echo $vehicleNo;
	}
}
function getVehicleStatus($status){
	if($status == 'Y')
	{
		echo '<span class="label label-success">Active</span>';
	}
	else
	{
		echo '<span class="label label-danger">Inactive</span>';
	}
}
function getCustType($type){
	if($type != NULL)
	{
		echo $type;
	}
	else
	{
		echo 'N/A';
	}
}
function getBankName($id)
{
  $sql="select bankName from tblbank where bankId=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['bankName'])
  return $result['bankName'];
  else
  return NULL;
}

function getIntervelname($id)
{
  $sql="select Intervalname from tblesitmateperiod where intervalId=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Intervalname'])
  return $result['Intervalname'];
  else
  return NULL;
}
function getproducts($id)
{
  $sql="select category from tblcallingcategory where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['category'])
  return $result['category'];
  else
  return NULL;
}
function getRequesttype($id)
{
  $sql="select 	rqsttype from tblrqsttype where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['rqsttype'])
  return $result['rqsttype'];
  else
  return NULL;
}
function gettelecallername($id)
{
  $sql="select  CONCAT(First_Name,' ',Last_Name) As fullname from tbluser where id='$id' ORDER BY First_Name";
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['fullname'])
  return $result['fullname'];
  else
  return 'N/A';
}
function getCType($type)
{
	if($type == 1)
	{
		echo 'Sale';
	}
	elseif($type == 2)
	{
		echo 'Rent';
	}
	elseif($type == 3)
	{
		echo 'Installment';
	}
	else
	{
		echo 'N/A';
	}
}
function getRepairType($repair)
{
	if($repair == 1)
	{
		echo "Sim";
	}
	else if($repair == 2)
	{
		echo "Device";
	}
	else if($repair == 3)
	{
		echo "Both";
	}
}
function getsimprovider($id)
{
  $sql="select serviceprovider from tblserviceprovider where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['serviceprovider'])
  return $result['serviceprovider'];
  else
  return NULL;
}
function getstate($id)
{
  $sql="select State_name from tblstate where State_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['State_name'])
  return $result['State_name'];
  else
  return 'N/A';
}
function getproviderid($id)
{
  $sql="select company_id from tblsim where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['company_id'])
  return $result['company_id'];
  else
  return NULL;
}
function getIMEINO($id)
{
  $sql="SELECT `imei_no` FROM `tbl_device_master` WHERE `id` =".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['imei_no'])
  return $result['imei_no'];
  else
  return NULL;
}
function getMobile($id)
{
  $sql="select mobile_no from tblsim where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['mobile_no'])
  return $result['mobile_no'];
  else
  return "N/A";
}

function getdevicename($id)
{
  $sql="select model_name from tbldevicemodel where device_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['model_name'])
  return $result['model_name'];
  else
  return NULL;
}
function getCustomerAddress($id)
{
  $sql="SELECT CONCAT(`Address`, '\n' , `Mobile`) as address FROM `tblcallingdata` WHERE `id`=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['address'])
  return $result['address'];
  else
  return 'N/A';
}
function getCustomerDistrict($id)
{
  $sql="SELECT B.District_name as district FROM tblcallingdata as A 
		INNER JOIN tbl_district as B 
		ON A.District_id = B.District_id
		WHERE A.id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['district'])
  return $result['district'];
  else
  return 'N/A';
}
function getDeviceType($custId)
{
  $sql="SELECT B.DeviceType as deviceType FROM tbl_gps_vehicle_payment_master as A 
		INNER JOIN tbl_device_type as B 
		On A.device_type = B.DeviceTypeId WHERE A.cust_id =".$custId;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['deviceType'])
  return $result['deviceType'];
  else
  return NULL;
}
function getDeviceAmt($id)
{
  $sql="select plan_rate from tblplan where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['plan_rate'])
  return $result['plan_rate'];
  else
  return NULL;
}
function getFrequency($id)
{
  $sql="select FrqDescription from tbl_frequency where FrqId=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['FrqDescription'])
  return $result['FrqDescription'];
  else
  return 'N/A';
}
function getFrequencyId($id)
{
  $sql="SELECT `rent_payment_mode` FROM `tbl_customer_master` WHERE `cust_id`=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['rent_payment_mode'])
  return $result['rent_payment_mode'];
  else
  return 'N/A';
}
function getNoOfVehicles($custId)
{
  $sql="SELECT COUNT(*) as totalVehicles FROM `tbl_gps_vehicle_master` WHERE `customer_Id`=".$custId;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['totalVehicles'])
  return $result['totalVehicles'];
  else
  return 'N/A';
}
function getRentAmt($id)
{
	  $sql = "select * from tblplan where productCategoryId = 4 and planSubCategory = 2 and id =".$id;

	  $rs = mysql_query($sql);
	  $result = mysql_fetch_assoc($rs);
	  if($result['plan_rate'])
	  return $result['plan_rate'];
	  else
	  return '0';
}
function getdeviceimei($id)
{
  $sql="select imei_no from tbl_device_master where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result ['imei_no'])
  return $result ['imei_no'];
  else
  return NULL;
}
function getdcompany($id)
{
  $sql="select name from tbldevicecompany where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['name'])
  return $result['name'];
  else
  return NULL;
}
function getPlanCategory($id)
{
  $sql="select 	category from tblplancategory where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['category'])
  return $result['category'];
  else
  return NULL;
}
function getPlanAmt($id)
{
  $sql="select plan_rate from tblplan where id = ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['plan_rate'])
  return $result['plan_rate'];
  else
  return '0';
}
function lastpaymentreceiveddate($custId){
  $sql="SELECT Max(A.end_date) as startdate
		FROM tbl_payment_breakage as A 
		INNER JOIN tbl_invoice_master as B 
		ON A.invoiceId = B.invoiceId 
		WHERE B.invoiceFlag = 'Y'
		AND B.customerId = ".$custId;
  // echo $sql;
  // exit();
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['startdate'])
  return $result['startdate'];
  else
  return 'N/A';
 // (B.invoiceFlag = 'N' OR B.invoiceFlag = 'P')
}
function pendingEstimateDate($custId){
  $sql="SELECT MIN(A.start_date) as startdate
		FROM tbl_payment_breakage as A 
		INNER JOIN tbl_invoice_master as B 
		ON A.invoiceId = B.invoiceId 
		WHERE (B.invoiceFlag = 'N' OR B.invoiceFlag = 'P')
		AND B.customerId = ".$custId;
  // echo $sql;
  // exit();
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['startdate'])
  return $result['startdate'];
  else
  return 'N/A';
 // (B.invoiceFlag = 'N' OR B.invoiceFlag = 'P')
}
function next_due_date($custId){
  $sql="SELECT MIN(next_due_date) as next_due_date 
  		FROM `tbl_gps_vehicle_payment_master` 
  		WHERE `PlanactiveFlag` ='Y' 
  		AND `cust_id` = ".$custId;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['next_due_date'])
  return $result['next_due_date'];
  else
  return 'N/A';
}
function payment_from($estimateId){
  $sql="SELECT MIN(`start_date`) as fromdate, MAX(`end_date`) as todate 
		FROM `tbl_payment_breakage` 
		WHERE `invoiceId` = ".$estimateId;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);

  if($result['fromdate'])
  return $result['fromdate'];
  else
  return 'N/A';
}
function payment_to($estimateId){
  $sql="SELECT MIN(`start_date`) as fromdate, MAX(`end_date`) as todate 
		FROM `tbl_payment_breakage` 
		WHERE `invoiceId` = ".$estimateId;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);

  if($result['todate'])
  return $result['todate'];
  else
  return 'N/A';
}
function getserviceprovider($id)
{
  $sql="select serviceprovider from tblserviceprovider where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['serviceprovider'])
  return $result['serviceprovider'];
  else
  return NULL;
}
function getdept_bv($id)
{
  $sql="select business_vertical_id from department where dept_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['business_vertical_id'])
  return getvertical($result['business_vertical_id']);
  else
  return NULL;
} 
function getVehicle($id)
{
  $sql="SELECT `vehicle_no` FROM `tbl_gps_vehicle_master` WHERE `id` =".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['vehicle_no'])
  return $result['vehicle_no'];
  else
  return 'N/A';
} 
function getDealer1($id)
{
  $sql="SELECT Company_Name FROM tbl_device_master as A 
		Inner Join tbldealer as B 
		On A.dealer_id = B.id
		Where A.id = ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['Company_Name'])
  return $result['Company_Name'];
  else
  return 'N/A';
}
function getstore($store_id)
{
  $sql="select store_code from store where store_id=".$store_id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['store_code'])
  return $result['store_code'];
  else
  return NULL;
}  

function getriskcategory($id)
{
  $sql="select name from risk_category where risk_category_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['name'])
  return $result['name'];
  else
  return NULL;
}  

function getriskClassification($id)
{
  $sql="select risk_classification_name from risk_classification where id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['risk_classification_name'])
  return $result['risk_classification_name'];
  else
  return NULL;
}  
  
function getvertical($id)
{
  $sql="select business_vertical_name from business_vertical where business_vertical_id=".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['business_vertical_name'])
  return $result['business_vertical_name'];
  else
  return NULL;
}   
function getBranch($id)
{
  $sql="select * from tblbranch where id= ".$id;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
  if($result['CompanyName'])
  return $result['CompanyName'];
  else
  return 'N/A';
}  

function getusercategory($id)
{
	//echo $id;
  //die;
  $sql="select User_Category from tblusercategory where id=".$id;
  //echo $sql;
//  die;
  $rs=mysql_query($sql);
  $result=mysql_fetch_assoc($rs);
 // echo $result['User_Category'];
 //die;
  
  if($result['User_Category'])
  return $result['User_Category'];
  else
  return NULL;
}   

$query3='';
function getcolor($li, $ip)
{
$sql="select risk_color_code from risk where likelihood_id=".$li." and	impact_id=".$ip;
//$query3=$query3 .";". $sql;
$res=mysql_query($sql);
$data=mysql_fetch_assoc($res);
if($data['risk_color_code'])
  return $data['risk_color_code'];
else
  return NULL;						
}
function getbizvername($id){
$query=mysql_query("select * from business_vertical where business_vertical_id=".$id);
$result=mysql_fetch_assoc($query);
return (ucfirst($result['business_vertical_name']));
}
function getStatus($statusId)
{
	if($statusId == 0)
	{
		echo "<span class='label label-warning'>Instock</span>";
	}
	else if($statusId == 1)
	{
		echo "<span class='label label-success'>Installed</span>";
	}
	else if($statusId == 2){
		echo "<span class='label label-warning'>Replacement</span>";
	}
	else
	{
		echo "<span class='label label-danger'>Damage</span>";
	}
}
function getTicketStatusEdit($Id)
{
	if($Id == 0)
	{
		echo "Open";
	}
	else if($Id == 1)
	{
		echo "Close";
	}
	else if($Id == 2)
	{
		echo "Reschedule";
	}
}
function getAdjustment($Status)
{
	if($Status == 0)
	{
		echo "<span class='label label-success'>Yes</span>";
	}
	else 
	{
		echo "<span class='label label-danger'>No</span>";
	}
}
function getConfirm($statusId)
{
	if($statusId == 2)
	{
		echo "<span class='label label-success'>Confirmed</span>";
	}
	else
	{
		echo "<span class='label label-danger'>Not Confirmed</span>";
	}
}
function getAllocated($statusId)
{
	if($statusId == 0)
	{
		echo "<span class='label label-danger'>Instock</span>";
	}
	else
	{
		echo "<span class='label label-success'>Allocated</span>";
	}
}
function getBranchAllocateStatus($statusId)
{
	if($statusId == 0)
	{
		echo "<span>Unallocated</span>";
	}
	else
	{
		echo "<span>Allocated</span>";
	}
}
function getBranchAssignStatus($statusId)
{
	if($statusId == 0)
	{
		echo "<span>InStock</span>";
	}
	else
	{
		echo "<span>Assigned</span>";
	}
}
function CheckValue($statusId)
{
	if($statusId == 0)
	{
		echo "N/A";
	}
	else
	{
		echo $statusId;
	}
}
function getCallingData($statusId)
{
	if($statusId == 0)
	{
		echo "N/A";
	}
	else
	{
		echo $statusId;
	}
}
function getTechnicianAssignStatus($statusId)
{
	if($statusId == 0)
	{
		echo "<span>N/A</span>";
	}
	else
	{
		echo "<span>Assigned</span>";
	}
}

function getCallingStatus($statusId)
{
	if($statusId == 0)
	{
		echo "<span>No</span>";
	}
	else
	{
		echo "<span>Yes</span>";
	}
}
function getTicketStatus($statusId)
{
	if($statusId == 0)
	{
		echo "<span class='label label-danger'>Pending</span>";
	}
	else if($statusId == 1)
	{
		echo "<span class='label label-success'>Closed</span>";
	}
	else if($statusId == 2)
	{
		echo "<span class='label label-warning'>Reschedule</span>";
	}
}
// invoice report function 
function getConfirmation($value)
{
	if($value == 0)
	{
		echo "<span class='label label-danger'>No</span>";
	}
	else
	{
		echo "<span class='label label-success'>Yes</span>";
	}
}
function getClearStatus($value)
{
	if($value == 'Y')
	{
		echo "<span class='label label-success'>Cleared</span>";
	}
	else if($value == 'B')
	{
		echo "<span class='label label-danger'>Bounced</span>";
	}
	else if($value == 'N')
	{
		echo "<span class='label label-warning'>Pending</span>";
	}
}
// End
function getCompany($id){
$query=mysql_query("select * from company where company_id=".$id);
$result=mysql_fetch_assoc($query);
return (ucfirst($result['company_name']));
}
function getCompanyMatrix($id){
$query=mysql_query("select * from company where company_id=".$id);
$result=mysql_fetch_assoc($query);
return ($result['risk_matrix']);
}

function getCallingCategory($id){
$query=mysql_query("select * from tblcallingcategory where id=".$id);
$result=mysql_fetch_assoc($query);
return (ucfirst($result['category']));
}
function getBranchID($name){
$query=mysql_query("select * from branch where branch_name='".$name."'");
$result=mysql_fetch_assoc($query);
return (ucfirst($result['branch_id']));
}

function pt($id){
$query=mysql_query("select dept_name from department where dept_id=".$id);
$result=mysql_fetch_assoc($query);
return (ucfirst($result['dept_name']));
}
function getUserCat($id){
$query=mysql_query("select * from user_category where user_category_id=".$id);
$result=mysql_fetch_assoc($query);
return (ucfirst($result['name']));
}
function ptID($name){
$name=strtolower($name);
$query=mysql_query("select * from department where lcase(dept_name)='".$name."'");
$result=mysql_fetch_assoc($query);
return ($result['dept_id']);
}
function getriskclassificationID($name){
$name=strtolower($name);
$query=mysql_query("select * from risk_classification where lcase(risk_classification_name)='".$name."'");
$result=mysql_fetch_assoc($query);
return ($result['id']);
}
function getBizVerID($name){
$name=strtolower($name);
$query=mysql_query("select * from business_vertical where lcase(business_vertical_name)='".$name."'");
$result=mysql_fetch_assoc($query);
return ($result['business_vertical_id']);
}


function getriskcatID($name){
$name=strtolower($name);
$query=mysql_query("select * from risk_category where lcase(name)='".$name."'");
$result=mysql_fetch_assoc($query);
return ($result['risk_category_id']);
}
function getcurrentStatus($id){
$query=mysql_query("select * from current_status where status_id='$id'");
$result=mysql_fetch_assoc($query);
return ($result['name']);
}
function getReferenceID($id){
$query=mysql_query("select risk_reference_label_val from risk_reg where id='$id'");
$result=mysql_fetch_assoc($query);
return ($result['risk_reference_label_val']);
}
function getTotalDept($id,$comp_id){
$query=mysql_query("select max(right(risk_reference_label_val,3)) as cs  from risk_reg where department_label_val='$id' and company_id='$comp_id' and delete_status=0 and archive!=1");
$result=mysql_fetch_assoc($query);
return ($result['cs']);
}
function ptShortName($id){
$query=mysql_query("select dept_short_name  from department where dept_id='$id'");
$result=mysql_fetch_assoc($query);
return ($result['dept_short_name']);
}
function getRefID($refid){
$query=mysql_query("select count(*) as cs  from risk_reg where risk_reference_label_val='".$refid."' and delete_status=0 and archive!=1");

$result=mysql_fetch_assoc($query);
//echo "select count(*) as cs  from risk_reg where risk_reference_label_val='".$refid."'";
//die;
return ($result['cs']);
}

function formatdate($ftdate)
{
$from_due=explode("-",$ftdate);
return $from_due[2]."-".$from_due[1]."-".$from_due[0];
}
?>

<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

//echo count($_POST['linkID']);

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}


 if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) )
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{ //echo 'nitin';
			  foreach($_POST['linkID'] as $chckvalue)
              {
		        /*  $device_id=$_POST['linkID'][$dsl];*/
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="0";
				$device_model = $_POST['devic_model_id'];
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_device_assign_branch where device_id='$chckvalue'";
				//echo $sql;
				$results = mysql_query($sql); 	
				$assign = "Update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
				//echo $sql;
				$query = mysql_query($assign);
				 
				/* echo $query;*/
	  			$_SESSION['sess_msg']="State deleted successfully";
   			   }
			 }  
  		$id="";
  
  }
  if(count($_POST['linkID'])>0 && (isset($_POST['submit'])) )
   {			   
  		$dsl="";
		// echo 'nitin-submit';
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		        /*  $device_id=$_POST['linkID'][$dsl];*/
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="1";
				$device_model = $_POST['devic_model_id'];
		  		$createdby=$_SESSION['user_id']; 
	            $check_deviceId = mysql_query("SELECT * FROM tbl_device_assign_branch WHERE device_id='$chckvalue'") or die(mysql_error());
						if(!$row = mysql_fetch_array($check_deviceId) or die(mysql_error()))
						{
							 $sql = "update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
							 //echo $sql;
							 $results = mysql_query($sql); 	
							 $assign = "insert into tbl_device_assign_branch set device_id='$chckvalue', branch_id='$branch_id', assigned_date=Now()";
							 //echo $sql;
							 $query = mysql_query($assign);
							  //echo $query; 
							 $_SESSION['sess_msg']="State deleted successfully";
						}
   			   }
			 }  
  		$id="";
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
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script  src="js/ajax.js"></script>
<script>
 $(function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>
<script type="text/javascript" language="javascript">
function ShowbyDate()
	{   
	    date = document.getElementById("date").value;
		telecaller = document.getElementById("telecaller").value;
		/*alert(telecaller);*/
		url="ajaxrequest/assign_contact_follow_up_date.php?date="+date+"&telecaller="+telecaller+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,date,"getResponseDate");
	}
	function getResponseDate(str){
	/*alert(str);*/
	document.getElementById('divassign').innerHTML=str;
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
    	<h3> Telecalling Follow-up</h3>
        <hr>
    </div>
    <div class="col-md-12">
      <div class="col-md-12 form-inline">
     
      	<div class="form-group">
    		<label for="exampleInputName2">Follow-up Date*</label>
    		
            <input type="text" name="date" id="date" class="form-control text_box"/>
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Telecaller*</label>
                <select name="telecaller" id="telecaller" class="form-control drop_down">
                <option label="" value="0" selected="selected">Select Telecaller</option>
                <?php $Country=mysql_query("select * from tbluser where  User_Category='6' or User_Category='9' or User_Category='8'");
                      while($telecaller=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $telecaller['id']; ?>" ><?php echo stripslashes(ucfirst($telecaller['First_Name']." ". $telecaller["Last_Name"])); ?></option>
                <?php } ?>
                </select>
        </div>
  		<input type="submit" name="search" value="Submit" class="btn btn-primary btn-sm" onClick="return ShowbyDate();" />
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>
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
				/*echo $sql;*/
				$results = mysql_query($sql); 	
				$assign = "Update tbl_device_master set assignstatus='$status_id' where id='$chckvalue'";
				/*echo $sql;*/
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
<!--<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>-->
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
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
    	<h3> Assign</h3>
      <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Device Name</label>
    			<select name="modelname" id="modelname"  class="form-control drop_down">
                <option label="" value="0" selected="selected">All Device</option>
                <?php $Country=mysql_query("select * from tbldevicemodel order by model_name");
							   while($resultCountry=mysql_fetch_assoc($Country)){
                ?>
                <option value="<?php echo $resultCountry['device_id']; ?>" 
							   <?php if(isset($State_name) && $resultCountry['device_id']==$State){ ?>selected<?php } ?>>
							   <?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
                               <?php } ?>
                </select>
  		</div>
        <div class="form-group">
            <label for="exampleInputEmail2">Branch</label>
            <select name="branch" id="branch" class="form-control drop_down" >
            <option label="" value="" selected="selected">Select Branch</option>
            <?php $Country=mysql_query("select * from tblbranch");
			 			   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?>			</option>
            <?php } ?>
            </select>
        </div>
  		<input type="button" name="assign" value="Assign Devices" id="submit" class="btn btn-primary" onClick="showUnassignedStock()" />
        <input type="button" name="view" id="view" value="View Assigned Devices" class="btn btn-primary" onClick="showAssignedStock()"/>
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
    </form>
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
</body>
</html>
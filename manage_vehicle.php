<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
//Delete single record
if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$delete_single_row = "DELETE FROM tbl_gps_vehicle_master WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete multiple records
if(isset($_POST['delete_selected']))
	{
		foreach($_POST['linkID'] as $chckvalue)
        	{
		    	$sql = "DELETE FROM tbl_gps_vehicle_master WHERE id='$chckvalue'";
				$result = mysql_query($sql);
   			}
			if($result)
				{
			   		echo "<script> alert('Records Deleted Successfully'); </script>";
			   	}
	}
//end
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
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
    	<h3>Vehicle Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
    	<div class="col-md-4 btn_grid">
        <form name='fullform1'  method='post'>       	
     	<input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('add_gps_vehicle.php?token=<?php echo $token ?>')"/>
       &nbsp;&nbsp;&nbsp;
        <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Edit/Repair Vehicle" onClick="window.location.replace('edit_repair_vehicle.php?token=<?php echo $token ?>')"/>
        </form>
        </div>
    </div>
    <div class="col-md-12"> 
    <div class="table-responsive">
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
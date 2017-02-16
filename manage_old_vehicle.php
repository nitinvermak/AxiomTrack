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
		$delete_single_row = "DELETE FROM tbl_device_master WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		$msg = "Device Deleted Successfully";
	}
//End
//Delete multiple records
if(isset($_POST['delete_selected']))
	{
		foreach($_POST['linkID'] as $chckvalue)
        	{
		    	$sql = "DELETE FROM tbl_device_master WHERE id='$chckvalue'";
				$result = mysql_query($sql);
   			}
			if($result)
				{
			   		$msg = "Device Deleted Successfully";
			   	}
	}
//end
if(isset($_POST['instock']))
	{
		echo 'jafhsda';
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bootstrap/css/ionicons.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
	<?php include_once("includes/header.php") ?>
	<!-- Content Wrapper. Contains page content -->
	<div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        Vehicle Details
	        <!--<small>Control panel</small>-->
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">Vehicle Details</li>
	      </ol>
	    </section>
	    <!-- Main content -->
	    <section class="content">
	    	<div class="box box-info">
	            <div class="box-header">
	              <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Add New" onClick="window.location.replace('1_old_29_15_add_gps_vehicle.php?token=<?php echo $token ?>')"/>
          		  <input type='button' name='cancel' class="btn btn-primary btn-sm" value="Edit/Repair Vehicle" onClick="window.location.replace('old_edi_gps_vehicle.php?token=<?php echo $token ?>')"/>
	            </div>
	            <div class="box-body">
	            	
	            </div><!-- /.box-body -->
	        </div> <!-- end box-info -->
	    </section><!-- End Main content -->
	</div> <!-- end content Wrapper-->
	<?php include_once("includes/footer.php") ?>
	<!-- Loader -->
	<div class="loader">
		<img src="images/loader.gif" alt="loader">
	</div>
	<!-- End Loader -->
</div> <!-- End site wrapper -->
<!-- jQuery 2.2.3 -->
<script src="assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="assets/plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/app.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="assets/dist/js/demo.js"></script>
</body>
</html>
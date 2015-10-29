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
		$delete_single_row = "DELETE FROM tblsim WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete  multiple records
if(count($_POST['linkID'])>0 && (isset($_POST['delete_selected'])) )
   {			   
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		       	$sql = "DELETE FROM tblsim WHERE id='$chckvalue'";
				$result = mysql_query($sql);
			  }
			  if($result)
			  {
			    echo "<script> alert('Records Deleted Successfully'); </script>";
			  }
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

<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/device_report.js"></script>

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
    	<h3>Device Report</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<div class="form-group">
    	<input type="text" name="search_box" id="search_box" class="form-control text_box" Placeholder="Ex. Device Id or IMEI No."/>  		</div>
        <input type="button" name="assign" value="Search" id="submit" class="btn btn-primary btn-sm" onClick="return SearchRecords();" />
        <input type="button" name="view" id="view" value="Download Report" class="btn btn-primary btn-sm" onClick="window.location.replace('device_report_export.php?token=<?php echo $token;?>')" />
         <input type="button" name="view" id="view" value="Summary" class="btn btn-primary btn-sm" onClick="window.location.replace('device_summary.php?token=<?php echo $token;?>')" />
         <input type="button" name="advanceFilter" id="advanceFilter" value="Advance Filter" class="btn btn-primary btn-sm" onClick="window.location.replace('device_advance_filter.php?token=<?php echo $token;?>')" />
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">

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
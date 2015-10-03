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
$sql = "select * from tbl_device_master where status=0";
$result = mysql_query($sql);
$inStock = mysql_num_rows($result);
$totalInstock = $inStock;

$sql = "select * from tbl_device_master where status=1";
$result = mysql_query($sql);
$installed = mysql_num_rows($result);
$totalInstalled = $installed;

$sql = "select * from tbl_device_master where status=2";
$result = mysql_query($sql);
$reIssue = mysql_num_rows($result);
$totalreIssue = $reIssue;


$sql = "select * from tbl_device_master where status=3";
$result = mysql_query($sql);
$Close = mysql_num_rows($result);
$totalClose = $Close;

$sql = "select * from tbl_device_master";
$result = mysql_query($sql);
$total = mysql_num_rows($result);
$totaldevice = $total;

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
<script type="text/javascript" language="javascript">
function SearchRecords()
	{   
	    search_box = document.getElementById("search_box").value;
		/*alert(search_box);*/
		url="ajaxrequest/sim_report.php?search_box="+search_box+"&token=<?php echo $token;?>";
		/*alert(url);*/
		xmlhttpPost(url,search_box,"GetRecords");
	}
	function GetRecords(str){
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
    	<h3>Installation Summary</h3>
        <hr>
    </div>
    <div class="table-responsive col-md-12">
      <table class="table table-hover table-bordered">
      <tr>
      <th><center>S. No.</center></th>
      <th><center>Sale</center></th>
      <th><center>Rented</center></th>
      <th><center>Customer Device</center></th>
      <th><center>Sale On Installment</center></th>
      <th><center>Total</center></th>
      </tr>
      <tr>
      <td>1.</td>
      <td><center><?php echo $totalInstock;?></center></td>
      <td><center><?php echo $totalInstalled;?></center></td>
      <td><center><?php echo $totalreIssue;?></center></td>
      <td><center><?php echo $totalClose?></center></td>
      <td><center><?php echo $totaldevice; ?></center></td>
      </tr>
      </table>
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
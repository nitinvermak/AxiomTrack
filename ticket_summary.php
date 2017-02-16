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
$sql = "select * from tblticket where ticket_status = 1";
$result = mysql_query($sql);
$inStock = mysql_num_rows($result);
$close = $inStock;

$sql = "select * from tblticket where ticket_status = 0";
$result = mysql_query($sql);
$installed = mysql_num_rows($result);
$pending = $installed;

$sql = "select * from tblticket where status=2";
$result = mysql_query($sql);
$reIssue = mysql_num_rows($result);
$reshedule = $reIssue;

$sql = "select * from tblticket";
$result = mysql_query($sql);
$total = mysql_num_rows($result);
$totalTkt = $total;

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
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
    	<h3>Ticket Summary</h3>
        <hr>
    </div>
    <div class="table-responsive col-md-12">
      <table class="table table-hover table-bordered">
      <tr>
      <th><center>S. No.</center></th>
      <th><center>Closed</center></th>
      <th><center>Pending</center></th>
      <th><center>Reschedule</center></th>
      <th><center>Total</center></th>
      </tr>
      <tr>
      <td>1.</td>
      <td><center><?php echo $close;?></center></td>
      <td><center><?php echo $pending;?></center></td>
      <td><center><?php echo $reshedule;?></center></td>
      <td><center><?php echo $totalTkt?></center></td>
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
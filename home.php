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
	// Sim Report calculate
    $sql = "select * from tblsim where status_id=0";
    $result = mysql_query($sql);
    $inStock = mysql_num_rows($result);
    $totalInstock = $inStock;

    $sql = "select * from tblsim where status_id=1";
    $result = mysql_query($sql);
    $installed = mysql_num_rows($result);
    $totalInstalled = $installed;

    $sql = "select * from tblsim where status_id=2";
    $result = mysql_query($sql);
    $reIssue = mysql_num_rows($result);
    $totalreIssue = $reIssue;


    $sql = "select * from tblsim where status_id=3";
    $result = mysql_query($sql);
    $Close = mysql_num_rows($result);
    $totalClose = $Close;

    $sql = "select * from tblsim";
    $result = mysql_query($sql);
    $total = mysql_num_rows($result);
    $totalSim = $total;
	// End Sim
	// Device Report Calculate
    $sqlInstock = "select * from tbl_device_master where status=0";
    $resultInstock = mysql_query($sqlInstock);
    $inStockDevice = mysql_num_rows($resultInstock);
    $totalInstockDevice = $inStockDevice;

    $sqlInstalled = "select * from tbl_device_master where status=1";
    $resultInstalled = mysql_query($sqlInstalled);
    $installedDevice = mysql_num_rows($resultInstalled);
    $totalInstalledDevice = $installedDevice;

    $sqlReIssue = "select * from tbl_device_master where status=2";
    $resultReIssue = mysql_query($sqlReIssue);
    $reIssue = mysql_num_rows($resultReIssue);
    $totalreIssue = $reIssue;


    $sqlClose = "select * from tbl_device_master where status=3";
    $resultClose = mysql_query($sqlClose);
    $Close = mysql_num_rows($resultClose);
    $totalClose = $Close;

    $sqlTotal = "select * from tbl_device_master";
    $resultTotal = mysql_query($sqlTotal);
    $total = mysql_num_rows($resultTotal);
    $totaldevice = $total;
	// End Device
	// Ticket Report Calculate
    $sqlPending = "SELECT * FROM `tblticket` WHERE ticket_status = 0";
    $resultPending = mysql_query($sqlPending);
    $pendingTicket = mysql_num_rows($resultPending);
    $totalPendingTkt = $pendingTicket;
	
	$sqlTodayPending = "SELECT * FROM `tblticket` WHERE `ticket_status` = 0 AND `createddate` = CURDATE()";
    $resultTodayPending = mysql_query($sqlTodayPending);
    $pendingTodayTicket = mysql_num_rows($resultTodayPending);
    $totalTodayPending = $pendingTodayTicket;

    $sqlReschedule = "SELECT * FROM `tblticket` WHERE scheduleDate = CURDATE() and ticket_status = 2";
    $resultReschedule = mysql_query($sqlReschedule);
    $rescheduleTicket = mysql_num_rows($resultReschedule);
    $totalReschedule = $rescheduleTicket;

    $sqlClosed = "SELECT * FROM `tblticket` WHERE `close_date` = CURDATE() and ticket_status = 1";
    $resultClosed = mysql_query($sqlClosed);
    $closedTicket = mysql_num_rows($resultClosed);
    $totalClosed = $closedTicket;


    $sqlUnAssigned = "SELECT * FROM `tblticket` WHERE  branch_assign_status = 0 AND `createddate` = CURDATE()";
    $resultUnAssigned = mysql_query($sqlUnAssigned);
    $Unassigned = mysql_num_rows($resultUnAssigned);
    $totalUnAssigned = $Unassigned;

    $sqlTotalTicket = "select * from tblticket Where createddate = CURDATE()";
    $resultTotalTicket = mysql_query($sqlTotalTicket);
    $totalTicket = mysql_num_rows($resultTotalTicket);
    $ticketTotal = $totalTicket;
	// End Ticket
	// Payment Report Calculate
    $sqlCash = "SELECT SUM(CashAmount) as totalCash FROM `quickbookpaymentmethoddetailsmaster`  WHERE `RecivedDate` = CURDATE()";
    $resultcash = mysql_query($sqlCash);
    $rowCash = mysql_fetch_assoc($resultcash);
    $todayCashTotal = $rowCash['totalCash'];

    $sqlCheque = "SELECT SUM(A.chequeAmount) as chequeAmt 
				  FROM quickbookpaymentcheque as A 
 				  INNER JOIN quickbookpaymentmethoddetailsmaster as B 
				  ON A.Id = B.ChequeID  WHERE B.RecivedDate = CURDATE()" ;
    $resultCheque = mysql_query($sqlCheque);
    $paymentCheque = mysql_fetch_assoc($resultCheque);
    $totalChequeAmt = $paymentCheque['chequeAmt'];

    $sqlNeft = "SELECT SUM(A.onlineAmount) as onlineAmt 
				FROM quickbookpaymentonlinetransfer as A 
				INNER JOIN quickbookpaymentmethoddetailsmaster as B 
				ON A.Id = B.OnlineTransferId  WHERE B.RecivedDate = CURDATE()";
    $resultsqlNeft = mysql_query($sqlNeft);
    $totalNeft = mysql_fetch_assoc($resultsqlNeft);
    $TotalNeft = $totalNeft['onlineAmt'];
	// End Payment
	// Lead Report
	$sqlLead = "SELECT * FROM `tblcallingdata` WHERE `status` = 0 AND `calling_status`= 1";
	$resultPending = mysql_query($sqlLead);
	$resultPendingCount = mysql_num_rows($resultPending);
	$totalPending = $resultPendingCount; 
	
	$sqlconfirm = "SELECT * FROM `tblcallingdata` WHERE `status` = 1 AND `calling_status`= 1";
	$resultconfirm = mysql_query($sqlconfirm);
	$resultleadconfirm = mysql_num_rows($resultconfirm);
	$totalleadconfirm = $resultleadconfirm; 
	
	$sqlLead = "SELECT * FROM `tblcallingdata`";
	$resultLead = mysql_query($sqlLead);
	$resultTotalLead = mysql_num_rows($resultLead);
	$totalLead = $resultTotalLead; 
	// End Lead report
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/custom.css">
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
    	<h1>Dashboard</h1>
        <hr>
    </div>
    <div class="col-md-12 table-responsive">
    	<!-- Sim Details -->
        <table class="table table_light table-bordered">
        <tr>
        <th colspan="5"><center><strong>Sim</strong></center></th>
        </tr>
        <tr>
        <td><center><strong>InStock</strong></center></td>
        <td><center><strong>Installed</strong></center></td>
        <td><center><strong>Re-issue</strong></center></td>
        <td><center><strong>Damage</strong></center></td>
        <td><center><strong>Total Sim</strong></center></td>
        </tr>
        <tr>
        <td><center><?php echo $totalInstock; ?></center></td>
        <td><center><?php echo $totalInstalled; ?></center></td>
        <td><center><?php echo $totalreIssue; ?></center></td>
        <td><center><?php echo $totalClose; ?></center></td>
        <td><center><?php echo $totalSim; ?></center></td>
        </tr>
        </table>
        <hr>
       	<!-- End -->
        <!-- Device Details -->
        <table class="table table_light table-bordered">
        <tr>
        <th colspan="5"><center><strong>Device</strong></center></th>
        </tr>
        <tr>
        <td><center><strong>InStock</strong></center></td>
        <td><center><strong>Installed</strong></center></td>
        <td><center><strong>Re-issue</strong></center></td>
        <td><center><strong>Damage</strong></center></td>
        <td><center><strong>Total Sim</strong></center></td>
        </tr>
        <tr>
        <td><center><?php echo $totalInstockDevice; ?></center></td>
        <td><center><?php echo $totalInstalledDevice; ?></center></td>
        <td><center><?php echo $totalreIssue; ?></center></td>
        <td><center><?php echo $totalClose; ?></center></td>
        <td><center><?php echo $totaldevice; ?></center></td>
        </tr>
        </table>
        <hr>
        <!-- End -->    
        <!-- Ticket Details -->
        <table class="table table_light table-bordered">
        <tr>
        <th colspan="6"><center><strong>Ticket</strong></center></th>
        </tr>
        <tr>
        <td><center><strong>Pending</strong></center></td>
        <td><center><strong>Today Pending</strong></center></td>
        <td><center><strong>Today Reschedule</strong></center></td>
        <td><center><strong>Today Closed</strong></center></td>
        <td><center><strong>Today Un-Assigned</strong></center></td>
        <td><center><strong>Today Total</strong></center></td>
        </tr>
        <tr>
        <td><center><?php echo $totalPendingTkt; ?></center></td>
        <td><center><?php echo $totalTodayPending; ?></center></td>
        <td><center><?php echo $totalReschedule; ?></center></td>
        <td><center><?php echo $totalClosed; ?></center></td>
        <td><center><?php echo $totalUnAssigned; ?></center></td>
        <td><center><?php echo $ticketTotal; ?></center></td>
        </tr>
        </table>
        <hr>
        <!-- End -->    
        <!-- Payment Collection -->
        <table class="table table_light table-bordered">
        <tr>
        <th colspan="4"><center><strong>Payment Collection</strong></center></th>
        </tr>
        <tr>
        <td><center><strong>Today Cash Amt.</strong></center></td>
        <td><center><strong>Today Chq. Amt.</strong></center></td>
        <td><center><strong>Today NEFT Amt.</strong></center></td>
        <td><center><strong>Total</strong></center></td>
        </tr>
        <tr>
        <td><center><?php if($todayCashTotal == NULL){ echo '0';} else { echo $todayCashTotal; } ?>
            		<input type="hidden" id="cash" value="<?php echo $todayCashTotal; ?>"></center></td>
        <td><center><?php if($totalChequeAmt == NULL){ echo '0'; } else { echo $totalChequeAmt;} ?>
            		<input type="hidden" value="<?php echo $totalChequeAmt; ?>" id="chq"></center></td>
        <td><center><?php if($TotalNeft == NULL){ echo '0'; } else { echo $TotalNeft; } ?>
            		<input type="hidden" value="<?php echo $TotalNeft; ?>" id="neft"></center></td>
        <td><center><span id="totalcollection"></span></center></td>
        </tr>
        </table>
        <hr>
        <!-- end -->
        <!-- leads -->
        <table class="table table_light table-bordered">
        <tr>
        <th colspan="3"><center><strong>Leads</strong></center></th>
        </tr>
        <tr>
        <td><center><strong>Pending</strong></center></td>
        <td><center><strong>Confirm</strong></center></td>
        <td><center><strong>Total</strong></center></td>
        </tr>
        <tr>
        <td><center><?php echo $totalPending; ?></center></td>
        <td><center><?php echo $totalleadconfirm; ?></center></td>
        <td><center><?php echo $totalLead; ?></center></td>
        </tr>
        </table>
        <!-- End -->
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
<script>
var cashAmt = document.getElementById("cash").value;
var chqAmt = document.getElementById("chq").value;
var neftAmt = document.getElementById("neft").value;
var result = parseInt(cashAmt) + parseInt(chqAmt);
document.getElementById("totalcollection").innerHTML = result;
console.log(result);
</script>
</body>
</html>
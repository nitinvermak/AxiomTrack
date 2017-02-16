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
    $totalInstockSim = $inStock;

    $sql = "select * from tblsim where status_id=1";
    $result = mysql_query($sql);
    $installed = mysql_num_rows($result);
    $totalInstalledSim = $installed;

    $sql = "select * from tblsim where status_id=4";
    $result = mysql_query($sql);
    $reIssue = mysql_num_rows($result);
    $totalreIssueSim = $reIssue;


    $sql = "select * from tblsim where status_id=3";
    $result = mysql_query($sql);
    $Close = mysql_num_rows($result);
    $totalCloseSim = $Close;

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
    $totalreIssueDevice = $reIssue;


    $sqlClose = "select * from tbl_device_master where status=3";
    $resultClose = mysql_query($sqlClose);
    $Close = mysql_num_rows($resultClose);
    $totalCloseDevice = $Close;

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
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.6 -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="assets/bootstrap/css/font-awesome.min.css">
<!-- Ionicons -->
<link rel="stylesheet" href="assets/bootstrap/css/ionicons.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript">
function getDeviceAmt()
{
    $.post("ajaxrequest/device_pending_amt_details.php?token=<?php echo $token;?>",
    function( data){
    /*alert(data);*/
    $(".modal-content").html(data);
    });  
}
// export CSV
$(document).ready(function () {
     console.log("HELLO")
            function exportTableToCSV($table, filename) {
                console.log("HELLO")
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
          $(document).on("click","#export", function(){
                // var outputFile = 'export'
                var outputFile = window.prompt("Please Enter the name your output file.") || 'DeviceAmtReport';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#dvData > table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
         })
//end
</script>
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
        Dashboard
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
            <?php 
            // $sql_received_amt = mysql_query("SELECT SUM(`deviceamt`) AS amt FROM `devicepayment`");
            // $row1 = mysql_fetch_assoc($sql_received_amt);
            // $received_amt = $row1['amt']; 

            $SQL = "SELECT count(*) as noOfVehicle, sum(C.plan_rate) as deviceAmt
                    FROM tbl_gps_vehicle_master as A 
                    INNER JOIN tbl_gps_vehicle_payment_master as B 
                    ON A.id = B.Vehicle_id
                    INNER JOIN tblplan as C 
                    ON B.device_amt = C.id
                    INNER JOIN tbl_customer_master as D 
                    ON B.cust_id = D.cust_id 
                    INNER JOIN tbl_device_master as E 
                    ON A.device_id = E.id
                    LEFT OUTER JOIN tbl_assign_customer_branch as F 
                    ON D.cust_id = F.cust_id
                    WHERE A.activeStatus = 'Y' 
                    AND B.device_type = '1'
                    AND A.devicePaymentStatus <> 'F' 
                    AND B.PlanactiveFlag ='Y' ";

                    // AND B.devicepaymentStatus <>'A'
            $result = mysql_query($SQL);
            if(mysql_num_rows($result)>0)
                {
                    while ($row = mysql_fetch_array($result))
                        {
                            $total_vehicle = $row['noOfVehicle']; 
                            $device_Amt = $row['deviceAmt'];
                        }
                }
            ?>
              <h3>Device Pending Amount</h3>
              <div class="dash-info">
                  <p>No. Of Vehicle</p>
                  <span><?= $total_vehicle; ?></span>
              </div>
              <div class="dash-info">
                  <p>Amount</p>
                  <span><a href="#" data-toggle="modal" data-target=".bs-example-modal-lg" onClick="getDeviceAmt();"><?= $device_Amt; ?></a></span>
              </div>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Sim</h3>
              <div class="dash-info">
                  <p>InStock</p>
                  <span><?= $totalInstockSim; ?></span>
              </div>
              <div class="dash-info">
                  <p>Installed</p>
                  <span><?= $totalInstalledSim; ?></span>
              </div>
              <div class="dash-info">
                  <p>Re-Issue</p>
                  <span><?= $totalreIssueSim; ?></span>
              </div>
              <div class="dash-info">
                  <p>Damage</p>
                  <span><?= $totalCloseSim; ?></span>
              </div>
              <div class="dash-info">
                  <p>Total Sim</p>
                  <span><?= $totalSim; ?></span>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>Device</h3>
              <div class="dash-info">
                  <p>InStock</p>
                  <span><?= $totalInstockDevice; ?></span>
              </div>
              <div class="dash-info">
                  <p>Installed</p>
                  <span><?= $totalInstalledDevice; ?></span>
              </div>
              <div class="dash-info">
                  <p>Re-Issue</p>
                  <span><?= $totalreIssueDevice; ?></span>
              </div>
              <div class="dash-info">
                  <p>Damage</p>
                  <span><?= $totalCloseDevice; ?></span>
              </div>
              <div class="dash-info">
                  <p>Total Device</p>
                  <span><?= $totaldevice; ?></span>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>Ticket</h3>
              <div class="dash-info">
                  <p>Pending</p>
                  <span><?= $totalPendingTkt; ?></span>
              </div>
              <div class="dash-info">
                  <p>Today Pending</p>
                  <span><?= $totalTodayPending; ?></span>
              </div>
              <div class="dash-info">
                  <p>Today Reschedule</p>
                  <span><?= $totalReschedule; ?></span>
              </div>
              <div class="dash-info">
                  <p>Today Closed</p>
                  <span><?= $totalClosed; ?></span>
              </div>
              <div class="dash-info">
                  <p>Today Un-Assigned</p>
                  <span><?= $totalUnAssigned; ?></span>
              </div>
              <div class="dash-info">
                  <p>Today Total</p>
                  <span><?= $ticketTotal; ?></span>
              </div>
            </div>
            <div class="icon">
              <i class="fa fa-file-text"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- end box row -->
       <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>Payment Collection</h3>
              <div class="dash-info">
                  <p>Today Cash Amt.</p>
                  <span><?php if($todayCashTotal == NULL){ echo '0';} else { echo $todayCashTotal; } ?>
                    <input type="hidden" id="cash" value="<?php echo $todayCashTotal; ?></span>
              </div>
              <div class="dash-info">
                  <p>Today Chq. Amt.</p>
                  <span><?php if($totalChequeAmt == NULL){ echo '0'; } else { echo $totalChequeAmt;} ?>
                    <input type="hidden" value="<?php echo $totalChequeAmt; ?>" id="chq"></span>
              </div>
              <div class="dash-info">
                  <p>Today NEFT Amt.</p>
                  <span><?php if($TotalNeft == NULL){ echo '0'; } else { echo $TotalNeft; } ?>
                    <input type="hidden" value="<?php echo $TotalNeft; ?>" id="neft"></span>
              </div>
              <div class="dash-info">
                  <p>Total</p>
                  <span id="totalcollection"></span>
              </div>
            </div>
            <div class="icon">
              <i class="fa fa-inr"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>Leads</h3>
              <div class="dash-info">
                  <p>Pending</p>
                  <span><?= $totalPending; ?></span>
              </div>
              <div class="dash-info">
                  <p>Confirm</p>
                  <span><?= $totalleadconfirm; ?></span>
              </div>
              <div class="dash-info">
                  <p>Total</p>
                  <span><?= $totalLead; ?></span>
              </div>
            </div>
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            <!-- <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- end box row -->
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<!-- Modal -->
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Show Content From Ajax request -->
        </div>
    </div>
</div>
 <!-- End Modal -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
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
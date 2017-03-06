<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
{
  session_destroy();
  header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
  session_destroy();
  header("location: index.php?token=".$token);
}
// Select Invoice Details
$invoiceId = $_GET['est'];
$where='';
$linkSQL="";
/*echo $invoiceId;*/      
$planRateQuery= "Select id, planSubCategory, plan_rate 
                 from tblplan 
                 where productCategoryId = 4  
                 and (planSubCategory = 1 
                 or planSubCategory = 2 
                 or planSubCategory = 3)";
$planRateQueryArr = mysql_query($planRateQuery);
$deviceAmountDict = array();
$deviceRentAmtDict = array();
$installationChargesDict = array();
$typeBAmountEntry =0;
while ($rowA = mysql_fetch_array( $planRateQueryArr)){
  //echo $rowA["plan_category"].'='.$rowA["id"].'='.$rowA["plan_rate"].'</br>';
  if ($rowA["planSubCategory"] == 1){
    $deviceAmountDict[$rowA["id"] ] =$rowA["plan_rate"];
  }
  if ($rowA["planSubCategory"] == 2){
    $deviceRentAmtDict[$rowA["id"] ] =$rowA["plan_rate"];
  }
  if ($rowA["planSubCategory"] == 3){
    $installationChargesDict[$rowA["id"] ] =$rowA["plan_rate"];
  }              
}

$sql_invoice_details = "Select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, 
                        C.amount as amt, C.vehicleId  as vId, C.start_date as startDate, 
                        C.end_date as endDate, B.customer_Id as custId, 
                        C.payment_rate_id as plan_rate_id, 
                        B.installation_date as activationdate, C.typeOfPaymentId as typeofpayment
                        from tbl_payment_breakage as C left outer join
                        tbl_gps_vehicle_master as B  
                        On C.vehicleId = B.id         
                        where C.invoiceId= '$invoiceId'
                        order by   C.vehicleId, C.typeOfPaymentId";
$result_invoice_details = mysql_query($sql_invoice_details);

// Invoice Summary 
$sql_invoice_summary = "Select COUNT(*) as totalVehicle, C.typeOfPaymentId as paymentType, 
                        SUM(C.amount)as amt, MIN(C.start_date) as startDate, MAX(C.end_date) as endDate,
                        B.customer_Id as custId, C.typeOfPaymentId as typeofpayment
                        from tbl_payment_breakage as C 
                        left outer join tbl_gps_vehicle_master as B 
                        On C.vehicleId = B.id where C.invoiceId= '$invoiceId' 
                        order by C.vehicleId, C.typeOfPaymentId ";
$result_invoice_summary = mysql_query($sql_invoice_summary);
$row = mysql_fetch_assoc($result_invoice_summary);
$total_vehicle = $row['totalVehicle'];
$grand_total = $row['amt'];
$from = $row['startDate'];
$to = $row['endDate'];
$customer_Id = $row['custId'];


// Select Company Details
$sql_company_details = "SELECT B.Company_Name as Company_Name, B.Address as Address, B.Area as area, 
                        B.City as city, B.State as state, B.District_id as district, B.Country as country, 
                        B.Pin_code as pincode, B.Mobile as mobileno, B.email as email
                        FROM tbl_customer_master as A 
                        INNER JOIN tblcallingdata as B 
                        ON A.callingdata_id = B.id
                        Where A.cust_id = '$customer_Id'";
$result_company_details = mysql_query($sql_company_details);
$row = mysql_fetch_assoc($result_company_details);
$Company = $row['Company_Name'];
$address = $row['Address'];
$area = $row['area'];
$city = $row['city'];
$state = $row['state'];
$district = $row['district'];
$pincode = $row['pincode'];
$mobileno = $row['mobileno'];
$email = $row['email'];

$sql_invoice = "SELECT `invoiceId`, `generateDate`, `dueDate`, `discountedAmount` 
                FROM `tbl_invoice_master`  
                WHERE `invoiceId` =".$invoiceId;
$result_invoice = mysql_query($sql_invoice);
$row1 = mysql_fetch_assoc($result_invoice);
$invoice_No = $row1['invoiceId'];
$generateDate = $row1['generateDate'];
$dueDate = $row1['dueDate'];
$discountedAmount = $row1['discountedAmount'];
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
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- Print CSS -->
<link rel="stylesheet" type="text/css" media="print,handheld" href="css/print.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<!-- Jquery -->
<script type="text/javascript" src="assets/bootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/assign_device_to_branch.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript">
  function printContent(obj){
    // alert(obj);
    var restorepage = document.body.innerHTML;
    var print_content = document.getElementById(obj).innerHTML;
    document.body.innerHTML = print_content;
    window.print();
    document.body.innerHTML = restorepage;
  }
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
          Generate Invoice
          <!--<small>Control panel</small>-->
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li class="active">Generate Invoice</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <form name='fullform' action="generate_invoice_pdf.php" id="fullform" class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
        <input type="hidden" name="invoice_id" id="invoice_id" value="<?= $_GET['est'] ?>">
          <div class="box box-info">
               <!--  <div class="box-header">
                  <h3 class="box-title">Details</h3>
                </div> -->
                <div class="box-body">
                 <div class="col-lg-12 table-responsive" id="invoice_content">
                   <center><img src="images/logo.jpg" alt="SRTMS"></center><br>
                   <table width="100%" border="1">
                      <tr>
                        <td width="50%" style="padding: 5px; font-size: 16px; font-weight: bold; text-align: center;">
                          <strong>Customer Information</strong>
                        </td>
                        <td width="50%" style="padding: 5px; font-size: 16px; font-weight: bold; text-align: center;">
                          <strong>Company Information</strong>
                        </td>
                      </tr>
                     <tr>
                       <td width="50%" style="padding:5px; font-size: 15px;" valign="top">
                        <p style="padding: 5px 10px 5px 10px; line-height: 25px; font-size: 13px;">
                          <span>  
                           <strong>Customer Id:</strong> <?= $customer_Id; ?> <br> 
                           <strong>Contact Person:</strong> <?= getCustomerName($customer_Id); ?> <br>
                           <strong><?= $Company; ?><input type="hidden" name="company_name" value="<?= $Company; ?>"></strong>
                          </span><br> 
                          <span>
                            <?= $address; ?>, <?= getarea($area); ?><br> <?= getcityname($city); ?>, 
                            <?= getdistrict($district); ?>, <?= getstate($state); ?>,  
                            <?= getpincode($pincode); ?>
                            <input type="hidden" name="address" id="address" value="<?= $address; ?>, <?= getarea($area); ?>">
                            <input type="hidden" name="address1" id="address1" value=" <?= getcityname($city); ?>, 
                            <?= getdistrict($district); ?>, <?= getstate($state); ?>,  
                            <?= getpincode($pincode); ?>">
                          </span><br>
                          <span>
                           <?= $mobileno; ?>
                           <input type="hidden" name="mobileno" id="mobileno" value="<?= $mobileno; ?>">
                          </span><br>
                          <span>
                           <?= $email; ?>
                           <input type="hidden" name="email" id="email" value="<?= $email; ?>">
                          </span><br>
                        </p>
                       </td>
                       <td width="50%" style="padding: 5px;" valign="top">
                        <center><strong>SR Transport Management Services Pvt. Ltd.</strong></center>
                        <p style="padding: 5px 10px 5px 10px; line-height: 25px; font-size: 13px;">
                          <span style="float: left;">                            
                           <strong>Pan Card No. </strong>
                          </span> 
                          <span style="float: right;"> 
                            AAWCS1335F
                          </span><br>
                          <span style="float: left;">
                           <strong>Service Tax No. </strong> 
                          </span>
                          <span style="float: right;">
                            AAWCS1335FST001
                          </span>
                          <br>
                          <span style="float: left;">
                           <strong>Vat/CST No. </strong> 
                          </span>
                          <span style="float: right;">
                           Applied for 
                          </span><br>
                          <span style="float: left;">
                           <strong>Bank Name </strong>  
                          </span>
                          <span style="float: right;">
                            Kotak Mahindra
                          </span><br>
                          <span style="float left;">
                           <strong>Account Number </strong> 
                          </span> 
                          <span style="float: right;">
                            0411640116
                          </span>
                          <br>
                          <span style="float left;">
                           <strong>IFSC Code </strong> 
                          </span>
                          <span style="float: right;">
                           KKBK0000193
                          </span><br>
                          <span style="float left;">
                           <strong>Branch</strong> 
                          </span>
                          <span style="float: right;">
                            Sec.- 5, Dwarka, New Delhi
                          </span>
                        </p>
                       </td>
                     </tr>
                   </table><br>
                   <table width="100%" border="1">
                    <tr>
                      <td colspan="3" width="100%" style="padding: 5px; font-size: 16px; font-weight: bold; text-align: center;">
                        ESTIMATE SUMMARY
                      </td>
                    </tr>
                    <tr>
                      <td width="33%" style="padding: 5px;"><span><strong>Estimate No.:</strong> 
                        <?= $invoice_No; ?>
                        <input type="hidden" name="invoice_No" id="invoice_No" value="<?= $invoice_No; ?>">
                        </span></td>
                      <td width="33%" style="padding: 5px;"><span><strong>Estimate Date:</strong> 
                        <?= date("d-m-Y", strtotime($generateDate)); ?>
                        <input type="hidden" name="invoice_date" id="invoice_date" value="<?= date("d-m-Y", strtotime($generateDate)); ?>">
                      </span></td>
                      <td width="33%" style="padding: 5px;"><span><strong>Due Date:</strong> 
                      <?= date("d-m-Y", strtotime($dueDate)); ?>
                      <input type="hidden" name="due_date" id="due_date" value="<?= date("d-m-Y", strtotime($dueDate)); ?>">
                      </span></td>
                    </tr>
                   </table><br>
                   <table width="100%" border="1">
                    <tr>
                      <td width="15%" style="padding: 5px;"><span><strong>No. of Vehicles</strong></span></td>
                      <td width="25%" style="padding: 5px;"><span><strong>Rent Period</strong></span></td>
                      <td width="15%" style="padding: 5px;"><span><strong>Amount</strong></span></td>
                      <td width="15%" style="padding: 5px;"><span><strong>Tax Amount</strong></span></td>
                      <td width="15%" style="padding: 5px;"><span><strong>Discount Amount</strong></span></td>
                      <td width="15%" style="padding: 5px;"><span><strong>Payble Amount</strong></span></td>
                    </tr>
                    <tr>
                      <td width="15%" style="padding: 5px;">
                        <span> <?= $total_vehicle;?>
                        <input type="hidden" name="total_vehicle" value="<?= $total_vehicle;?>"></span>
                      </td>
                      <td width="25%" style="padding: 5px;">
                        <span><input type="hidden" name="from_period" value="<?= date("d-m-Y", strtotime($from)); ?>">
                      <?= date("d-m-Y", strtotime($from)); ?> To <?= date("d-m-Y", strtotime($to)); ?> 
                        <input type="hidden" name="to_period" value="<?= date("d-m-Y", strtotime($to)); ?>"> </span>
                      </td>
                      <td width="15%" style="padding: 5px;">
                      <span>
                      <?php $summ_total = $grand_total/115 * 100;
                            echo number_format($summ_total,2, '.', '');
                      ?>
                      <input type="hidden" name="summ_amt" value="<?php echo number_format($summ_total,2, '.', ''); ?>" ></span>
                      </td>
                      <td width="15%" style="padding: 5px;">
                      <span><?php $summ_tax = $summ_total/100 * 15;
                            echo number_format($summ_tax,2, '.', '');
                      ?>
                      <input type="hidden" name="summ_tax" value="<?php echo number_format($summ_tax,2, '.', ''); ?>"></span>
                      </td>
                      <td width="15%" style="padding: 5px;">
                        <span>
                          <?= $discountedAmount;?>
                        </span>
                      </td>
                      <td width="15%" style="padding: 5px;">
                        <span>
                          <?= $grandtotal = $grand_total - $discountedAmount;?>
                        </span>
                      </td>
                      <!-- <td width="15%" style="padding: 5px;">
                      </td> -->
                    </tr>
                  </table>
                   <br>
                  <table width="100%" border="1">
                    <tr>
                      <td colspan="9" width="100%" style="padding: 5px; font-size: 16px; font-weight: bold; text-align: center;">
                        ESTIMATE DETAILS
                      </td>
                    </tr>
                    <tr>
                      <td width="5%" style="padding: 5px;"><span><strong>S.No.</strong></span></td>
                      <td width="10%" style="padding: 5px;"><span><strong>Vehicle No.</strong></span></td>
                      <td width="10%" style="padding: 5px;"><span><strong>Activation Date</strong></span></td>
                      <td width="14%" style="padding: 5px;"><span><strong>Type</strong></span></td>
                      <td width="25%" style="padding: 5px;"><span><strong>Rent Period</strong></span></td>
                      <td width="10%" style="padding: 5px;"><span><strong>Rent Per Vehicle</strong></span></td>
                      <td width="10%" style="padding: 5px;"><span><strong>Total Amount</strong></span></td>
                      <td width="8%" style="padding: 5px;"><span><strong>Tax</strong></span></td>
                      <td width="8%" style="padding: 5px;"><span><strong>Payble Amount</strong> </span></td>
                    </tr>
                    <?php 
                    $sno = 1;
                    $sum_amt =0;
                    while ($row = mysql_fetch_assoc($result_invoice_details)) {

                      $amt = $row['amt'];
                      $sum_amt += $amt;
                    ?>
                      <tr>
                        <td width="5%" style="padding: 5px;"><?= $sno++; ?>.<span></span></td>
                        <td width="10%" style="padding: 5px;"><span><?= $row['vehicleNo']; ?> 
                        <input type="hidden" name="vehicle_No[]" value="<?= $row['vehicleNo']; ?>"> </span></td>
                        <td width="10%" style="padding: 5px;"><span><?= date("d-m-Y", strtotime($row['activationdate'])); ?></span></td>
                        <td width="14%" style="padding: 5px;"><span>
                        <?php if($row['typeofpayment'] == 'A'){
                           echo "Rental";
                          }else{
                            echo "Installation Chrg.";
                            } ; ?>
                          
                        </span></td>
                        <td width="25%" style="padding: 5px;"><span><?= date("d-m-Y", strtotime($row['startDate'])); ?> To <?= date("d-m-Y", strtotime($row['endDate'])); ?>
                        	<input type="hidden" name="rent_period[]" value="<?= date("d-m-Y", strtotime($row['startDate'])); ?> To <?= date("d-m-Y", strtotime($row['endDate'])); ?>">
                        </span></td>
                        <td width="10%" style="padding: 5px;"><span><?= $deviceRentAmtDict[$row["plan_rate_id"] ]; ?>
                        	<input type="hidden" name="rent_per_vehicle[]" value="<?= $deviceRentAmtDict[$row["plan_rate_id"] ]; ?>">
                        </span></td>
                        <td width="10%" style="padding: 5px;"><span>
                          <?php 
                          $total = $row['amt']/115 * 100;
                          echo number_format($total,2, '.', '');
                          ?>
                          <input type="hidden" name="vehicle_total_amt[]" value="<?php echo number_format($total,2, '.', ''); ?>">
                        </span></td>
                        <td width="8%" style="padding: 5px;"><span>
                          <?php 
                            $tax = $total/100 * 15;
                            echo  number_format($tax,2, '.', ''); 
                          ?>
							           <input type="hidden" name="vehicle_tax[]" value="<?php echo  number_format($tax,2, '.', '');  ?>">
                        </span></td>
                        <td width="8%" style="padding: 5px;"><span><?= $amt; ?>
                        <input type="hidden" name="vehicle_grand_total[]" value="<?= $amt; ?>">
                        </span></td>
                      </tr>
                    <?php 
                     }
                    ?>
                    <tr>
                      <td colspan="8" style="padding: 5px;">
                        <center><strong>Discount Amount</strong></center>
                      </td>
                      <td  style="padding: 5px;">
                        <strong><?= $discountedAmount; ?>
                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="8" style="padding: 5px;">
                        <center><strong>Total Due Amount</strong></center>
                      </td>
                      <td  style="padding: 5px;">
                        <strong><?php echo $grandtotal_sm= $sum_amt-$discountedAmount; ?>
                        <input type="hidden" name="vehicle_sum_total" value="<?php echo $sum_amt; ?>">
                        </strong>
                      </td>
                    </tr>
                  </table><br>
                  <p><strong>* This is an electronically generated statements and does not require any signature</strong></p>
                  <hr>
                  <center>
                    <p><strong>Office Address:</strong> Plot No.- 610, Second Floor, Kakrola Housing Complex, Opp. Metro Pillor No.- 805, New Delhi - 110043<br>
                    <strong>Contact No.:</strong> 9015222422/7042198790 <br>
                    <strong>Email:</strong> <a href="mailto:accounts@srtms.in?Subject=Estimate" target="_top">accounts@srtms.in</a>
                    </p>
                  </center>
                 </div> <!-- end table-responsive -->
                 <div class="col-lg-12">
                 <button type="button" onclick="printContent('invoice_content');" class="btn btn-primary btn-sm"><i class="fa fa-print" aria-hidden="true"></i> Print</button>
                  <button type="submit" name="generatePDF" class="btn btn-default btn-sm pull-right">Generate PDF</button>
                 </div>
                </div><!-- /.box-body -->
            </div> <!-- end box-info -->
        </form>
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
<!-- Select2 -->
<script src="assets/plugins/select2/select2.full.min.js"></script>
<script>
  $(function () {
    //Initialize Select2 Elements
    $(".select2").select2();
  });
</script>
</body>
</html>
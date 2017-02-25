<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
include("includes/simpleimage.php");
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
if(isset($_POST['submit'])){

  $neft_Id = mysql_real_escape_string($_POST['neft_Id']);
  $chequeId = mysql_real_escape_string($_POST['chequeId']);
  $cashId = mysql_real_escape_string($_POST['cashId']);
  $organizationName = mysql_real_escape_string($_POST['organizationName']);
  $cashAmount = mysql_real_escape_string($_POST['cashAmount']);
  $chequeNo = mysql_real_escape_string($_POST['chequeNo']);
  $chequeDate = mysql_real_escape_string($_POST['chequeDate']);
  $bank = mysql_real_escape_string($_POST['bank']);
  $amountCheque = mysql_real_escape_string($_POST['amountCheque']);
  $depositDate = mysql_real_escape_string($_POST['depositDate']);
  $onlineTransferAmount = mysql_real_escape_string($_POST['onlineTransferAmount']);
  $refNo = mysql_real_escape_string($_POST['refNo']);
  $remarks = mysql_real_escape_string($_POST['remarks']) ;

  $sqlcheque = "UPDATE `quickbookpaymentcheque` SET `ChequeNo`='$chequeNo', `ChequeDate` = '$chequeDate', 
                `Bank` = '$bank', `bankDepositDate`='$depositDate', `chequeAmount`= '$amountCheque' 
                WHERE `Id`=".$chequeId;
  $resultcheque = mysql_query($sqlcheque);

  $sqlCash = "UPDATE `quickbookpaymentmethoddetailsmaster` SET `CashAmount`='$cashAmount', 
              `Remarks` = '$remarks' WHERE `PaymentID`=".$cashId;
  $resultCash = mysql_query($sqlCash);

  $sql_neft = "UPDATE `quickbookpaymentonlinetransfer` SET `RefNo`='$refNo',
              `onlineAmount`='$onlineTransferAmount' 
              WHERE `Id`=".$neft_Id;
  $resultneft = mysql_query($sql_neft);
  
  $_SESSION['sess_msg'] = 'Payment Updated successfully';
  header("location:edit_payment.php?token=".$token);
}
// Select payment details
$sqlcheque = "SELECT * FROM quickbookpaymentcheque as A 
        LEFT OUTER JOIN quickbookpaymentmethoddetailsmaster as B 
        ON A.Id = B.ChequeID 
        LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
        ON B.OnlineTransferId = C.Id WHERE B.ChequeID  = ".$_GET['chequeId'];
/*echo $sql;*/
$resultcheque = mysql_query($sqlcheque);
$rowcheque = mysql_fetch_assoc($resultcheque);

// Select Case Amount
$sqlcash = "SELECT * FROM `quickbookpaymentmethoddetailsmaster` WHERE `PaymentID`= ".$_GET['cashId'];
/*echo $sql;*/
$resultcash = mysql_query($sqlcash);
$rowcash = mysql_fetch_assoc($resultcash);


// Select Online Amount
$sql_neft = "SELECT `RefNo`, `onlineAmount` FROM `quickbookpaymentonlinetransfer` 
             WHERE `Id`= ".$_GET['neftId'];
// echo $sql_neft;
$result_neft = mysql_query($sql_neft);
$row_neft = mysql_fetch_assoc($result_neft);
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
<!-- daterange picker -->
<link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
<!-- bootstrap datepicker -->
<link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
<!-- iCheck for checkboxes and radio inputs -->
<link rel="stylesheet" href="assets/plugins/iCheck/all.css">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="assets/plugins/colorpicker/bootstrap-colorpicker.min.css">
<!-- Bootstrap time Picker -->
<link rel="stylesheet" href="assets/plugins/timepicker/bootstrap-timepicker.min.css">
<!-- Select2 -->
<link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<!-- Custom CSS -->
<link rel="stylesheet" type="text/css" href="assets/dist/css/custom.css">
<script src="assets/bootstrap/js/jquery-1.10.2.js"></script>
<script src="assets/bootstrap/js/jquery-ui.js"></script>
<script type="text/javascript" src="js/textboxEnabled.js"></script>
<script type="text/javascript">
// send ajax request for new client
$(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
// Select Organization when select ticket Id
$(document).ready(function(){
    $("select.ticket").change(function(){
      $.post("ajaxrequest/show_ticket_organization_quick_book.php?token=<?php echo $token;?>",
        {
          ticket : $(".ticket option:selected").val()
        },
          function( data ){
            $("#divOrgranization").html(data);
        });
    
    });
});
// End 
</script>
</head>
<body class="hold-transition skin-blue sidebar-mini" onLoad="checkDefault()">
<!-- Site wrapper -->
<div class="wrapper">
<?php include_once("includes/header.php") ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Quick Book Invoice
        <!--<small>Control panel</small>-->
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Quick Book Invoice</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="box box-info small-panel">
            <div class="box-header">
              <!-- <h3 class="box-title">New Ticket</h3> -->
            </div>
            <div class="box-body">
              <div class="col-md-12">
                <?php if(isset($msg) && $msg !="") {?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> <?= $msg;?>
                </div>
                <?php 
                }
                ?>
                <form name='fullform' class="form-horizontal"  method='post'>
                  <input type="hidden" name="chequeId" id = "chequeId" value="<?= $_GET['chequeId'] ?>">
                  <input type="hidden" name="cashId" id = "cashId" value="<?= $_GET['cashId'] ?>">
                  <input type="hidden" name="neft_Id" id="neft_Id" value="<?php echo $_GET['neftId'] ?>">
                  <div class="form-group form_custom"><!-- form_custom -->
                    <div class="row"><!-- row -->
                          <div class="col-md-6 col-sm-6 custom_field">
                              <span><strong>Organization</strong> <i>*</i></span>
                                <span id="divOrgranization">
                                   <select name="organizationName" id="organizationName" class="form-control select2" style="width: 100%">
                                      <?php 
                                      $custId = $rowcash['customerId'];
                                      if($custId != "")
                                      {
                                        echo "<option value='$custId'>".getCust($custId)."</option>";
                                      }
                                      else
                                      {
                                        echo "<option value=''>Select Orgranization</option>";
                                      }
                                      ?>
                                  </select> 
                                </span>                            
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 field-option"><strong>Cash</strong> <input type="checkbox" name="cash" id="cash">
                            </div>
                            <div class="col-md-6 col-sm-6 custom_field">
                                <span><strong>Amount</strong> <i>*</i></span>
                                <input type="text" name="cashAmount" id="cashAmount" value="<?php if(isset($rowcash['CashAmount'])){ echo $rowcash['CashAmount']; }?>" class="form-control" disabled>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-12 field-option"><strong>Cheque</strong> <input type="checkbox" name="cheque" id="cheque"></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                              <span><strong>Cheque No.</strong> <i>*</i></span>
                            <input type="text" name="chequeNo" id="chequeNo" class="form-control" value="<?php if(isset($rowcheque['ChequeNo'])){ echo $rowcheque['ChequeNo']; }?>" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Cheque Date</strong></span>
                          <input type="text" name="chequeDate" id="chequeDate" value="<?php if(isset($rowcheque['ChequeDate'])){ echo $rowcheque['ChequeDate']; }?>" class="date form-control" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Bank</strong> <i>*</i></span>
                            <select name="bank" id="bank" class="form-control select2 ddlCountry" style="width: 100%" disabled>
                              <option value="">Select Plan Category</option>
                              <?php $Country=mysql_query("select * from tblbank");
                              while($resultCountry=mysql_fetch_assoc($Country)){
                              ?>
                              <option value="<?php echo $resultCountry['bankId']; ?>" 
                              <?php if(isset($rowcheque['Bank']) && $resultCountry['bankId']==$rowcheque['Bank']){ ?>selected<?php } ?>>
                              <?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
                              <?php } ?>
                            </select>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Amount</strong> <i>*</i></span>
                            <input type="text" name="amountCheque" id="amountCheque" value="<?php if(isset($rowcheque['chequeAmount'])){ echo $rowcheque['chequeAmount']; }?>" class="form-control" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Bank Deposit Date</strong> <i>*</i></span>
                          <input type="text" name="depositDate" id="depositDate" value="<?php if(isset($rowcheque['DepositDate'])){ echo $rowcheque['DepositDate']; }?>" class="date form-control" disabled>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-12 field-option"><strong>Online Transfer</strong> <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Amount</strong> <i>*</i></span>
                          <input type="text" name="onlineTransferAmount" id="onlineTransferAmount" 
                          class="form-control" value="<?php echo $row_neft['onlineAmount']; ?>" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Reference No.</strong> <i>*</i></span>
                          <input type="text" name="refNo" id="refNo" 
                          value="<?php echo $row_neft['RefNo']; ?>" class="form-control" disabled>
                          </div>
                          <div class="col-md-12 field-option"><strong>Other Details</strong></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Remarks</strong> <i>*</i></span>
                          <input type="text" name="remarks" id="remarks" value="<?php if(isset($rowcash['Remarks'])) { echo $rowcash['Remarks']; }?>" class="form-control" >
                          </div>
                        </div><!-- End row --> 
                      </div><!--End form_custom -->
                      <div class="clearfix"></div>
                      <div class="form-group form_custom"><!-- form_custom -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6 custom_field">
                                <input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> 
                               <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset">
                               <a href='edit_payment.php?token=<?= $token ?>' class='btn btn-primary btn-sm'>Back</a>
                            </div>
                        </div>
                     </div>
                </form>
              </div>
            </div><!-- /.box-body -->
          </div>
    </section> <!-- end main content -->
</div><!-- /.content-wrapper -->
<?php include_once("includes/footer.php") ?>
</div><!-- ./wrapper -->
<script src="js/bootstrap.min.js"></script>
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
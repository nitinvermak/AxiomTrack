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
if(isset($_POST['submit']))
  {
    $returnCode= 0;
    $userId = $_SESSION['user_id'];
    $ticketId = mysql_real_escape_string($_POST['ticketId']);
    $organizationName = mysql_real_escape_string($_POST['organizationName']);
    $quickBookRefNo = mysql_real_escape_string($_POST['quickBookRefNo']);
    /*Cash payment*/
    $cashAmount = mysql_real_escape_string($_POST['cashAmount']);
    /*Cheque*/
    $chequeNo = mysql_real_escape_string($_POST['chequeNo']);
    $chequeDate = mysql_real_escape_string($_POST['chequeDate']);
    $bank = mysql_real_escape_string($_POST['bank']);
    $amountCheque = mysql_real_escape_string($_POST['amountCheque']);
    $depositDate = mysql_real_escape_string($_POST['depositDate']);
    /*Online Tranfer*/
    $onlineTransferAmount = mysql_real_escape_string($_POST['onlineTransferAmount']);
    $refNo = mysql_real_escape_string($_POST['refNo']);
    /*Other Details*/
    /*$revievingDate = mysql_real_escape_string($_POST['revievingDate']);*/
    $remarks = mysql_real_escape_string($_POST['remarks']);
    $confirmby = mysql_real_escape_string($_POST['confirmby']);
    
    // Sum Received Amount
    $totalAmt = $cashAmount + $amountCheque + $onlineTransferAmount;
    
    if(isset($_POST['cash']) == False && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== True){
            $returnCode = 1;        

        }
        if(isset($_POST['cash']) == False && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== False){
            $returnCode = 2;        
        }
        if(isset($_POST['cash']) == False && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== True){
            $returnCode = 3;        
        }
        if(isset($_POST['cash']) == True && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== False){
            $returnCode = 4;        
        }
        if(isset($_POST['cash']) == True && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== True){
            $returnCode = 5;        
        }
        if(isset($_POST['cash']) == True && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== False){
            $returnCode = 6;        
        }
        if(isset($_POST['cash']) == True && ($_POST['cheque']) == True && ($_POST['onlineTransfer'])== True){
            $returnCode = 7;        
        }
        if(isset($_POST['cash']) == False && ($_POST['cheque']) == False && ($_POST['onlineTransfer'])== False){
            $returnCode = 8;        
        }
    
    switch($returnCode) {
    case 1: // if payment type online transfer when execute this query
                $sql = "Insert into quickbookpaymentonlinetransfer Set 
                        customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
                        RefNo = '$refNo', onlineAmount = '$onlineTransferAmount'";
                // echo $sql;
                $result = mysql_query($sql);
                $OnlineTransferId = mysql_insert_id();
                break;
    case 2: // if payment type cheque when execute this query
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
                        ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
                        chequeAmount = '$amountCheque'";
                // echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id(); 
                break;
    case 3:
                // if payment type cheque when execute this query
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
                        ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
                        chequeAmount = '$amountCheque'";
                // echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                //Online Payment
                // do nothing
                break;
     case 4:
                // Cash Payment
                // do nothing
                break;
    
     case 6:
                //Cash Payment
                // do nothing

                //Cheque Payment
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
                        ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
                        chequeAmount = '$amountCheque'";
                // echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                // cash amount
                // do nothing
                break;
    case 7:
                // cash payment
                // do nothing
                //Cheque Payment
                $sql = "Insert into quickbookpaymentcheque Set ChequeNo = '$chequeNo', 
                        ChequeDate = '$chequeDate', Bank = '$bank', DepositDate = '$depositDate', 
                        chequeAmount = '$amountCheque'";
                // echo $sql;
                $result = mysql_query($sql);
                $ChequeID = mysql_insert_id();
                 // Online Payment
                $sql = "Insert into quickbookpaymentonlinetransfer Set 
                        customerId = '$organizationName', 
                        quickBookRefNo = '$quickBookRefNo',RefNo = '$refNo', 
                        onlineAmount = '$onlineTransferAmount'";
                // echo $sql;
                $result = mysql_query($sql);
                $OnlineTransferId = mysql_insert_id();
            default:
                # code...
                break;
    }
    $sql = "Insert into quickbookpaymentmethoddetailsmaster Set ticketId = '$ticketId', 
            customerId = '$organizationName', quickBookRefNo = '$quickBookRefNo', 
            CashAmount = '$cashAmount', ChequeID = '$ChequeID', 
            OnlineTransferId = '$OnlineTransferId', adjustmentAmt = '$totalAmt', 
            userId = '$userId', RecivedDate = Now(), 
            Remarks = '$remarks'";
    // echo $sql;
    $result = mysql_query($sql);
    if($result){
          $msg = "Payment Added Successfully!";
    }
                $paymentId = mysql_insert_id();
    
  }
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
                  <div class="form-group form_custom"><!-- form_custom -->
                    <div class="row"><!-- row -->
                        <div class="col-md-6 col-sm-6 custom_field">
                          <span id="name" for="name"><strong>Ticket Id</strong> <i>*</i></span>
                                <select name="ticketId" id="ticketId" class="form-control ticket select2" style="width: 100%">
                                    <option value="">Select Ticket Id</option>
                                    <?php $Country=mysql_query("SELECT A.ticket_id as ticket_id FROM tblticket as A 
                                                                INNER JOIN tbl_ticket_assign_branch as B 
                                                                ON A.ticket_id = B.ticket_id 
                                                                where A.organization_type = 'Existing Client'  
                                                                and A.ticket_status <> 1 AND B.technician_assign_status = 1 
                                                                order by ticket_id ASC");
                                           while($resultCountry=mysql_fetch_assoc($Country)){
                                    ?>
                                    <option value="<?php echo $resultCountry['ticket_id']; ?>" 
                                    <?php if(isset($result['ticket_id']) && $resultCountry['ticket_id']==$result['ticket_id']){ ?>selected
                                    <?php } ?>><?php echo stripslashes(ucfirst($resultCountry['ticket_id'])); ?></option>
                                    <?php } ?>
                                </select>                            
                      </div>
                          <div class="clearfix"></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                              <span><strong>Organization</strong> <i>*</i></span>
                                <span id="divOrgranization">
                                  <select name="organizationName" id="organizationName" class="form-control select2"
                                  style="width: 100%">
                                        <option value="">Select Organization</option>
                                    </select>
                                </span>                            
                            </div>
                            <div class="col-md-6 col-sm-6 custom_field">
                              <span><strong>Quick Book Ref. No.</strong> <i>*</i></span>
                                <input type="text" name="quickBookRefNo" id="quickBookRefNo" class="form-control">                            
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 field-option"><strong>Cash</strong> <input type="checkbox" name="cash" id="cash">
                            </div>
                            <div class="col-md-6 col-sm-6 custom_field">
                                <span><strong>Amount</strong> <i>*</i></span>
                                <input type="text" name="cashAmount" id="cashAmount" class="form-control" disabled>
                          </div>
                          <div class="clearfix"></div>
                          <div class="col-md-12 field-option"><strong>Cheque</strong> <input type="checkbox" name="cheque" id="cheque"></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                              <span><strong>Cheque No.</strong> <i>*</i></span>
                            <input type="text" name="chequeNo" id="chequeNo" class="form-control" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Cheque Date</strong></span>
                          <input type="text" name="chequeDate" id="chequeDate" class="date form-control" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Bank</strong> <i>*</i></span>
                          <select name="bank" id="bank" class="form-control ddlCountry" disabled>
                                <option value="">Select Plan Category</option>
                                <?php $Country=mysql_query("select * from tblbank");
                                               while($resultCountry=mysql_fetch_assoc($Country)){
                                ?>
                                <option value="<?php echo $resultCountry['bankId']; ?>" 
                                <?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>>
                                <?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
                                <?php } ?>
                            </select>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Amount</strong> <i>*</i></span>
                          <input type="text" name="amountCheque" id="amountCheque" class="form-control" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Bank Deposit Date</strong> <i>*</i></span>
                          <input type="text" name="depositDate" id="depositDate" class="date form-control" disabled>
                          </div>
                          <div class="clearfix"></div>
                         <!-- <div class="col-md-12 field-option"><strong>Online Transfer</strong> <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Amount</strong> <i>*</i></span>
                          <input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control" disabled>
                          </div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Reference No.</strong> <i>*</i></span>
                          <input type="text" name="refNo" id="refNo" class="form-control" disabled>
                          </div>-->
                          <div class="col-md-12 field-option"><strong>Other Details</strong></div>
                          <div class="col-md-6 col-sm-6 custom_field">
                            <span><strong>Remarks</strong> <i>*</i></span>
                          <input type="text" name="remarks" id="remarks" class="form-control" >
                          </div>
                        </div><!-- End row --> 
                      </div><!--End form_custom -->
                      <div class="clearfix"></div>
                      <div class="form-group form_custom"><!-- form_custom -->
                        <div class="row">
                            <div class="col-md-6 col-sm-6 custom_field">
                                <input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> 
                               <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset">
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
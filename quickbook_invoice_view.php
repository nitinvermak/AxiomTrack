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
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
// Divison Show and Hide
function chequeReport() {
    document.getElementById("chequeReport").style.display = "";
	document.getElementById("cashReport").style.display = "none";
	document.getElementById("neftReport").style.display = "none";
	
}

function cashReport() {
/*alert("test");*/
   document.getElementById("cashReport").style.display = "";
   document.getElementById("chequeReport").style.display = "none";
   document.getElementById("neftReport").style.display = "none";  
}
function neftReport() {
/*alert("test");*/
   document.getElementById("neftReport").style.display = "";
   document.getElementById("cashReport").style.display = "none";
   document.getElementById("chequeReport").style.display = "none"; 
}
// End
// datepicker script
$(function() {
	$( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
});
// end datepicker script
// pass ajax request when search cheque report
$(document).ready(function(){
	$('#submit').click(function(){
	$('.loader').show();
		$.post("ajaxrequest/quick_book_invoice_details.php?token=<?php echo $token;?>",
				{
					date : $('#date').val(),
					dateto : $('#dateto').val(),
					confirmationStatus : $('#confirmationStatus').val(),
					depositStatus : $('#depositStatus').val(),
					clearanceStatus : $('#clearanceStatus').val()
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	 
	});
});
// end

// pass ajax request when search cash report
$(document).ready(function(){
	$('#cashReportSubmit').click(function(){
	$('.loader').show();
		$.post("ajaxrequest/quick_book_invoice_cash_details.php?token=<?php echo $token;?>",
				{
					reciveDateForm : $('#reciveDateForm').val(),
					reciveDateto : $('#reciveDateto').val(),
					cashConfirmation : $('#cashConfirmation').val()
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	 
	});
});
// end

// pass ajax request when search neft report
$(document).ready(function(){
	$('#neftReportDetails').click(function(){
	$('.loader').show();
		$.post("ajaxrequest/quick_book_invoice_neft_details.php?token=<?php echo $token;?>",
				{
					neftDateForm : $('#neftDateForm').val(),
					neftDateTo : $('#neftDateTo').val(),
					neftConfirmationStatus : $('#neftConfirmationStatus').val()
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	 
	});
});
// end
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
    	<h3>Quick Book Invoice   Report</h3>
        <hr>
    </div>
    <div class="col-md-12 select_form">
    	<div class="radio-inline">
              <label>
                <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="chequeReport()" /> 
                Cheque Report </label>
    	</div>
        <div class="radio-inline">
        <label>
              <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="cashReport()"/>
              Cash Report</label>
         </div>
        <div class="radio-inline">
        <label>
              <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="neftReport()"/>
              NEFT Report</label>
         </div>
    </div>
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
    <!-- Cheque Report Section-->
    <div class="col-md-12 table-responsive" id="chequeReport">
    <div class="col-md-12"><h5 class="small-title">Cheque Report</h5></div>
     <table class="form-field" width="100%">
     <tr>
     <td>Date (From)* </td>
     <td><input type="text" name="date" id="date" class="form-control text_box-sm date"></td>
     <td>Confirmation Status</td>
     <td><select name="confirmationStatus" id="confirmationStatus" class="form-control drop_down-sm">
             <option value="">All</option>                         
     		 <option value="1">Yes</option>
             <option value="0">No</option>
        </select>     </td>
     <td>Deposit Status</td>
     <td>
     <select name="depositStatus" id="depositStatus" class="form-control drop_down drop_down-sm">
       <option value="">All</option>
       <option value="Y">Yes</option>
       <option value="N">No</option>      	
     </select>
     </td>
     <td>&nbsp;</td>
     <td><p class="ico"><a href="vehicle_report_csv.php?token=<?php echo $token;?>" title="Download CSV"> <span class="glyphicon glyphicon-download-alt"></span></a></p></td>
     </tr>
      <tr>
     <td>Date&nbsp;(To)*</td>
     <td><input type="text" name="dateto" id="dateto" class="form-control text_box-sm date"></td>
     <td>Clearance Status</td>
     <td>
     	<select name="clearanceStatus" id="clearanceStatus" class="form-control drop_down drop_down-sm">
            <option value="" selected>All</option>                         
            <option value="N">Pending</option>
            <option value="Y">Cleared</option>
            <option value="B">Bounced</option>
        </select>     
      </td>
     <td>&nbsp;</td>
     <td><input type="button" name="assign" value="Submit" id="submit" class="btn btn-primary btn-sm" />
     	 <input type="button" name="assign" value="Summary" onClick="window.location.replace('installation_summary.php?token=<?php echo $token;?>')" id="submit" class="btn btn-primary btn-sm"  />
     </td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
    </div>
	<!-- End cheque Report Section -->
    <!-- Cash Report Section -->
    <div class="col-md-12 table-responsive" id="cashReport" style="display:none" >
    <div class="col-md-12"><h5 class="small-title">Cash Report</h5></div>
     <table class="form-field" width="100%">
     <tr>
     <td width="11%">Date (From)* </td>
     <td width="24%"><input type="text" name="reciveDateForm" id="reciveDateForm" class="form-control text_box-sm date"></td>
     <td width="13%">Confirmation Status</td>
     <td width="14%"><select name="cashConfirmation" id="cashConfirmation" class="form-control drop_down-sm">
             <option value="">All</option>                         
     		 <option value="1">Yes</option>
             <option value="0">No</option>
        </select>     </td>
     <td width="32%">&nbsp;</td>
     <td width="2%"></td>
     <td width="2%">&nbsp;</td>
     <td width="2%"><p class="ico"><a href="vehicle_report_csv.php?token=<?php echo $token;?>" title="Download CSV"> <span class="glyphicon glyphicon-download-alt"></span></a></p></td>
     </tr>
      <tr>
     <td>Date&nbsp;(To)*</td>
     <td><input type="text" name="reciveDateto" id="reciveDatedateto" class="form-control text_box-sm date"></td>
     <td>&nbsp;</td>
     <td><input type="button" name="cashReportSubmit" value="Submit" id="cashReportSubmit" class="btn btn-primary btn-sm" /></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
    </div>
    <!-- End Cash Report Section -->
    <!-- NEFT Report Section -->
     <div class="col-md-12 table-responsive" id="neftReport" style="display:none">
     <div class="col-md-12"><h5 class="small-title">NEFT Report</h5></div>
     <table class="form-field" width="100%">
     <tr>
     <td width="11%">Date (From)* </td>
     <td width="24%"><input type="text" name="neftDateForm" id="neftDateForm" class="form-control text_box-sm date"></td>
     <td width="16%">Confirmation Status</td>
     <td width="11%"><select name="neftConfirmationStatus" id="neftConfirmationStatus" class="form-control drop_down-sm">
             <option value="">All</option>                         
     		 <option value="1">Yes</option>
             <option value="0">No</option>
        </select>     </td>
     <td width="20%"></td>
     <td width="14%"></td>
     <td width="2%">&nbsp;</td>
     <td width="2%"><p class="ico"><a href="vehicle_report_csv.php?token=<?php echo $token;?>" title="Download CSV"> <span class="glyphicon glyphicon-download-alt"></span></a></p></td>
     </tr>
      <tr>
     <td>Date&nbsp;(To)*</td>
     <td><input type="text" name="neftDateTo" id="neftDateTo" class="form-control text_box-sm date"></td>
     <td></td>
     <td><input type="button" name="neftReportDetails" value="Submit" id="neftReportDetails" class="btn btn-primary btn-sm" />      </td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
    </div>
    <!-- End NEFT Report -->
      <div class="col-md-12" style="margin-top:10px;"></div> 
      
      <div id="divassign" class="col-md-12 table-responsive">
		
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
<!-- hidden loader division -->
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
<!-- end hidden loader division-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/sim_confirmation.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/textboxEnabled.js"></script>
<script type="text/javascript">
// Date 
/* $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });*/
// End Date
/* Send ajax request*/
$(document).ready(function(){
		$("#company").change(function(){
			$.post("ajaxrequest/invoice_details.php?token=<?php echo $token;?>",
				{
					cust_id : $('#company').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
		});
});
/* End */

function getValue(name, iName, iId, amount, iYear)
	{

		/*alert(name+iName+iId+amount+iYear);*/
		document.getElementById("name").innerHTML = "Company Name: "+name+ ", Interval Name: "+iName+ " "+iYear+ ", Payable Amount: "+amount;
	    $('#hiddenInvoiceID').val(iId);
    }
// open modal
function getPaymentDetails(a)
	{
		/*alert(a);*/
		$.post("ajaxrequest/invoice_view_popup.php?token=<?php echo $token;?>",
		{
			paymentId : a
		},
		function( data){
			$(".modal-content-payment").html(data);
		});	 
	}
//End
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
    	<h3>Invoice View</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
        <div class="form-group">
            <label for="exampleInputEmail2">Company</label>
            <select name="company" id="company" class="form-control drop_down" >
                <option value="">Select Company</option>
                <?php $Country=mysql_query("SELECT DISTINCT A.cust_id, A.callingdata_id, B.customerId  
											FROM tbl_customer_master as A
											inner join tbl_invoice_master as B
											on A.cust_id = B.customerId;");
				 	  while($resultCountry=mysql_fetch_assoc($Country)){
				?>
                <option value="<?php echo $resultCountry['cust_id']; ?>" ><?php echo getOraganization(stripslashes(ucfirst($resultCountry['callingdata_id']))); ?></option>
                <?php } ?>
            </select>
        </div>
      </div> 
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!---- this division shows the Data of devices from Ajax request --->
       </div>
    </form>
    </div>
</div>
<!--end of the content-->
<!--open of the footer-->
<!-- Payment Modal Start -->
<div class="modal fade bs-example-modal-lg-payment" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content-payment">
    <!-- Show modal body -->
    </div>
  </div>
</div>
<!-- End Payment Modal -->

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
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

// update Installation  Charges
if(count($_POST['linkID'])>0){			   
		if(isset($_POST['linkID']) && (isset($_POST['submit']))){
				foreach($_POST['linkID'] as $vId){
					$sql = "UPDATE `tbl_gps_vehicle_payment_master` SET `oneTimePaymentFlag` = 'Y'
							WHERE `Vehicle_id`=".$vId;
					$result = mysql_query($sql);
					if($result){
						$_SESSION['success_msg'] = "Installation Charge Received !";
					}
				}
		}  
}
// update device Amount
if(count($_POST['linkID'])>0){			   
		if(isset($_POST['linkID']) && (isset($_POST['upadteDeviceAmt']))){
				foreach($_POST['linkID'] as $vId){
					$sql = "UPDATE `tbl_gps_vehicle_payment_master` SET `devicepaymentStatus` = 'Y' 
							WHERE `Vehicle_id`=".$vId;
					echo $sql;
					$result = mysql_query($sql);
					if($result){
						$_SESSION['success_msg'] = "Device Amount Received !";
					}
				}
		}  
}
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
<link rel="stylesheet" href="http:/resources/demos/style.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/sim_confirmation.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript" src="js/validation.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript">
// Date 
/* $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });*/
   $(function() {
    $( ".date" ).datepicker();
  });
// End Date
function getInstalltion(){
	$.post("ajaxrequest/get_combo_installation.php?token=<?php echo $token; ?>",
		function(data){

			$("#DVfield").html(data);
		})
}
function getDeviceAmt(){
	$.post("ajaxrequest/get_combo_device_amt.php?token=<?php echo $token; ?>",
		function(data){
			$("#DVfield").html(data);
		})
}
/* Send ajax request*/
function getInstallationData(){
			$.post("ajaxrequest/show_onetimepayment.php?token=<?php echo $token;?>",
				{
					cust_id : $('#company').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
	}
/* End */
/* Send ajax request*/
function getDeviceAmtData(){
			$.post("ajaxrequest/show_onetimepayment _device_amt.php?token=<?php echo $token;?>",
				{
					cust_id : $('#company').val(),
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
	}
/* End */
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
    	<h3>Update One Time Payment</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<input type="radio" name="payment" value="inChrg" onclick="getInstalltion();"> <strong>Installation Charge</strong>
  		<input type="radio" name="payment" value="dAmt" onclick="getDeviceAmt();"> <strong>Device Amount</strong>
      </div><!-- End col-md-12-->
      <div class="col-md-12" id="DVfield">
        <!-- Show Combo from ajax request -->
      </div> 
	  <div class="col-md-12">
		<div class="col-md-6">
			<?php if($_SESSION['success_msg'] !=''){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <?php echo $_SESSION['success_msg']; $_SESSION['success_msg']='' ?>
			</div>
			<?php 
			}
			?>
		</div>
	  </div>
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
          <!--this division shows the Data of devices from Ajax request -->
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>
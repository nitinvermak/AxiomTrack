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
    	<h3>Payment Details</h3>
        <hr>
    </div>
    <div class="col-md-12">
    
   	 
    </div>
    <div class="col-md-12">
        <form name='fullform' method='post' onSubmit="return confirmdelete()">
       <input type="hidden" name="token" value="<?php echo $token; ?>" />
       <input type='hidden' name='pagename' value='users'>   
    <div class="table-responsive">
      <table class="table table-hover table-bordered ">
      <?php
		$where='';
		$linkSQL="";
		$invoiceId = $_GET['invoiceId'];
		/*echo $invoiceId;*/			
  		if(!isset($linkSQL) or $linkSQL =='')		
     	$linkSQL = "select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, C.amount as amt, 
					A.paymentStatusFlag as statusFlag
					from tbl_invoice_master as A
					inner join tbl_gps_vehicle_master as B
					On A.invoiceId = B.id
					inner join tbl_payment_breakage as C 
					on B.id = C.invoiceId Where C.invoiceId= '$invoiceId'";
		/*echo $linkSQL;*/
 		$oRS = mysql_query($linkSQL); 
 		?>
      <thead>
      <tr>
      <th><small>S. No.</small></th>
      <th><small>Vehile Reg. No.</small></th>
      <th><small>Payment Type</small></th>    
      <th><small>Amount</small></th> 
      <th><small>Action</small></th>  
      </tr>    
      </thead>
	  <?php
	  $kolor=1;
	  if(mysql_num_rows($oRS)>0)
	  	{
  			while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  ?>
      <tbody>
      <tr>
      <td><small><?php print $kolor++;?>.</small></td>
	  <td><small><?php echo stripslashes($row["vehicleNo"]);?></small></td>
      <td><small>
	  <?php 
	  if($row["paymentType"] == "A")
	  {
	  echo "Rent";
	  }
	  if($row["paymentType"] == "B")
	  {
	  echo "Device Amount";
	  }
	  if($row["paymentType"] == "C")
	  {
	  	echo "Installation Charges";
	  }
	  if($row["paymentType"] == "D")
	  {
	  	echo "Installment";
	  }
	  ?>
      </small></td>
	  <td><small><?php echo stripcslashes($row["amt"]); ?></small></td>
      <td><small>
      	  <?php 
		  if($row['statusFlag']=='A')
		  	{
		  ?>
          	<input type="submit" name="payment" id="payment" class="btn btn-info btn-sm" value="Make Payment">
		  <?php 
		  }
		  if($row['statusFlag']=='B')
		  {
		  	echo "Recieved";
		  }
		  ?>
      </small></td>
      </tr>
  	
      </tbody>
	<?php 
    	}
    }
    ?>
    <tr>
    <td></td>
    <td></td>
    <td><p class="pull-right"><strong>Total Amount</strong></p></td>
    <td>
    	<?php 
			$sql = "select sum(amount) from tbl_payment_breakage where invoiceId = '$invoiceId'";
			$query = mysql_query($sql);
			$row = mysql_fetch_array($query);
			echo $row[0];
		?>
    </td>
    <td></td>
    </tr>
    </table>
    <div class="col-md-12">
   
    </div>
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
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['customerId']);

$sql = "SELECT B.invoiceId as estimateId, B.invoiceType as type, B.generatedAmount as amt, 
		B.discountedAmount as discount
		FROM tbl_gps_vehicle_payment_master as A 
		INNER JOIN tbl_invoice_master as B 
		ON A.cust_id = B.customerId
		WHERE B.invoiceType='B' 
		AND A.cust_id = '$cust_id' 
		AND A.device_status_gen_status ='Y'
		AND (B.invoiceFlag = 'N' OR B.invoiceFlag = 'P')";

$result = mysql_query($sql);
if (mysql_num_rows($result)>0) {
	$sno = 1;
	echo "<table class='table table-hover table-bordered example'>";
	echo "<thead>";
	echo "<tr>";
	echo "<th><small>S. No.</small></th>";
	echo "<th><small>Estimate Id</small></th>";
	echo "<th><small>Estimate Type</small></th>";
	echo "<th><small>Generated Amount</small></th>";
	echo "<th><small>Discount Amount</small></th>";
	echo "<th><small>Payble Amount</small></th>";
	echo "<th><small>Payment Details</small></th>";
	echo "<th><small>Make Payment</small></th>";
	echo "<th><small>Download</small></th>";
	echo "</tr>";
	echo "</thead>";
	echo "<tbody>";
	while ($row = mysql_fetch_assoc($result)) {
		echo "<tr>";
		echo "<td><small>".$sno++."</small></td>";
		echo "<td><small>".$row['estimateId']."</small></td>";
		echo "<td><small>".$row['type']."</small></td>";
		echo "<td><small>".$row['amt']."<input type='hidden' value='".$row['amt']."' id='amt' ></small></td>";
		echo "<td><small>".$row['discount']."<input type='hidden' value='".$row['discount']."' id='discount' ></small></td>";
		echo "<td><small>".$payble_amt = $row['amt']-$row['discount']."</small></td>";
		echo "<td><button type='button' class='btn btn-primary btn-sm' data-toggle='modal' 
				   data-target='.bs-example-modal-lg' onclick='get_device_amt_payment_details(".$row['estimateId'].")'>Details</button></td>";
		echo "<td><button type='button' class='btn btn-success btn-sm' data-toggle='modal' 
				   data-target='.bs-example-modal-lg' onclick='get_form_device_payment(".$row['estimateId'].")'>
				   Make Payment</button></td>";
		echo "<td><a href='generate_invoice_device.php?est=".$row['estimateId']."&token=".$token."' target='_blank' class='btn btn-success btn-sm'>Download</a></td>";
		echo "</tr>";

	}
	echo "</tbody>";
	echo "</table>";
}
?>
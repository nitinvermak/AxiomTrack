<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$estimateId = mysql_real_escape_string($_POST['estimateId']);
$sql = "SELECT B.vehicle_no as vehicleno, B.installation_date as activeDate, A.device_amt as device_amt,
		C.discountedAmount as discountamt 
		FROM tbl_gps_vehicle_payment_master as A 
		INNER JOIN tbl_gps_vehicle_master as B 
		ON A.Vehicle_id = B.id 
		INNER JOIN tbl_invoice_master as C 
		ON B.customer_Id = C.customerId
		WHERE C.invoiceType = 'B' 
		AND A.device_status_gen_status = 'Y' 
		AND C.invoiceId ='$estimateId'";
$result = mysql_query($sql);
?>	
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="exampleModalLabel">Payment Details</h4>
</div>
<div class="modal-body">
    <table class="table table-hover table-bordered example">
    	<thead>
    		<tr>
    			<th><small>S.No</small></th>
    			<th><small>Vehicle Reg. No.</small></th>
    			<th><small>Activation Date</small></th>
    			<th><small>Device Amt.</small></th>
    			<!-- <th><small></small></th> -->
    		</tr>
    	</thead>
    	<tbody>
    	<?php 
    	if (mysql_num_rows($result)>0){
    		$sno = 1;
    		while ($row = mysql_fetch_assoc($result)){
    			$total += getPlanAmt($row['device_amt']);
    			$discount = $row['discountamt'];
    			echo "<tr>";
				echo "<td><small>".$sno++."</small></td>";
	    		echo "<td><small>".$row['vehicleno']."</small></td>";
	    		echo "<td><small>".date("d-m-Y", strtotime($row['activeDate']))."</small></td>";
	    		echo "<td><small>".getPlanAmt($row['device_amt'])."</small></td>";
				echo "</tr>";
	    	}
	    	echo "<tr>";
	    	echo "<td>&nbsp;</td>";
	    	echo "<td>&nbsp;</td>";
	    	echo "<td><strong class='pull-right'>Total Amount</strong></td>";
	    	echo "<td><strong>".$total."</strong></td>";
	    	echo "</tr>";

	    	echo "<tr>";
	    	echo "<td>&nbsp;</td>";
	    	echo "<td>&nbsp;</td>";
	    	echo "<td><strong class='pull-right'>Discount Amount</strong></td>";
	    	echo "<td><strong>".$discount."</strong></td>";
	    	echo "</tr>";

	    	echo "<tr>";
	    	echo "<td>&nbsp;</td>";
	    	echo "<td>&nbsp;</td>";
	    	echo "<td><strong class='pull-right'>Discount Amount</strong></td>";
	    	echo "<td><strong>".$grand_total = $total-$discount."</strong></td>";
	    	echo "</tr>";
		}
		else{
			echo "No Details";
		}
    	?>
    	</tbody>
    </table>
    <div class="col-md-12 form-inline">
    	<div id="MsgDv"></div>
    	<div class="form-group">
		    <label for="exampleInputName2">Provide Discount</label>
		    <input type="text" class="form-control" id="discount_amt" placeholder="RS.">
		</div>
		 <button type="button" class="btn btn-primary btn-sm" onclick="add_discount_amt(<?= $estimateId; ?>)">Go</button>
    </div>
    <div class="clearfix"></div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <!-- <button type="button" class="btn btn-primary">Send message</button> -->
</div>
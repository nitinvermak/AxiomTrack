<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
// echo $cust_id;
error_reporting(0);
if($cust_id != "")
{
		 $sql = "SELECT A.id as vId, A.vehicle_no as vNo, B.next_due_date as next_due_date,
					A.installation_date as activationDate
					FROM tbl_gps_vehicle_master as A 
					INNER JOIN tbl_gps_vehicle_payment_master as B 
					ON A.id = B.Vehicle_id
					WHERE A.activeStatus = 'Y'
					AND B.PlanactiveFlag= 'Y'
					AND A.customer_Id ='$cust_id'";


		// SELECT A.Vehicle_id as vId, B.vehicle_no as vNo, 
		// 			A.next_due_date as next_due_date,
		// 			B.installation_date as activationDate
		// 			FROM tbl_gps_vehicle_payment_master as A
		// 			INNER JOIN tbl_gps_vehicle_master as B 
		// 			ON A.Vehicle_id = B.id 
		// 			WHERE A.cust_id = '$cust_id'
		// 			AND A.PlanactiveFlag = 'Y'
		// 			AND B.activeStatus = 'Y'
		// 			ORDER BY A.next_due_date";

		$result = mysql_query($sql);
		if(mysql_num_rows($result)>0){
			echo "<form method='post' action=''>";
			echo "<div class = 'col-md-12' id = 'dvMSG'></div>";
			echo "<table id='example' class='table table-striped table-bordered' cellspacing='0' width='100%'>";
			echo "<thead>";
			echo "<tr>";
			echo "<th><small>S. No.</small></th>";
			echo "<th><small><strong>Vehicle Id</strong></small></th>";
			echo "<th><small><strong>Vehicle No.</strong></small></th>";
			echo "<th><small>Activation Date</small></th>";
			echo "<th><small><strong>Next Due Date</strong> 
				<input type='checkbox' name='date_field' class='date_field' id='date_field' onchange='makeAllDateSame()' >
				  <span  style='color:#fff'>Make All Date Same</span></small>
					
				 </th>";
			echo "</tr>";
			$sNo =1;
			while($row = mysql_fetch_assoc($result))
			{
?>
				<tbody>
					<tr>
						<td><small><?= $sNo++; ?>.</small></td>
						<td><small><?= $row['vId']; ?>
						<input type="hidden" name="vehicleId[]" id="vehicleId" value="<?= $row['vId']; ?>"/>
						</small></td>
						<td><small><?= $row['vNo']; ?></small></td>
						<td><small><?= date("d-m-Y", strtotime($row['activationDate'])); ?></small></td>
						<td><input type="date" class="next_due_date form-control" 
						id="<?= $row['vId']; ?>" value="<?= $row['next_due_date']; ?>" style="border-radius:0px;"/></td>
					</tr>
				</tbody>
<?php				
			}
			echo "</table>";
			echo "<input type='button' name='submit' onclick='getDueDateData();' class='btn btn-primary btn-sm' value='submit'/>";
			echo "</form>";
		}
		else{
			echo "<h3 style='color:red;'>No Records found !</h3>";
		}
		
}
?>		
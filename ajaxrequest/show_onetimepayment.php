<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
/*echo $cust_id;*/
error_reporting(0);
if($cust_id != ""){
		$sql = "SELECT A.Vehicle_id as vId, A.oneTimePaymentFlag as paymentStatus, 
				B.vehicle_no as vNo
				FROM tbl_gps_vehicle_payment_master as A 
				INNER JOIN tbl_gps_vehicle_master as B
				ON A.Vehicle_id = B.id 
				WHERE A.oneTimePaymentFlag = 'N' 
				AND A.cust_id = '$cust_id' 
				ORDER BY A.Vehicle_id";
				
		$result = mysql_query($sql);
		echo "<form method= 'post' action=''>";
		echo "<div class='col-md-12' style='margin:0px 0px 50px 0px; padding:0px;'><h3>Installation Charges</h3></div>";
		echo "<div class='clearfix'></div>";
		echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
					<th><small>S.No.</small></th>  
					<th><small>Vehicle Id</small></th>  
					<th><small>Vehicle No.</small></th>
					<th><small>One Time Payment</small></th>  
					<th><small>Action&nbsp;&nbsp;
						<strong>
						<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" 
						style="color:#fff; font-size:11px;">Check All </a>
                       	&nbsp;
						<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" 
						style="color:#fff; font-size:11px;">Uncheck All </a>
						</strong>
					</small></th>
				</tr>    
        <?php
			$sNo=1;
			if(mysql_num_rows($result)>0){
				while ($row = mysql_fetch_array($result)){
 	  	?>
				<tr>
					<td><small><?= $sNo++; ?>.</small></td>
					<td><small><?= $row['vId'] ?></small></td>
					<td><small><?= $row['vNo'] ?></small></td>
					<td><small><?php if($row['paymentStatus'] == 'N'){ echo 'No'; } ?></small></td>
					<td><input type='checkbox' name='linkID[]' id="linkID" value='<?= $row["vId"]; ?>'></td>
				</tr>
<?php 
				}
				echo "</table>";
				echo "<input type='submit' name='submit' value='Submit' onclick='return val();' id='submit' class='btn btn-primary btn-sm'>";
				echo "</form>";
			}
			else{
				echo "<h3><font color=red>No records found !</font></h3><br><br>";
			}
	}
	else{
		echo "<h3><font color=red>Please Provide Search Criteria !</font></h3><br><br>";
	}
?>

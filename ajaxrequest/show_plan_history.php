<?php
include("../includes/config.inc.php"); 
/*include("../includes/crosssite.inc.php"); */
$cust_id = $_REQUEST['cust_id']; 
error_reporting(0);
if ($cust_id == '')
	{
	$linkSQL = "Please Provide Search Criteria";
	}
		else if($cust_id !== '')
			{
				$linkSQL = "SELECT * FROM tbl_customer_master as A 
						    INNER JOIN tbl_gps_vehicle_master as B 
						    on A.cust_id = B.customer_Id
						    INNER JOIN tbl_gps_vehicle_payment_master as C 
						    ON B.id = C.Vehicle_id
						    WHERE A.cust_id = '$cust_id'
							and C.PlanactiveFlag = 'Y' 
                            and B.activeStatus = 'Y'
							order by B.vehicle_no
							";
				/*echo "cmd" . $linkSQL;*/
			}
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{	
	 	echo '<table width="500px" class="table table-hover table-bordered ">';
?>	
			 
             <tr>
             <th><small>S. No.</small></th> 
             <th><small>Vehicle No.</small></th>  
             <th><small>Device Type</small></th>
             <th><small>Device Amt.</small></th>
             <th><small>Rent Amt.</small></th>
             <th><small>Rent Frq.</small></th>
             <th><small>Inst. Charges</small></th>
             <th><small>Installment Amt</small></th>
             <th><small>No of Installment</small></th>
             <th><small>Inst. Frq.</small></th>
             <th><small>Start Date</small></th>
             <th><small>End Date</small></th>
             <th><small>Action</small></th>
             </tr>
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
             
        	<tr <?php print $class?>  id='<?php echo stripslashes($row["id"]);?>'>
      		<td><small><?php print $kolor++;?>.</small></td>
	  		<td><small><?php echo stripslashes($row["vehicle_no"]);?> 
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo stripslashes($row["Vehicle_id"]);?>">
            <input type="hidden" name="custid" id="custid" value="<?php echo stripslashes($row["cust_id"]);?>">
            </small>
            </td>
	  		<td><small><?php echo getDeviceType($row['device_type']);?></small></td>
	  		<td><small><?php  if($row['device_amt'] !=0) { echo getDeviceAmt($row['device_amt']); } else { echo 'N/A'; } ?></small></td>
	  		<td><small><?php if($row['device_rent_amt'] !=0) { echo getDeviceAmt($row['device_rent_amt']); } else { echo 'N/A';} ?></small></td>
            <td><small><?php if($row['RentalFrequencyId'] !=0) { echo getFrequency($row['RentalFrequencyId']); } else { echo 'N/A';} ?></small></td>
        	<td><small><?php if($row['installation_charges'] == '0') { echo 'N/A'; } else { echo getDeviceAmt($row['installation_charges']); } ?></small></td>
            <td><small><?php if($row['InstallmentamountID'] !=0){ echo $row['InstallmentamountID'];} else { echo 'N/A';} ?></small></td>
            <td><small><?php if($row['NoOfInstallment'] !=0) { echo stripcslashes(ucfirst($row['NoOfInstallment']));} else { echo 'N/A';}?></small></td>
            <td><small><?php if($row['InstFrequencyID'] !=0) { echo getFrequency($row['InstFrequencyID']); } else { echo 'N/A'; } ?></small></td>
            <td><small><?php echo date("d-m-Y", strtotime($row["PlanStartDate"]));?> 
            <input type="hidden" name="installation_date" id="installation_date" value="<?php echo stripslashes($row["installation_date"]);?>">
            </small></td>
            <td><small>
                <?php 
                echo date("d-m-Y", strtotime($row["PlanendDate"]));
                ?> 
            <input type="hidden" name="plan_end" id="plan_end" value="<?php echo stripslashes($row["PlanendDate"]);?>">
            </small></td>
        	<td><img class="pointer" id="image" onclick="getDetails(<?php echo stripslashes($row["Vehicle_id"]);?>)" src="images/plus.gif" /></td>
</tr>
            <tr id="divHistory<?php echo stripslashes($row["Vehicle_id"]);?>" style="display: none;">
            <td colspan="13" style="margin:0; padding:0; border:none;">
            <div id="dataDivHistory<?php echo stripslashes($row["Vehicle_id"]);?>" style="margin:0; padding:0;">
        		 
      		</div> 
          
            </td>
            </tr>
        
       
	<?php 
	      }
	}
    else
   		 echo "<h3 style='color:red;'>No Plan & History found!</h3>";
	?> 
          			
                
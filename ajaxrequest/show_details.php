<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$vehicle_id = $_REQUEST['vehicle_id']; 
/*echo 'ajfhasjkfh';*/
/*echo $searchText;*/
error_reporting(0);
error_reporting(0);
if ($vehicle_id == '')
	{
	$linkSQL = "Please Provide Search Criteria";
	}
		else if($vehicle_id !== '')
			{
				$linkSQL = "SELECT * FROM tbl_customer_master as A 
							INNER JOIN tbl_gps_vehicle_master as B 
							on A.cust_id = B.customer_Id 
							INNER JOIN tbl_gps_vehicle_payment_master as C 
							ON B.id = C.Vehicle_id WHERE C.Vehicle_id = '$vehicle_id' AND C.PlanactiveFlag = 'Y'";
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
             </tr>
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
             
        	<tr <?php print $class?>  id='<?php echo stripslashes($row["id"]);?>' class="info">
      		<td><small><?php print $kolor++;?>.</small></td>
	  		<td><small><?php echo stripslashes($row["vehicle_no"]);?> 
            <input type="hidden" name="vehicle_id" id="vehicle_id" value="<?php echo stripslashes($row["Vehicle_id"]);?>">
            <input type="hidden" name="custid" id="custid" value="<?php echo stripslashes($row["cust_id"]);?>">
            </small>
            </td>
	  		<td>
                <?php echo $row['device_type'];?>
           </td>
	  		<td>
            <?php echo $row['device_amt']; ?>
            </td>
	  		<td>               
             <?php echo $row['device_rent_amt']; ?>                
            </td>
            <td>
            	<?php echo $row['RentalFrequencyId']; ?>
            </td>
        	<td>
            	<?php echo $row['r_installation_charge']; ?>             
    		</td>
            <td>
               <?php echo $row['InstallmentamountID']; ?>          
            </td>
            <td>
           	<?php echo stripcslashes(ucfirst($row['NoOfInstallment']));?>
        	</td>
            <td>
            <?php echo $row['InstFrequencyID']; ?>  
        	</td>
            <td><small><?php echo stripslashes($row["PlanStartDate"]);?> 
            <input type="hidden" name="installation_date" id="installation_date" value="<?php echo stripslashes($row["installation_date"]);?>">
            </small></td>
            <td><small><?php echo stripslashes($row["PlanendDate"]);?> 
            <input type="hidden" name="plan_end" id="plan_end" value="<?php echo stripslashes($row["PlanendDate"]);?>">
            </small></td>
      		</tr>
        
       
	<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
	?> 
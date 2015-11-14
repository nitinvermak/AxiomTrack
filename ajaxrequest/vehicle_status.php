<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = $_REQUEST['cust_id']; 
/*echo $cust_id;*/
error_reporting(0);
if ($cust_id == '')
	{
	$linkSQL = "Please Provide Search Criteria";
	}
		else if($cust_id !== '')
			{
				$linkSQL = "SELECT A.cust_id, A.customer_type, A.np_device_amt, 
							A.np_device_rent, A.installment_amt, A.r_installation_charge, A.no_of_installment, 
							A.rent_payment_mode, B.vehicle_no, B.id, B.installation_date, B.device_id, B.mobile_no, 
							B.model_name, B.paymentActiveFlag, B.activeStatus 
							FROM tbl_customer_master as A
							Inner JOIN tbl_gps_vehicle_master as B 
							ON A.cust_id = B.Customer_id 
							WHERE A.cust_id = '$cust_id' and B.paymentActiveFlag='N'
							order by B.device_id ASC
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
             <th><small>Device Id</small></th>
             <th><small>Model</small></th>
             <th><small>Mobile No.</small></th>
          	 <th><small>Date of Instl.</small></th>
             <th><small>Status</small></th>
             </tr>
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 	?>
             
        	<tr <?php print $class?>  id='<?php echo stripslashes($row["id"]);?>'>
      		<td><small><?php print $kolor++;?>.</small></td>
	  		<td><small><?php echo stripslashes($row["vehicle_no"]);?></small></td>
            <td>
            <small><?php echo stripslashes($row["device_id"]);?></small>
            <input type="hidden" name="deviceId" id="deviceId" value="<?php echo stripslashes($row["device_id"]);?>">
            </td>
            <td><small><?php echo stripslashes($row["model_name"]);?></small></td>
            <td><small><?php echo getMobile(stripslashes($row["mobile_no"]));?></small></td>
	  		<td><small><?php echo stripslashes($row["installation_date"]);?></small></td>        
        	<td>
            <?php 
			if($row['activeStatus']=='Y')
			{
			?>
            <input type="button" name="Inactive" id="Inactive" class="btn btn-success btn-sm" value="Active" onClick="getInactive(<?php echo stripslashes($row['device_id']); ?>);">
			<?php 
			}
			else
			{
			?>
			<input type="button" name="Active" id="Active" class="btn btn-danger btn-sm" value="Inactive" onClick="getActive(<?php echo stripslashes($row['device_id']); ?>);">
            <?php
			}
			?>
            </td>
      	</tr>
        
        
	<?php 
	      }
		  
 
	}
    else
   		 echo "<h3 style='color:red;'>No records found!</h3>";
	?> 
          			
                
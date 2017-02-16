<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = mysql_real_escape_string($_POST['custId']);
error_reporting(0);
	$linkSQL = "SELECT A.customer_Id as custId, A.vehicle_no as vehicleNo, A.paymentActiveFlag as paymentStatus, 
				C.callingdata_id as callingdateId, B.device_amt as dueAmt, A.receivedAmt as receivedAmt, B.Vehicle_id as vehicleId
				FROM tbl_gps_vehicle_master as A 
				INNER JOIN tbl_gps_vehicle_payment_master as B 
				ON A.id = B.Vehicle_id
				INNER JOIN tbl_customer_master as C 
				ON B.cust_id = C.cust_id
				WHERE A.customer_Id = '$custId '";
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
?>		
				<div class="paymentType">
                <p><strong>Payment Id</strong>
                <select name="paymentId" class="form-control input-sm drop_down" id="paymentId" onChange="getDeviceAmt();">
                <option label="" value="">--Select--</option>
                        <?php $sql = mysql_query("SELECT `PaymentID` FROM `quickbookpaymentmethoddetailsmaster` WHERE `customerId` = '$custId' and adjustmentAmt <> 0");
                                       while($result=mysql_fetch_assoc($sql)){
                        ?>
                        <option value="<?php echo $result['PaymentID']; ?>">
                        	<?php echo $result['PaymentID']; ?>
                        </option>
                        <?php }?>
                </select>
                <span id="divAmt"> </span></p>
                
                </div>
                
				<table border="0" width="100%" class="table table-hover table-bordered">
				<tr>
	            	<th><small>S. No.</small></th>                        
	                <th><small>Company Name</small></th>  
	                <th><small>Vehicle No.</small></th>
	                <th><small>Due Amt.</small></th>  
	                <th><small>Recieved Amt.</small></th>
                    <th><small>Pending Amt.</small></th>
                    
	                <th><small>Actions</small></td>   
                    <th></th>
               </tr>   
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
    ?>
       		   <tr>
               <td><small><?php print $kolor++;?>.</small></td>
			   <td><small><?php echo getOraganization(stripslashes($row["callingdateId"]));?></small></td>
               <td><small><?php echo stripslashes($row["vehicleNo"]);?></small></td>	
			   <td><small><?php echo getPlanAmt(stripslashes($row["dueAmt"]));?></small></td>	
			   <td><small><?php echo stripslashes($row["receivedAmt"]);?></small>
               	   <input type="hidden" name="PrereceivedAmt<?php echo stripslashes($row["vehicleId"]);?>" id="PrereceivedAmt<?php echo stripslashes($row["vehicleId"]);?>" value="<?php echo stripslashes($row["receivedAmt"]);?>" />
               </td>		
               <td><small><?php $pendingAmt = getPlanAmt($row["dueAmt"]) - $row["receivedAmt"]; echo $pendingAmt; ?></small>
               </td>		  
               <td><?php $pendingAmt = getPlanAmt($row["dueAmt"]) - $row["receivedAmt"]; 
			   	if($pendingAmt ==0)
				{
				}
				else
				{
			   ?>
               <input type='checkbox' name='linkID[]' id="linkID<?php echo $row["vehicleId"]; ?>" value='<?php echo $row["vehicleId"]; ?>' onclick='getField(<?php echo $row["vehicleId"]; ?>);'>
               <?php }?>
               </td>
               <td><div id="dvAmt<?php echo $row["vehicleId"]; ?>" style="display:none">
               <input type="text" name="receivedAmt"  id="receivedAmt<?php echo stripslashes($row["vehicleId"]);?>" />
               <input type="button" value="Save" id="save<?php echo $row["vehicleId"]; ?>" onclick="getAmount(<?php echo stripslashes($row["vehicleId"]);?>);" />
               </div></td>
               </tr>
 
	<?php 
	      }
	echo "</table>";
	}
    else
   		 echo "<h3>No records found!</h3><br><br>";
?> 

                         
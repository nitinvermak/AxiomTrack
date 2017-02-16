<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = mysql_real_escape_string($_POST['searchText']);
error_reporting(0);
	$linkSQL = "SELECT D.callingdata_id as callingdataId, SUM(C.plan_rate) as deviceAmt, COUNT(*) as noOfVehicle
				FROM tbl_gps_vehicle_master as A 
				INNER JOIN tbl_gps_vehicle_payment_master as B 
				ON A.id = B.Vehicle_id
				INNER JOIN tblplan as C 
				ON B.device_amt = C.id
				INNER JOIN tbl_customer_master as D 
				ON B.cust_id = D.cust_id WHERE A.activeStatus = 'Y' and D.cust_id = '$custId'";
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
?>		
				
				<table border="0" width="100%" class="table table-hover table-bordered">
				<tr>
	            	<th><small>S. No.</small></th>                        
	                <th><small>Company Name</small></th>  
	                <th><small>No. of Vehicle</small></th>
	                <th><small>Pending Amt.</small></th>
                </tr>   
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
    ?>
       		   <tr>
               <td><small><?php print $kolor++;?>.</small></td>
			   <td><small><?php echo getOraganization(stripslashes($row["callingdataId"]));?></small></td>
               <td><small><?php echo stripslashes($row["noOfVehicle"]);?></small></td>	
			   <td><small><?php echo stripslashes($row["deviceAmt"]);?></small></td>	
               </tr>
 
	<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3>No records found!</h3></td><tr/></table>";
?> 
</table>

                         
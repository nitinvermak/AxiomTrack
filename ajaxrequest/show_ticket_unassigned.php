<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$date=$_REQUEST['date']; 
error_reporting(0);
if ($date == 0)
	{
		$linkSQL = "SELECT B.vehicle_no as vehicleNo, A.repairReason as reason, A.ticket_id as ticketId, 
					A.organization_id as organizationId, A.product as product, A.rqst_type as rqstTpe, 
					A.createddate as createDate, A.CreateBy as createdBy, A.appointment_date as apointmentDate  
					FROM tblticket as A 
					Left Outer Join tbl_gps_vehicle_master as B 
					ON A.vehicleId = B.id 
					WHERE A.branch_assign_status = '0'
					ORDER BY A.ticket_id";
	}
		else
			{
				$linkSQL = "SELECT B.vehicle_no as vehicleNo, A.repairReason as reason, A.ticket_id as ticketId, 
							A.organization_id as organizationId, A.product as product, A.rqst_type as rqstTpe, 
							A.createddate as createDate, A.CreateBy as createdBy, A.appointment_date as apointmentDate  
							FROM tblticket as A 
							Left Outer Join tbl_gps_vehicle_master as B 
							ON A.vehicleId = B.id 
							WHERE A.branch_assign_status = '0'
							AND A.appointment_date LIKE '%$date%' 
							ORDER BY A.ticket_id";
				/*echo $linkSQL;*/
			}
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table class="table table-hover table-bordered ">  ';
?>		
				 
                 
    	          <tr>
                  <th><small>S. No.</small></th>  
                  <th><small>Ticket Id</small></th> 
                  <th><small>Organization Name</small></th>
                  <th><small>Product</small></th>
                  <th><small>Request Type</small></th> 
                  <th><small>Reason</small></th>
                  <th><small>Vehicle No.</small></th>
                 <!-- <th><small>Created Date</small></th> -->
				  <th><small>Created By</small></th> 
                  <th><small>Appointment Date Time</small></th>             
                  <th><small>Actions<br>
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>  </small>           </th>
                  </tr>    
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 			if($kolor%2==0)
				$class="bgcolor='#ffffff'";
			else
				$class="bgcolor='#fff'";
  	
 	?>
          		 <tr <?php print $class?>>
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small><?php echo stripslashes($row["ticketId"]);?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["organizationId"]));?></small></td>
				 <td><small><?php echo getproducts(stripslashes($row["product"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["rqstTpe"]));?></small></td>
                 <td><small>
				 <?php
				 if($row["reason"] == NULL)
				 {
				 	echo "N/A";
				 }
				 else
				 {
				 	echo stripslashes($row["reason"]);
				 }
				 ?>
                 </small></td>
                 <td><small>
				 <?php
				 if($row["vehicleNo"] == NULL) 
				 {
				 	echo "N/A";
				 }
				 else
				 {
				 	echo stripslashes($row["vehicleNo"]);
				 }
				 ?>
                 </small></td>
				 <!--<td><small><?php echo stripslashes($row["createDate"]);?></small></td>-->
				 <td><small><?php echo gettelecallername(stripslashes($row["createdBy"]));?></small></td>
                 <td><small><?php echo stripslashes($row["apointmentDate"]);?></small></td>
                 <td><small><input type='checkbox' name='linkID[]' value='<?php echo $row["ticketId"]; ?>'> </small></td>
                 </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<h3 style='color:red;'>No records found!</h3><br><br>";
?> 
          	   <form method="post" onSubmit="return validate(this);">
               <table>
               <tr>
               <td colspan="3">
               <input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
               <td></td>
               </tr>
               </table>
               </form>   
                
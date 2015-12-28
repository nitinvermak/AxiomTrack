<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch = $_REQUEST['branch']; 
error_reporting(0);
if ($branch == 0)
	{
		$linkSQL = "SELECT A.ticket_id as tId, A.organization_id as OrgId, 
					A.product as prdct, A.rqst_type as rquestType, 
					A.repairReason as reason, A.createddate as createdDate, 
					B.assign_by as assignBy, A.appointment_date as apointDate, 
					B.assign_date as assignDate, C.vehicle_no as vehicleNo 
					FROM tblticket as A 
					INNER JOIN tbl_ticket_assign_branch as B 
					ON A.ticket_id = B.ticket_id
					LEFT OUTER JOIN tbl_gps_vehicle_master as C 
					ON A.vehicleId = C.id
					WHERE A.ticket_id =  B.ticket_id 
					AND B.branch_confirmation_status='0'";
	}
else
	{
		$linkSQL = "SELECT A.ticket_id as tId, A.organization_id as OrgId, 
					A.product as prdct, A.rqst_type as rquestType, 
					A.repairReason as reason, A.createddate as createdDate, 
					B.assign_by as assignBy, A.appointment_date as apointDate, 
					B.assign_date as assignDate, C.vehicle_no as vehicleNo 
					FROM tblticket as A 
					INNER JOIN tbl_ticket_assign_branch as B 
					ON A.ticket_id = B.ticket_id
					LEFT OUTER JOIN tbl_gps_vehicle_master as C 
					ON A.vehicleId = C.id
					WHERE A.ticket_id =  B.ticket_id 
					AND B.branch_confirmation_status='0' 
					AND B.branch_id = '$branch'";
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
                  <th><small>Created</small></th>
                  <th><small>Appointment Date Time</small></th>  
                  <th><small>Assign Date</small></th>            
				  <th><small>Assign By</small></th>  
                  <th><small>Actions</small><br>
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>             </th>  
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
                 <td><small><?php echo stripslashes($row["tId"]);?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["OrgId"]));?></small></td>
				 <td><small><?php echo getproducts(stripslashes($row["prdct"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["rquestType"]));?></small></td>
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
				 <td><small><?php echo stripslashes($row["createdDate"]);?></small></td>
                 <td><small><?php echo stripslashes($row["apointDate"]);?></small></td>
                 <td><small><?php echo stripcslashes($row['assignDate']);?></small></td>
				 <td><small><?php echo gettelecallername(stripcslashes($row['assignBy']));?></small></td>
                 <td><input type='checkbox' name='linkID[]' value='<?php echo $row["tId"]; ?>'> 
                 </td>
                 </tr>
 
	<?php 
	      }

 

	}
    else
   	echo "<h3 style='color:red'>No records found!</h3><br><br>";
?> 
                         
          				<form method="post">
                          <table>
                          <tr>
                          <td colspan="3"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
                          <td></td>
                          </tr>
                          </table>
                   	    </form>   
              
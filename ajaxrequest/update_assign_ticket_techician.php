<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$ticket_id = mysql_real_escape_string($_POST['ticket_id']);
error_reporting(0);
$linkSQL = "SELECT * FROM tblticket as A 
			INNER JOIN tbl_ticket_assign_branch as B 
			ON A.ticket_id = B.ticket_id
			INNER JOIN tbl_ticket_assign_technician as C 
			ON B.ticket_id = C.ticket_id Where B.ticket_id = '$ticket_id'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-bordered table-hover" id="example">  ';
	 	echo "<thead>";
?>                 
    	          <tr>
	                  <th><small>S. No.</small></th>     
	                  <th><small>Ticket Id</small></th> 
	                  <th><small>Organization Name</small></th>  
	                  <th><small>Product</small></th>
	                  <th><small>Request Type</small></th> 
	                  <th><small>Vehicle No</small></th> 
	                  <th><small>Created</small></th> 
	                  <th><small>Appointment Date Time</small></th>              
	                  <th><small>Actions</small></th>   
                  </tr> 
             </thead>
             <tbody>   
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 		   if($row["assignstatus"]==0)
				{
					$stock ='In Stock';
				}
		   if($row["assignstatus"]==1)
				{
					$stock = 'Assigned';
				}
  
 		   if($kolor%2==0)
				$class="bgcolor='#ffffff'";
		   else
				$class="bgcolor='#fff'";
  	
 	?>
       			 <tr <?php print $class?>>
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small><?php echo stripslashes($row["ticket_id"]);?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["organization_id"]));?></small></td>
				 <td><small><?php echo getproducts(stripslashes($row["product"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["rqst_type"]));?></small></td>
                 <td><small><?php echo getVehicle($row['vehicleId']); ?></small></td>
				 <td><small><?php echo stripslashes($row["createddate"]);?></small></td>
                 <td><small><?php echo stripslashes($row["appointment_date"]." ".$row["appointment_time"]);?></small></td>
                 <td>
                   <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>" ><img src="images/drop.png" title="Close" border="0" /></a> &nbsp;&nbsp;  <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>"><small><span>Update Status</span></small></a>
                 </td>
                 </tr>
	<?php 
	      }
	}
?> 
</tbody>
</table>

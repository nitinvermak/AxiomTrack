<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$search_date = $_REQUEST['search_date'];
$branch = $_GET['branch']; 
$users = $_GET['users']; 
/*echo  "sadkfhadskfhs";*/
error_reporting(0);
if($branch == 0)
	{
		$linkSQL = "SELECT * FROM tblticket as A 
					INNER JOIN tbl_ticket_assign_branch as B 
					ON A.ticket_id = B.ticket_id
					INNER JOIN tbl_ticket_assign_technician as C 
					ON B.ticket_id = C.ticket_id WHERE A.ticket_status=0";
	}
else if($branch >0)
	{
		$linkSQL = "SELECT * FROM tblticket as A 
					INNER JOIN tbl_ticket_assign_branch as B 
					ON A.ticket_id = B.ticket_id
					INNER JOIN tbl_ticket_assign_technician as C 
					ON B.ticket_id = C.ticket_id WHERE A.ticket_status=0 and B.branch_id='$branch'";
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-bordered table-hover">  ';
?>                 
    	          <tr>
                  <th>S. No.</td>     
                  <th>Ticket Id</td> 
                  <th>Organization Name</td>  
                  <th>Product</td>
                  <th>Request Type</td> 
                  <th>Created</td> 
                  <th>Appointment Date Time</td>              
                  <th>
                  <b>Actions</b>                  
                                   
                  </td>   
                  </tr>    
	
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
                 <td><?php print $kolor++;?>.</td>
                 <td><?php echo stripslashes($row["ticket_id"]);?></td>
				 <td><?php echo getOraganization(stripslashes($row["organization_id"]));?></td>
				 <td><?php echo getproducts(stripslashes($row["product"]));?></td>
                 <td><?php echo getRequesttype(stripslashes($row["rqst_type"]));?></td>
				 <td><?php echo stripslashes($row["createddate"]);?></td>
                 <td><?php echo stripslashes($row["appointment_date"]." ".$row["appointment_time"]);?></td>
                 <td>
                   <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>" ><img src="images/drop.png" title="Close" border="0" /></a> &nbsp;&nbsp;  <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>"><span>Update Status</span></a>
                 </td>
                 </tr>
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
?> 

 	
        <!-- Modal -->

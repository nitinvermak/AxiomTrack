<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$dateform = $_REQUEST['dateform'];
$dateto =$_GET['dateto'];
$branch = $_GET['branch']; 
$users = $_GET['users']; 
/*echo $branch;
echo $dateto;*/
error_reporting(0);
$linkSQL = "SELECT * FROM tblticket as A 
			INNER JOIN tbl_ticket_assign_branch as B 
			ON A.ticket_id = B.ticket_id
			INNER JOIN tbl_ticket_assign_technician as C 
			ON B.ticket_id = C.ticket_id" ;
			/*echo $linkSQL;*/ 

if ( ( $dateform !='' and $dateto !='') or ($branch != 0) or ($users !=0) ){
	$linkSQL  = $linkSQL." WHERE ";	
}
$counter = 0;
if ( $dateform !='' and $dateto !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." DATE(A.appointment_date) BETWEEN '$dateform' AND '$dateto' AND (ticket_status = 0 or ticket_status = 2) " ;
		$counter+=1;
		/*echo $linkSQL;*/
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.branch_id = '$branch'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $users != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." C.technician_id = '$users'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-bordered table-hover">  ';
?>                 
    	          <tr>
                  <th><small>S. No.</small></th>     
                  <th><small>Ticket Id</small></th> 
                  <th><small>Organization Name</small></th>  
                  <th><small>Product</small></th>
                  <th><small>Request Type</small></th> 
                  <th><small>Created</small></th> 
                  <th><small>Appointment Date Time</small></th>              
                  <th><small>Actions</small></th>   
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
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small><?php echo stripslashes($row["ticket_id"]);?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["organization_id"]));?></small></td>
				 <td><small><?php echo getproducts(stripslashes($row["product"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["rqst_type"]));?></small></td>
				 <td><small><?php echo stripslashes($row["createddate"]);?></small></td>
                 <td><small><?php echo stripslashes($row["appointment_date"]." ".$row["appointment_time"]);?></small></td>
                 <td>
                   <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>" ><img src="images/drop.png" title="Close" border="0" /></a> &nbsp;&nbsp;  <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>"><small><span>Update Status</span></small></a>
                 </td>
                 </tr>
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
?> 

 	
        <!-- Modal -->

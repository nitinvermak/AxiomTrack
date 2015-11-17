<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch_id = mysql_real_escape_string($_POST['branch']);
error_reporting(0);
/*echo $branch_id;*/
if ($branch_id == 0)
{
	$linkSQL = "SELECT * FROM tblticket as A, 
				tbl_ticket_assign_branch as B
				WHERE A.ticket_id = B.ticket_id 
				AND B.branch_confirmation_status = '1' 
				and B.technician_assign_status = '0'";
	$authorized_branches = BranchLogin($_SESSION['user_id']);
		if ( $authorized_branches != '0'){
			$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
		}
/*	echo $linkSQL;*/
}
else
	$linkSQL = "SELECT * FROM tblticket as A, 
				tbl_ticket_assign_branch as B
				WHERE A.ticket_id = B.ticket_id 
				AND B.branch_confirmation_status = '1' 
				and B.technician_assign_status = '0' 
				and B.branch_id = '{$branch_id}'";
	$authorized_branches = BranchLogin($_SESSION['user_id']);
		if ( $authorized_branches != '0'){
			$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
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
                  <th><small>Created</small></th> 
                  <th><small>Appointment Date Time</small></th>              
                  <th><small>Actions
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>             </th>   
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
                 <td><small>
                        <a href="#" onclick="if(confirm('Do you really want to delete this record?')){ window.location.href='transusers_del.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' }" ><img src="images/drop.png" title="Delete" border="0" /></a>     <a href="plan_category.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> &nbsp;&nbsp;<input type='checkbox' name='linkID[]' value='<?php echo $row["ticket_id"]; ?>'></small> </td>
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
                          <td colspan="3"><input type="submit" name="submit" class="btn btn-primary btn-sm" onClick="return val();" value="Submit" id="submit" /> </td>
                          <td></td>
                          </tr>
                          </table>
                   	    </form>   
                
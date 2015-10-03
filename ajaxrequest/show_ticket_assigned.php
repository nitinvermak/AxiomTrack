<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$date=$_REQUEST['date']; 
error_reporting(0);
if ($date == 0)
	{
	$linkSQL = "select * from tblticket where branch_assign_status = '1' order by ticket_id";
	}
		else
			{
				$linkSQL = "select * from tblticket where branch_assign_status = '1' and appointment_date='$date' order by ticket_id";
			}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-hover table-bordered ">  ';
?>                 
    	          <tr>
                  <th>S. No.</th>     
                  <th>Ticket Id</th> 
                  <th>Organization Name</th>
                  <th>Product</th>
                  <th>Request Type</th> 
                  <th>Created</th>
                  <th>Appointment Date Time</th>           
                  <th>Actions
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>                              
                  </th>   
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
                 <td><a href="#" onclick="if(confirm('Do you really want to delete this record?')){ window.location.href='transusers_del.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' }" ><img src="images/drop.png" title="Delete" border="0" /></a>     <a href="plan_category.php?id=<?php echo $row["id"] ?>&token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a> &nbsp;&nbsp;<input type='checkbox' name='linkID[]' value='<?php echo $row["ticket_id"]; ?>'> </td>
                 </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br><br></td><tr/></table>";
?> 
          				<form method="post">
                          <table>
                          <tr>
                          <td></td>
                          <td colspan="3"><input type="submit" name="remove" value="Remove" class="btn btn-primary" onClick="return val();" id="submit" /> </td>
                          <td></td>
                          </tr>
                          </table><br />
                   	    </form>   
             
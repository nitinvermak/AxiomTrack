<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$date=$_REQUEST['date']; 
error_reporting(0);
if ($date == 0)
	{
	$linkSQL = "select * from tblticket where branch_assign_status = '0' order by ticket_id";
	}
		else
			{
				$linkSQL = "select * from tblticket 
							where branch_assign_status = '0' 
							and appointment_date like'$date%' 
							order by ticket_id";
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
                  <th><small>Created Date</small></th> 
				  <th><small>Created By</small></th> 
                  <th><small>Appointment Date Time</small></th>             
                  <th><small>Actions<br>
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>  </small>           </th>
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
				 <td><small><?php echo gettelecallername(stripslashes($row["CreateBy"]));?></small></td>
                 <td><small><?php echo stripslashes($row["appointment_date"]." ".$row["appointment_time"]);?></small></td>
                 <td><small><input type='checkbox' name='linkID[]' value='<?php echo $row["ticket_id"]; ?>'> </small></td>
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
               <td colspan="3"><input type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
               <td></td>
               </tr>
               </table>
               </form>   
                
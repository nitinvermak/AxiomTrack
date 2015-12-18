<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id = mysql_real_escape_string($_POST['branch']); 
$executive = mysql_real_escape_string($_POST['executive']);
/*echo $executive.'<br>';
echo $branch_id;*/
error_reporting(0);
$linkSQL = "SELECT * FROM tblticket as A 
			INNER JOIN tbl_ticket_assign_branch as B 
			ON A.ticket_id = B.ticket_id
			INNER JOIN tbl_ticket_assign_technician as C 
			ON B.ticket_id = C.ticket_id 
			WHERE B.branch_confirmation_status = '1' 
			AND B.technician_assign_status = '1' 
			AND  A.ticket_status = '0'";
//echo $linkSQL;
if ( ($executive != 0) or ($branch != 0) )
{
	$linkSQL  = $linkSQL." AND ";	
}
$counter = 0;
if ( $executive != 0) {
	if ($counter > 0 )
		$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." C.technician_id = '$executive'" ;
		$counter+=1;
		//echo $linkSQL;
}
if ( $branch_id != 0) {
	if ($counter > 0 )
		$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.branch_id = '$branch_id'" ;
		$counter+=1;
		//echo $linkSQL;
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
				  <th><small>Assign By</small></th>
                  <th><small>Appointment Date Time</small></th>              
                  <th><small>Actions                  
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small>            </div>                  
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
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small><?php echo stripslashes($row["ticket_id"]);?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["organization_id"]));?></small></td>
				 <td><small><?php echo getproducts(stripslashes($row["product"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["rqst_type"]));?></small></td>
				 <td><small><?php echo stripslashes($row["createddate"]);?></small></td>
				 <td><small><?php echo gettelecallername(stripslashes($row["assign_by"]));?></small></td>
                 <td><small><?php echo stripslashes($row["appointment_date"]." ".$row["appointment_time"]);?></small></td>
                 <td><input type='checkbox' name='linkID[]' value='<?php echo $row["ticket_id"]; ?>'> </td>
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
<td colspan="3"><input type="submit" name="remove" class="btn btn-primary btn-sm" onClick="return val();" value="Remove" id="submit" /> </td>
<td></td>
</tr>
</table>
</form>   
                
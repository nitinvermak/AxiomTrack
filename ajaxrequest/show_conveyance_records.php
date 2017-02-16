<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$dateFrom = mysql_real_escape_string($_POST['dateFrom']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$users = mysql_real_escape_string($_POST['users']);
error_reporting(0);
$linkSQL = "Select A.createddate as Date, B.ticket_id as TicketId, A.product as Pid, A.rqst_type as VisitType, A.organization_id as 			Company, B.technician_id as Tid from tblticket as A 
			inner join tbl_ticket_assign_technician as B 
			on A.ticket_id = B.ticket_id
			WHERE B.conveyenceStatus = 'N'" ;
			/*echo $linkSQL; */

if ( ( $dateFrom != NULL and $dateto != NULL) or ($users != 0) ) {
	$linkSQL  = $linkSQL." And ";	
}
$counter = 0;
if ( $dateFrom != NULL and $dateto != NULL) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." DATE(A.createddate) BETWEEN '$dateFrom' AND '$dateto'" ;
		$counter+=1;
		/*echo $linkSQL;*/
}
if ( $users != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL."B.technician_id = '$users'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-bordered table-hover" id="my-table">  ';
?>                 
    	          <tr>
                  <th><small>S. No.</small></th>
                  <th><small>Date</small></th>         
                  <th><small>Ticket Id</small></th> 
                  <th><small>Product</small></th>
                  <th><small>Visit (Repair/New)</small></th>  
                  <th><small>Company Name</small></th>
                  <th><small>Executive</small></th>
                  <th><small>Description</small></th>
                  <th><small>KM Travelled</small></th> 
                  <th><small>Fare</small></th> 
                  <th><small>Amount</small></th> 
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
                 <td><small><?php echo stripslashes($row["Date"]);?></small></td>
				 <td><small><?php echo stripslashes($row["TicketId"]);?></small>
                 	<input type="hidden" name="ticketId" id="ticket<?php echo stripslashes($row["TicketId"]);?>" value="<?php echo stripslashes($row["TicketId"]);?>" />
                 </td>
				 <td><small><?php echo getproducts(stripslashes($row["Pid"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["VisitType"]));?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["Company"]));?></small></td>
                 <td><small><?php echo gettelecallername(stripslashes($row["Tid"]));?></small></td>
                 <td><textarea name="description" id="description<?php echo $row['TicketId']; ?>" style="width:100px;"></textarea></td>
                 <td><input type="text" name="kmTravel" id="kmTravel<?php echo $row['TicketId']; ?>"  class="kmTravel" style="width:50px;" /></td>
                 <td><input type="text" name="fare" id="fare<?php echo $row['TicketId']; ?>" 
                   onchange="calTotal(<?php echo $row['TicketId']; ?>)"  class="fare" style="width:50px;"></td>
                 <td>
                 <input type="text" name="amount" id="amount<?php echo $row['TicketId']; ?>" class="amount" style="width:50px;" readonly>                  
                 <input type="button" class="clickbtn" onclick="getData(<?php echo $row['TicketId']; ?>);" value="Click"></td>
                 </tr>
	<?php 
	      }

 		  echo ' <input type="hidden" id="totalFields" value="'.($kolor-1).'">';	

	}
    else
   		 echo "<h3 style='color:red;'>No records found!</h3>";
?> 

 	
        <!-- Modal -->

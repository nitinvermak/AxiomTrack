<?php 
include("../includes/config.inc.php"); 
$technician = mysql_real_escape_string($_POST['technician']);
/*echo $technician;*/
?>
<select name="ticketId" id="ticketId" class="form-control drop_down ticket" onChange="getOrg();">
                    	 <option value="">Select Ticket Id</option>
						 <?php
	      			     $Country=mysql_query("select A.ticket_id 
						 					   from tblticket as A
											   INNER JOIN tbl_ticket_assign_technician as B 
											   On A.ticket_id = B.ticket_id 
											   where A.organization_type = 'Existing Client'  
											   and A.ticket_status <> 1  and B.technician_id = '$technician'"); 
						
                         while($resultCountry=mysql_fetch_assoc($Country)){
                         ?>
                        <option value="<?php echo $resultCountry['ticket_id']; ?>" <?php if(isset($result['ticket_id']) && $resultCountry['ticket_id']==$result['ticket_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['ticket_id'])); ?></option>
                        <?php } ?>						 
</select>
<?php 
include("../includes/config.inc.php"); 
$ticket = mysql_real_escape_string($_POST['ticket']);
/*echo $ticket;*/
?>
<div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization <span class="red">*</span></label>
                <div class="col-sm-10">
<select name="organization" id="organization" class="form-control drop_down">
	<!--<option value="">Select Organization</option>-->
    <?php $Country=mysql_query("SELECT * FROM tbl_ticket_assign_technician as A 
								INNER JOIN tbluser as B 
								ON A.technician_id = B.id WHERE A.ticket_id = '$ticket'");
		  while($resultCountry=mysql_fetch_assoc($Country)){
	?>
   				<option value="<?php echo $resulttechnician['id']; ?>" 
				 <?php if(isset($result['techinician_name']) && $resulttechnician['id']==$result['techinician_name']){ ?>selected
				 <?php } ?>><?php echo stripslashes(ucfirst($resulttechnician['First_Name']." ".$resulttechnician['Last_Name'])); ?>
                </option>
                 <?php } ?>
</select>
			</div>
</div>
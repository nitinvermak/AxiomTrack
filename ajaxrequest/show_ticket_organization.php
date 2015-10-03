<?php 
include("../includes/config.inc.php"); 
$ticket = mysql_real_escape_string($_POST['ticket']);
/*echo $ticket;*/
?>
<div class="form-group">
                <label for="provider" class="col-sm-2 control-label">Organization*</label>
                <div class="col-sm-10">
<select name="organization" id="organization" class="form-control drop_down">
	<!--<option value="">Select Organization</option>-->
    <?php $Country=mysql_query("select organization_id from tblticket where ticket_id ='$ticket' order by ticket_id ASC");
		  while($resultCountry=mysql_fetch_assoc($Country)){
	?>
    <option value="<?php echo $resultCountry['organization_id']; ?>" <?php if(isset($result['organization_id']) && $resultCountry['organization_id']==$result['organization_id']){ ?>selected<?php } ?>><?php echo getOraganization(stripslashes(ucfirst($resultCountry['organization_id']))); ?></option>             <?php } ?>
</select>
			</div>
</div>
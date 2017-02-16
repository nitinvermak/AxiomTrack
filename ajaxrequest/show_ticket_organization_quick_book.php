<?php 
include("../includes/config.inc.php"); 
$ticket = mysql_real_escape_string($_POST['ticket']);
/*echo $ticket;*/
?>            
<select name="organizationName" id="organizationName" class="form-control">
	<!--<option value="">Select Organization</option>-->
    <?php $Country=mysql_query("select B.cust_id as customerId, A.organization_id as Orgranization 
								from tblticket as A 
								inner join tbl_customer_master as B 
								On A.organization_id = B.callingdata_id 
								where A.ticket_id = '$ticket' order by ticket_id ASC");
		  while($resultCountry=mysql_fetch_assoc($Country)){
	?>
    <option value="<?php echo $resultCountry['customerId']; ?>" <?php if(isset($result['customerId']) && $resultCountry['customerId']==$result['customerId']){ ?>selected<?php } ?>><?php echo getOraganization(stripslashes(ucfirst($resultCountry['Orgranization']))); ?></option>             <?php } ?>
</select>

<?php 
include("../includes/config.inc.php"); 
$ticket = mysql_real_escape_string($_POST['ticket']);
/*echo $ticket;*/
?>
<div class="form-group">
	<label for="provider">Organization <span class="red">*</span></label>

	<select name="organization" id="organization" class="form-control select2" style="width: 100%">
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

</div>
<div class="form-group">
	<label for="Product">Vehicle No <span class="red">*</span></label>
    <select name="vehcileNo" id="vehicleNo" class="form-control select2" onChange="getValue();">
          	<option value="">Select Vehicle No.</option>
            <?php $Country=mysql_query("SELECT B.id as vehicleId, B.vehicle_no as vehicleNo 
			 							 FROM tblticket as A 
										 INNER JOIN tbl_gps_vehicle_master as B 
										 ON A.vehicleId = B.id 
										 WHERE A.ticket_id = '$ticket' 
										 order by A.ticket_id ASC");
		  		  while($resultCountry=mysql_fetch_assoc($Country)){
		    ?>
    		<option value="<?php echo $resultCountry['vehicleId']; ?>"><?php echo stripslashes(ucfirst($resultCountry['vehicleNo'])); ?>
    		</option><?php } ?>
    </select>
</div>
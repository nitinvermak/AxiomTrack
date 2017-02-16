<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
?>
<div>
	<h4 class="red">&nbsp;</h4>
</div>
<div class="form-inline">
	<div class="form-group">
		<label for="exampleInputName2">Device Model</label>
		<select name="modelname" id="modelname"  class="form-control drop_down">
		    <option label="" value="0" selected="selected">All</option>
		    <?php $Model = mysql_query("select * from tbldevicemodel order by model_name");
			      while($resultModel = mysql_fetch_assoc($Model)){
			?>
			<option value="<?php echo $resultModel['device_id']; ?>" 
			<?php if(isset($State_name) && $resultModel['device_id']==$State){ ?>selected<?php } ?>>
			<?php echo stripslashes(ucfirst($resultModel['model_name'])); ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="form-group">
	    <label for="exampleInputName2">Branch</label>
	    <select name="branch" id="branch" class="form-control drop_down">
	        <option value="0">All</option>
	        <?php 
		  		$branch_sql= "select * from tblbranch ";
				$Country = mysql_query($branch_sql);								  
				while($resultCountry=mysql_fetch_assoc($Country)){
		    ?>
			<option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
			<?php } ?>
		</select>
	</div>
	<input type="button" name="assign" onclick="getDeviceStock();" value="Assign Devices" id="assignDevices" class="btn btn-primary btn-sm" />
	<input type="button" onclick="getAssignDevice();" name="view" id="viewAssignedDevices" value="View Assigned Devices" class="btn btn-primary btn-sm"/>
</div>		    			
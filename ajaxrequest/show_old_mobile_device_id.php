<?php 
include("../includes/config.inc.php"); 
$vehicleNo = mysql_real_escape_string($_POST['vehicleNo']);
/*echo $vehicleNo;*/
?>
<div class="form-group">
    <label for="provider">Old Mobile  <span class="red">*</span></label>
    <select name="oldmobileNo" id="oldmobileNo" class="form-control drop_down">
	   <!--<option value="">Select Organization</option>-->
        <?php $Country=mysql_query("SELECT id, mobile_no FROM `tbl_gps_vehicle_master` where id = '$vehicleNo' ");
		      while($resultCountry=mysql_fetch_assoc($Country)){
	    ?>
        <option value="<?php echo getMobile($resultCountry['mobile_no']); ?>"><?php echo getMobile(stripslashes(ucfirst($resultCountry['mobile_no']))); ?></option> <?php } ?>
    </select>
</div>

<div class="form-group">
	<label for="Product">Old Device Id <span class="red">*</span></label>
    <select name="olddeviceId" id="olddeviceId" class="form-control drop_down" onChange="getOldDeviceModal();">
        <!--  	<option value="">Select Vehicle No.</option>-->
        <?php $Country=mysql_query("SELECT id, device_id FROM `tbl_gps_vehicle_master` where id = '$vehicleNo'");
		      while($resultCountry=mysql_fetch_assoc($Country)){
	    ?>
        <option value="">Select Device Id</option>
        <option value="<?php echo $resultCountry['device_id']; ?>"><?php echo stripslashes(ucfirst($resultCountry['device_id'])); ?>
        </option><?php } ?>
    </select>
</div>
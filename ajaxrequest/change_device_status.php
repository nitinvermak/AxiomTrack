<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$vehicleId = mysql_real_escape_string($_POST['vehicleId']);
?>
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Inactive Reason</h4>
</div>
<div>
<form method="post" action="">
    <div class="modal-body">
      <div class="form-group">
        <label for="InactiveReason">Inactive Reason</label>
        <select name="reason" id="reason" class="form-control drop_down-sm">
        	<option value="">Select Reason</option>
            <option value="Battery Disconnected">Battery Disconnected</option>
            <option value="Signal Issue">Signal Issue</option>
            <option value="No Data">No Data</option>
        </select>
        <input type="hidden" value="<?php echo $vehicleId; ?>" name="vehicleId" id="vehicleId"/>
      </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
        <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Save" />
    </div>
</form>
</div>
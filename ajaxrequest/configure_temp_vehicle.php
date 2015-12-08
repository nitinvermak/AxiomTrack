<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$id = mysql_real_escape_string($_POST['id']);
?>

<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
<h4 class="modal-title" id="myModalLabel">Configure</h4>
</div>
<div class="modal-body">
<div class="col-md-12">
<form>
  <div class="form-group">
    <label for="Battery">Battery</label>
	<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
    <select name="battery" id="battery" class="form-control drop_down">
		<option value=''>Select</option>
		<option value = 'Y'>Yes</option>
		<option value = 'N'>No</option>
	</select>
  </div>
  <div class="form-group">
    <label for="Ignition">Ignition</label>
    <select name="ignition" id="ignition" class="form-control drop_down">
		<option value=''>Select</option>
		<option value = 'Y'>Yes</option>
		<option value = 'N'>No</option>
	</select>
  </div>
  <div class="form-group">
    <label for="Location">Location</label>
	<select name="location" id="location" class="form-control drop_down">
		<option value=''>Select</option>
		<option value = 'Y'>Yes</option>
		<option value = 'N'>No</option>
	</select>
  </div>
  <input type="submit" name="submit" class="btn btn-primary btn-sm" value="Submit">
</form>
</div>
<div class="clearfix"></div>
</div>
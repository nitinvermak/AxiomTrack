<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$simId = mysql_real_escape_string($_POST['simId']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title" id="myModalLabel">Change Sim Status</h4>
</div>
<div class="modal-body">
  <div id="dvAlert"></div>
  <form name='myform' action="" method="post" onSubmit="return validate(this)">
    <!-- from-group -->
    <div class="form-group">
      <label>Sim Id<i>*</i></label>
      <input type="text" name="simId" id="simId" value="<?= $simId; ?>" class="form-control text_box" readonly>
    </div>
    <!-- /.form group -->
    <div class="form-group">
      <label>Status<i>*</i></label>
      <select name="status" id="status" class="form-control drop_down">
        <option value="">Select Status</option>
        <option value="0">Instock</option>
        <option value="2">Replacement</option>
        <option value="3">Damage</option>
        <option value="4">Reissue</option>
      </select>
    </div> <!-- /.form group -->
  </form>
</div>
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary btn-sm" onclick="updateSimStatus()">Submit</button>
</div>
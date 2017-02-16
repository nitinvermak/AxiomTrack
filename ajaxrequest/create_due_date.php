<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$custId = mysql_real_escape_string($_POST['custId']);
error_reporting(0);
?>		
<form method="">
<p>Due Date <input type="text" name="dueDate" id="dueDate" class="form-control text_box date" /> <input type="button" name="saveDueDate"id="saveDueDate"  class="btn btn-primary btn-sm" onclick="getDueDataValue();" value="Submt" /></p>
</form>
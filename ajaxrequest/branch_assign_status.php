<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$installedStatus = mysql_real_escape_string($_POST['installedStatus']);
if($installedStatus == 0)
	{
		echo '<select name="assignStatus" id="assignStatus" class="form-control drop_down-sm">
               <option value="0">Instock</option>
              </select>';
	}
else
	{
		echo '<select name="assignStatus" id="assignStatus" class="form-control drop_down-sm">	
		       <option value="1">Assign</option>
              </select>';
	}
?>
			
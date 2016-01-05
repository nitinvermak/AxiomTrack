<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branchId = mysql_real_escape_string($_POST['branch']);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="gridSystemModalLabel">New Installation</h4>
</div>
<div class="modal-body">
<?php
$sNo = 1;
$sql = "SELECT A.imei_no as imeiNo, A.company_id as companyId, A.device_name as deviceName, 
		C.assigned_date as assignDate, C.assigned_by
		FROM tbl_device_master as A 
		INNER JOIN tbl_device_assign_branch as B 
		ON A.id = B.device_id
		INNER JOIN tbl_device_assign_technician as C 
		ON B.device_id = C.device_id 
		WHERE A.status = 0 And C.technician_id = ".$_SESSION['user_id'];
$result = mysql_query($sql);
echo "<div class = 'table-responsive'>
		<table class='table table_light'>
		<tr>
		<th><small><strong>S. No.</strong></small></th>
		<th><small><strong>IMEI No.</strong></small></th>
		<th><small><strong>Device</strong></small></th>
		<th><small><strong>Assign Date</strong></small></th>
		<th><small><strong>Assign By</strong></small></th>
		</tr>";
if(mysql_num_rows($result)>0)
	  	{
			while ($row = mysql_fetch_array($result))
				{
					$serialNo = $sNo++;
					$imeiNo = $row['imeiNo'];
					$deviceName = getdevicename($row['deviceName']);
					$assignDate = $row['assignDate'];
					$assignby = gettelecallername($row['assignby']);
					echo "<tr>
						  <td><small>$serialNo</small></td>
						  <td><small>$imeiNo</small></td>
						  <td><small>$deviceName</small></td>
						  <td><small>$assignDate</small></td>
						  <td><small>$assignby</small></td>
						  </tr>";
				}
				echo "</table>
					  </div>";
		}
else
	{
		echo "<tr>
			  <td colspan='5'><center><h3 style='color:red'>No Records found !</h3></center></td>
			  </tr>
			  </table>
			  </div>";
	}
?>
</div>
<div class="modal-footer">
	<button type="button" class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
</div>
		 
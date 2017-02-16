<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branchId = mysql_real_escape_string($_POST['branch']);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </button>
    <h4 class="modal-title" id="gridSystemModalLabel">Sim</h4>
</div>
<div class="modal-body">
<?php
$sNo = 1;
$sql = "SELECT A.sim_no as simNo, A.mobile_no as mobileNo, C.assigned_date as assignDate, 
		C.assigned_by as assignby
		FROM tblsim as A 
		INNER JOIN tbl_sim_branch_assign as B 
		ON A.id = B.sim_id
		INNER JOIN tbl_sim_technician_assign as C 
		ON B.sim_id = C.sim_id 
		WHERE A.status_id = 0 And C.technician_id = ".$_SESSION['user_id'];
$result = mysql_query($sql);
echo "<div class = 'table-responsive'>
		<table class='table'>
		<tr>
		<th><small><strong>S. No.</strong></small></th>
		<th><small><strong>Sim No.</strong></small></th>
		<th><small><strong>Mobile No.</strong></small></th>
		<th><small><strong>Assign Date</strong></small></th>
		<th><small><strong>Assign By</strong></small></th>
		</tr>";
if(mysql_num_rows($result)>0)
	  	{
			while ($row = mysql_fetch_array($result))
				{
					$serialNo = $sNo++;
					$simNo = $row['simNo'];
					$mobileNo = $row['mobileNo'];
					$assignDate = $row['assignDate'];
					$assignby = gettelecallername($row['assignby']);
					echo "<tr>
						  <td><small>$serialNo</small></td>
						  <td><small>$simNo</small></td>
						  <td><small>$mobileNo</small></td>
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
		 
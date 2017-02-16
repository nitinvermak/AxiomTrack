<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$repairDateFrom = mysql_real_escape_string($_POST['repairDateFrom']);
$repairDateTo = mysql_real_escape_string($_POST['repairDateTo']);
$branch = mysql_real_escape_string($_POST['branch']);
$executive = mysql_real_escape_string($_POST['executive']);
$configStatus = mysql_real_escape_string($_POST['configStatus']);
/*echo $configStatus.'saf';*/
error_reporting(0);
$linkSQL = "SELECT A.techinicianId as technician, A.id as id, A.ticketId as ticketId, A.oldMobileId as oldMobileId, 
			A.oldDeviceId as oldDeviceId, A.repairType as repairType, A.repairDate as repairDate, 
			A.newDeviceId as newDeviceId,
			A.newMobileId as newMobileId, D.vehicle_no, C.Company_Name as CompanyName, E.device_name as ModelId, 
			A.repairDate as repairDate, A.repairCategory as repairCategory, A.reason as reason, 
			A.create_by as create_by
			FROM tempvehicledatarepair as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customerId = B.cust_id
			INNER JOIN tblcallingdata as C 
			ON B.callingdata_id = C.id
			INNER JOIN tbl_gps_vehicle_master as D 
			ON A.vehicleId = D.id 
			INNER JOIN tbl_device_master as E 
			ON A.oldDeviceId = E.id";
/*echo $linkSQL;*/
if ( ($executive != 0) or ( $repairDateFrom != NULL) or ( $repairDateTo != NULL) or ($branch != 0) or ( $configStatus != NULL ) )
{
	$linkSQL  = $linkSQL." Where ";	
	/*echo $linkSQL;	*/
}
$counter = 0;
if ( $executive != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." A.techinicianId = '$executive' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $repairDateFrom != NULL) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." DATE(A.repairDate) BETWEEN '$repairDateFrom' AND '$repairDateTo' ";
	$counter+=1;
	/*echo $linkSQL;*/
}	
if ( $branch != 0 ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." D.branch_id = '$branch' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $configStatus != NULL ) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." A.configStatus = '$configStatus' ";
	$counter+=1;
	/*echo $linkSQL;*/
}	 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<table border="0" class="table table-hover table-bordered" width="100%" cellspacing="0" id="example">  ';
?>	
	<thead>
		<tr>
        	<th><small>S. No.</small></th>     
            <th><small>Ticket Id</small></th>
            <th><small>Company</small></th> 
            <th><small>Vehicle No</small></th> 
            <th><small>Repair Type</small></th>
            <th><small>Old Mobile No.</small></th> 
            <th><small>Old Device Id</small></th>   
            <th><small>Model</small></th> 
			<th><small>New Mobile No.</small></th>
			<th><small>New Device Id</small></th>
            <th><small>Tehnician</small></th>
            <th><small>Repair Category</small></th>
            <th><small>Reason</small></th>
            <th><small>Repair Date</small></th> 
            <th><small>Punch By</small></th>
            <th><small>Action <br />             
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">
                Check All</a>
      			&nbsp;&nbsp;
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">
                Uncheck All</a></small>
            </th>                 
        </tr>    
	</thead>
	<tbody>
	<?php
	$kolor=1;
	if(isset($_GET['page']) and is_null($_GET['page'])){ 
		$kolor = 1;
	}
	elseif(isset($_GET['page']) and $_GET['page']==1){ 
		$kolor = 1;
	}
	elseif(isset($_GET['page']) and $_GET['page']>1){
		$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
	}
	if(mysql_num_rows($stockArr)>0){
		while ($row = mysql_fetch_array($stockArr)){
	?>
        <tr>
	 		<td><small><?php print $kolor++;?>.</small></td>
            <td><small><?php echo stripslashes($row["ticketId"]);?></small></td>
	 		<td><small><?php echo stripcslashes($row['CompanyName']);?></small></td>
            <td><small><?php echo stripcslashes($row['vehicle_no']);?></small></td>
            <td><small><?php echo getRepairType(stripcslashes($row['repairType'])); ?></small>
                	<input type="hidden" name="repairType<?php echo $row["id"]; ?>" id="repairType<?php echo $row["id"]; ?>" value="<?php echo stripcslashes($row['repairType']); ?>" />
            </td>
            <td><small><?php echo stripcslashes($row['oldMobileId']);?></small>
                	<input type="hidden" name="oldMobileNo<?php echo $row["id"]; ?>" id="oldMobileNo<?php echo $row["id"]; ?>" value="<?php echo stripcslashes($row['oldMobileId']);?>" />
            </td>
            <td><small><?php echo stripcslashes($row['oldDeviceId']); ?></small></td>
            <td><small><?php echo getdevicename(stripcslashes($row['ModelId'])); ?></small>
                	<input type="hidden" name="model<?php echo $row["id"]; ?>" id="model<?php echo $row["id"]; ?>" value="<?php echo stripcslashes($row['ModelId']);?>" />
            </td>
			<td><small><?php echo CheckValue(stripcslashes($row['newMobileId']));?></small>
               	<input type="hidden" name="newMobile<?php echo $row["id"]; ?>" id="newMobile<?php echo $row["id"]; ?>" value="<?php echo CheckValue(stripcslashes($row['newMobileId']));?>" />
            </td>
			<td><small><?php echo CheckValue(stripcslashes($row['newDeviceId'])); ?></small></td>
            <td><small><?php echo gettelecallername(stripcslashes($row['technician'])); ?></small></td>
            <td><small><?php echo $row['repairCategory']; ?></small></td>
            <td><small><?php echo $row['reason']; ?></small></td>
            <td><small><?php echo stripcslashes($row['repairDate']); ?></small></td>
            <td><small><?php echo gettelecallername($row['create_by']); ?></small></td>
            <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'>
                	<button type="button" name="sendCmd" id="sendCmd" onclick="getValue1(<?php echo $row["id"]; ?>)" class="btn btn-primary btn-sm">Re-Send</button>
            </td>
        </tr> 
        <?php 
        }
      }  
      echo "</tbody>"; 
      echo "</table>";
	}
?>
<table>
	<tr>
        <td colspan="3"><input type="submit" name="submitRepair" value="Configure" class="btn btn-primary btn-sm" id="submitRepair" /> </td>
        <td></td>
    </tr>
</table>
 
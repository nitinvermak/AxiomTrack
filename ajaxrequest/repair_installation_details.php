<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$depositDate = mysql_real_escape_string($_POST['depositDateFrom']);
$depositDateTo = mysql_real_escape_string($_POST['depositDateTo']);
$branch = mysql_real_escape_string($_POST['branch']);
$executive = mysql_real_escape_string($_POST['executive']);
error_reporting(0);
$linkSQL = "SELECT A.techinicianId as technician, A.id as id, A.ticketId as ticketId, A.oldMobileId as oldMobileId, 
			A.oldDeviceId as oldDeviceId, A.repairType as repairType, A.repairDate as repairDate, A.newDeviceId as newDeviceId,
			A.newMobileId as newMobileId, D.vehicle_no, C.Company_Name as CompanyName, E.device_name as ModelId, 
			A.repairDate as repairDate
			FROM tempvehicledatarepair as A 
			INNER JOIN tbl_customer_master as B 
			ON A.customerId = B.cust_id
			INNER JOIN tblcallingdata as C 
			ON B.callingdata_id = C.id
			INNER JOIN tbl_gps_vehicle_master as D 
			ON A.vehicleId = D.id 
			INNER JOIN tbl_device_master as E 
			ON A.oldDeviceId = E.id
			where A.configStatus = 'N'";
/*echo $linkSQL;*/
if ( ($executive != 0) or ( $depositDate != 0) or ( $depositDateTo != 0) or ($branch != 0) )
{
	$linkSQL  = $linkSQL." And";		
}
$counter = 0;
if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." A.techinicianId = '$executive'";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $depositDate !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." DATE(A.repairDate) BETWEEN '$depositDate' AND '$depositDateTo' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." D.branch_id ='$branch'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}					 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<div class="col-md-12">
			  	<div class="download pull-right">
					<a href="#" id ="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
				</div>
			  </div> 
				<table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th><small>S. No.</small></th>     
              	<th><small>Ticket Id</small></th>
              	<th><small>Company</small></th> 
                <th><small>Vehicle No</small></th> 
                <th><small>Old Mobile No.</small></th> 
              	<th><small>Old Device Id</small></th>   
                <th><small>Model</small></th> 
				<th><small>New Mobile No.</small></th>
				<th><small>Old Device Id</small></th>
                <th><small>Tehnician</small></th>
				<th><small>Repair Type</small></th>
                <th><small>Repair Date</small></th> 
                <th><small>Action <br />             
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">
                Check All</a>
      			&nbsp;&nbsp;
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">
                Uncheck All</a></small>
                </th>                 
              	</tr>    
	
				  	<?php
					$kolor=1;
					if(isset($_GET['page']) and is_null($_GET['page']))
					{ 
					$kolor = 1;
					}
					elseif(isset($_GET['page']) and $_GET['page']==1)
					{ 
					$kolor = 1;
					}
					elseif(isset($_GET['page']) and $_GET['page']>1)
					{
					$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
					}
					
						if(mysql_num_rows($stockArr)>0)
						{
					  while ($row = mysql_fetch_array($stockArr))
					  {
					 
					  if($kolor%2==0)
						$class="bgcolor='#ffffff'";
						else
						$class="bgcolor='#fff'";
						
					 ?>
                <tr <?php print $class?>>
	 			<td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo stripslashes($row["ticketId"]);?></small></td>
	 			<td><small><?php echo stripcslashes($row['CompanyName']);?></small></td>
                <td><small><?php echo stripcslashes($row['vehicle_no']);?></small></td>
                <td><small><?php echo getMobile(stripcslashes($row['oldMobileId']));?></small></td>
                <td><small><?php echo stripcslashes($row['oldDeviceId']); ?></small></td>
                <td><small><?php echo getdevicename(stripcslashes($row['ModelId'])); ?></small></td>
				<td><small><?php echo getMobile(stripcslashes($row['newMobileId']));?></small></td>
				<td><small><?php echo stripcslashes($row['newDeviceId']); ?></small></td>
                <td><small><?php echo gettelecallername(stripcslashes($row['technician'])); ?></small></td>
				<td><small><?php echo getRepairType(stripcslashes($row['repairType'])); ?></small></td>
                <td><small><?php echo stripcslashes($row['repairDate']); ?></small></td>
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                </tr> 
                <?php 
                }
                echo $pagerstring;
                }    
		}
		else
			{
				echo "<h3><font color=red>No records found !</font></h3><br><br>";
			}
?>
 <form method="post">
                <table>
                <tr>
                <td colspan="3"><input type="submit" name="submitRepair" value="Configure" class="btn btn-primary btn-sm" id="submitRepair" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>  
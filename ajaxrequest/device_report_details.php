<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch = mysql_real_escape_string($_POST['branch']);
$installedStatus = mysql_real_escape_string($_POST['installedStatus']);
$executive = mysql_real_escape_string($_POST['executive']);
/*$assignStatus = mysql_real_escape_string($_POST['assignStatus']);*/
error_reporting(0);
	$linkSQL = "SELECT  A.id as DeviceId, A.dealer_id as dealerId, A.device_name as modal, 
				A.date_of_purchase as purchaseDate, A.imei_no as IMEI, A.company_id as CompId, 
				B.branch_id as Branch_name, A.status as status, A.assignstatus as branch_asgn_status, 
				B.branch_id as Branch_name, D.CompanyName as branch, 
				B.technician_assign_status as technician_asgn_status, 
				C.technician_id as TechnicianId, E.First_Name as fname, E.Last_Name as lname, 
				G.callingdata_id as callingDataId, F.vehicle_no as vehicleNo,
				B.assigned_date as branchAssignDate, C.assigned_date as technicianAssignDate,
				A.modifyDate as modifyDate
				FROM tbl_device_master as A 
				LEFT OUTER JOIN tbl_device_assign_branch as B
				ON A.id = B.device_id
				LEFT OUTER JOIN tbl_device_assign_technician as C
				ON B.device_id = C.device_id
				LEFT OUTER JOIN tblbranch as D 
				ON B.branch_id = D.id
				LEFT OUTER JOIN tbluser as E 
				ON C.technician_id = E.id 
				LEFT OUTER Join tbl_gps_vehicle_master as F 
				ON A.id = F.device_id
				LEFT OUTER JOIN tbl_customer_master as G 
				ON F.customer_Id = G.cust_id";

	/*$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' Where B.branch_id in  '.$authorized_branches;		
	}*/
		// echo $linkSQL;
	if( ($branch != 0) or ( $installedStatus != NULL) or ($executive != 0) or ($assignStatus != NULL) )
	{
		$linkSQL  = $linkSQL." Where ";
	}
	$counter = 0;
	if($branch != 0)
		{
			if ($counter > 0 )
			$linkSQL = $linkSQL.' AND ';
			$linkSQL  = $linkSQL." B.branch_id = '$branch'" ;
			$counter+=1;
			// echo $linkSQL;
		}
	if($installedStatus != NULL)
		{
			if ($counter > 0 )
			$linkSQL = $linkSQL.' AND ';
			$linkSQL  = $linkSQL." A.status = '$installedStatus'" ;
			$counter+=1;
			// echo $linkSQL;
		}
	if($executive != 0)
		{
			if ($counter > 0 )
			$linkSQL = $linkSQL.' AND ';
			$linkSQL  = $linkSQL." C.technician_id = '$executive'" ;
			$counter+=1;
			/*echo $linkSQL;*/
		}
	/*if($assignStatus != NULL)
		{
			if ($counter > 0 )
			$linkSQL = $linkSQL.' AND ';
			$linkSQL  = $linkSQL." A.assignstatus = '$assignStatus'" ;
			$counter+=1;
			echo $linkSQL;
		}*/
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">  ';
?>		
				<thead>
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Device Id.</small></th> 
                <th><small>Model</small></th>  
              	<th><small>IMEI No.</small></th> 
              	<th><small>Dealer</small></th>  
                <th><small>Date of Purchase</small></th>  
                <th><small>Modify Date</small></th>
              	<th><small>Final Status</small></th>
              	<th><small>Branch Status</small></th>   
              	<th><small>Branch</small></th>
                <th><small>Branch Assign Date </small></th>     
              	<th><small>Tech. Status</small></th>
              	<th><small>Tech.</small></th> 
                <th><small>Tech. Assign Date</small></th>
              	<th><small>Tech. Status</small></th>
                <th><small>Installed Company</small></th> 
                <th><small>Vehicle No</small></th>                           
              	</tr> 
                </thead>  
                <tbody>
			  	<?php
				$kolor = 1;
				while ($row = mysql_fetch_array($stockArr))
					{  
				?>
                		
                        <tr <?php print $class?>>
                        <td><small><?php print $kolor++;?>.</small></td>
                        <td><small><?php echo stripslashes($row["DeviceId"]);?></small></td>
                        <td><small><?php echo getdevicename(stripcslashes($row["modal"]));?></small></td>
                        <td><small><?php echo stripslashes($row["IMEI"]);?></small></td>
                        <td><small><?php echo getDealer(stripslashes($row["dealerId"]));?></small></td>
                        <td><small><?php echo stripcslashes($row["purchaseDate"]);?></small></td>
                        <td><small><?php echo $row['modifyDate']; ?></small></td>
                        <td><small><?php echo getStatus($row["status"]); ?></small></td>
                        <td><small><?php echo getBranchAllocateStatus($row["branch_asgn_status"]); ?></small></td>
                        <td><small><?php echo getBranch($row['Branch_name']); ?></small></td>
                        <td><small><?php echo $row['branchAssignDate']; ?></small></td>
                        <td><small><?php echo getTechnicianAssignStatus($row["technician_asgn_status"]); ?></small></td>
                        <td><small><?php echo gettelecallername($row["TechnicianId"]); ?></small></td>
                        <td><small><?php echo $row['technicianAssignDate']; ?></small></td>
                        <td><small><?php echo getStatus($row["status"]); ?></small></td>
                        <td><small><?php echo getOraganization($row['callingDataId']); ?></small></td>
                        <td><small><?php echo $row['vehicleNo']; ?> </small></td>
                        </tr> 
						
                    <?php 
                    }
                   echo '</tbody>
				   		</table>';
    }
    else{
    	echo "<center><h2 class='red'>No Records Found ! </h2></center>";
    }				
?>
              
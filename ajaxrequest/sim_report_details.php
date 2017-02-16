<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branch = mysql_real_escape_string($_POST['branch']);
$installedStatus = mysql_real_escape_string($_POST['installedStatus']);
$executive = mysql_real_escape_string($_POST['executive']);
error_reporting(0);
	$linkSQL = "SELECT A.sim_no as simNo, A.date_of_purchase as purchaseDate, A.company_id as provider, 
				A.mobile_no as mobileNo, A.status_id as statusId, A.branch_assign_status as branchAssignStatus,
				B.branch_id  as branchId, D.CompanyName as branchname, 
				B.technician_assign_status as technicianStatus, 
				C.technician_id as technicianId, G.callingdata_id as callingDataId, 
				E.First_Name as fName, E.Last_Name as lName, F.vehicle_no as vehicleNo, 
				B.assigned_date as branchAssignDate, C.assigned_date as techAssignDate,
				A.modifyDate as modifyDate
				FROM tblsim as A 
				LEFT OUTER JOIN tbl_sim_branch_assign as B
				ON A.id = B.sim_id
				LEFT OUTER JOIN tbl_sim_technician_assign as C
				ON B.sim_id = C.sim_id
				LEFT OUTER JOIN tblbranch as D 
				ON B.branch_id = D.id
				LEFT OUTER JOIN tbluser as E 
				ON C.technician_id = E.id 
				LEFT OUTER JOIN tbl_gps_vehicle_master as F 
				ON A.id = F.mobile_no
				LEFT OUTER JOIN tbl_customer_master as G 
				ON F.customer_Id = G.cust_id";
	/*$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' Where and B.branch_id in  '.$authorized_branches;		
	}*/
	/*echo $linkSQL;*/
	if( ($branch != 0) or ( $installedStatus != NULL) or ($executive != 0) or ($assignStatus != NULL) ){
		$linkSQL  = $linkSQL." Where ";
	}
	$counter = 0;
	if($branch != 0){
		if ($counter > 0 )
		$linkSQL = $linkSQL.' AND ';
		$linkSQL  = $linkSQL." B.branch_id = '$branch'" ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
	if($installedStatus != NULL){
		if ($counter > 0 )
		$linkSQL = $linkSQL.' AND ';
		$linkSQL  = $linkSQL." A.status_id = '$installedStatus'" ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
	if($executive != 0){
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
			$linkSQL  = $linkSQL." A.branch_assign_status = '$assignStatus'" ;
			$counter+=1;
			echo $linkSQL;
		}*/
	/*echo $linkSQL;*/
	$stockArr = mysql_query($linkSQL);
	/*$total_num_rows = mysql_num_rows($stockArr);*/
if(mysql_num_rows($stockArr)>0)
	{
?>		
	<table border="0" id="example" class="table table-hover table-bordered">
		<thead>
			<tr>
	        	<th><small>S. No.</small></th>     
	            <th><small>Sim  No.</small></th>  
	            <th><small>Mobile No.</small></th>
	            <th><small>Company</small></th> 
	            <th><small>Date of Purchase</small></th>
	            <th><small>Final Status</small></th>
	            <th><small>Modify Date</small></th>
	            <th><small>Branch Status</small></th>   
	            <th><small>Branch</small></th>
	            <th><small>Branch Assign Date</small></th>   
	            <th><small>Tech. Status</small></th>
	            <th><small>Tech.</small></th>
	            <th><small>Tech. Assign Date</small></th>
	            <th><small>Installed Company</small></th> 
	            <th><small>Vehicle No.</small></th>                         
	        </tr>   
	    </thead>
	    <tbody> 
		<?php
		$kolor=1;
		while ($row = mysql_fetch_array($stockArr)){
		?>
		<tr>
		 	<td><small><?php print $kolor++;?>.</small></td>
		 	<td><small><?php echo stripslashes($row["simNo"]);?></small></td>
		 	<td><small><?php echo stripslashes($row["mobileNo"]);?></small></td>
		 	<td><small><?php echo getserviceprovider(stripslashes($row["provider"]));?></small></td>
	        <td><small><?php echo stripslashes($row["purchaseDate"]);?></small></td>
	        <td><small><?php echo getStatus(stripcslashes($row["statusId"])); ?></small></td>
	        <td><small><?php echo $row["modifyDate"]; ?></small></td>
	        <td><small><?php echo getBranchAllocateStatus(stripcslashes($row["branchAssignStatus"])); ?></small></td>
	        <td><small><?php echo stripslashes($row["branchname"]);?></small></td>
	        <td><small><?php echo stripslashes($row["branchAssignDate"]);?></small></td>
	        <td><small><?php echo getBranchAssignStatus(stripslashes($row["technicianStatus"]));?></small></td>
	        <td><small><?php echo gettelecallername(stripcslashes($row["technicianId"])); ?></small></td>
	        <td><small><?php echo stripslashes($row["techAssignDate"]);?></small></td>
	        <td><small><?php echo getOraganization($row['callingDataId']);?></small></td>
	        <td><small><?php echo getVehicleNo($row['vehicleNo']); ?></small></td>
	    </tr> 	
		<?php 
        }
        ?>
        </tbody>
        </table>
<?php 
    }
    else{
    	echo "<center><h3 style='color:red;'>No Records Found</h3></center>";
    }
?>
              
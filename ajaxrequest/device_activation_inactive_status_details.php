<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$companyInactive = mysql_real_escape_string($_POST['companyInactive']);
$branchInactive = mysql_real_escape_string($_POST['branchInactive']);
$serviceAreaMgr = mysql_real_escape_string($_POST['serviceAreaMgr']);
$executive = mysql_real_escape_string($_POST['executive']);
/*echo $company;*/
error_reporting(0);
	$linkSQL = "SELECT D.Company_Name as companyName, B.service_branchId as branch, 
				B.service_area_manager as areaMgr, B.service_executive as executive,
				A.vehicle_no as vehicleNO, A.model_name as modal, A.id as vehicleId, 
				D.Mobile as contact, E.inactiveReason as Reason, C.telecaller_id as telecallerId,
				A.mobile_no as mobile
				FROM tbl_gps_vehicle_master as A 
				INNER JOIN tbl_assign_customer_branch as B 
				ON A.customer_Id = B.cust_id 
				INNER JOIN tbl_customer_master as C 
				ON B.cust_id = C.cust_id 
				INNER JOIN tblcallingdata as D 
				ON C.callingdata_id = D.id 
				INNER JOIN tblinactivevehicledata as E 
				On A.id = E.vehicleId
				Where A.deviceActivationStatus = 'N'";
				/*echo $linkSQL;*/
if(( $companyInactive != 0 ) or ( $branchInactive != 0 ) or ( $serviceAreaMgr != 0 ) or ( $executive != 0))
{
	$linkSQL  = $linkSQL." And";
}
$counter = 0;
if ( $companyInactive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." D.id = '$companyInactive'";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branchInactive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.service_branchId = '$branchInactive'";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $serviceAreaMgr != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.service_area_manager = '$serviceAreaMgr'";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.service_executive = '$executive'";
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
                <th><small>Company Name</small></th> 
                <th><small>Contact No.</small></th>
                <th><small>Vehicle No.</small></th> 
                <th><small>Mobile No.</small></th> 
                <th><small>Reason</small></th>
                <th><small>Service Branch</small></th>
                <th><small>Area Mgr.</small></th>
                <th><small>Lead Generate by</small></th>
                <th><small>Service Executive</small></th>
                <th><small>Status</small></th>
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
	            <tr <?php print $class?>  id='<?php echo stripslashes($row["id"]);?>'>
                <td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo stripslashes($row["companyName"]);?></small></td>
                <td><small><?php echo stripslashes($row["contact"]);?></small></td>
                <td><small><?php echo stripslashes($row["vehicleNO"]);?></small></td>
                <td><small><?php echo getMobile(stripslashes($row["mobile"]));?></small></td>
                <td><small><?php echo stripslashes($row["Reason"]);?></small></td>
                <td><small><?php echo getBranch(stripslashes($row["branch"]));?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["areaMgr"]));?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["telecallerId"]));?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["executive"]));?></small></td>
                <td><input type="button"  name="Inactive" id="Inactive" class="btn btn-danger btn-sm" value="Inactive"
                	onClick="if(confirm('Do you really want to Activate this Vehicle?'))
                    { 
                    window.location.href='device_activation_status.php?vid=<?php echo $row["vehicleId"]; ?>&token=<?php echo $token ?>' } "
                 ></td>
      			</tr>
                <?php 
                		}
                echo $pagerstring;
                
                  }
                   
			}
			else
                   echo "<h3><font color=red>No records found !</h3></font>";
                ?>
              
<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$company = mysql_real_escape_string($_POST['company']);
/*echo $company;*/
error_reporting(0);
if($company == 0)
	$linkSQL = "SELECT D.Company_Name as companyName, B.service_branchId as branch, 
				B.service_area_manager as areaMgr, B.service_executive as executive, 
				A.vehicle_no as vehicleNO, A.model_name as modal, A.id as vehicleId
				FROM tbl_gps_vehicle_master as A 
				INNER JOIN tbl_assign_customer_branch as B 
				ON A.customer_Id = B.cust_id 
				INNER JOIN tbl_customer_master as C 
				ON B.cust_id = C.cust_id 
				INNER JOIN tblcallingdata as D 
				ON C.callingdata_id = D.id 
				Where A.deviceActivationStatus = 'Y'";
				/*echo $linkSQL;*/
else
	$linkSQL = "SELECT D.Company_Name as companyName, B.service_branchId as branch, 
				B.service_area_manager as areaMgr, B.service_executive as executive, 
				A.vehicle_no as vehicleNO, A.model_name as modal, A.id as vehicleId
				FROM tbl_gps_vehicle_master as A 
				INNER JOIN tbl_assign_customer_branch as B 
				ON A.customer_Id = B.cust_id 
				INNER JOIN tbl_customer_master as C 
				ON B.cust_id = C.cust_id 
				INNER JOIN tblcallingdata as D 
				ON C.callingdata_id = D.id 
				where A.deviceActivationStatus = 'Y' and D.id = '$company'" ;
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
                <th><small>S. No.</small></th>  
                <th><small>Company Name</small></th> 
                <th><small>Vehicle No.</small></th>
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
                <td><small><?php echo stripslashes($row["vehicleNO"]);?></small></td>
                <td><input type="button" data-toggle="modal" data-target=".bs-example-modal-sm" name="Active" id="Active" class="btn btn-success btn-sm" value="Active" onClick="getModal(<?php echo stripslashes($row['vehicleId']); ?>);"></td>
      			</tr>
                <?php 
                		}
                echo $pagerstring;
                
                  }
                   
			}
			else
                   echo "<h3><font color=red>No records found !</h3></font>";
                ?>
              
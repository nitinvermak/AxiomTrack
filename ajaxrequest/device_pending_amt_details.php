<?php 
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$callingcategory =$_REQUEST['callingcat']; 
error_reporting(0);
$linkSQL = "SELECT D.callingdata_id as callingDateId, A.vehicle_no vehicleNo, C.plan_rate as deviceAmt, 
			A.installation_date as activationDate, F.service_branchId as assignBranch, 
            D.telecaller_id referBy, F.service_area_manager as areaManager, 
            F.service_executive as serviceExecutive, A.imei_no as imeiNo, A.mobile_no as mobileNo,
            A.id as vehicleId
			FROM tbl_gps_vehicle_master as A 
			INNER JOIN tbl_gps_vehicle_payment_master as B 
			ON A.id = B.Vehicle_id
			INNER JOIN tblplan as C 
			ON B.device_amt = C.id
			INNER JOIN tbl_customer_master as D 
			ON B.cust_id = D.cust_id 
			INNER JOIN tbl_device_master as E 
			ON A.device_id = E.id
			LEFT OUTER JOIN tbl_assign_customer_branch as F 
			ON D.cust_id = F.cust_id
			WHERE A.activeStatus = 'Y' 
			AND B.device_type = '1'
			AND A.devicePaymentStatus <> 'F' 
            AND B.PlanactiveFlag ='Y'
            order by A.installation_date";
            // AND B.devicepaymentStatus <>'A'
// exit();
$stockArr=mysql_query($linkSQL);

?>
    <div class="modal-header">
    	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <h4 class="modal-title" id="gridSystemModalLabel">Device Pending Amt.</h4>
    </div>
    <div class="modal-body">
    	<div class="table-responsive">
        	<div class="col-md-12">
    			<div class="download pull-right">
    				<a href="#" id="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
    		    </div>
    	    </div>
        <div id="dvData">
        	<table class="table table-hover table-bordered">
            	<tr>
                <th><small>S. No.</small></th>
                <th><small>Vehicle Id</small></th>
                <th><small>Company Name</small></th>
                <th><small>Vehicle No.</small></th>
                <th><small>IMEI No.</small></th>
                <th><small>Mobile No.</small></th>
                <th><small>ActivationDate</small></th>
                <th><small>Assign Branch</small></th>
                <th><small>Refer by</small></th>
                <th><small>Area Manager</small></th>
                <th><small>Service Executive</small></th>
                <th><small>Device Amt</small></th>
                </tr>
                <?php
                if(mysql_num_rows($stockArr)>0){
        	  		$kolor =1;
        		    while ($row = mysql_fetch_array($stockArr)){
     		  	?>
                    <tr>
                        <td><small><?php print $kolor++;?>.</small></td>
                        <td><small><?php echo stripslashes($row["vehicleId"]);?></small></td>
            			<td><small><?php echo getOraganization(stripslashes($row["callingDateId"]));?></small></td>
                        <td><small><?php echo stripslashes($row["vehicleNo"]);?></small></td>
                        <td><small><?php echo stripslashes($row["imeiNo"]);?></small></td>
                        <td><small><?php echo getMobile(stripslashes($row["mobileNo"]));?></small></td>
                        <td><small><?php echo  $row["activationDate"];?></small></td>
            			<td><small><?php echo getBranch(stripslashes($row["assignBranch"]));?></small></td>
                        <td><small><?php echo gettelecallername(stripslashes($row["referBy"]));?></small></td>
                        <td><small><?php echo gettelecallername(stripslashes($row["areaManager"]));?></small></td>
                        <td><small><?php echo gettelecallername(stripslashes($row["serviceExecutive"]));?></small></td>
                        <td><small><?php echo stripslashes($row["deviceAmt"]);?></small></td>
                    </tr>
                <?php 
    			   }
                }
                else{
                    echo "<tr>
                            <td colspan='11'><center><h3 style='color:red'>No Records found !</h3></center></td>
                          </tr>";
                }
    		   ?>
            </table>
          </div>
        </div>
    </div>
<?php 
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$customerId =$_REQUEST['customerId']; 
error_reporting(0);
// $linkSQL = "SELECT D.callingdata_id as callingDateId, A.vehicle_no vehicleNo, 
//             C.plan_rate as deviceAmt, A.installation_date as activationDate, 
//             F.service_branchId as assignBranch, D.telecaller_id referBy,
// 			F.service_area_manager as areaManager, F.service_executive as serviceExecutive, 
//             A.imei_no as imeiNo, 
//             A.mobile_no as mobileNo
// 			FROM tbl_gps_vehicle_master as A 
// 			INNER JOIN tbl_gps_vehicle_payment_master as B 
// 			ON A.id = B.Vehicle_id
// 			INNER JOIN tblplan as C 
// 			ON B.device_amt = C.id
// 			INNER JOIN tbl_customer_master as D 
// 			ON B.cust_id = D.cust_id 
// 			INNER JOIN tbl_device_master as E 
// 			ON A.device_id = E.id
// 			LEFT OUTER JOIN tbl_assign_customer_branch as F 
// 			ON D.cust_id = F.cust_id
// 			WHERE A.activeStatus = 'Y' 
// 			AND B.device_type = '1'
// 			AND B.PlanactiveFlag = 'Y' 
//             AND D.cust_id = '$customerId'
//             order by A.installation_date";
$linkSQL = "SELECT A.customer_Id as custId, A.vehicle_no as vehicleNo, 
            A.paymentActiveFlag as paymentStatus, C.callingdata_id as callingdateId, 
            B.device_amt as dueAmt, B.Vehicle_id as vehicleId, A.mobile_no as mobileNo, 
            A.imei_no as imeiNo, A.installation_date as installation_date, 
            A.devicePaymentStatus as paymentStatus
            FROM tbl_gps_vehicle_master as A 
            INNER JOIN tbl_gps_vehicle_payment_master as B 
            ON A.id = B.Vehicle_id
            INNER JOIN tbl_customer_master as C 
            ON B.cust_id = C.cust_id
            WHERE A.customer_Id = '$customerId'
            and B.PlanactiveFlag ='Y'
            and A.activeStatus = 'Y'";
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0){
?>
<table class="table table-hover table-bordered example">
    <thead>
        <tr>
            <th><small>S. No.</small></th>
            <th><small>Estimate Id</small></th>
            <th><small>Vehicle No.</small></th>
            <th><small>IMEI No.</small></th>
            <th><small>Mobile No.</small></th>
            <th><small>Activation Date</small></th>
            <th><small>Device Amt</small></th>
            <th><small>Payment Status</small></th>
        </tr>
    </thead>
    <tbody>
    <?php
	$kolor =1;
	while ($row = mysql_fetch_array($stockArr)){
    ?>
        <tr>
            <td><small><?php print $kolor++;?>.</small></td>
            <td><small><?= getEstimateId($row['vehicleId']); ?></small></td>
            <td><small><?php echo stripslashes($row["vehicleNo"]);?></small></td>
            <td><small><?php echo stripslashes($row["imeiNo"]);?></small></td>
            <td><small><?php echo getMobile(stripslashes($row["mobileNo"]));?></small></td>
            <td><small><?php echo  date("d-m-Y", strtotime($row["installation_date"]));?></small></td>
            <td><small><?php echo getPlanAmt($row["dueAmt"]);?>
            </small></td>
            <td><small><?php 
                        if($row['paymentStatus'] == 'A'){
                            echo '<span class="label label-danger">Pending</span>';
                        }
                        else if($row['paymentStatus'] == 'P'){
                            echo '<span class="label label-danger">Pending</span>';
                        }
                        else if($row['paymentStatus'] == ''){
                            echo '<span class="label label-danger">Pending</span>';
                        }
                        else if($row['paymentStatus'] == 'F'){
                            echo '<span class="label label-success">Received</span>';
                        }
                       ?>
                       </small></td>
            <?php 
                $deviceTotalAmt = getPlanAmt($row["dueAmt"]) + $deviceTotalAmt;
            ?>
        </tr>
            <?php 
	}
}
    ?>

    </tbody>
</table>
<div>
    <table class="table table-hover table-bordered">
        <tr>
            <thead>
                <td class="col-sm-8">&nbsp;</td>
                <td class="col-sm-2" style="background-color: red; color: #fff; text-align: center; font-size: 16px;"><small><strong>Total Amount</strong></small></td>
                <td class="col-sm-2" style="background-color: red; color: #fff; text-align: center; font-size: 14px; font-weight: bold;"><small><?= $deviceTotalAmt ?></small></td>
            </thead>
          </tr>
    </table>
</div>
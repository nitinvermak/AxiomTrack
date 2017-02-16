<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$executive = mysql_real_escape_string($_POST['executive']);
$branch = mysql_real_escape_string($_POST['branch']);
$status = mysql_real_escape_string($_POST['status']);
$customerStatus = mysql_real_escape_string($_POST['customerStatus']);
// echo "string";
error_reporting(0);
$linkSQL = "select A.Company_Name as company, A.First_Name as fname, A.Last_Name as lname, 
			A.Address as address, A.Area as area, A.City as city, A.State as state, 
			B.cust_id as customerId, B.confirmation_date as activationDate, 
			B.customer_type as customerType,B.telecaller_id as refferBy,
			B.activeStatus as activeStatus,
			C.service_branchId as serviceBranch, B.customerStatus as customerStatus,
			C.service_area_manager as areaManager, C.service_executive as serviceExecutive,
			A.Mobile as mobile, D.paymentMode as paymentMode, 
			D.billDeliveryMode as billDeliveryMode, D.paymentPeriod as paymentPeriod, 
			D.paymentPickupMode as paymentPickupMode, B.np_device_rent as rentAmt	
			from tblcallingdata as A
			inner join tbl_customer_master as B
			On A.id = B.callingdata_id
			left outer join tbl_assign_customer_branch as C 
			on B.cust_id = C.cust_id
            Left Outer JOIN billingprofile as D 
            ON C.cust_id = D.custId
           ";
/*echo $linkSQL;*/
if ( ($executive != 0) or ( $dateto !='' and $date !='') or ($branch != 0) or ($status !='') or ($customerStatus != '')){
	$linkSQL  = $linkSQL." WHERE ";	
}

$counter = 0;

if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.telecaller_id = '$executive' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}

if ( $dateto !='' and $date !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(B.confirmation_date) BETWEEN '$date' AND '$dateto' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." C.service_branchId ='$branch' order by B.cust_id" ;
	$counter+=1;
	/*echo $linkSQL;*/
}	
if ( $status != '') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.customer_type ='$status' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}	
if ( $customerStatus != '') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.customerStatus ='$customerStatus' order by B.cust_id";
	$counter+=1;
	/*echo $linkSQL;*/
}	 			
$stockArr=mysql_query($linkSQL);
?>	
	<table border="0" id="example" class="table table-hover table-bordered">
		<thead>	
			<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Cust Id.</small></th> 
                <th><small>Customer Type.</small></th>  
                <th><small>Customer Name</small></th>  
              	<th><small>Company Name</small></th> 
                <th><small>Address</small></th> 
              	<th><small>City</small></th> 
                <th><small>State</small></th>
                <th><small>Contact No.</small></th>
                <th><small>Activation Date</small></th>
                <th><small>Mode of Payment</small></th>
                <th><small>Bill Dilivery Mode</small></th>
                <th><small>Payment Period</small></th>
                <th><small>Payment Pickup Mode</small></th>
                <th><small>Reffer By</small></th>
                <th><small>Service Branch</small></th> 
                <th><small>Area Manager</small></th> 
                <th><small>Service Executive</small></th>  
                <th><small>Customer Profile</small></th>  
                <th><small>Customer Status</small></th> 
                <th><small>Frq.</small></th>  
                <th><small>No. of Vehicle</small></th>  
                <th><small>Amt.</small></th>  
                <th><small>Last Pymt. Rcd. Date</small></th>                 
                <th><small>Next Gen. Date</small></th>
                <!-- <th><small>Last Invoice Start Date</small></th> -->
            </tr> 
        </thead>  
        <tbody>
		<?php
		$kolor=1;
		if(mysql_num_rows($stockArr)>0){
			while ($row = mysql_fetch_array($stockArr)){
				$fraq = getFrequencyId($row["customerId"]);
		?>
			<tr>
		        <td><small><?= $kolor++;?>.</small></td>
		        <td><small><?= $row["customerId"];?></small></td>
		        <td><small><?= getCType($row["customerType"]); ?></small></td>
		        <td><small><?= $row["fname"].' '.$row["lname"]; ?></small></td>
		        <td><small><?= $row["company"]; ?></small></td>
		        <td><small><?= $row["address"]; ?>, <?= getarea($row["area"]); ?></small></td>
		        <td><small><?= getcities($row["city"]); ?></small></td>
		        <td><small><?= getstate($row["state"]); ?></small></td>
		        <td><small><?= $row["mobile"]; ?></small></td>
		        <td><small><?= date("d-m-Y", strtotime($row["activationDate"])); ?></small></td>
		        <td><small><?= $row["paymentMode"]; ?></small></td>
		        <td><small><?= $row["billDeliveryMode"]; ?></small></td>
		        <td><small><?= $row["paymentPeriod"]; ?></small></td>
		        <td><small><?= $row["paymentPickupMode"]; ?></small></td>
		        <td><small><?= gettelecallername($row["refferBy"]); ?></small></td>
		        <td><small><?= getBranch($row["serviceBranch"]); ?></small></td>
		        <td><small><?= gettelecallername($row["areaManager"]); ?> </small></td>    
		        <td><small><?= gettelecallername($row["serviceExecutive"]); ?></small></td> 
		        <td><small><?= $row["customerStatus"]; ?></small></td> 
		        <td><small><?= getVehicleStatus($row['activeStatus']); ?></small></td>     
		        <td><small><?= getFrequency($fraq); ?></small></td>
		        <td><small><?= getNoOfVehicles($row["customerId"]); ?></small></td>
		        <td><small><?= getRentAmt($row["rentAmt"]); ?></small></td>
		        <td><small><?= date("d-m-Y", strtotime(lastpaymentreceiveddate($row["customerId"])));?></small></td>
		        <td><small><?= date("d-m-Y", strtotime(next_due_date($row["customerId"])));?></small></td>

		    </tr> 
        <?php 
            }    
		}
		?>
		</tbody>
		</table>

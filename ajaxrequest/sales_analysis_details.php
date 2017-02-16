<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$dateFrom = mysql_real_escape_string($_POST['dateFrom']);
$dateTo = mysql_real_escape_string($_POST['dateTo']);
$customerType = mysql_real_escape_string($_POST['customerType']);
$leadGenBy = mysql_real_escape_string($_POST['leadGenBy']);
$installedBy = mysql_real_escape_string($_POST['installedBy']);
$branch = mysql_real_escape_string($_POST['branch']);
error_reporting(0);

	$linkSQL = "SELECT A.callingdata_id as companyId, C.vehicle_no as vehicleNo, A.cust_id as custId,
				A.customer_type as custType, C.installation_date as installationDate, 
				B.service_branchId as serviceBranchId, A.telecaller_id as leadGenId, 
				C.techinician_name as installedBy, A.np_device_amt as saleAmt, E.Company_Name as dealerCompany,
				D.price as devicePrice, D.company_id as dCompany, A.np_device_rent as rentAmt, C.mobile_no as simId, 
				C.device_id as deviceId, A.rent_payment_mode as rentPaymentMode, C.receivedAmt as receivedAmt
				FROM tbl_customer_master as A 
				left outer JOIN tbl_assign_customer_branch as B 
				ON A.cust_id = B.cust_id
				INNER JOIN tbl_gps_vehicle_master as C 
				ON B.cust_id = C.customer_Id
				INNER JOIN tbl_device_master as D 
				ON C.device_id = D.id
				INNER JOIN tbldealer as E 
	  			ON D.dealer_id = E.id 
				WHERE C.paymentActiveFlag = 'Y'";
	/*echo $linkSQL;*/
if( ($dateFrom != 0) or ( $dateTo != 0) or ( $customerType != 0) or ( $leadGenBy != 0) or ( $installedBy != 0) or ( $branch != 0) )
{
	$linkSQL  = $linkSQL." AND ";
}
$counter = 0;
if( $dateFrom != 0 and $dateTo != 0 )
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL =$linkSQL."  DATE(C.installation_date) BETWEEN '$dateFrom' AND '$dateTo' ";
		$counter+=1;
	/*	echo $linkSQL; */
	}
if($customerType != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.customer_type = '$customerType' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if($leadGenBy != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.telecaller_id = '$leadGenBy' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if($branch != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.service_branchId = '$branch' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
if($installedBy != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." C.techinician_name = '$installedBy' " ;
		$counter+=1;
		/*echo $linkSQL;*/
	}
	$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0){
?>	
	<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">	
		<thead>
			<tr>
			  	<th><small>S. No.</small></th>     
			  	<th><small>Company Name</small></th> 
		        <th><small>Vehicle No.</small></th>  
		        <th><small>IMEI</small></th>
		        <th><small>Mobile No.</small></th>
		        <th><small>Customer Type</small></th>
		        <th><small>Device Type</small></th> 
		        <th><small>Installation Date</small></th>  
		        <th><small>Dealer</small></th>  
		        <th><small>Service Branch</small></th>
		        <th><small>Lead Gen. By</small></th>   
		        <th><small>Installed By</small></th>    
		        <th><small>Purchase Amt.</small></th> 
		        <th><small>Sale Amt</small></th> 
		        <th><small>Rent Amt</small></th>
		        <th><small>Rent Frq. </small></th> 
		        <th><small>Payment</small></th>                         
            </tr> 
        </thead>
        <tbody>  
		<?php
		$kolor=1;
		while ($row = mysql_fetch_array($stockArr)){
		?>   
        <tr>
            <td><small><?php print $kolor++;?>.</small></td>
            <td><small><?php echo getOraganization(stripslashes($row["companyId"]));?></small></td>
            <td><small><?php echo stripcslashes($row["vehicleNo"]);?></small></td>
            <td><small><?php echo getIMEINO(stripcslashes($row["deviceId"]));?></small></td>
            <td><small><?php echo getMobile(stripcslashes($row["simId"]));?></small></td>
            <td><small><?php echo getCustomerType(stripslashes($row["custType"]));?></small></td>
            <td><small><?php echo getDeviceType($row['custId']); ?></small></td>
            <td><small><?php echo stripslashes($row["installationDate"]);?></small></td>
            <td><small><?php echo stripslashes($row["dealerCompany"]);?></small></td>
            <td><small><?php echo getBranch(stripcslashes($row["serviceBranchId"]));?></small></td>
            <td><small><?php echo gettelecallername(stripcslashes($row["leadGenId"]));?></small></td>
            <td><small><?php echo gettelecallername(stripcslashes($row["installedBy"]));?></small></td>
            <td><small><?php echo stripcslashes($row["devicePrice"]); ?></small></td>
            <td><small><?php echo getPlanAmt(stripcslashes($row["saleAmt"])); ?></small></td>
            <td><small><?php echo getPlanAmt(stripcslashes($row["rentAmt"])); ?></small></td>
            <td><small><?php echo getFrequency(stripcslashes($row["rentPaymentMode"])); ?></small></td>
            <td><small><?php echo getpaymentStatus($row['receivedAmt']); ?></small></td>
        </tr> 
		<?php 
        }
        echo "</tbody>";
  	echo "</table>";
}
echo '<h4 class="red">Records not found</h4>';
?>
              
<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
 
 
$myArray = json_decode($_POST["postdata"] );
 
foreach ( $myArray as $array1){
	foreach ($array1 as $key => $val) {
	     	echo '</br>'; 
	    	/* echo var_dump($array1);*/ 
	     // echo "$key => $val\n";
     		 	$chunk = explode('=',$val); 

       		switch ($chunk[0]) {
				case 'vehicle_id':
					$vehicle_id = $chunk[1];
					/*echo 'vehicle_id='.$vehicle_id;	*/
					break;	
				case 'custid':
					$custid = $chunk[1];
					/*echo 'custid'.$custid;*/
					break;
				case 'installation_date':
					$installation_date = $chunk[1];
					/*echo 'Instal Date='.$installation_date;*/
					break;
				case 'model_name':
					$model_name = $chunk[1];
					/*echo 'Model Name='.$model_name;*/
					break;
				case 'device_type':
					$device_type = $chunk[1];
					/*echo 'Device type='.$device_type;*/
					break;
				case 'device_amt':
					$device_amt = $chunk[1];
					/*echo 'Device Amt.='.$device_amt;*/
					break;
				case 'device_rent':
					$device_rent = $chunk[1];
					/*echo 'device_rent='.$device_rent;*/
					break;
				case 'rent_frq':
					$rent_frq = $chunk[1];
					/*echo 'rent_frq='.$rent_frq;*/
					break;
				case 'installation_charges':
					$installation_charges = $chunk[1];
					/*echo 'installation_charges='.$installation_charges;*/
					break;
				case 'instalment':
					$instalment = $chunk[1];
					/*echo 'instalment'.$instalment;*/
					break;
				case 'NoOfInstallation':
					$NoOfInstallation = $chunk[1];
					/*echo 'NoOfInstallation'.$NoOfInstallation;*/
					break;
				case 'instalment_frq':
					$instalment_frq = $chunk[1];
					/*echo 'instalment_frq'.$instalment_frq;*/
					break;
				case 'downpayment':
					$downpayment = $chunk[1];
					default:
		}  
 	} 
	
}

if($device_type == 4)


	{	
		echo $device_amt;
		
		$deviceAmt =explode('@',$device_amt);
		echo '<br/>';
		echo $deviceAmt[0];
		echo '<br/>';
		echo $deviceAmt[1];
		
		
		$instalment = 	($deviceAmt[1] - $downpayment)/$NoOfInstallation;
	    echo $instalment;
		$Update = "Insert tblinstallmentmaster SET VehicleId = '$vehicle_id', Installmentamount = '$instalment',   		
		downpaymentAmount = '$downpayment', InstFrequencyID='$instalment_frq', NoOfInstallment = '$NoOfInstallation'"; 
		echo "Update".$Update;
		$result1 = mysql_query($Update);
		$instalmentId = mysql_insert_id();
		/*echo 'inid'.$instalmentId;*/
		$sql = "Insert into tbl_gps_vehicle_payment_master set cust_id = '$custid', instalmentId='$instalmentId', Vehicle_id = '$vehicle_id', device_type = '$device_type', device_amt = '$deviceAmt[0]', device_rent_amt = '$device_rent', installation_charges = '$installation_charges', RentalFrequencyId='$rent_frq',PlanStartDate='$installation_date', PlanactiveFlag='Y'";
		echo 'comnd' .$sql;
		$result = mysql_query($sql);
		$change_status = "UPDATE tbl_gps_vehicle_master SET paymentActiveFlag='Y' where id='$vehicle_id'";
		/*echo $change_status; */
		$change = mysql_query($change_status);
	}
else
	{
	
		$deviceAmt =explode('@',$device_amt);
 
	$sql = "Insert into tbl_gps_vehicle_payment_master set cust_id = '$custid', Vehicle_id = '$vehicle_id ', device_type = '$device_type', device_amt = '$deviceAmt[0]', device_rent_amt = '$device_rent', installation_charges = '$installation_charges', RentalFrequencyId='$rent_frq', PlanStartDate='$installation_date', PlanactiveFlag='Y'";
	echo 'comnd' .$sql;
	$result = mysql_query($sql);
	$change_status = "UPDATE tbl_gps_vehicle_master SET paymentActiveFlag='Y' where id='$vehicle_id'";
	echo $change_status; 
	$change = mysql_query($change_status);
	}
 
?>
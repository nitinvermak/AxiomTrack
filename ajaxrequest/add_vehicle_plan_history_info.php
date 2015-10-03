<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
 
 
$myArray = json_decode($_POST["postdata"] );
 /*echo 'fahfsak';*/
foreach ( $myArray as $array1){
	foreach ($array1 as $key => $val) {
	     	echo '</br>'; 
	    	/* echo var_dump($array1); */
	     // echo "$key => $val\n";
     		 	$chunk = explode('=',$val); 

       		switch ($chunk[0]) {
				case 'vehicle_id':
					$vehicle_id = $chunk[1];
					echo 'vehicle_id='.$vehicle_id;	
					break;	
				case 'custid':
					$custid = $chunk[1];
					echo 'custid'.$custid;
					break;
				case 'installation_date':
					$installation_date = $chunk[1];
					echo 'Plan Start Date='.$installation_date;
					break;
				case 'plan_end':
					$plan_end = $chunk[1];
					echo "Plan End".$plan_end;
					break;
				case 'model_name':
					$model_name = $chunk[1];
					echo 'Model Name='.$model_name;
					break;
				case 'device_type':
					$device_type = $chunk[1];
					echo 'Device type='.$device_type;
					break;
				case 'device_amt':
					$device_amt = $chunk[1];
					echo 'Device Amt.='.$device_amt;
					break;
				case 'device_rent':
					$device_rent = $chunk[1];
					echo 'device_rent='.$device_rent;
					break;
				case 'rent_frq':
					$rent_frq = $chunk[1];
					echo 'rent_frq='.$rent_frq;
					break;
				case 'installation_charges':
					$installation_charges = $chunk[1];
					echo 'installation_charges='.$installation_charges;
					break;
				case 'instalment':
					$instalment = $chunk[1];
					echo 'instalment'.$instalment;
					break;
				case 'NoOfInstallation':
					$NoOfInstallation = $chunk[1];
					echo 'NoOfInstallation'.$NoOfInstallation;
					break;
				case 'instalment_frq':
					$instalment_frq = $chunk[1];
					echo 'instalment_frq'.$instalment_frq;
					default:
		}  
 	} 
	
}
if($device_type == 4)
	{	
	
		$change_status = "UPDATE `tbl_gps_vehicle_payment_master` SET PlanactiveFlag = 'N', PlanendDate=Now() WHERE 			
		Vehicle_id='$vehicle_id' and PlanactiveFlag = 'Y'";
		echo $change_status; 
		$change = mysql_query($change_status);
			
		$Update = "Insert tblinstallmentmaster SET VehicleId = '$vehicle_id', InstallmentamountID = '$instalment', InstFrequencyID='$instalment_frq', NoOfInstallment = '$NoOfInstallation'"; 
		echo "Update".$Update;
		$result1 = mysql_query($Update);
		$instalmentId = mysql_insert_id();
		
		$sql = "Insert into tbl_gps_vehicle_payment_master set cust_id = '$custid', instalmentId='$instalmentId', Vehicle_id = '$vehicle_id', device_type = '$device_type', device_amt = '$device_amt', device_rent_amt = '$device_rent', installation_charges = '$installation_charges', RentalFrequencyId='$rent_frq',PlanStartDate='$installation_date', PlanendDate=' ', PlanactiveFlag='Y'";
		echo 'comnd' .$sql;
		$result = mysql_query($sql);

	}
else
	{
		$change_status = "UPDATE `tbl_gps_vehicle_payment_master` SET PlanactiveFlag = 'N', PlanendDate=Now() WHERE 			
		Vehicle_id='$vehicle_id' and PlanactiveFlag = 'Y'";
		echo $change_status; 
		$change = mysql_query($change_status);
		
	$sql = "Insert into tbl_gps_vehicle_payment_master set cust_id = '$custid', Vehicle_id = '$vehicle_id ', device_type = '$device_type', device_amt = '$device_amt', device_rent_amt = '$device_rent', installation_charges = '$installation_charges', RentalFrequencyId='$rent_frq', PlanStartDate='$installation_date', PlanendDate=' ', PlanactiveFlag='Y'";
	echo 'comnd' .$sql;
	$result = mysql_query($sql);
 
	}
 
?>
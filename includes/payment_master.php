<?php

error_reporting(0); 

function generate_estimates($intervalId , $rentFrequencyId){
     
    $joinQuery = "
	        SELECT  
			A.id as vehicleId , A.customer_Id  as customerId, B.device_amt as deviceAmount,
			B.device_rent_amt as deviceRentAmt , B.installation_charges as  installationCharges	 			
			FROM tbl_gps_vehicle_master as A 
			INNER JOIN tbl_gps_vehicle_payment_master as B 
			ON A.id = B.Vehicle_id
			where A.paymentActiveFlag = 'Y'
			and   B.PlanactiveFlag = 'Y'
			and   B.instalmentId = 0
			and   B.RentalFrequencyId = '$rentFrequencyId'
			order by A.customer_Id 
			";
			 
	$stockArr = mysql_query($joinQuery);
	$planRateQuery= " Select id , plan_category  , plan_rate  from tblplan where plan_category = 5 or   plan_category = 6 or plan_category = 7 ";
	$planRateQueryArr = mysql_query($planRateQuery);
 
	$deviceAmountDict = array();
	$deviceRentAmtDict = array();
	$installationChargesDict = array();
 
	while ($rowA = mysql_fetch_array( $planRateQueryArr)){
		
		//echo $rowA["plan_category"].'='.$rowA["id"].'='.$rowA["plan_rate"].'</br>';
		if ($rowA["plan_category"] == 5){
			$deviceAmountDict[$rowA["id"] ] =$rowA["plan_rate"];
		}
		if ($rowA["plan_category"] == 7){
			$deviceRentAmtDict[$rowA["id"] ] =$rowA["plan_rate"];
		}
		if ($rowA["plan_category"] == 6){
			$installationChargesDict[$rowA["id"] ] =$rowA["plan_rate"];
		}
	}
	
	
	echo mysql_num_rows($stockArr);
	
	$maxRow = mysql_num_rows($stockArr);
	$nextCustomer = -1;
	$loopCounter = 0 ;
	$newInvoiceId= 0;
	// Looop start for calculating the payment details 
	
	while ($row = mysql_fetch_array( $stockArr)){
		$loopCounter=$loopCounter+1;
        
		if ( $nextCustomer != $row["customerId"] ){  // new record adjustment
			if($nextCustomer != -1){
				$sql = "Insert into tbl_Invoice_Master set 
				intervalId = '$intervalId', generatedAmount = '$payableAmount', taxId = '1', discountedAmount = '0', paidAmount ='0',
				invoiceFlag ='N' , paymentBreakageId ='0' , paymentMethodId = '0' , paymentStatusFlag = 'A'"; 
				echo 'comnd' .$sql;
				$result = mysql_query($sql);
				$newInvoiceId =  mysql_insert_id();
				echo 'result='.$result;
			}
				 
			echo 'Record Changed';
			$nextCustomer = $row["customerId"];
			$newFlag = 'y';
			$payableAmount = 0;			
		}		
 
			
		$payableAmount  = $payableAmount + ($deviceAmountDict[$row["deviceAmount"]] + $deviceRentAmtDict[$row["deviceRentAmt"]] + 
			$installationChargesDict[$row["installationCharges"]]);
		echo '</br>'.'amount='.$payableAmount;

		if ($maxRow == $loopCounter){   // Last Record Processing
				$sql = "Insert into tbl_Invoice_Master set 
				intervalId = '$intervalId', generatedAmount = '$payableAmount', taxId = '1', discountedAmount = '0', paidAmount ='0',
				invoiceFlag ='N' , paymentBreakageId ='0' , paymentMethodId = '0' , paymentStatusFlag = 'A'"; 
				echo 'comnd' .$sql;
				$result = mysql_query($sql);
			    $newInvoiceId =  mysql_insert_id();
				echo
				echo ' Last Record Processing';
				echo 'result='.$result;
		}
		 
		
 

				
	
	
	}
	
	
	
	
}


?>


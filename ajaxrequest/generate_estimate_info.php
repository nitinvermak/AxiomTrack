<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
//include("../includes/payment_master.php"); 
 
error_reporting(E_ALL);
$myArray = json_decode($_POST["postdata"] );
/*echo $myArray;*/
 

foreach ( $myArray as $array1){
	foreach ($array1 as $key => $val) {
	     	echo '</br>'; 
  		 	$chunk = explode('=',$val); 

       		switch ($chunk[0]) {
				case 'interval_Id':
					$interval_Id = $chunk[1];	 		
					echo $interval_Id;
					break;					 				 				
 					
		}  
 	} 
}
$sql = "UPDATE `tblesitmateperiod` SET GeneratedStatus='Y', GeneratedDate = Now() WHERE intervalId = '$interval_Id'"; 
//$result = mysql_query($sql);
$rentFreqId = 1;  //  pass it from the page
//$estimateStatus = generate_estimates($interval_Id,$rentFreqId);
 $intervalId = $interval_Id;
 $rentFrequencyId = 1;
    $joinQuery = "
	        SELECT  
			A.id as vehicleId , A.customer_Id  as customerId, B.device_amt as deviceAmount,
			B.device_rent_amt as deviceRentAmt , B.installation_charges as  installationCharges,
			B.oneTimePaymentFlag as oneTimePaymentFlag, B.planId as planId, B.instalmentId vehicleInstalmentId,
			C.id as installmenPlanId, C. Installmentamount as installmentAmountID,
			C.PaidInstalments as paidInstalments, C.NoOfInstallment as noOfInstallment,
			C.activeFlag as installmentActiveFlag
			FROM tbl_gps_vehicle_master as A 
			INNER JOIN tbl_gps_vehicle_payment_master as B 
			ON A.id = B.Vehicle_id
			LEFT OUTER JOIN  tblinstallmentmaster  as C
			ON B.instalmentId = C.id
			where A.paymentActiveFlag = 'Y'
			and   B.PlanactiveFlag = 'Y'
			and   B.RentalFrequencyId = '$rentFrequencyId'
			order by B.cust_Id 
			";
	// watchout the joins used	first is inner and second is left outer		
	echo $joinQuery;		 
	$stockArr = mysql_query($joinQuery);
	$planRateQuery= " Select id , planSubCategory  , plan_rate  from tblplan where 
	 productCategoryId = 4  and ( 	planSubCategory = 1 or   	planSubCategory = 2 or 	planSubCategory = 3)";
	$planRateQueryArr = mysql_query($planRateQuery);
 
	$deviceAmountDict = array();
	$deviceRentAmtDict = array();
	$installationChargesDict = array();
 
	while ($rowA = mysql_fetch_array( $planRateQueryArr)){
		
		//echo $rowA["plan_category"].'='.$rowA["id"].'='.$rowA["plan_rate"].'</br>';
		if ($rowA["planSubCategory"] == 1){
			$deviceAmountDict[$rowA["id"] ] =$rowA["plan_rate"];
		}
		if ($rowA["planSubCategory"] == 2){
			$deviceRentAmtDict[$rowA["id"] ] =$rowA["plan_rate"];
		}
		if ($rowA["planSubCategory"] == 3){
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
		echo '</br>';
		echo 'processing customer id= '.$row['customerId'];
		echo '</br>';
		
		$loopCounter=$loopCounter+1;
		
		if ($nextCustomer == -1){  // to get invoice id for the first payment breakage Ids
			$sqlMaxId = "Select Max(invoiceId) as  invoiceId from tbl_Invoice_Master ";
			$resultMaxId  = mysql_fetch_array(mysql_query($sqlMaxId));
			$newInvoiceId =  $resultMaxId["invoiceId"] + 1;
			echo 'invoiceId='.$newInvoiceId ;
			echo '</br>';
		}
        
		if ( $nextCustomer != $row["customerId"] ){  // new record adjustment
			if($nextCustomer != -1){
				$sql = "Insert into tbl_Invoice_Master set 
				intervalId = '$intervalId', customerId ='".$nextCustomer."',
				generatedAmount = '$payableAmount', taxId = '1', discountedAmount = '0', paidAmount ='0',
				invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
				
				$result = mysql_query($sql);
				$newInvoiceId =  mysql_insert_id() + 1; // For first inserted record behaviour is different.
				echo '</br>';
				echo 'new  generated invoice id= '.$newInvoiceId;
				echo '</br>';
				//echo $newInvoiceId;
				
				echo '</br>';
				echo 'invoice record inserted';
				echo '</br>';
				echo $sql;
				
			}
				 
			echo 'Record Changed';
			$nextCustomer = $row["customerId"];
			
			$newFlag = 'y';
			$payableAmount = 0;			
		}		
 
		echo 'deviceAmount='.$deviceAmountDict[$row["deviceAmount"]];
		echo '</br>';
		echo 'deviceRentAmt='.$deviceRentAmtDict[$row["deviceRentAmt"]];
		echo '</br>';
		echo 'installationCharges='.$installationChargesDict[$row["installationCharges"]];
		echo '</br>';
		
		
		if ($row['oneTimePaymentFlag'] == 'N'){
		
		    $payableAmount  = $payableAmount + ($deviceAmountDict[$row["deviceAmount"]] + $deviceRentAmtDict[$row["deviceRentAmt"]] + 
			$installationChargesDict[$row["installationCharges"]]);
			$sqlUpd = "UPDATE `tbl_gps_vehicle_payment_master` SET oneTimePaymentFlag='Y' WHERE planId = '".$row['planId']."'"; 
            $resultUpd = mysql_query($sqlUpd);
			
		}
		elseif ($row['oneTimePaymentFlag'] == 'Y'){
			$payableAmount  = $payableAmount + $deviceRentAmtDict[$row["deviceRentAmt"]] ;
			
		}
		
		if ($row['installmentActiveFlag'] == 'Y' ){
			
			echo 'installment amount added=++++++++++++++++++++++++++++++++++++++++++'.$row['installmentAmountID'];
			$payableAmount= $payableAmount + $row['installmentAmountID'];
			
		}
		
		echo '</br>'.'amount='.$payableAmount;
		echo '</br>';

		if ($maxRow == $loopCounter){   // Last Record Processing
				$sql = "Insert into tbl_Invoice_Master set 
				intervalId = '$intervalId', customerId ='".$row['customerId']."',
				generatedAmount = '$payableAmount', taxId = '1', discountedAmount = '0', paidAmount ='0',
				invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
				echo  $sql;
				$result = mysql_query($sql);
			    $newInvoiceId =  mysql_insert_id();
				echo '</br>';
				echo 'new  generated invoice id= '.$newInvoiceId;
				echo '</br>';
				
				echo '</br>';
				echo 'invoice record inserted----------------------------last record----------------------';
				echo '</br>';
				 
		}

		
		//  Add payment breakage data  Starts	
		
		if ($row['oneTimePaymentFlag'] == 'N'){ // this flag takes care of the one time payment
		
			
			$sqlA = "Insert into tbl_Payment_Breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'A',
					amount ='".$deviceRentAmtDict[$row['deviceRentAmt']]."' ";
			echo  $sqlA;
			$resultA = mysql_query($sqlA);
			
			echo '</br>';
			$sqlB = "Insert into tbl_Payment_Breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'B',
					amount ='".$deviceAmountDict[$row['deviceAmount']]."' ";
		
			echo  $sqlB;
			$resultB = mysql_query($sqlB);
			echo '</br>';

			echo '</br>';
			$sqlC = "Insert into tbl_Payment_Breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'C',
					amount ='".$installationChargesDict[$row['installationCharges']]."' ";
 
			echo  $sqlC;
			$resultC = mysql_query($sqlC);
			echo '</br>';
			
		}
		elseif ($row['oneTimePaymentFlag'] == 'Y'){ // this flag takes care of the one time payment. After first payment , only rent 
			echo '</br>';			
			$sqlA = "Insert into tbl_Payment_Breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'A',
					amount ='".$deviceRentAmtDict[$row['deviceRentAmt']]."' ";
			echo  $sqlA;
			echo '</br>';
			$resultA = mysql_query($sqlA);
		 	
		}

		// Installment Process starts
		if ($row['installmentActiveFlag'] == 'Y' ){ // This check will exclude NULLS & also non active installment plans
				
			$sqlD = "Insert into tbl_Payment_Breakage set 
			invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'D',
			amount ='".$row['installmentAmountID']."' ";
			echo  $sqlD;
			echo '</br>';
			$resultD = mysql_query($sqlD);		
				
			if ($row['paidInstalments']+1 == $row['noOfInstallment'] ){  // if the number of instalment is completed
				$sqlU1 = "UPDATE `tblinstallmentmaster` SET activeFlag='N', 
				PaidInstalments = ".($row['paidInstalments']+1)." WHERE id = '".$row['installmenPlanId']."'"; 
                $resultU1 = mysql_query($sqlU1);
				
			}
			else{  // If the number of installment is not complete
				$sqlU2 = "UPDATE `tblinstallmentmaster` SET  
				PaidInstalments = ".($row['paidInstalments']+1)." WHERE id = '".$row['installmenPlanId']."'"; 
                $resultU2 = mysql_query($sqlU2);
				
				
			}
			
			
			
		}
		
		// Installment Process Ends
		
		
		
		
		
		
		
		
		
	 
        

		//  Add payment breakage data  Ends
 

				
	
	
	}
?>
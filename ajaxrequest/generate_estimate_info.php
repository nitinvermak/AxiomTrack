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
			    case 'intervalMonth':
					$intervalMonth = $chunk[1];	 		
					echo $intervalMonth;
					break;					 				 				
 				case 'Intervel_Year':
					$Intervel_Year = $chunk[1];	 		
					echo $Intervel_Year;
					break;
		}  
 	} 
}

$genDate = $Intervel_Year.'-'.$intervalMonth.'-01';
$dueDate = $Intervel_Year.'-'.$intervalMonth.'-15';
$monthDays=cal_days_in_month(CAL_GREGORIAN,$intervalMonth,$Intervel_Year);

$sql0 = "UPDATE `tblesitmateperiod` SET GeneratedStatus='Y', GeneratedDate = Now() WHERE intervalId = '$interval_Id'"; 
$result = mysql_query($sql0);
$rentFreqId = 1;  //  pass it from the page
//$estimateStatus = generate_estimates($interval_Id,$rentFreqId);
 $intervalId = $interval_Id;
 $rentFrequencyId = 1;
    $joinQuery = "
	        SELECT  
			A.id as vehicleId , A.customer_Id  as customerId, B.device_amt as deviceAmount,
			EXTRACT(DAY FROM A.installation_date) AS installation_date,
			EXTRACT(MONTH FROM A.installation_date) AS installation_month,
			EXTRACT(YEAR FROM A.installation_date) AS installation_year,
			B.device_rent_amt as deviceRentAmt , B.installation_charges as  installationCharges,
			B.oneTimePaymentFlag as oneTimePaymentFlag, B.planId as planId, B.instalmentId vehicleInstalmentId,
			C.id as installmenPlanId, C. Installmentamount as installmentAmountID,
			C.PaidInstalments as paidInstalments, C.NoOfInstallment as noOfInstallment,
			C.activeFlag as installmentActiveFlag, C.downpaymentAmount as downpaymentAmount
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
	$typeBAmountEntry =0;
 
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
		echo '----------------------------------------processing customer id= '.$row['customerId'];
		echo '</br>';
		
		$loopCounter=$loopCounter+1;
		$proRataDeviceRentAmt =0;
		$vehicle_installation_date = $row["installation_date"]; // return only the day of the month
		$monthDays=cal_days_in_month(CAL_GREGORIAN,$row["installation_month"],$row["installation_year"]);
		echo '</br>';
		echo '$monthDays='.$monthDays;
		echo '</br>';
		echo '----------------------------------------vehicle_installation_date= '.$vehicle_installation_date;
		echo '</br>';
		$proRataDeviceRentAmt = 0;
		if ($nextCustomer == -1){  // to get invoice id for the first payment breakage Ids
			$sqlMaxId = "Select Max(invoiceId) as  invoiceId from tbl_Invoice_Master ";
			$resultMaxId  = mysql_fetch_array(mysql_query($sqlMaxId));
			$newInvoiceId =  $resultMaxId["invoiceId"] + 1;
			$newInvoiceIdTypeB = $resultMaxId["invoiceId"] + 2;
			echo 'invoiceId='.$newInvoiceId ;
			echo '</br>';
		}
        
		if ( $nextCustomer != $row["customerId"]  ){  // new record adjustment
			echo '</br>';
			echo '-----------------------------Record changed--------------------------';
			echo '</br>';
			echo '$nextCustomer='.$nextCustomer;
			echo '</br>';
			echo '$loopCounter='.$loopCounter;
			echo '</br>';
			echo '$maxRow='.$maxRow;
			echo '</br>';
			
						
			if($nextCustomer != -1 ){	
				echo '-----------------------------Record change invoice are getting added--------------------------';
				echo '</br>';
				echo ' Inserting Type A invoice record 1';	
				echo '</br>';
				$sql = "Insert into tbl_Invoice_Master set 
				intervalId = '$intervalId', customerId ='".$nextCustomer."',
				generateDate = '$genDate' , dueDate = '$dueDate',
				invoiceType = 'A', generatedAmount = '$payableAmountTypeA', taxId = '1', discountedAmount = '0', paidAmount ='0',
				invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
				echo $sql;
				$result = mysql_query($sql);

				
				if($typeBAmountEntry==1){
					echo '</br>';
					echo ' Inserting Type B invoice record 1';
					echo '</br>';
					$sql1 = "Insert into tbl_Invoice_Master set 
					intervalId = '$intervalId', customerId ='".$nextCustomer."',
					generateDate = '$genDate' , dueDate = '$dueDate',
					invoiceType = 'B' , generatedAmount = '$payableAmountTypeB', taxId = '1', discountedAmount = '0', paidAmount 					
					='0',	invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
					echo $sql1;
					$result = mysql_query($sql1);
 					
				}
				$newInvoiceId =  mysql_insert_id() + 1;
				$newInvoiceIdTypeB = $newInvoiceId + 1 ;
					
			}				
				
			 // For first inserted record behaviour is different.
			echo '</br>';
			echo 'new  generated invoice id= '.$newInvoiceId;
			echo '</br>';
			
				
			//echo $newInvoiceId;
				
			echo '</br>';
			echo 'invoice record inserted';
			echo '</br>';
			//echo $sql;
			echo 'Record Changed+++++++++++++';
			echo '</br>';
			$nextCustomer = $row["customerId"];			
			$newFlag = 'y';	 
			$payableAmountTypeA = 0;		
			$payableAmountTypeB = 0;
			$typeBAmountEntry =0;
			
			
		}		
 
		echo 'deviceAmount='.$deviceAmountDict[$row["deviceAmount"]];
		echo '</br>';
		echo 'deviceRentAmt='.$deviceRentAmtDict[$row["deviceRentAmt"]];
		echo '</br>';
		echo 'installationCharges='.$installationChargesDict[$row["installationCharges"]];
		echo '</br>';
		
		
		if ($row['oneTimePaymentFlag'] == 'N'){		
		
			$proRataDeviceRentAmt = $deviceRentAmtDict[$row["deviceRentAmt"]] * ($monthDays - $vehicle_installation_date + 1)/$monthDays;
			echo '</br>';
			echo 'prorata rent='.$proRataDeviceRentAmt;
			echo '</br>';
		    $payableAmountTypeA  = $payableAmountTypeA +  $proRataDeviceRentAmt + $installationChargesDict[$row["installationCharges"]] ; 
			$sqlUpd = "UPDATE `tbl_gps_vehicle_payment_master` SET oneTimePaymentFlag='Y' WHERE planId = '".$row['planId']."'"; 
            $resultUpd = mysql_query($sqlUpd);			
		}
		elseif ($row['oneTimePaymentFlag'] == 'Y'){
			$payableAmountTypeA  = $payableAmountTypeA + $deviceRentAmtDict[$row["deviceRentAmt"]] ;
			
		}
		
		if ($row['installmentActiveFlag'] == 'Y' ){
			$typeBAmountEntry = 1;
			if ($row['oneTimePaymentFlag'] == 'N'){
					$payableAmountTypeB= $payableAmountTypeB + $row['installmentAmountID'] + $row['downpaymentAmount'] ;							
			}
			if ($row['oneTimePaymentFlag'] == 'Y'){
					$payableAmountTypeB= $payableAmountTypeB + $row['installmentAmountID'];				
			}				
			echo 'installment amount added=++++++++++++++++++++++++++++++++++++++++++'.$row['installmentAmountID'];					
		}
		
		if ($row['installmentActiveFlag'] == NULL){
			
			if ($row['oneTimePaymentFlag'] == 'N'){
				    echo '</br>';
				    echo 'Device Amount added='.$deviceAmountDict[$row["deviceAmount"]];
					echo '</br>';
				    $typeBAmountEntry = 1;
					$payableAmountTypeB= $payableAmountTypeB + $deviceAmountDict[$row["deviceAmount"]] ;							
			}
			
		}
		
		echo '</br>'.'payableAmountTypeA='.$payableAmountTypeA;
		echo '</br>'.'payableAmountTypeB='.$payableAmountTypeB;
		echo '</br>';

		if ($maxRow == $loopCounter){   // Last Record Processing
				echo '</br>';
				echo '-----------------------------Last Record invoice are getting added--------------------------';
				echo '</br>';
				echo '</br>';
				echo ' Inserting Type A invoice record 2';
				echo '</br>';
				$sql = "Insert into tbl_Invoice_Master set 
				intervalId = '$intervalId', customerId ='".$row['customerId']."',
				generateDate = '$genDate' , dueDate = '$dueDate',
				invoiceType = 'A' , generatedAmount = '$payableAmountTypeA', taxId = '1', discountedAmount = '0', 
				paidAmount ='0',
				invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
				
				$result = mysql_query($sql);
				echo $sql;
			    $newInvoiceId =  mysql_insert_id();

				
				if($typeBAmountEntry==1){
					echo '</br>';
					echo ' Inserting Type B invoice record 2';
					echo '</br>';
					$sql1 = "Insert into tbl_Invoice_Master set 
					intervalId = '$intervalId', customerId ='".$row['customerId']."',
					generateDate = '$genDate' , dueDate = '$dueDate',
					invoiceType = 'B', generatedAmount = '$payableAmountTypeB', taxId = '1', discountedAmount = '0', paidAmount ='0',
					invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
					echo $sql1;
					echo '</br>';
					$result = mysql_query($sql1);
					$newInvoiceIdTypeB = mysql_insert_id() ;
					 

				}
 
				echo '</br>';
				echo 'last $newInvoiceId ------------------'.$newInvoiceId;
				echo '</br>';
				echo '</br>';
				echo '$newInvoiceIdTypeB='.$newInvoiceIdTypeB;
				echo '</br>';
					
				 
		}

		
		//  Add payment breakage data  Starts	
		
		if ($row['oneTimePaymentFlag'] == 'N'){ // this flag takes care of the one time payment
		
			echo '</br>';
			$sqlA = "Insert into tbl_Payment_Breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'A',
					amount ='".$proRataDeviceRentAmt."' ";
			echo  $sqlA;
			echo '</br>';
			$resultA = mysql_query($sqlA);
			
			$sqlC = "Insert into tbl_Payment_Breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'C',
					amount ='".$installationChargesDict[$row['installationCharges']]."' ";
 
			echo  $sqlC;
			$resultC = mysql_query($sqlC);
			echo '</br>';
			
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

		// Installment Process starts -------------------------------------------------------------------------------------
		
		//if ($row['installmentActiveFlag'] == 'Y' ){
		//	if ($row['oneTimePaymentFlag'] == 'N'){
		echo '</br>';
		echo 'Installment Process starts';
		echo '</br>';
		echo " installmentActiveFlag=".$row['installmentActiveFlag'];
		echo '</br>';
		echo '$typeBAmountEntry='.$typeBAmountEntry;
		echo '</br>';
		echo " oneTimePaymentFlag=".$row['oneTimePaymentFlag'];
		echo '</br>';
		if ($row['installmentActiveFlag'] == 'Y' && $typeBAmountEntry==1){ // This check will exclude NULLS & also non active installment plans
				
			$sqlD = "Insert into tbl_Payment_Breakage set 
			invoiceId = '$newInvoiceIdTypeB', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'D',
			amount ='".$row['installmentAmountID']."' ";
			echo  $sqlD;
			echo '</br>';
			$resultD = mysql_query($sqlD);		// installment amount
			
			if($row['oneTimePaymentFlag'] == 'N'){ // down payment
				$sqlB = "Insert into tbl_Payment_Breakage set 
							invoiceId = '$newInvoiceIdTypeB', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'E',
							amount ='".$row['downpaymentAmount']."' ";			
				echo  $sqlB;
				$resultB = mysql_query($sqlB);
				echo '</br>';
				echo '</br>';
			}

			
			if ($row['paidInstalments']+1 == $row['noOfInstallment'] ){  // if the number of installment is completed. End the 
																		 //  update the activeFlag to N.
				$sqlU1 = "UPDATE `tblinstallmentmaster` SET activeFlag='N', 
				PaidInstalments = ".($row['paidInstalments']+1)." WHERE id = '".$row['installmenPlanId']."'"; 
                $resultU1 = mysql_query($sqlU1);
				echo $sqlU1;
				echo '</br>';
				echo '</br>';
				
			}
			else{  // If the number of installment is not complete. Increase the No of paid installment counter.
				$sqlU2 = "UPDATE `tblinstallmentmaster` SET  
				PaidInstalments = ".($row['paidInstalments']+1)." WHERE id = '".$row['installmenPlanId']."'"; 
                $resultU2 = mysql_query($sqlU2);
				echo $sqlU2;
				echo '</br>';
				echo '</br>';
				
				
			}
		}
		
		if ($row['installmentActiveFlag'] == NULL && $row['oneTimePaymentFlag'] == 'N' && $typeBAmountEntry ==1){
					$sqlB = "Insert into tbl_Payment_Breakage set 
							invoiceId = '$newInvoiceIdTypeB', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'B',
							amount ='".$deviceAmountDict[$row['deviceAmount']]."' ";			
					echo  $sqlB;
					$resultB = mysql_query($sqlB);
					echo '</br>';
					echo '</br>';
		}
		
		
		// Installment Process Ends  -------------------------------------------------------------------------------------

		//  Add payment breakage data  Ends

	}
?>
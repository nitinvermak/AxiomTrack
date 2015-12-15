<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
//include("../includes/payment_master.php"); 
set_time_limit(0); 
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

if (strlen($intervalMonth)==1){
	$intervalMonthTemp= "0".$intervalMonth;			
}
else{
$intervalMonthTemp = $intervalMonth;	
}

$genDate = $Intervel_Year.'-'.$intervalMonthTemp.'-01';
$dueDate = $Intervel_Year.'-'.$intervalMonthTemp.'-15';
$monthDays=cal_days_in_month(CAL_GREGORIAN,$intervalMonth,$Intervel_Year);

$sql0 = "UPDATE `tblesitmateperiod` SET GeneratedStatus='Y', GeneratedDate = Now() WHERE intervalId = '$interval_Id'"; 
$result = mysql_query($sql0);
$rentFreqId = 1;  //  pass it from the page
//$estimateStatus = generate_estimates($interval_Id,$rentFreqId);
$intervalId = $interval_Id;

    $joinQuery = "
	        SELECT  
			A.id as vehicleId , A.customer_Id  as customerId, B.device_amt as deviceAmount,
			EXTRACT(DAY FROM A.installation_date) AS installation_date,
			EXTRACT(MONTH FROM A.installation_date) AS installation_month,
			EXTRACT(YEAR FROM A.installation_date) AS installation_year,
			A.installation_date AS installation_date_desc,
			B.device_rent_amt as deviceRentAmt ,
			B.installation_charges as  installationCharges,
			B.oneTimePaymentFlag as oneTimePaymentFlag, B.planId as planId, B.instalmentId vehicleInstalmentId,
			B.RentalFrequencyId as rentalFreg,
			B.next_due_date as next_due_date,
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
			
			order by B.cust_Id , B.Vehicle_id
			";
	// this condition removed		
	// and   B.RentalFrequencyId = '$rentFrequencyId'	
	
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
	$skipLastVehicle = 0;
	// Looop start for calculating the payment details 
	
	while ($row = mysql_fetch_array( $stockArr)){
		echo '</br>';
		echo '---------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>processing customer id= '.$row['customerId'];
		echo '</br>';
		echo '---------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>processing vehicle id= '.$row['vehicleId'];
		echo '</br>';
		$loopCounter=$loopCounter+1;
		//$proRataDeviceRentAmt =0;
		$vehicle_installation_date = $row["installation_date"]; // return only the day of the month
		$monthDays=cal_days_in_month(CAL_GREGORIAN,$row["installation_month"],$row["installation_year"]);
		echo '</br>';
		echo '$monthDays='.$monthDays;
		echo '</br>';
		echo '----------------------------------------vehicle_installation_date= '.$row["installation_date_desc"];
		echo '</br>';
		$proRataDeviceRentAmt = 0;
		$deviceRentPayableOneTime = 0;
		$deviceRentPayableGeneral = 0;

 
 
		if ($nextCustomer == -1){  // to get invoice id for the first payment breakage Ids
			$sqlMaxId = "Select Max(invoiceId) as  invoiceId from tbl_invoice_master ";
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
				if ($payableAmountTypeA != 0){
					$sql = "Insert into tbl_invoice_master set 
					intervalId = '$intervalId', customerId ='".$nextCustomer."',
					generateDate = '$genDate' , dueDate = '$dueDate',
					invoiceType = 'A', generatedAmount = '$payableAmountTypeA', taxId = '1', discountedAmount = '0', paidAmount ='0',
					invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
					echo $sql;
					$result = mysql_query($sql);					
					echo '<br>'.mysql_error();
					echo '<br>query result= '.$result;
				}
				
				if($typeBAmountEntry==1 && $payableAmountTypeB !=0){
					echo '</br>';
					echo ' Inserting Type B invoice record 1';
					echo '</br>';
					$sql1 = "Insert into tbl_invoice_master set 
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
			// skip those vehicles whose due date has not arrived (especially for quaterly, Monthly,yearly payment options)
		if (!($row['next_due_date'] == '0000-00-00')){
				
				list($year,$month,$day) = explode('-', $row['next_due_date']);
				if ( !(($year==$Intervel_Year) && ($month==$intervalMonth))){ // Proceed only if the next due month has arrived
					if ($maxRow != $loopCounter){ 
						echo '</br>---------------skipping this vehicle due date not current-------------------'.$row['vehicleId'];
						continue;
					}else{
						$skipLastVehicle =1;
					}
				}		
		}
			 
			// Skip those vehicles whose installation dates is older than the current month for which the invoie is being generated
			// or in future
			echo "<br>row['oneTimePaymentFlag']=".$row['oneTimePaymentFlag'];
			echo "<br>row['installation_year']=".$row['installation_year'];
			echo "<br>Intervel_Year=".$Intervel_Year;
			echo "<br>row['installation_month']=".$row['installation_month'];
			echo "<br>intervalMonth=".$intervalMonth;
			
		if($row['oneTimePaymentFlag'] == 'N'){
				
				if (!(($row['installation_year']==$Intervel_Year) &&($row['installation_month']==$intervalMonth))){
					if ($maxRow != $loopCounter){  
						echo '</br>---------------skipping this vehicle installtion date not current-------------------'.$row['vehicleId'];
						continue;	
					}else{
						$skipLastVehicle = 1;
					}
						
				}
		}	
		
		if($skipLastVehicle == 1){
			echo '<br><br><br>-------------------------------------------------------LAST vehicle skipped---adding invoice -----';
				if ($payableAmountTypeA != 0){
					$sql = "Insert into tbl_invoice_master set 
					intervalId = '$intervalId', customerId ='".$row['customerId']."',
					generateDate = '$genDate' , dueDate = '$dueDate',
					invoiceType = 'A' , generatedAmount = '$payableAmountTypeA', taxId = '1', discountedAmount = '0', 
					paidAmount ='0',
					invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
					
					$result = mysql_query($sql);
					echo $sql;
					$newInvoiceId =  mysql_insert_id();
				}   	
				if($typeBAmountEntry==1 && $payableAmountTypeB!=0){
					echo '</br>';
					echo ' Inserting Type B invoice record 2';
					echo '</br>';
					$sql1 = "Insert into tbl_invoice_master set 
					intervalId = '$intervalId', customerId ='".$row['customerId']."',
					generateDate = '$genDate' , dueDate = '$dueDate',
					invoiceType = 'B', generatedAmount = '$payableAmountTypeB', taxId = '1', discountedAmount = '0', paidAmount ='0',
					invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
					echo $sql1;
					echo '</br>';
					$result = mysql_query($sql1);
					$newInvoiceIdTypeB = mysql_insert_id() ;
				}
			continue;			
		}
		
		echo '</br>';			
		echo 'deviceAmount='.$deviceAmountDict[$row["deviceAmount"]];
		echo '</br>';
		echo 'deviceRentAmt='.$deviceRentAmtDict[$row["deviceRentAmt"]];
		echo '</br>';
		echo 'installationCharges='.$installationChargesDict[$row["installationCharges"]];
		echo '</br>';
		
		
		if ($row['oneTimePaymentFlag'] == 'N'){	
			 
			$payment_duration_start_date=$row['installation_date_desc'];
			if ($row['rentalFreg'] == 1){
				$proRataDeviceRentAmt = $deviceRentAmtDict[$row["deviceRentAmt"]] * 
										($monthDays - $vehicle_installation_date + 1)/$monthDays;
				$deviceRentPayableOneTime = $proRataDeviceRentAmt;
				$nextDueMonth = $intervalMonth + 1;						
			}
			elseif ($row['rentalFreg'] == 2){
				$proRataDeviceRentAmt = $deviceRentAmtDict[$row["deviceRentAmt"]] * 
										($monthDays - $vehicle_installation_date + 1)/$monthDays;
				if ($vehicle_installation_date >20){
					$nextDueMonth = $intervalMonth + 4;	
					$deviceRentPayableOneTime= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 3);
				}
				elseif($vehicle_installation_date <=20){
					$nextDueMonth = $intervalMonth + 3;
					$deviceRentPayableOneTime= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 2);
				} 							
			}
			elseif ($row['rentalFreg'] == 3){
				$proRataDeviceRentAmt = $deviceRentAmtDict[$row["deviceRentAmt"]] * 
										($monthDays - $vehicle_installation_date + 1)/$monthDays;
				$proRataDeviceRentAmt= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 6);
	 
				if ($vehicle_installation_date >20){
					$nextDueMonth = $intervalMonth + 7;
					$deviceRentPayableOneTime= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 6);
				}
				elseif($vehicle_installation_date <=20){
					$nextDueMonth = $intervalMonth + 6;	
					$deviceRentPayableOneTime= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 5);
				}
 				
			}
			elseif ($row['rentalFreg'] == 4){
				$proRataDeviceRentAmt = $deviceRentAmtDict[$row["deviceRentAmt"]] * 
										($monthDays - $vehicle_installation_date + 1)/$monthDays;
				$proRataDeviceRentAmt= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 12);
				
				if ($vehicle_installation_date >20){
					$nextDueMonth = $intervalMonth + 13;
					$deviceRentPayableOneTime= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 12);
				}
				elseif($vehicle_installation_date <=20){
					$nextDueMonth = $intervalMonth + 12;
					$deviceRentPayableOneTime= $proRataDeviceRentAmt + ($deviceRentAmtDict[$row["deviceRentAmt"]] * 11);
				}
				
			
			}
			
			$nextDueYear= $Intervel_Year;
			if ($nextDueMonth > 12){
				$nextDueMonth = $nextDueMonth - 12;
				$nextDueYear = $nextDueYear +1;					
			}
			if (strlen($nextDueMonth)==1){
				$nextDueMonth= "0".$nextDueMonth;				
			}
				
			$nextDueDate=$nextDueYear."-".$nextDueMonth."-01";
			
			
			$payableAmountTypeA  = $payableAmountTypeA +  $proRataDeviceRentAmt +
										$installationChargesDict[$row["installationCharges"]] ; 
			
			$sqlUpd = "UPDATE `tbl_gps_vehicle_payment_master` SET oneTimePaymentFlag='Y',next_due_date ='$nextDueDate' 
					WHERE planId = '".$row['planId']."'"; 
            $resultUpd = mysql_query($sqlUpd);			
			
			echo '</br> one time payment active------------';
			echo '</br> $payableAmountTypeA='.$payableAmountTypeA;
			echo '</br> $proRataDeviceRentAmt='.$proRataDeviceRentAmt;
			echo '</br> $deviceRentPayableOneTime='.$deviceRentPayableOneTime;
			echo '</br> $installationChargesDict='.$installationChargesDict[$row["installationCharges"]];
			echo '</br> $deviceRentAmtDict='.$deviceRentAmtDict[$row["deviceRentAmt"]];
			echo '</br>  rentalFreg '.$row['rentalFreg'];
			echo '</br>'.$sqlUpd;
			
			
		}
		elseif ($row['oneTimePaymentFlag'] == 'Y'){
			$payment_duration_start_date=$row['next_due_date'];
			if ($row['rentalFreg'] == 1){
				$deviceRentPayableGeneral = $deviceRentAmtDict[$row["deviceRentAmt"]] ;								 	 	
				$nextDueMonth = $intervalMonth + 1;	
			}		
			elseif ($row['rentalFreg'] == 2){
				$deviceRentPayableGeneral = $deviceRentAmtDict[$row["deviceRentAmt"]] * 3;
				$nextDueMonth = $intervalMonth + 3;						 							
			}
			elseif ($row['rentalFreg'] == 3){
				$deviceRentPayableGeneral = $deviceRentAmtDict[$row["deviceRentAmt"]] * 6;				 
				$nextDueMonth = $intervalMonth + 6;						 
 			}
			elseif ($row['rentalFreg'] == 4){
				$deviceRentPayableGeneral = $deviceRentAmtDict[$row["deviceRentAmt"]] * 12;			
				$nextDueMonth = $intervalMonth + 12;						 	
			}
			$nextDueYear= $Intervel_Year;
			if ($nextDueMonth > 12){
				$nextDueMonth = $nextDueMonth - 12;
				$nextDueYear = $nextDueYear +1;					
			}
			if (strlen($nextDueMonth)==1){
				$nextDueMonth= "0".$nextDueMonth;				
			}
				
			$nextDueDate=$nextDueYear."-".$nextDueMonth."-01";
			$sqlUpd = "UPDATE `tbl_gps_vehicle_payment_master` SET next_due_date ='$nextDueDate' WHERE planId = '".$row['planId']."'"; 
            $resultUpd = mysql_query($sqlUpd);	
				
			$payableAmountTypeA  = $payableAmountTypeA + $deviceRentPayableGeneral ;
			
			echo '</br> one time payment NOT active++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++';
			echo '</br> $payableAmountTypeA='.$payableAmountTypeA;
			echo '</br> $proRataDeviceRentAmt='.$proRataDeviceRentAmt;
			echo '</br> $deviceRentPayableGeneral='.$deviceRentPayableGeneral;
			echo '</br> $installationChargesDict='.$installationChargesDict[$row["installationCharges"]];
			echo '</br> $deviceRentAmtDict[$row["deviceRentAmt"]='.$deviceRentAmtDict[$row["deviceRentAmt"]];
			echo '</br>  rentalFreg '.$row['rentalFreg'];
			echo '</br>'.$sqlUpd;
			
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
		echo '</br>----------------------------------------------------$nextDueDate========'.$nextDueDate;

		if ($maxRow == $loopCounter){   // Last Record Processing
				echo '</br>';
				echo '-----------------------------Last Record invoice are getting added--------------------------';
				echo '</br>';
				echo '</br>';
				echo ' Inserting Type A invoice record 2';
				echo '</br>';
				if ($payableAmountTypeA != 0){
					$sql = "Insert into tbl_invoice_master set 
					intervalId = '$intervalId', customerId ='".$row['customerId']."',
					generateDate = '$genDate' , dueDate = '$dueDate',
					invoiceType = 'A' , generatedAmount = '$payableAmountTypeA', taxId = '1', discountedAmount = '0', 
					paidAmount ='0',
					invoiceFlag ='N' ,   paymentStatusFlag = 'A'"; 
					
					$result = mysql_query($sql);
					echo '<br>query result= '.$result;
					echo '<br>'.$sql;
					$newInvoiceId =  mysql_insert_id();
				}
			    

				
				if($typeBAmountEntry==1 && $payableAmountTypeB!=0){
					echo '</br>';
					echo ' Inserting Type B invoice record 2';
					echo '</br>';
					$sql1 = "Insert into tbl_invoice_master set 
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

		
		//  Add payment breakage data  Starts	----------------------------------------------------------------------------------
		
		if ($row['oneTimePaymentFlag'] == 'N'){ // this flag takes care of the one time payment
		
			echo '</br>';
			$sqlA = "Insert into tbl_payment_breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'A',
					amount ='".$deviceRentPayableOneTime."' ,
					payment_rate_id ='".$row['deviceRentAmt']."' , 
					start_date = '".$row['installation_date_desc']."',
					end_date='".date( 'Y-m-d', strtotime( $nextDueDate . ' -1 day' ) )."'";  
					 
			echo  $sqlA;
			echo '</br>';
			$resultA = mysql_query($sqlA);
			
			$sqlC = "Insert into tbl_payment_breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'C',
					amount ='".$installationChargesDict[$row['installationCharges']]."' ,
					payment_rate_id ='".$row['installationCharges']."' , 
					start_date = '".$row['installation_date_desc']."',
					end_date='".date( 'Y-m-d', strtotime( $nextDueDate . ' -1 day' ) )."'";  
 
 
			echo  $sqlC;
			$resultC = mysql_query($sqlC);
			echo '</br>';
			
			echo '</br>';
			
			
		}
		elseif ($row['oneTimePaymentFlag'] == 'Y'){ //   After first payment , only rent 
			echo '</br>';			
			$sqlA = "Insert into tbl_payment_breakage set 
					invoiceId = '$newInvoiceId', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'A',
					amount ='".$deviceRentPayableGeneral."',
					payment_rate_id ='".$row['deviceRentAmt']."' , 
					start_date = '".$genDate."',
					end_date='".date( 'Y-m-d', strtotime( $nextDueDate . ' -1 day' ) )."'";  
 
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
				
			$sqlD = "Insert into tbl_payment_breakage set 
			invoiceId = '$newInvoiceIdTypeB', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'D',
			amount ='".$row['installmentAmountID']."' ,
			payment_rate_id ='".$row['deviceAmount']."' , 
			start_date = '".$genDate."',
			end_date= '".date( 'Y-m-d', strtotime( $nextDueDate . ' -1 day' ) )."'";  
		 
			echo  $sqlD;
			echo '</br>';
			$resultD = mysql_query($sqlD);		// installment amount
			
			if($row['oneTimePaymentFlag'] == 'N'){ // down payment
				$sqlB = "Insert into tbl_payment_breakage set 
							invoiceId = '$newInvoiceIdTypeB', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'E',
							amount ='".$row['downpaymentAmount']."' ,
							payment_rate_id ='".$row['deviceAmount']."' , 
							start_date = '".$row['installation_date_desc']."',
							end_date='".date( 'Y-m-d', strtotime( $nextDueDate . ' -1 day' ) )."'";  
							 							
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
					$sqlB = "Insert into tbl_payment_breakage set 
							invoiceId = '$newInvoiceIdTypeB', vehicleId = '".$row['vehicleId']."' ,   typeOfPaymentId = 'B',
							amount ='".$deviceAmountDict[$row['deviceAmount']]."',
							payment_rate_id ='".$row['deviceAmount']."' , 
							start_date = '".$row['installation_date_desc']."',
							end_date='".date( 'Y-m-d', strtotime( $nextDueDate . ' -1 day' ) )."'";  
							
					echo  $sqlB;
					$resultB = mysql_query($sqlB);
					
					echo '</br>';
					echo '</br>';
		}
		
		
		// Installment Process Ends  -------------------------------------------------------------------------------------

		//  Add payment breakage data  Ends

	}
?>
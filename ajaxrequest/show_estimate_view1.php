<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
/*echo $cust_id;*/
error_reporting(0);
if($cust_id != "")
{
	$linkSQL = "select * from tbl_customer_master as A
				inner join tbl_invoice_master as B
				on A.cust_id = B.customerId
				inner Join tblesitmateperiod as C
				on B.intervalId = C.intervalId
				where B.customerId ='$cust_id'
				And (B.invoiceFlag = 'N' or B.invoiceFlag = 'P') 
				
				order by invoiceId";
				// And B.paymentStatusFlag = 'A'
    //echo $linkSQL;				
}
else {

	$linkSQL = "select * from tbl_customer_master as A
				inner join tbl_invoice_master as B
				on A.cust_id = B.customerId
				inner Join tblesitmateperiod as C
				on B.intervalId = C.intervalId
				where (B.invoiceFlag = 'N' or B.invoiceFlag = 'P')
				order by invoiceId";
				// And B.invoiceFlag <> 'D'
				// B.paymentStatusFlag = 'A'
				// And 
}
$oRS = mysql_query($linkSQL);

// echo 	'<div style="margin-bottom: 20px;">
// 		<button type="button" id="create_manually_invoice" id="create_manually_invoice"  
// 		class="btn btn-warning btn-sm" data-toggle="modal" data-target=".bs-example-modal-lg"
// 		onclick="generate_manually_invoice('.$cust_id.')">
// 			Create Manually Invoice
// 		</button>
// 		<button type="button" id="create_manually_invoice" id="create_manually_invoice"  
// 			class="btn btn-success btn-sm" 
// 			onclick="re_generate_manually_estimate('.$cust_id.')">
// 				Re-Generate Estimate Manually  
// 		</button>
// 	    </div>	';

	if(mysql_num_rows($oRS)>0){
?>
	
		<table border="0" class="table table-hover table-bordered" id="example"> 
		 <thead>
		 	<tr>
		      	<th><small>S.No.</small></th>  
		        <th><small>Estimate Id</small></th>  
				<th><small>Estimate Type</small></th>
		      	<th><small>Customer Name</small></th>  
		      	<th><small>Generated Date</small></th>
		        <th><small>Due Date</small></th>
		        <th><small>Period</small></th>
		      	<th><small>Generated Amount</small></th> 
		        <th><small>Discount Amount</small></th> 
		        <th><small>Payble Amount</small></th> 
		        <th><small>Payment Details</small></th>
		        <!-- <th><small>Action</small></th> -->
				<th><small>Make Payment</small></th>
				<th><small>Download Invoice</small></th>
	      	</tr>  
		 </thead>  
		 <tbody>
        <?php
		$kolor=1;
	 	if(mysql_num_rows($oRS)>0)
	  		{
  				while ($row = mysql_fetch_array($oRS)){
 	  	?>
 	  	
        <tr <?php print $class; ?>  >
      	<td><small><?php print $kolor++;?>.</small></td>
	  	<td><small><?php echo stripslashes($row["invoiceId"]);?>
	  				<input type="hidden" name="invoiceId" class="invoiceId" id="invoiceId" value="<?php echo stripslashes($row["invoiceId"]);?>" />
	  				<input type="hidden" name="intervalId" id="intervalId" class="intervalId" value="<?php echo $row['intervalId'];?>">
	  	</small></td>
      	<td><small>
		  <?php if ($row["invoiceType"] == "A"){ echo 'Rental';} elseif($row["invoiceType"] == "B") { echo 'Device';}  ?>
        </small>
        </td>
		<td><small><?php $orgName =  getOraganization(stripslashes($row["callingdata_id"])); echo $orgName;  ?></small></td>
      	<td><small><?php echo date("d-m-Y", strtotime(stripslashes($row["generateDate"])));?> </small></td>
        <td class="<?php if(strtotime($row["dueDate"]) < strtotime(date("Y-m-d"))) echo 'datecolor' ?>">
        <small><?php echo date("d-m-Y", strtotime(stripslashes($row["dueDate"]))); ?></small></td>
        <td><small><strong>From:</strong> 
        	<?php echo date("d-m-Y", strtotime(payment_from($row["invoiceId"])));?> 
        	<strong>To:</strong> 
        	<?php echo date("d-m-Y", strtotime(payment_to($row["invoiceId"])));?>
        	</small></td>
        <td><small><?php echo stripslashes($row["generatedAmount"]);?></small></td>
        <td><small><?php if($row["discountedAmount"]==0)
					{
						echo "N/A";
					}
				  else
					{
						echo stripcslashes($row["discountedAmount"]);	
					}
			?>
			     
				<input type="hidden" name="interval_Id" class="interval_Id" id="interval_Id_<?php echo $row["invoiceId"];?>" 
				value="<?php echo $row['intervalId']; ?>">

				<input type="hidden" name="intervalMonth" class="intervalMonth" id="intervalMonth_<?php echo $row["invoiceId"];?>" 
				value="<?php echo $row['intervalMonth']; ?>">

				<input type="hidden" name="Intervel_Year" class="Intervel_Year" id="Intervel_Year_<?php echo $row["invoiceId"];?>" 
				value="<?php echo $row['IntervelYear']; ?>">

				<input type="hidden" name="customer_id" class="customer_id" id="customer_id_<?php echo $row["invoiceId"];?>" 
				value="<?php echo $row['cust_id']; ?>">
				 
			
			</small>
		</td>
		<td><small><?php echo $row["generatedAmount"] -  $row["discountedAmount"]; ?></small></td>
        <td><strong>
         
        
        <button type="button" data-toggle="modal" data-target=".bs-example-modal-lg<?php echo stripslashes($row["invoiceId"]);?>" class="btn btn-info btn-sm">Details</button></strong>
        <!--Modal-->
        <!--<a data-toggle="modal" data-target=".bs-example-modal-lg">Large modal</a>-->
<!-- Make payement modal -->
        <div class="modal fade bs-example-modal-lg<?php echo stripslashes($row["invoiceId"]);?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 >Payment Details</h4>
                </div>
                <div class="modal-body">
                <div class="table-responsive">
                	<div class="col-md-12">
		    			<div class="download pull-right">
		    				<a href="#" id="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
		    		    </div>
		    	    </div>
		    	    <div id="dvData">
                    <table class="table table-hover table-bordered ">
				      <?php
						$where='';
						$linkSQL="";
						$invoiceId = $row["invoiceId"];
						/*echo $invoiceId;*/			
				 		$planRateQuery= "Select id, planSubCategory, plan_rate from tblplan 
										 where productCategoryId = 4  and (planSubCategory = 1 or planSubCategory = 2 
										 or planSubCategory = 3)";
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
				     	$linkSQL1 = "select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, 
				     				C.amount as amt, C.vehicleId  as vId, C.start_date as startDate, 
				     				C.end_date as endDate, B.customer_Id as custId, 
				     				C.payment_rate_id as plan_rate_id					 
									from tbl_payment_breakage as C 
									left outer join tbl_gps_vehicle_master as B  
									On C.vehicleId = B.id					
									where C.invoiceId= '$invoiceId'
									order by   C.vehicleId, C.typeOfPaymentId";
						$oRS1 = mysql_query($linkSQL1); 
						//echo $linkSQL1;
						//echo 'num='.mysql_num_rows($oRS1);
				 		?>
				  
					  <?php
					  $kolor1=1;
					  if(mysql_num_rows($oRS1)>0)
					  	{   $vehicleId = -1;
						    $initialFlag = -1; 
							$counter =1;
							$rowCounter = 0;
							$maxRow = mysql_num_rows($oRS1);
							$vehicleTotal =0;
							$orgTotal=0;
				  			while ($row1 = mysql_fetch_array($oRS1))
				  			{  	
								
								 ++$rowCounter;
				  				 if ($vehicleId != $row1['vId'] && $initialFlag == -1 ){
								 //echo '-----first-----';
									 $typeA=' ';
									 $typeB=' ';
									 $typeC=' ';
									 $typeD=' ';
									 $typeE=' ';		 
									 $initialFlag = 0;
									 /*$vehicleReg=  stripslashes($row1["vehicleNo"]);*/
									 $vehicleId = $row1['vId'];
									 $static_vehicle_id  = $row1['vId'];
									 // show table header
									 echo '
										   <tr>';
									 echo '<th><small>S. No.</small></th>';
									 echo '<th><small>Vehile Reg. No.</small></th>';
									 
									 
									 if($row['invoiceType'] == 'A')
									 {
									 	echo '<th><small>Monthly Rent</small></th>';
										echo '<th><small>Rent</small></th>';
										echo '<th><small>Installation Charges</small></th>';
									 }

									 if($row['invoiceType'] == 'B')
									 {
										echo '<th><small>Device Amount</small></th>';
										echo '<th><small>Installment Amount</small></th>';
										echo '<th><small>DownPayment Amount</small></th>';
									 }
									 echo '<th><small>Start Date</small></th>';
									 echo '<th><small>End Date</small></th>';
									 echo '<th><small>Total Amount</small></th> ';
									 echo '</tr>
										  ';
								// end table header
								}
								//echo '</br>';
								//echo $vehicleId;
								//echo '</br>';
								//echo $row1['vId'];
								//echo '</br>';
								//echo '$rowCounter='.$rowCounter;
								

								
											
							
								
								if ($static_vehicle_id  != $row1['vId']  ){
								//echo 'asas';
								//echo '$counter='.$counter;
								//echo '$maxRow ='.$maxRow;
									
								    echo '<tr>';
									echo '<td><small>'.$counter.'</small></td>';
									echo '<td><small>'.$static_vehicle_no.'<input type="hidden" value="'.$static_vehicle_id .'" 
											class="vehicleId" id="vehicleId">
											<input type="hidden" value="'.$static_cust_id.'" class="custId" id="custId">
											
											</small>
										  </td>';
									
									if($row['invoiceType'] == 'A'){
										echo '<td><small>'.$deviceRentAmtDict[$row1["plan_rate_id"] ].'</small></td>';
										echo '<td><small>'.$typeA.'</small></td>';
										echo '<td><small>'.$typeC.'</small></td>';								
									}
									
									if($row['invoiceType'] == 'B'){				 
				 						echo '<td><small>'.$typeB.'</small></td>';
										echo '<td><small>'.$typeD.'</small></td>';
										echo '<td><small>'.$typeE.'</small></td>';
								    }
									echo '<td><small>'.date("d-m-Y", strtotime($static_start_date)).'</small></td>';
									echo '<td><small>'.date("d-m-Y", strtotime($static_end_date)).'</small></td>';
									echo '<td><small>'.$vehicleTotal.'</small></td>';
									echo '</tr>';
									$vehicleId=   $row1["vId"];
									++$counter; 
									$typeA=' ';
								 	$typeB=' ';
								 	$typeC=' ';
								 	$typeD=' ';
								 	$typeE=' ';	
									$orgTotal = $orgTotal + $vehicleTotal;
									$vehicleTotal =0;
								
								}
								
								switch($row1['paymentType']){
									case 'A':
									$typeA = $row1['amt'];
									$vehicleTotal = $vehicleTotal + $typeA;	
									break;
									case 'B':
									$typeB = $row1['amt'];
									$vehicleTotal = $vehicleTotal + $typeB;	
									break;
									case 'C':
									$typeC = $row1['amt'];
									$vehicleTotal = $vehicleTotal + $typeC;	
									break;
									case 'D':
									$typeD = $row1['amt'];
									$vehicleTotal = $vehicleTotal + $typeD;	
									break;
									case 'E':
									$typeE = $row1['amt'];
									$vehicleTotal = $vehicleTotal + $typeE;	
									break;
								}
								
								
								$static_vehicle_id =    $row1["vId"];
								$static_vehicle_no =	$row1["vehicleNo"] ;
								$static_cust_id    =    $row1['custId'];
                                $static_start_date =    $row1['startDate'] ;
								$static_end_date   =    $row1['endDate'];
						 

								
				   				if($maxRow == $rowCounter){ 
								   // echo 'last record';
						            echo '<tr>';
									echo '<td><small>'.$counter.'</small></td>';
									echo '<td><small>'.$row1["vehicleNo"].'</small></td>';
									if($row['invoiceType'] == 'A'){
										echo '<td><small>'.$deviceRentAmtDict[$row1["plan_rate_id"] ].'</small></td>';
										echo '<td><small>'.$typeA.'</small></td>';
										echo '<td><small>'.$typeC.'</small></td>';								
									}
									
									if($row['invoiceType'] == 'B'){				   
				 						echo '<td><small>'.$typeB.'</small></td>';
										echo '<td><small>'.$typeD.'</small></td>';
										echo '<td><small>'.$typeE.'</small></td>';
								    }
									echo '<td><small>'.date("d-m-Y", strtotime($row1['startDate'])).'</small></td>';
									echo '<td><small>'.date("d-m-Y", strtotime($row1['endDate'])).'</small></td>';
									echo '<td><small>'.$vehicleTotal.'</small></td>';
									/*echo '<td><small>'.$vehicleTotal.'</small></td>';
									echo '<td><small>'.$vehicleTotal.'</small></td>';*/
									echo '</tr>';
									$orgTotal = $orgTotal + $vehicleTotal;
								}
				 	  ?>

					<?php 
				    	}
						 
				    }
				    ?>
				    <tr>
					<td></td>
				    <?php
					if($typeA > 0)
					{
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
					}
					if($typeB > 0)
					{
						echo "<td></td>";
					}
					if($typeC > 0)
					{
				    	echo "<td></td>";
					}
					if($typeD >0)
					{
				    echo "<td></td>";
					}
					if($typeE >0)
					{
				    echo "<td></td>";
					}
					?>
				    <td><p class="pull-right"><strong>Total Amount</strong></p></td>
				    <td><p class="pull-right"><strong>
				    	<?php 
				 
							echo 'RS.'.$orgTotal;
							echo "<input type='hidden' name='total$invoiceId' id='total$invoiceId' value='$orgTotal'>";
						?>
						</strong></p>
				    </td>
				   
				    </tr>
				    <tr>
				    <td></td>
					 <?php
					if($typeA > 0)
					{
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
					}
					if($typeB > 0)
					{
						echo "<td></td>";
					}
					if($typeC > 0)
					{
				    	echo "<td></td>";
					}
					if($typeD >0)
					{
				    echo "<td></td>";
					}
					if($typeE >0)
					{
				    echo "<td></td>";
					}
					?>
				    <td><p class="pull-right"><strong>Discount</strong></td>
				    <td><p class="pull-right"><strong>
				        	<?php 
				 
							echo $row["discountedAmount"];
						    ?>
						</strong></p>
				    </td>
				    </tr>
				    <td></td>
					 <?php
					if($typeA > 0)
					{
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
						echo "<td></td>";
					}
					if($typeB > 0)
					{
						echo "<td></td>";
					}
					if($typeC > 0)
					{
				    	echo "<td></td>";
					}
					if($typeD >0)
					{
				    echo "<td></td>";
					}
					if($typeE >0)
					{
				    echo "<td></td>";
					}
					?>
				    <td><p class="pull-right"><strong>Grand Total</strong></td>
				    <td><p class="pull-right"><strong>
				    	<?php 
				 
							echo 'RS.'.( $orgTotal - $row["discountedAmount"] );
						?>
						</strong></p>
					</td>
				    </tr>
				    </table>
				    <div>
				    <table cellspacing="10">
				    <tr>
				    <td>Provide Discount</td>
				    <td>
				    <select name="discountAmt" id="discountAmt<?php echo $invoiceId; ?>" class="form-control drop_down" onchange=showData1(<?php echo $invoiceId; ?>)>
				    	<option value="0">Select</option>
				    	<option value="Rs">RS</option>
				    	<option value="Percentage">Percentage</option>
				    </select>

				    </td>
				    <td>
				     <input type='text' name='Percentage' id='Percentage<?php echo $invoiceId; ?>' 
				       class='form-control text_box' style="display: none;"
				       onkeyup="calPercent(<?php echo $invoiceId; ?>)"
				     placeholder="Percentage"
				     >
				     Rs.<input type='text' name='rupee' id='rupee<?php echo $invoiceId; ?>' class='form-control text_box'>

				    </td>
				    <td>
				    <input type="button" value="Go" class="btn btn-primary btn-sm" id="go" onclick="addPercent(<?php echo $invoiceId; ?>)" 
				    name="go">
				    </td>
				    </tr>
				    </table>
				    </div>
				    </div>
				    </div>
                </div>
            </div>
          </div>
        </div>
        <!-- End  Make Payment modal-->
        </td>
	    <td>
				<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-content-payment"    
				onclick="getValue( <?php echo "'".$orgName."','".stripslashes($row["Intervalname"])."',".stripslashes($row["invoiceId"]).",".
				stripslashes($row["generatedAmount"]).",".stripslashes($row["discountedAmount"]).",".
				stripslashes($row["paidAmount"]).",".$row["IntervelYear"]; ?> )">
				Make Payment</button>
		</td>
      	<td><a href="generate_invoice.php?est=<?= $row["invoiceId"] ?>&token=<?= $token; ?>" target="_blank" class="btn btn-success btn-sm">Download</a></td>
		</tr>
        <?php 
           	}
            echo '</tbody>
				</table>';
          }
        }
	 else
       echo "<h3><font color=red>No records found !</h3></font>";

   
   
//------------------------------------------------------------------------------------------------------------------------------------------
   
    //echo '----------------------Partial Payment estimate';

	  
	
	
	
echo '
	<div class="modal fade   in" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id ="modal-content-payment"   ">
          <div class="modal-dialog modal-lg">
            <div class="modal-content modal-content-payment">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                <h4>Payment Details</h4>
                </div>
                <div class="modal-body">
        
				</div>
                </div>
            </div>
          </div>
        </div>

';	
	
	
	

	
	
	
	
	
	//-------- partial payment ends
		
 ?>

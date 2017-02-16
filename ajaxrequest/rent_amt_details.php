<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$invoiceId = mysql_real_escape_string($_POST['invoiceId']);
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 >Payment Details</h4>
</div>
<div class="modal-body">
	<div id="dvMsg1"></div>
	<table class="table table-hover table-bordered ">
    <?php			
 	$linkSQL1 = "select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, C.amount as amt,		         C.vehicleId  as vId, C.start_date as startDate, C.end_date as endDate					 
				 from tbl_payment_breakage as C 
				 left outer join tbl_gps_vehicle_master as B  
				 On C.vehicleId = B.id					
				 where C.invoiceId= '$invoiceId'
				 order by C.vehicleId, C.typeOfPaymentId";
	$oRS1 = mysql_query($linkSQL1); 
	?>
    <?php
	$kolor1=1;
	if(mysql_num_rows($oRS1)>0){   
		$vehicleId = -1;
		$initialFlag = -1; 
		$counter =1;
		$rowCounter = 0;
		$maxRow = mysql_num_rows($oRS1);
		$vehicleTotal =0;
		$orgTotal=0;
  		while ($row1 = mysql_fetch_array($oRS1)){  	
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
				 // show table header
				 echo '<thead>
					   <tr>';
				 echo '<th><small>S. No.</small></th>';
				 echo '<th><small>Vehile Reg. No.</small></th>';
				 
				 
				 if($row['invoiceType'] == 'A')
				 {
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
					  </thead>';
				// end table header
				}
				//echo '</br>';
				//echo $vehicleId;
				//echo '</br>';
				//echo $row1['vId'];
				//echo '</br>';
				//echo '$rowCounter='.$rowCounter;
				
				
				if ($vehicleId != $row1['vId'] ){
				//echo 'asas';
				//echo '$counter='.$counter;
				//echo '$maxRow ='.$maxRow;
					
				    echo '<tr>';
					echo '<td><small>'.$counter.'</small></td>';
					echo '<td><small>'.$row1["vehicleNo"].'</small></td>';
					
					if($row['invoiceType'] == 'A'){
						echo '<td><small>'.$typeA.'</small></td>';
						echo '<td><small>'.$typeC.'</small></td>';								
					}
					
					if($row['invoiceType'] == 'B'){				 
 						echo '<td><small>'.$typeB.'</small></td>';
						echo '<td><small>'.$typeD.'</small></td>';
						echo '<td><small>'.$typeE.'</small></td>';
				    }
					echo '<td><small>'.$row1['startDate'].'</small></td>';
					echo '<td><small>'.$row1['endDate'].'</small></td>';
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
				
				switch($row1['paymentType'])
				{
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
				
   				if($maxRow == $rowCounter){
				   // echo 'last record';
		            echo '<tr>';
					echo '<td><small>'.$counter.'</small></td>';
					echo '<td><small>'.$row1["vehicleNo"].'</small></td>';
					if($row['invoiceType'] == 'A'){
						echo '<td><small>'.$typeA.'</small></td>';
						echo '<td><small>'.$typeC.'</small></td>';								
					}
					
					if($row['invoiceType'] == 'B'){				   
 						echo '<td><small>'.$typeB.'</small></td>';
						echo '<td><small>'.$typeD.'</small></td>';
						echo '<td><small>'.$typeE.'</small></td>';
				    }
					echo '<td><small>'.$row1['startDate'].'</small></td>';
					echo '<td><small>'.$row1['endDate'].'</small></td>';
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
    <td>
    	<?php 
 
			echo 'RS.'.$orgTotal;
			echo "<input type='hidden' name='total$invoiceId' id='total$invoiceId' value='$orgTotal'>";
		?>
    </td>
   
    </tr>
    <tr>
    <td></td>
	 <?php
	if($typeA > 0)
	{
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
    <td>
        	<?php 
			echo $row["discountedAmount"];
		    ?>


    </td>
    </tr>
    <td></td>
	 <?php
	if($typeA > 0)
	{
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
    <td>
    	<?php 
 
			echo 'RS.'.( $orgTotal - $row["discountedAmount"] );
		?>
	</td>
    </tr>
    </table>
    <div class="col-lg-12" style="padding-bottom: 10px; padding-top: 10px;">
    	<form class="form-inline">
		  <div class="form-group">
		    <label for="Provide Discount">Provide Discount</label>
		    <select name="discountAmt" id="discountAmt<?php echo $invoiceId; ?>" class="form-control drop_down" onchange=showData1(<?php echo $invoiceId; ?>)>
		    	<option value="0">Select</option>
		    	<option value="Rs">RS</option>
		    	<option value="Percentage">Percentage</option>
		    </select>
		  </div>
		  <div class="form-group">
		  	<input type='text' name='Percentage' id='Percentage<?php echo $invoiceId; ?>' 
		       class='form-control text_box' style="display: none;"
		       onkeyup="calPercent(<?php echo $invoiceId; ?>)"
		     placeholder="Percentage">
		    <label for="rs">Rs</label>
		    <input type='text' name='rupee' id='rupee<?php echo $invoiceId; ?>' class='form-control text_box'>
		  </div>
		  <input type="button" value="Go" class="btn btn-primary btn-sm" id="go" onclick="addPercent(<?php echo $invoiceId; ?>)" 
    name="go">
		</form>
    </div> <!-- end col-lg-12 -->
    <div class="clearfix"></div>
</div> <!-- end body -->
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
</div>

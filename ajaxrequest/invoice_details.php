<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
/*echo $cust_id;*/
error_reporting(0);
if($cust_id != "")
{
		$linkSQL = "Select A.invoiceId as invoiceId, A.invoiceType as invoiceType, B.paymentID as paymentId, 
					A.customerId as customerId, A.generatedAmount as Amount, 
					A.generateDate as generateDate, A.dueDate as dueDate, 
					A.discountedAmount as discount, F.callingdata_id as callingdateId, 
					E.RecivedDate as rcdDate
					from tbl_invoice_master as A
					left outer Join tblpaymentinvoicemap as B 
					On A.invoiceId = B.invoiceId
					left outer join paymentcheque as C 
					On B.paymentId = C.id
					left outer join paymentonlinetransfer as D 
					On C.id = D.id
					left outer Join paymentmethoddetailsmaster as E 
					on D.id = E.paymentId 
					left outer join tbl_customer_master as F
					On A.customerId = F.cust_id
					where A.invoiceFlag ='Y' and A.customerId = '$cust_id' order by Amount";
		/*echo $linkSQL;*/
		$oRS = mysql_query($linkSQL);
		if(mysql_num_rows($oRS)>0)
			{
				echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
		<tr>
       
      	<th><small>S.No.</small></th>  
        <th><small>Invoice Id</small></th>  
        <th><small>Invoice Type </small></th>
		<th><small>Payment Id</small></th>
      	<th><small>Customer Name</small></th>  
      	<th><small>Generated Amount</small></th>
		<th><small>Received Date</small></th>
        <th><small>Generated Date</small></th>
      	<th><small>Due Date</small></th> 
        <th><small>Discount Amount</small></th>
        <th><small>Details</small></th> 
      	</tr>    
        <?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page']))
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']==1)
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']>1)
			{
				$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
			}
	 	if(mysql_num_rows($oRS)>0)
	  		{
  				while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  	?>
        <tr <?php print $class?>>
      	<td><small><?php print $kolor++;?>.</small></td>
	  	<td><small><?php echo stripslashes($row["invoiceId"]);?></small></td>
        <td><small><?php if ($row["invoiceType"] == "A"){ echo 'Rental';} elseif($row["invoiceType"] == "B") { echo 'Device';}  ?></small></td>
      	<td><small><?php echo stripslashes($row["paymentId"]);?><input type="hidden" name="paymentId" id="paymentId" value="<?php echo stripslashes($row["paymentId"]);?>" /></small></td>
		<td><small><?php echo getOraganization(stripcslashes($row['callingdateId'])); ?></small></td>
      	<td><small><?php echo stripslashes($row["Amount"]);?> </small></td>
		<td><small><?php echo $row['rcdDate'] ?></small></td>
        <td><small><?php echo stripslashes($row["generateDate"]); ?></small></td>
		
        <td><small><?php echo stripslashes($row["dueDate"]);?></small></td>
        <td><small><?php echo stripcslashes($row["discount"]); ?></small></td>
        <td><button type="button" data-toggle="modal" data-target=".bs-example-modal-lg1<?php echo stripslashes($row["paymentId"]);?>" class="btn btn-info btn-sm">Details</button>
        <!-- Make payement modal -->
        <div class="modal fade bs-example-modal-lg1<?php echo stripslashes($row["paymentId"]);?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 >Payment Details</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-hover table-bordered ">
      <?php
		$where='';
		$linkSQL="";
		$invoiceId = $row["invoiceId"];
		/*echo $invoiceId;*/			
 		
     	$linkSQL1 = "select B.vehicle_no as vehicleNo, C.typeOfPaymentId as paymentType, C.amount as amt,		                    C.vehicleId  as vId					 
					from  
					tbl_payment_breakage as C left outer join
					tbl_gps_vehicle_master as B  
					On C.vehicleId = B.id					
					where C.invoiceId= '$invoiceId'
					order by   C.vehicleId, C.typeOfPaymentId";
		$oRS1 = mysql_query($linkSQL1); 
		//echo 'num='.mysql_num_rows($oRS1);
 		?>
     <!-- <thead>
      <tr>
      <th><small>S. No.</small></th>
      <th><small>Vehile Reg. No.</small></th>
      <th><small>Rent</small></th>
      <th><small>Device Amount</small></th>
      <th><small>Installation Charges</small></th> 
      <th><small>Installment Amount</small></th>
	  <th><small>DownPayment Amount</small></th>
      <th><small>Total Amount</small></th> 
      </tr>    
      </thead>-->
  
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
					
					echo '<td><small>'.$vehicleTotal.'</small></td>';
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
    <td></td>
    <?php
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
	<td></td>
	<?php
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
    <td></td>
	<?php	
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
                </div>
            </div>
          </div>
        </div>
        <!-- End  Make Payment modal-->
        </td>
        
      	</tr>
        <?php 
           	}
             	echo $pagerstring;
          }
        }
	 else
       echo "<tr><td colspan=6 align=center><h3><font color=red>No records found !</h3></font></td><tr/></table>";
	}
else
{
	echo "<script> alert('Please Provide Search Criteria'); </script>";
}
 ?>

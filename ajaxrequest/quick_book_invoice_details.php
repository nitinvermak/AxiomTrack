<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$confirmationStatus = mysql_real_escape_string($_POST['confirmationStatus']);
$depositStatus = mysql_real_escape_string($_POST['depositStatus']);
$clearanceStatus = mysql_real_escape_string($_POST['clearanceStatus']);
/*echo $confirmationStatus;*/
error_reporting(0);
$linkSQL = "SELECT B.PaymentID as paymentId, C.callingdata_id as callingDataId, 
			A.chequeAmount as chequeAmt, A.Bank as bankId, A.ChequeNo as chequeNo, 
			B.status as confirmationStatus, B.paymentConfirmBy as confrmBy, 
			A.bankDepositDate as depositDate, A.DepositStatus as DepositStatus,
			A.ClearStatus as clearStatus, B.Remarks as remarks, B.adjustmentAmt as adjustmentAmt,
			B.RecivedDate as rcdDate, A.chequeClearDate chequeClearDate, A.ChequeDate as ChequeDate,
			B.userId as userId
			FROM quickbookpaymentcheque as A 
			INNER JOIN quickbookpaymentmethoddetailsmaster as B 
			ON A.Id = B.ChequeID
			INNER JOIN tbl_customer_master as C 
			ON B.customerId = C.cust_id";
	// echo $linkSQL;
if ( ($confirmationStatus != NULL) or ( $date !='' and $dateto !='') or ($depositStatus != NULL) or ($clearanceStatus != "") )
	{
		$linkSQL  = $linkSQL." WHERE ";	
	}
$counter = 0;
if($confirmationStatus != NULL)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.status = '$confirmationStatus'" ;
		$counter+=1;
		// echo $linkSQL;
	}
if ( $date !='' and $dateto !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(B.RecivedDate) BETWEEN '$date' AND '$dateto' ";
	$counter+=1;
	// echo $linkSQL;
}
if($depositStatus != NULL)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.DepositStatus = '$depositStatus'" ;
		$counter+=1;
		// echo $linkSQL;
	}
if($clearanceStatus != "")
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.ClearStatus = '$clearanceStatus'" ;
		$counter+=1;
		// // echo $linkSQL;
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '<table border="0" id="example" class="table table-hover table-bordered">  ';
?>		
			<thead>
				<tr>
	  			<th><small>S. No.</small></th>     
	  			<th><small>Payment ID</small></th>  
              	<th><small>Organization Name</small></th>
              	<th><small>Cheque Amt.</small></th>
              	<th><small>Bank</small></th>   
              	<th><small>Cheque No.</small></th> 
              	<th><small>Cheque Date</small></th>
                <th><small>Remarks</small></th>
                <th><small>Confirmation Status</small></th> 
                <th><small>Confirm By</small></th>
                <th><small>Recieved Date</small></th>
              	<th><small>Deposit Date</small></th> 
              	<th><small>Clear Date</small></th>
              	<th><small>Clearance Status</small></th> 
                <th><small>Adjustment Status</small></th> 
                <th><small>Punch By</small></th>                          
              	</tr>
            </thead>
            <tbody>
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
					
				if(mysql_num_rows($stockArr)>0)
					{
						while ($row = mysql_fetch_array($stockArr))
					  	{
						  if($kolor%2==0)
							$class="bgcolor='#ffffff'";
							else
							$class="bgcolor='#fff'";
				?>   
	            <tr <?php print $class?>>
                <td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo stripslashes($row["paymentId"]);?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["callingDataId"]));?></small></td>
                <td><small><?php echo stripslashes($row["chequeAmt"]); ?></small></td>
                <td><small><?php echo getBankName(stripslashes($row["bankId"]));?></small></td>
                <td><small><?php echo stripslashes($row["chequeNo"]);?></small></td>
                <td><small><?php echo stripslashes($row["ChequeDate"]);?></small></td>
                <td><small><?php echo CheckValue($row['remarks']); ?></small></td>
                <td><small><?php getConfirmation($row["confirmationStatus"]); ?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["confrmBy"]));?></small></td>
                <td><small><?php echo stripcslashes($row["rcdDate"]);?></small></td>
                <td><small><?php echo stripcslashes($row["depositDate"]);?></small></td>
                <td><small><?php echo stripcslashes($row["chequeClearDate"]);?></small></td>
                <td><small><?php echo getClearStatus($row["clearStatus"]); ?></small></td>
                <td><small><?php echo getAdjustment($row['adjustmentAmt']); ?></small></td>
                <td><small><?php echo gettelecallername($row['userId']); ?></small></td>
                </tr> 
                <?php 
                		}
                echo '</tbody></table>';
                
                  }
                   
			}
			else
                   echo "<h3><font color=red>No records found !</h3></font>";
                ?>
              
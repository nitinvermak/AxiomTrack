<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$neftDateForm = mysql_real_escape_string($_POST['neftDateForm']);
$neftDateTo = mysql_real_escape_string($_POST['neftDateTo']);
$neftConfirmationStatus = mysql_real_escape_string($_POST['neftConfirmationStatus']);
// echo $neftDateForm;
// echo $neftDateTo;
// echo $neftConfirmationStatus;
// exit();
error_reporting(0);
$linkSQL = "SELECT B.PaymentID as paymentId, C.callingdata_id as callingDateId, 
			B.paymentConfirmBy as confirmBy, B.RecivedDate as recivedDate, 
			A.onlineAmount as onlineAmt, A.RefNo as refNo, B.adjustmentAmt as adjustmentAmt,
			B.userId as userId, C.cust_id as custId
			FROM quickbookpaymentonlinetransfer as A 
			Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
			ON A.Id = B.OnlineTransferId 
			Left Outer JOIN tbl_customer_master as C 
			ON B.customerId = C.cust_id ";
// echo $linkSQL;
if ( ($neftConfirmationStatus != NULL) or ( $neftDateForm !='' and $neftDateTo !='') )
	{
		$linkSQL  = $linkSQL." Where ";	
	}
$counter = 0;
if($neftConfirmationStatus != NULL)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.status = '$neftConfirmationStatus'" ;
		$counter+=1;
		// echo $linkSQL;
	}
if ( $neftDateForm !='' and $neftDateTo !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(B.RecivedDate) BETWEEN '$neftDateForm' AND '$neftDateTo' ";
	$counter+=1;
	// echo $linkSQL;
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
	  			<th><small>Customer Id</small></th>
              	<th><small>Organization Name</small></th>
                <th><small>Ref. No.</small></th>
              	<th><small>Online Amt.</small></th>
                <th><small>Confirmation Status</small></th> 
                <th><small>Confirm By</small></th>
              	<th><small>Recive Date</small></th>                             
                <th><small>Adjustment Amt. </small></th>
                <th><small>Punch By</small></th>
              	</tr>
            </thead>
            <tbody>
                <?php
				$kolor=1;
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
                <td><small><?= $row['custId']; ?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["callingDateId"]));?></small></td>
                <td><small><?php echo stripslashes($row["refNo"]); ?></small></td>
                <td><small><?php echo stripslashes($row["onlineAmt"]); ?></small></td>
                <td><small><?php echo getConfirmation($row["confirmationStatus"]); ?></small></td>
                <td><small><?php echo gettelecallername(stripslashes($row["confirmBy"]));?></small></td>
                <td><small><?php echo stripcslashes($row["recivedDate"]);?></small></td>
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
              
<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$organization = mysql_real_escape_string($_POST['organization']);
$paymentId = mysql_real_escape_string($_POST['paymentId']);
error_reporting(0);
$linkSQL = "SELECT A.PaymentID as paymentId, A.customerId as customerId,
			A.CashAmount as cashAmt, C.onlineAmount as onlineAmt, B.ChequeNo as chequeNo, 
			B.Bank as bankname, B.chequeAmount as chequeAmt, A.Remarks as remark, A.RecivedDate as rcdDate,
			D.callingdata_id as callindataId, B.Id as chequeId, A.OnlineTransferId as neftId
			FROM quickbookpaymentmethoddetailsmaster as A 
			LEFT OUTER JOIN quickbookpaymentcheque as B 
			ON A.ChequeID = B.Id
			LEFT OUTER JOIN quickbookpaymentonlinetransfer as C 
			ON A.OnlineTransferId = C.Id
			INNER JOIN tbl_customer_master as D 
			ON A.customerId = D.cust_id";
	// echo $linkSQL;
if ( ($organization != '') or ($paymentId != '') )
	{
		$linkSQL  = $linkSQL." WHERE ";	
	}
$counter = 0;
if($organization != '')
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.customerId = '$organization'" ;
		$counter+=1;
		// echo $linkSQL;
	}
if($paymentId != '')
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.PaymentID = '$paymentId'" ;
		$counter+=1;
		// echo $linkSQL;
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0){
	echo '  <table border="0" id="example" class="table table-hover table-bordered">  ';
	 	echo "<thead>";

?>		
				<tr>
		  			<th><small>S. No.</small></th>     
		  			<th><small>Payment ID</small></th>  
	              	<th><small>Organization Name</small></th>
	                <th><small>Payment Type</small></th>
	                <th><small>Bank</small></th> 
	                <th><small>Cheque No.</small></th>
	              	<th><small>Amt.</small></th>
	              	<th><small>Recieve Date</small></th> 
	                <th><small>Action</small></th>                            
	            </tr>
	        </thead>
	        <tbody>
	            <?php
				$kolor=1;				
					if(mysql_num_rows($stockArr)>0)
						{
							while ($row = mysql_fetch_array($stockArr))
						  	{
								$CashAmount = $row["cashAmt"];
								$chequeamt = $row["chequeAmt"];
								$onlineAmt = $row["onlineAmt"];
								$amount = $CashAmount + $chequeamt + $onlineAmt;
					?>   
		        <tr>
                <td><small><?php print $kolor++;?>.</small></td>
                <td><small><?php echo stripslashes($row["paymentId"]);?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["callindataId"]));?></small></td>
                <td><small><?php if($CashAmount != 0) { echo 'Cash'; } else if($chequeamt != 0) { echo 'Cheque'; } else if( $onlineAmt != 0) { echo "NEFT"; } ?></small></td>
                <td><small><?php if($row["bankname"] != ""){ echo getBankName(stripslashes($row["bankname"]));} else{ echo "N/A";}?></small></td>
                <td><small><?php if($row["chequeNo"] != ""){ echo stripslashes($row["chequeNo"]);} else{ echo "N/A";}?></small></td>
                <td><small><?php echo $amount; ?></small></td>
                <td><small><?php echo stripcslashes($row["rcdDate"]);?></small></td>
                <td><small>
                <a href="update_quickbook_payment_status.php?chequeId=<?php echo $row["chequeId"];?>&cashId=<?php echo $row["paymentId"] ?>&neftId=<?php echo $row["neftId"] ?>&token=<?php echo $token ?>">
                <img src='images/edit.png'></a>
                <a href="edit_payment.php?paymentId=<?= $row["paymentId"] ?>&chequeId=<?= $row["chequeId"] ?>&onlinetransferId=<?= $row['neftId']; ?>&token=<?php echo $token ?>"  onclick="return confirm('Are you sure you want to Delete this record?')"><img src='images/drop.png'></a>
                </small></td>
                </tr> 
                <?php 
                		}
                echo "</tbody>";
                echo "</table>";
                
                  }
                   
			}
			else
                   echo "<h3><font color=red>No records found !</h3></font>";
                ?>
              
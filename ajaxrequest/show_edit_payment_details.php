<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$date = mysql_real_escape_string($_POST['date']);
$dateto = mysql_real_escape_string($_POST['dateto']);
$confirmationStatus = mysql_real_escape_string($_POST['confirmationStatus']);
$depositStatus = mysql_real_escape_string($_POST['depositStatus']);
$clearanceStatus = mysql_real_escape_string($_POST['clearanceStatus']);
echo $clearanceStatus;
error_reporting(0);
$linkSQL = "SELECT B.PaymentID as PaymentID, B.customerId as customerId, 
			B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount, B.ChequeID as chequeId,
			B.status as status, A.chequeAmount as chequeamt, B.status as confirmationStatus,
			C.onlineAmount as onlineAmt, A.Id as chequeId, A.ClearStatus as clearStatus, 
			C.Id as onlinepaymentId, D.callingdata_id as callingdataid, B.paymentConfirmBy as confrmBy,
			A.ChequeNo as cheqNo, A.Bank as bankName, A.bankDepositDate as depositDate 
			from quickbookpaymentcheque as A 
			Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
			ON A.Id = B.ChequeID
			Left Outer JOIN quickbookpaymentonlinetransfer as C 
			ON B.OnlineTransferId = C.Id 
			LEFT OUTER JOIN tbl_customer_master as D 
			ON B.customerId = D.cust_id ";
	echo $linkSQL;
if ( ($confirmationStatus != 0) or ( $date !='' and $dateto !='') or ($depositStatus != 0) or ($clearanceStatus != 0) )
	{
		$linkSQL  = $linkSQL." WHERE ";	
	}
$counter = 0;
if($confirmationStatus != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." B.status = '$confirmationStatus'" ;
		$counter+=1;
		echo $linkSQL;
	}
if ( $date !='' and $dateto !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL."  DATE(A.bankDepositDate) BETWEEN '$date' AND '$dateto' ";
	$counter+=1;
	echo $linkSQL;
}
if($depositStatus != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.DepositStatus = '$depositStatus'" ;
		$counter+=1;
		echo $linkSQL;
	}
if($clearanceStatus != 0)
	{
		if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." A.ClearStatus = '$clearanceStatus'" ;
		$counter+=1;
		echo $linkSQL;
	}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
	  			<th><small>S.&nbsp;No.</small></th>     
	  			<th><small>Payment&nbsp;ID</small></th>  
              	<th><small>Organization Name</small></th>
              	<th><small>Cheque Amt.</small></th>
              	<th><small>Bank</small></th>   
              	<th><small>Cheque No.</small></th> 
                <th><small>Confirmation Status</small></th> 
              	<th><small>Deposit Date</small></th> 
              	<th><small>Clearance Status</small></th>  
                <th><small>Action</small></th>                            
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
                <td><small><?php echo stripslashes($row["PaymentID"]);?></small></td>
                <td><small><?php echo getOraganization(stripslashes($row["callingdataid"]));?></small></td>
                <td><small>
				<?php 
				if($row["chequeamt"] == 0)
				{
					echo "N/A";
				}
				else
				{
					echo stripslashes($row["chequeamt"]);
				}
				?>
                </small></td>
                <td><small><?php echo getBankName(stripslashes($row["bankName"]));?></small></td>
                <td><small><?php echo stripslashes($row["cheqNo"]);?></small></td>
                <td><small>
				<?php 
				if($row["confirmationStatus"] == 0)
				{
					echo "No";
				}
				else
				{
					echo "Yes";
				}	
				?>
                </small></td>
               
                <td><small><?php echo stripcslashes($row["depositDate"]);?></small></td>
                <td><small>
				<?php 
				if($row["clearStatus"] == "Y")
				{
					echo "<span style='color:green'>Cleared</span>";
				}
				else if($row["clearStatus"] == "B")
				{
					echo "<span style='color:red'>Bounced</span>";
				}
				else if($row["clearStatus"] == "N")
				{
					echo "<span style='color:orange'>Pending</span>";
				}
				?>
                </small></td>
                <td><small>
                <a href="update_quickbook_payment_status.php?chequeId=<?php echo $row["chequeId"];?>&token=<?php echo $token ?>">
                <img src='images/edit.png'></a>
                </small></td>
                </tr> 
                <?php 
                		}
                echo $pagerstring;
                
                  }
                   
			}
			else
                   echo "<h3><font color=red>No records found !</h3></font>";
                ?>
              
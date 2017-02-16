<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$depositDate = mysql_real_escape_string($_POST['depositDateFrom']);
$depositDateTo = mysql_real_escape_string($_POST['depositDateTo']);
$branch = mysql_real_escape_string($_POST['branch']);
$executive = mysql_real_escape_string($_POST['executive']);
error_reporting(0);
$linkSQL = "SELECT B.PaymentID as PaymentID, B.customerId as customerId, 
			B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount,
			B.status as status, B.userId as userId, B.paymentConfirmBy as confirmBy, 
			D.branch_id as Branch, A.chequeAmount as chequeamt, C.onlineAmount as onlineAmt, 
			A.ChequeDate as chequeDate,
			A.DepositDate as depositDate, E.callingdata_id as orgId, 
			A.DepositStatus as DepositStatus, A.Id as chequeId, 
			A.ChequeNo as cheqNo, A.Bank as bankName
			From quickbookpaymentcheque as A 
			Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
			ON A.Id = B.ChequeID
			Left Outer JOIN quickbookpaymentonlinetransfer as C 
			ON B.OnlineTransferId = C.Id
			LEFT OUTER JOIN tbluser as D 
			ON B.userId = D.id
			LEFT OUTER JOIN tbl_customer_master as E 
			ON B.customerId = E.cust_id  
			WHERE A.DepositStatus = 'N' and B.status = '1' ";
/*echo $linkSQL;*/
if ( ($executive != 0) or ( $depositDate != 0) or ( $depositDateTo != 0) or ($branch != 0) )
{
	$linkSQL  = $linkSQL." And";		
}
$counter = 0;
if ( $executive != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." B.userId = '$executive'";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $depositDate !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL =$linkSQL." DATE(A.ChequeDate) BETWEEN '$depositDate' AND '$depositDateTo' ";
	$counter+=1;
	/*echo $linkSQL;*/
}
if ( $branch != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL." D.branch_id ='$branch'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}					 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th><small>S. No.</small></th>     
              	<!--<th><small>Payment Id</small></th>  -->
              	<th><small>Quick Book Ref. No.</small></th>
              	<th><small>Company</small></th> 
                <th><small>Bank Name</small></th> 
                <th><small>Cheque No.</small></th> 
              	<th><small>Cheque Amount</small></th>   
              	<!--<th><small>Recieved By</small></th>
              	<th><small>Confirm By</small></th> -->
                <th><small>Cheque Date</small></th> 
                <th><small>Deposit as Per Client</small></th> 
                <th><small>Action <br />             
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">
                Check All</a>
      			&nbsp;&nbsp;
      			<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">
                Uncheck All</a></small>
                </th>                 
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
	 			<!--<td><small><?php echo stripslashes($row["PaymentID"]);?></small></td>
	 			<td><small><?php echo stripslashes($row["quickBookRefNo"]);?></small></td>-->
                <td><small><?php echo stripslashes($row["quickBookRefNo"]);?></small></td>
	 			<td><small><?php echo getOraganization(stripcslashes($row['orgId']));?></small></td>
                <td><small><?php echo getBankName(stripcslashes($row['bankName']));?></small></td>
                <td><small><?php echo stripcslashes($row['cheqNo']);?></small></td>
                <td><small>
				<?php 
				if($row["chequeamt"] == 0)
				{
					echo 'N/A';
				}
				else
				{
					echo stripslashes($row["chequeamt"]);
				}
				?>                
                </small></td>
               	
               <!-- <td><small><?php echo gettelecallername(stripcslashes($row['userId']));?></small></td>
                <td><small><?php echo stripcslashes($row['confirmBy']);?></small></td>-->
                <td><small><?php echo $row['chequeDate']; ?></small></td>
                <td><small><?php echo stripcslashes($row['depositDate']); ?></small></td>
                <td><input type='checkbox' name='linkID[]' value='<?php echo $row["chequeId"]; ?>'></td>
                </tr> 
                <?php 
                }
                echo $pagerstring;
                }    
		}
		else
			{
				echo "<h3><font color=red>No records found !</font></h3><br><br>";
			}
?>
 <form method="post">
                <table>
                <tr>
                <td colspan="3"><input type="submit" name="depositBank" value="Deposit" class="btn btn-primary btn-sm" onClick="return val();" id="submit" /> </td>
                <td></td>
                </tr>
                </table><br />
                </form>  
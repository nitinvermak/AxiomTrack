<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$search_box = mysql_real_escape_string($_POST['search_box']);

error_reporting(0);
	$linkSQL = "SELECT B.PaymentID as PaymentID, B.customerId as customerId, 
				B.quickBookRefNo as quickBookRefNo, B.CashAmount as CashAmount,
				B.status as status, B.userId as userId, 
				B.paymentConfirmBy as confirmBy,
				A.Amount as chequeamt, C.Amount as onlineAmt
				from quickbookpaymentcheque as A 
				Left Outer JOIN quickbookpaymentmethoddetailsmaster as B 
				ON A.Id = B.ChequeID
				Left Outer JOIN quickbookpaymentonlinetransfer as C 
				ON B.OnlineTransferId = C.Id WHERE B.status = '0'";
	$authorized_branches = BranchLogin($_SESSION['user_id']);
	if ( $authorized_branches != '0'){
		$linkSQL = $linkSQL.' and B.branch_id in  '.$authorized_branches;		
	}
	/*echo $linkSQL;*/
	$stockArr = mysql_query($linkSQL);
	/*$total_num_rows = mysql_num_rows($stockArr);*/
if(mysql_num_rows($stockArr)>0)
	{
		/*echo "Total Found Record" .$total_num_rows. "!";*/
	 	echo '  <table border="0" class="table table-hover table-bordered">  ';
?>		
				<tr>
              	<th><small>S. No.</small></th>     
              	<th><small>Payment Id</small></th>  
              	<th><small>Quick Book Ref. No.</small></th>
              	<th><small>Company</small></th> 
              	<th><small>Cash Amount</small></th>
              	<th><small>Cheque Amount</small></th>   
              	<th><small>Online Amount</small></th>   
              	<th><small>Recieved By</small></th>
              	<th><small>Confirm By</small></th>                   
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
	 			<td><small><?php echo stripslashes($row["quickBookRefNo"]);?></small></td>
	 			<td><small><?php echo stripcslashes($row['customerId']);?></small></td>
                <td><small>
				<?php
				if($row['CashAmount'] == 0)
				{
					echo 'N/A';
				}
				else
				{
					echo stripcslashes($row['CashAmount']);
				}
				?>
                </small></td>
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
               	<td><small>
				<?php 
				if($row['onlineAmt'] == '')
				{
					echo 'N/A';
				}
				else
				{
					echo stripcslashes($row['onlineAmt']);
				}	
				?>
                </small></td>
                <td><small><?php echo stripcslashes($row['userId']);?></small></td>
                <td><small><?php echo stripcslashes($row['confirmBy']);?></small></td>
                </tr> 
                
				<?php 
                }
                echo $pagerstring;
                
                        }
                    else
                    echo "<h3 style='color:red;'><font color=red>No records found !</h3><br></font>";
				}
                ?>
              </table>	
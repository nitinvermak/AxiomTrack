<?php
include("../includes/config.inc.php"); 
// include("../includes/crosssite.inc.php");  
$orgName = mysql_real_escape_string($_POST['orgName']);
$intervelName = mysql_real_escape_string($_POST['intervelName']);
$payableamt = mysql_real_escape_string($_POST['payableamt']);
// $paid_amount= mysql_real_escape_string($_POST['paid_amount']);
$discount_amount= mysql_real_escape_string($_POST['discount_amount']);
$custId = mysql_real_escape_string($_POST['customer_id']);
$invoiceId = mysql_real_escape_string($_POST['invoiceId']);

$sql = "SELECT SUM(amount) as previouspaidamt FROM paymentestimateadadjustment 
        WHERE estimateId =".$invoiceId;

$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
$previouspaid_amt = $row['previouspaidamt'];
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeForm();"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Payment Entry</h4>
</div>
<div class="modal-body">
  <div id="dv_success"></div>
    <form name='fullform' id="invoice_payment_form" class="form-horizontal"  method='post'>
        <input type="hidden" name="hiddenInvoiceID" id="hiddenInvoiceID" value="<?= $invoiceId; ?>">
        <div class="table-responsive">         
            <table class="table table-bordered">
                <tr>
                    <td><strong>Company Name:</strong> </td>
                    <td><strong><span style="color:#FF0000;" id="name"><?php echo  $orgName; ?></span></strong></td>
                    <td><strong>Interval Name:</strong></td>
                    <td><strong><span style="color:#FF0000;" id="intervelName"><?php echo  $intervelName; ?></span></strong></td>
					<td></td>
					<td></td>
				</tr>	
				<tr>
					<td><strong>Total Amount:</strong></td>
                    <td><strong><span style="color:#FF0000;" id="total_amount">
                        <?php echo  $payableamt; ?>
                        <input type="hidden" name="total_amt" id="total_amt" value="<?php echo  $payableamt; ?>">
                        </span></strong></td>
					<td><strong>Paid Amount:</strong></td>
                    <td><strong><span style="color:#FF0000;" id="paid_amount"><?php echo  $paid_amount; ?></span></strong></td>
                    <td><strong>Discounted Amount:</strong></td>
                    <td><strong><span style="color:#FF0000;" id="discount_amount">
                        <?php echo  $discount_amount; ?>
                        <input type="hidden" name="rent_discount_amount" id="rent_discount_amount" value="<?php echo  $discount_amount; ?>">
                        </span></strong></td>
					<td><strong>Payable Amount:</strong></td>
                    <td style="color:#FFF; background-color:green;">
                        <strong>
                            <span  id="payableamt">
                                <?php 
                                echo $payableamt-$discount_amount-$previouspaid_amt;
                                // if($previouspaid_amt != ""){
                                //    echo $previouspaid_amt - $payableamt - $discount_amount - $paid_amount ; 
                                // }
                                // else{
                                //     echo $payableamt - $discount_amount - $paid_amount ;
                                // }
                                ?>
                                
                            </span>
                            <input type="hidden" name="payable_amt" id="payable_amt" 
                            value="<?php 
                            echo $payableamt-$discount_amount-$previouspaid_amt;
                                // if($previouspaid_amt != ""){
                                //    echo $previouspaid_amt - $payableamt - $discount_amount - $paid_amount ; 
                                // }
                                // else{
                                //     echo $payableamt - $discount_amount - $paid_amount ;
                                // }
                                ?>">
                        </strong>
                    </td>
					
                </tr>
            </table>
            <div class="paymentType">
                <p><strong>Payment Id</strong>
                <select name="paymentId" id="paymentId" onChange="getDeviceAmt();">
                <option label="" value="">--Select--</option>
                        <?php $sql = mysql_query("SELECT `PaymentID` 
                                                  FROM `quickbookpaymentmethoddetailsmaster` 
                                                  WHERE `customerId` = '$custId' 
                                                  and adjustmentAmt <> 0");
                        
                                     while($result=mysql_fetch_assoc($sql)){
                        ?>
                        <option value="<?php echo $result['PaymentID']; ?>">
                            <?php echo $result['PaymentID']; ?>
                        </option>
                        <?php }?>
                </select>
                <span id="divAmt1"></span></p>
            </div>
        </div>
    </form>
</div> <!-- end body -->
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-sm" onclick="close_form()" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary btn-sm" onclick="getPaymentEntryData()">Submit</button>
</div>
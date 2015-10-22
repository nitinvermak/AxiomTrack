<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
?>
<div class="modal fade bs-example-modal-lg-payment" id="showInvoice" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
     <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Make Payment</h4>
      </div>
      <div class="modal-body">
      	<!--Start form -->
         <form name='fullform' class="form-horizontal"  method='post'>
         <input type="hidden" name="hiddenInvoiceID" id="hiddenInvoiceID" value="">
         <div class="table-responsive">         
    	 <table class="formStyle" border="0">
         <tr>
         <td colspan="4"><p id="name" style="font-weight:bold; font-family:'Trebuchet MS';"></p></td>
         </tr>
         <tr>
         <th colspan="4">Cash <input type="checkbox" name="cash" id="cash"></th>
         </tr>
         <tr>
         <td class="col-md-2">Amount</td>
         <td class="col-md-4"><input type="text" name="cashAmount" id="cashAmount" class="form-control text_box"></td>
         <td class="col-md-2"></td>
         <td class="col-md-4"></td>
         </tr>
         <tr>
         <th colspan="4">Cheque <input type="checkbox" name="cheque" id="cheque"></th>
         </tr>
         <tr>
         <td class="col-md-2">Cheque No.</td>
         <td class="col-md-4"><input type="text" name="chequeNo" id="chequeNo" class="form-control text_box"></td>
         <td class="col-md-2">Cheque Date</td>
         <td class="col-md-4"><input type="text" name="chequeDate" id="chequeDate" class="date form-control text_box"></td>
         </tr>
         <tr>
         <td class="col-md-2">Bank</td>
         <td class="col-md-4">
         <select name="bank" id="bank" class="form-control drop_down ddlCountry">
            <option value="">Select Plan Category</option>
            <?php $Country=mysql_query("select * from tblBank");
						   while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['bankId']; ?>" <?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
            <?php } ?>
        </select>
         </td>
         <td class="col-md-2">Amount</td>
         <td class="col-md-4"><input type="text" name="amountCheque" id="amountCheque" class="form-control text_box"></td>
         </tr>
         <tr>
         <td class="col-md-2">Bank Deposit Date</td>
         <td class="col-md-4"><input type="text" name="depositDate" id="depositDate" class="form-control text_box"></td>
         <td class="col-md-2"></td>
         <td class="col-md-4"></td>
         </tr>
         <tr>
         <th colspan="4">Online Transfer <input type="checkbox" name="onlineTransfer" id="onlineTransfer"></th>
         </tr>
         <tr>
         <td class="col-md-2">Amount</td>
         <td class="col-md-4"><input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control text_box"></td>
         <td class="col-md-2">Reference No.</td>
         <td class="col-md-4"><input type="text" name="refNo" id="refNo" class="form-control text_box"></td>
         </tr>
         <tr>
         <th colspan="4">Other Details</th>
         </tr>
         <tr>
         <td class="col-md-2">Date of Recieving</td>
         <td class="col-md-4"><input type="text" name="revievingDate" id="revievingDate" class="date form-control text_box" ></td>
         <td class="col-md-2">Remarks</td>
         <td class="col-md-4"><input type="text" name="remarks" id="remarks" class="form-control text_box" ></td>
         </tr>
         <tr>
         <td class="col-md-2">Payment Revieved by</td>
         <td class="col-md-4"><input type="text" name="recievedby" id="recievedby" class="form-control text_box" ></td>
         <td class="col-md-2">Payment Confirm by</td>
         <td class="col-md-4"><input type="text" name="confirmby" id="confirmby" class="form-control text_box" ></td>
         </tr>
         <tr>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4">&nbsp;</td>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4">&nbsp;</td>
         </tr>
         <tr>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4"><input type="submit" name="submit" id="submit" class="btn btn-primary btn-sm" value="Submit"> <input type="reset" name="reset" id="reset" class="btn btn-primary btn-sm" value="Reset"></td>
         <td class="col-md-2">&nbsp;</td>
         <td class="col-md-4">&nbsp;</td>
         </tr>
         </table>
    	 </div>
    	 </form>
        <!-- End Form -->
      </div>
    </div>
  </div>
</div>

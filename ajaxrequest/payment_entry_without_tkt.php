<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeForm();"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Payment Entry</h4>
</div>
<div class="modal-body">
  <div id="dv_Success1"></div>
  <div class="form-group form_custom"><!-- form_custom -->
    <div class="row"><!-- row -->
      <div class="clearfix"></div>
      <div class="col-md-12 field-option">
        <strong>Cash</strong> <input type="checkbox" name="cash" id="cash" onclick="cash(this)">
        <input type="hidden" name="customerId" id="customerId" value="<?= $cust_id ?>"/>
      </div>
      <div class="col-md-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Amount <i>*</i></strong></span>
        <input type="text" name="cashAmount" id="cashAmount" class="form-control" disabled>
      </div><!-- End custom_field-->
      <div class="clearfix"></div>
      <div class="col-md-12 field-option">
        <strong>Cheque</strong> <input type="checkbox" name="cheque" id="cheque" onclick="cheque(this)">
      </div>
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Cheque No. <i>*</i></strong></span>
        <input type="text" name="chequeNo" id="chequeNo" class="form-control" disabled> 
      </div><!-- end cutom_field-->
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Cheque Date <i>*</i></strong></span>
        <input type="text" name="chequeDate" id="chequeDate" class="date form-control" disabled> 
      </div><!-- end cutom_field-->
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Bank <i>*</i></strong></span>
        <select name="bank" id="bank" class="form-control" disabled>
          <option value="">Select Plan Category</option>
          <?php $Country=mysql_query("select * from tblbank");
                while($resultCountry=mysql_fetch_assoc($Country)){
          ?>
          <option value="<?php echo $resultCountry['bankId']; ?>" 
          <?php if(isset($result['bankId']) && $resultCountry['bankId']==$result['bankId']){ ?>selected<?php } ?>>
                <?php echo stripslashes(ucfirst($resultCountry['bankName'])); ?></option>
                <?php } ?>
        </select> 
      </div><!-- end cutom_field-->
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Amount <i>*</i></strong></span>
        <input type="text" name="amountCheque" id="amountCheque" class="form-control" disabled>
      </div><!-- end cutom_field-->
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Bank Deposit Date <i>*</i></strong></span>
        <input type="text" name="depositDate" id="depositDate" class="date form-control" disabled>
      </div><!-- end cutom_field-->
      <div class="clearfix"></div>
      <div class="col-md-12 field-option">
        <strong>Online Transfer </strong> <input type="checkbox" name="onlineTransfer" onclick="onlineTransfer(this)" id="onlineTransfer">
      </div>
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Amount <i>*</i></strong></span>
        <input type="text" name="onlineTransferAmount" id="onlineTransferAmount" class="form-control" disabled>
      </div><!-- end cutom_field-->
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Reference No. <i>*</i></strong></span>
        <input type="text" name="refNo" id="refNo" class="form-control" disabled>
      </div><!-- end cutom_field-->
      <div class="clearfix"></div>
      <div class="col-md-12 field-option">
        <strong>Other Details </strong> 
      </div>
      <div class="col-sm-6 col-sm-6 custom_field"> <!-- custom_field -->
        <span><strong>Remarks<i>*</i></strong></span>
        <input type="text" name="remarks" id="remarks" class="form-control" >
      </div><!-- end cutom_field-->
      <div class="clearfix"></div>
    </div><!-- End row -->
  </div> <!-- End form Custom -->
</div> <!-- end body -->
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary btn-sm" onclick="getPaymentEntryData1()">Submit</button>
</div>
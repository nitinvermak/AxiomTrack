<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['cust_id']);
if ($cust_id != NULL) {
  $queryArr=mysql_query("SELECT A.cust_id as cust_id, A.calling_product as calling_product, 
                         B.Company_Name as Company_Name, A.customerStatus as customerStatus,
                         B.created as created, B.First_Name as First_Name, B.Last_Name as Last_Name, 
                         B.email as email, B.Mobile as Mobile, B.id as callingDataId
                         FROM tbl_customer_master as A 
                         INNER JOIN  tblcallingdata as B 
                         ON A.callingdata_id = B.id 
                         WHERE A.cust_id =".$cust_id);
  $result=mysql_fetch_assoc($queryArr);

?>
<div class="form-group form_custom col-md-12"> <!-- form Custom -->
  <div class="row"><!-- row -->
    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
      <span>Customer Id <i class="red">*</i></span>
      <input type="text" name="cust_id" id="cust_id" class="form-control" style="width: 100%" value="<?php if(isset($result['cust_id'])) echo $result['cust_id'];?>" readonly>
    </div> <!-- end custom field -->
    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
      <span>Company Name <i class="red">*</i></span>
      <input type="text" name="customer_name" id="customer_name" style="width: 100%" value="<?php if(isset($result['cust_id'])) echo $result['Company_Name'];?>" class="form-control" readonly>
    </div> <!-- end custom field -->
    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
      <span>Activation Date<i class="red">*</i></span>
      <input type="text" name="createdate" id="createdate" style="width: 100%" value="<?php if(isset($result['cust_id'])) echo $result['created'];?>" class="form-control" readonly>
      <input type="hidden" value="<?php echo $result['First_Name']." ".$result['Last_Name'];?>" name="name" id="name">
      <input type="hidden" value="<?php echo $result['email'];?>" name="email" id="email">
      <input type="hidden" value="<?php echo $result['Mobile'];?>" name="mobile" id="mobile">
      <input type="hidden" value="<?php echo $result['callingDataId'];?>" name="id" id="id">
    </div> <!-- end custom field -->
    <div class="col-lg-6 col-sm-6 custom_field"> <!-- Custom field -->
      <span>Customer Status <i class="red">*</i></span>
      <input type="text" name="customerStatus" id="customerStatus" style="width: 100%" value="<?php if(isset($result['cust_id'])) echo $result['customerStatus'];?>" class="form-control" readonly>
    </div> <!-- end custom field -->
  </div><!-- end row --> 
  <div class="row button-op">
    <div class="col-md-12"> 
      <input type="button" name="add_vehicle" id="add_vehicle" value="Add Vehicle Profile" class="btn btn-info btn-sm">
      <button type="button" class="btn btn-info btn-sm" 
      onclick="getPaymentEntryForm(<?= $result['cust_id'];?>)" data-toggle="modal" data-target=".bs-example-modal-lg">Payment Entry</button>   
      <input type="button" name="showHistory" id="showHistory" value="View Plan & History" class="btn btn-info btn-sm">
      <input type="button" name="showEdit" id="showEdit" value="Edit Plan" class="btn btn-info btn-sm">   
      <input type="button" name="estimateView" id="estimateView" onclick="getEstimateView(<?= $result['cust_id'];?>)" value="Rent Balance" class="btn btn-info btn-sm">
      <input type="button" name="deviceAmt" id="deviceAmt" onclick="getDeviceAmount(<?= $result['cust_id'];?>)" value="Device Amount Balance" class="btn btn-info btn-sm">
      <input type="button" name="pendingPayment" id="pendingPayment" onClick="getPendingReport();" value="Adjust Device Amount" class="btn btn-info btn-sm">
      <input type="button" name="PaymentHistory" id="PaymentHistory" onClick="getPaymentHistory();" value="Payment History" class="btn btn-info btn-sm">
      <input type="button" name="billingProfile" id="billingProfile" onClick="getBillingProfile();" value="Billing Profile" class="btn btn-info btn-sm">
      <input type="button" name="editbillingprofile" id="editbillingprofile" onClick="getEditBillingProfile();" value="Edit Billing Profile" class="btn btn-info btn-sm">
      <input type="button" name="generate_duedate" id="generate_duedate" onclick="generate_duedate1(<?= $result['cust_id'];?>);" value="Edit Due Date" class="btn btn-info btn-sm">    
      <input type="button" name="get_estimate_history" id="get_estimate_history" 
      onclick="get_estimate_history_details(<?= $result['cust_id'];?>);" value="Get Estimate History" class="btn btn-info btn-sm">      
     </div>
     <div class="col-md-12" id="dv_Msg1"></div>
     <div class="col-md-12 table-responsive" id="dvassign"></div>
  </div>               
</div><!-- End From Custom -->
<?php 
}
else{
  echo '<div class="alert alert-danger alert-dismissible small-alert" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <strong><i class="fa fa-exclamation-circle" aria-hidden="true"></i></strong> Please Select Orgranization !
        </div>';
}
?>
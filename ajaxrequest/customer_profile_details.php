<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$cust_id = mysql_real_escape_string($_POST['searchText']);
if ($cust_id != NULL) {
  $queryArr=mysql_query("SELECT A.cust_id as cust_id, A.calling_product as calling_product, 
                         B.Company_Name as Company_Name, A.customerStatus as customerStatus,
                         B.created as created, B.First_Name as First_Name, B.Last_Name as Last_Name, 
                         B.email as email, B.Mobile as Mobile, B.id as callingDataId,
                         A.activeStatus as activestatus
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
      <input type="text" name="createdate" id="createdate" style="width: 100%" 
      value="<?php if(isset($result['cust_id'])) echo date("d-m-Y", strtotime($result['created']));?>" 
      class="form-control" readonly>
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
     <input type="button" name="inActive" id="inActive" value="InActive Vehicle" class="btn btn-info btn-sm">
     <input type="button" name="manageServiceBranch" id="manageServiceBranch" value="Add Service Branch" class="btn btn-info btn-sm">
     <input type="button" onClick="getUserform();" value="Create CRM User" class="btn btn-info btn-sm">
     <input type="button" name="editServiceBranch" id="editServiceBranch" value="Edit Service Branch" class="btn btn-info btn-sm">
     <input type="button" name="oldvehicle" id="oldvehicle" class="btn btn-info btn-sm" value="Add New Vehicle" onClick="getVehicleEntryForm()">
     <input type="button" name="repairoldvehicle" id="repairoldvehicle" class="btn btn-info btn-sm" value="Edit/Repair Vehicle" onClick="getRepairVehicleData()">
     <button type="button" onClick="getEditCustomerDetails();" class="btn btn-info btn-sm">Edit Customer Details</button>
      <?php if($result["activestatus"] == "Y")
      {
      ?>
            <input type="submit" name="inactive" id="inactive" value="In Active" class="btn btn-info btn-sm" />
      <?php 
        }
        else if($result["activestatus"] == "N")
        {
      ?>
            <input type="submit" name="active" id="active" value="Active" class="btn btn-info btn-sm" />
          <?php 
        }
      ?>
          <?php if($result["customerStatus"] == "Ok")
        {
      ?>
            <input type="button" name="defaulter" id="defaulter" value="Defaulter" class="btn btn-info btn-sm" onClick="getDefaulter()">
      <?php 
        }
        else if($result["customerStatus"] == "Defaulter")
        {
      ?>
            <input type="button" name="ok" id="ok" value="OK" class="btn btn-info btn-sm" onClick="getOK()">
          <?php 
        }
      ?>
          
     </div>
     <div class="col-md-12" id="dvassign"></div>
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
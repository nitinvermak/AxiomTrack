<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$vehicleId = mysql_real_escape_string($_POST['vehicleId']);

$queryArr=mysql_query("SELECT * FROM tbl_gps_vehicle_master WHERE id =".$vehicleId);
$result = mysql_fetch_assoc($queryArr);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeForm();"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Edit Vehicle</h4>
</div>
<div class="modal-body">
  <div id="dvSuccess"></div>
  <div class="form-group form_custom col-md-12"> <!-- form Custom -->
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Vehicle No. <i class="red">*</i></span>
      <input name="vehicle_no" id="vehicle_no" type="text" class="form-control" value="<?php if(isset($result['id'])) echo $result['vehicle_no']; ?>" style="width: 100%"/>
      <input type="hidden" name="vehicleId" id="vehicleId" value="<?= $vehicleId; ?>">
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Techician Name <i class="red">*</i></span>
      <select name="technician" id="technician" onChange="return ShowMobile();" class="form-control select2" style="width: 100%">
        <option value="">Select Techician</option>
        <?php $Country=mysql_query("select * from tbluser where (User_Category=5 or User_Category=8) AND `User_Status`='A'");
             while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?></option>
                 <?php } ?>
      </select>
      <input type="hidden" name="techincian_id" id="techincian_id" value="<?php echo $result['techinician_name']; ?>">
    </div> <!-- end custom field -->
  </div>
  <div id="service_provider" style="display:none">
    <div class="row"><!-- row -->
      <div class="col-md-12 custom_field"> <!-- Custom field -->
        <span>Model <i class="red">*</i></span>
        <select name="model" id="model" class="form-control select2" style="width: 100%">
          <option value="">Select Model</option>
          <?php $Country=mysql_query("select * from tbldevicemodel");       
                while($resultCountry=mysql_fetch_assoc($Country)){
          ?>
          <option value="<?php echo $resultCountry['device_id']; ?>" <?php if(isset($datasource) && $resultCountry['device_id']==$datasource){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['model_name'])); ?></option>
          <?php } ?>
        </select>
      </div> <!-- end custom field -->
    </div>
  </div> <!-- end service_provider -->
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Mobile <i class="red">*</i></span>
      <span id="divMobile">
        <select name="mobile_no" id="mobile_no" class="form-control select2" style="width: 100%">
          <option value="">Select Mobile</option>
          <option value="<?php echo $result['mobile_no']; ?>" <?php if(isset($result['id']) && $result['mobile_no']==$result['mobile_no']){ ?>selected<?php } ?>><?php echo getMobile(stripslashes(ucfirst($result['mobile_no']))); ?></option>
        </select>
      </span>
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Device Id <i class="red">*</i></span>
      <span id="divDevice">
      <select name="device" id="device" class="form-control drop_down select2" style="width: 100%" onChange="return ShowIMEIandDeviceName();">
        <option value="">Select Device</option>
        <option value="<?php echo $result['device_id']; ?>" <?php if(isset($result['id']) && $result['device_id']==$result['device_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['device_id'])); ?></option>
      </select>
      </span>
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>IMEI No. <i class="red">*</i></span>
      <span id="divIMEI">
        <select name="imei" id="imei" class="form-control select2" style="width: 100%">
          <option value="">Select IMEI</option>
          <option value="<?php echo $result['imei_no']; ?>" <?php if(isset($result['id']) && $result['imei_no']==$result['imei_no']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['imei_no'])); ?></option>
        </select>
      </span>
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Model Name <i class="red">*</i></span>
      <span id="getModel">
        <select name="model" id="dmodel" class="form-control select2" style="width: 100%">
          <option value="">Select Model</option>
          <option value="<?php echo $result['model_name']; ?>" <?php if(isset($result['id']) && $result['model_name']==$result['model_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['model_name'])); ?></option>
        </select>
      </span>
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Server Details <i class="red">*</i></span>
        <select name="server_details" id="server_details" class="form-control select2" style="width: 100%" onChange="return divshow(this.value)">
          <option value="">Select Server</option>
          <option value="vehicletrack.biz">vehicletrack.biz</option>
          <option value="vts24.com">vts24.com</option>
          <option value="<?php echo $result['server_details']; ?>" <?php if(isset($result['id']) && $result['server_details']==$result['server_details']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($result['server_details'])); ?></option>
        </select>
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <span>Installation Date <i class="red">*</i></span>
      <input name="insatallation_date" id="insatallation_date" type="text" class="form-control date" style="width: 100%" value="<?php if(isset($result['id'])) echo $result['installation_date']; ?>"/>
    </div> <!-- end custom field -->
  </div>
  <div class="row"><!-- row -->
    <div class="col-md-12 custom_field"> <!-- Custom field -->
      <input type='button' name='submit2' class="btn btn-primary btn-sm" value="Submit" onclick="UpdateOldVehicle();" />
    </div> <!-- end custom field -->
  </div>
</div>
</div> <!-- end body -->
<div class="clearfix"></div>
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-sm" onclick="closeForm();" data-dismiss="modal">Close</button>
</div>
<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
?>
<div class="form-group" style="margin-top: 40px;">
  <label for="exampleInputEmail2">Company</label>
  <select name="company" id="company" class="form-control drop_down" onchange="getDeviceAmtData();" >
    <option value="">Select Company</option>
      <?php $Country=mysql_query("SELECT DISTINCT A.Company_Name as companyName, 
                                  B.cust_id as custId
                                  FROM tblcallingdata as A 
                                  INNER JOIN tbl_customer_master as B 
                                  ON A.id = B.callingdata_id
                                  INNER JOIN tbl_gps_vehicle_payment_master as C 
                                  ON B.cust_id = C.cust_id
                                  WHERE C.devicepaymentStatus='N'
                                  ORDER BY A.Company_Name");
            while($resultCountry=mysql_fetch_assoc($Country)){
      ?>
      <option value="<?php echo $resultCountry['custId']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['companyName'])); ?></option>
      <?php } ?>
  </select>
</div>
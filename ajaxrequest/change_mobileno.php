<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$mobileNo = mysql_real_escape_string($_POST['mobileNo']);
?>
<div class="modal-header">
  <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closeForm();"><span aria-hidden="true">&times;</span></button>
  <h4 class="modal-title">Re-Allocate Mobile Number</h4>
</div>
<div class="modal-body">
  <div id="dvSuccess"></div>
  <div class="form-group">
    <label for="re-MobileNo">Mobile No.<i>*</i></label>
    <select name="mobileNo" id="re_mobileNo" class="form-control">
      <option value="<?= $mobileNo; ?>"><?= getMobile($mobileNo); ?></option>
    </select>
  </div>
  <div class="form-group">
    <label for="Branch">Branch<i>*</i></label>
    <select name="branch" id="re_branch" class="form-control">
      <option label="" value="" selected="selected">Select Branch</option>
      <?php $Country = mysql_query("select * from tblbranch");
            while($resultCountry=mysql_fetch_assoc($Country)){
      ?>
      <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
      <?php } ?>
    </select>
  </div>
  <div class="form-group">
    <label for="Technician">Technician<i>*</i></label>
    <select name="technician" id="re_technician" class="form-control">
      <option value="">Select Techician</option>
      <?php $Country=mysql_query("select * from tbluser where (User_Category=5 or 
                                  User_Category=8) AND `User_Status`='A'");
            while($resultCountry=mysql_fetch_assoc($Country)){
      ?>
      <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['techinician_name']) && $resultCountry['id']==$result['techinician_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ".$resultCountry['Last_Name'])); ?>
      </option>
      <?php } ?>
    </select>
  </div>

</div> <!-- end body -->
<div class="modal-footer">
  <button type="button" class="btn btn-default btn-sm" onclick="closeForm();" data-dismiss="modal">Close</button>
  <button type="button" class="btn btn-primary btn-sm" onclick="reAllocateMobile()">Save</button>
</div>
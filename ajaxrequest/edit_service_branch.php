<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id =$_REQUEST['cust_id']; 
error_reporting(0);
if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id'])
	{
	$queryArr=mysql_query("SELECT * FROM tbl_assign_customer_branch where cust_id=".$cust_id);
	$result=mysql_fetch_assoc($queryArr);
	}
?>	
<div class="col-md-12">
<div id="alert">
</div>
  <form name='myform' action="" method="post" class="form-inline">
    <div class="form-group">
      <label for="Username">Serivce Branch</label>
      <select name="service_branch" id="service_branch" class="form-control drop_down">
        <option value="">Select Techician</option>
        <?php $Country=mysql_query("select * from tblbranch");
             while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_branchId']) && $resultCountry['id']==$result['service_branchId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                 <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="Password">Service Area Mgr.</label>
      <select name="service_area_mgr" id="service_area_mgr"  class="form-control drop_down">
        <option value="">Select Techician</option>
        <?php $Country=mysql_query("select * from tbluser where User_Category='9'");
              while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                 <?php } ?>
      </select>
    </div>
    <div class="form-group">
      <label for="Password">Service Executive</label>
      <select name="service_exe" id="service_exe"  class="form-control drop_down">
        <option value="">Select Techician</option>
        <?php $Country=mysql_query("select * from tbluser");
             while($resultCountry=mysql_fetch_assoc($Country)){
        ?>
        <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_executive']) && $resultCountry['id']==$result['service_executive']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                 <?php } ?>
      </select>
    </div>
    <input type="button" name="update" id="update" value="Submit" class="btn btn-primary btn-sm">
  </form>
</div>
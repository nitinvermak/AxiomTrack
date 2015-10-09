<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$cust_id =$_REQUEST['cust_id']; 
error_reporting(0);
if(isset($_REQUEST['cust_id']) && $_REQUEST['cust_id'])
	{
	$queryArr=mysql_query("SELECT * FROM tbl_assign_customer_branch where cust_id = '$cust_id'");
	$result=mysql_fetch_assoc($queryArr);
	}
?>	
<div class="table table-responsive">
<?php 
if($result["cust_id"] == $cust_id)
{
	echo "<p style='color:red; font-weight:bold; padding:10px 0px 0px 20px;'>Branch already Assign</p>";
}
else
{
?>
<table border="0">
 <tr>
   <td height="34" colspan="4"><div id="alert">
      </div></td>
   </tr>
 <tr>
          <td height="34">Serivce Branch</td>
          <td>
           <select name="service_branch" id="service_branch" class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tblbranch");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['CompanyName']) && $resultCountry['id']==$result['CompanyName']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                 <?php } ?>
          </select>          </td>
          <td>Service Area Mgr.</td>
          <td>
          <select name="service_area_mgr" id="service_area_mgr"  class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tbluser where User_Category='9'");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                 <?php } ?>
          </select>          </td>
        </tr>
        <tr>
          <td height="34">Service Executive</td>
          <td>
          <select name="service_exe" id="service_exe"  class="form-control drop_down">
                 <option value="">Select Techician</option>
                 <?php $Country=mysql_query("select * from tbluser");
					   while($resultCountry=mysql_fetch_assoc($Country)){
				 ?>
                 <option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['service_area_manager']) && $resultCountry['id']==$result['service_area_manager']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'] )); ?></option>
                 <?php } ?>
          </select>          </td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="34"><input type="button" name="save" id="save" value="Submit" class="btn btn-primary btn-sm"></td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
      </table>
</div>
<?php } ?>
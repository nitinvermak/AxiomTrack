<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$state_id=$_REQUEST['state_id'];
error_reporting(0); 
$branchArr=mysql_query("select distinct(city_name) from tblcity where tblcity.state_id=".$state_id."  order by city_name");
?>
<select name="city" id="city" class="form-control input-sm drop_down" onchange="return callGrid();">
                              <option value="">Select City</option>
                               <?php 
							  // error_reporting(-1);
							 if(mysql_num_rows($branchArr)>0){ 
while($resultBranch=mysql_fetch_assoc($branchArr)){
?>
                              <option value="<?php echo $resultBranch['city_name']; ?>" <?php if($resultBranch['city_name']==$_REQUEST['City']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['city_name'])); ?></option>
                              <?php }}else {?>
<option value="">No Record available</option>
<?php } ?>

                            </select>

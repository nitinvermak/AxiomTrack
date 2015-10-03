<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$city=$_REQUEST['city'];

error_reporting(0);

$branchArr=mysql_query("select distinct Area from tblcity where tblcity.city_name='".$city. "' order by Area");

//echo "select distinct city_name from city where state_id=".$state_id." order by city_name";
?>
<select name="area" id="area" class="form-control drop_down" onchange="return callPincode(this.value)">
                              <option value="">Select Area</option>
                               <?php 
							  // error_reporting(-1);
							 if(mysql_num_rows($branchArr)>0){ 
while($resultBranch=mysql_fetch_assoc($branchArr)){
?>

                              <option value="<?php echo $resultBranch['Area']; ?>" <?php if($resultBranch['Area']==$_REQUEST['Area']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['Area'])); ?></option>
                              <?php }}else {?>
<option value="">No Record available</option>

<?php } ?>


                           
 </select>
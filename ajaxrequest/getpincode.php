<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$area=$_REQUEST['area'];
$city=$_REQUEST['city'];
$branchArr=mysql_query("select distinct pincode from tblcity where trim(city_name)='".trim($city)."' and trim(Area)='". trim($area) ."' order by pincode");
//echo "select distinct pincode from tblcity where trim(city_name)='".trim($city)."' and trim(Area)='".trim($area)."' order by pincode";

							  // error_reporting(-1);
//echo "select distinct pincode from city where trim(city_name)='".trim($city)."' and trim(Area)='". trim($area) ."' order by pincode"

?>
<select name="pin_code" id="pin_code" class="form-control drop_down">
                     <?php 
							  // error_reporting(-1);
							 if(mysql_num_rows($branchArr)>0){ 
while($resultBranch=mysql_fetch_assoc($branchArr)){
?>

                              <option value="<?php echo $resultBranch['pincode']; ?>" <?php if($resultBranch['pincode']==$_REQUEST['pincode']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['pincode'])); ?></option>
                              <?php }}else {?>
<option value="">No Record available</option>
<?php } ?>

                            </select>



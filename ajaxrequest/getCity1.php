<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$state_id = $_REQUEST['state'];
error_reporting(0); 
$branchArr=mysql_query("select distinct(city_name) from tblcity where tblcity.state_id=".$state_id."  order by city_name");
// $sql = "select distinct(city_name) from tblcity where tblcity.state_id=".$state_id." order by city_name";
// echo $sql;
// exit();
?>
<select name="city" id="city" onChange="return callGrid();" class="form-control select2" style="width: 100%">>
    <option value="">Select City</option>
    <?php 
	// error_reporting(-1);
	if(mysql_num_rows($branchArr)>0){ 
		while($resultBranch=mysql_fetch_assoc($branchArr)){
	?>
    <option value="<?php echo $resultBranch['city_name']; ?>" 
    <?php if($resultBranch['city_name']==$_REQUEST['City']){ ?>selected<?php } ?>>
    <?php echo stripslashes(ucfirst($resultBranch['city_name'])); ?></option>
    <?php }}else {?>
	<option value="">No Record available</option>
	<?php } ?>
</select>

<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$city=$_REQUEST['city'];
error_reporting(0);
$branchArr=mysql_query("SELECT * FROM tbl_area_new WHERE city_id='$city' Order by Area_name ASC");
?>
	<select name="area" id="area" class="form-control" style="width: 100%" onchange="return CallPincode(this.value)">
    <option value="">Select Area</option>
    	<?php 
		// error_reporting(-1);
		if(mysql_num_rows($branchArr)>0){ 
		   while($resultBranch=mysql_fetch_assoc($branchArr)){
		?>
    <option value="<?php echo $resultBranch['area_id']; ?>" <?php if($resultBranch['Area_name']==$_REQUEST['Area_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['Area_name'])); ?></option>
                              <?php }}else {?>
    <option value="">No Record available</option>
<?php } ?>
	</select>

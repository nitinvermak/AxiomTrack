<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$district=$_REQUEST['district'];
error_reporting(0);
$branchArr=mysql_query("SELECT * FROM tbl_city_new WHERE District_ID='$district' Order by City_Name ASC");
?>
	<select name="city" id="city" class="form-control"  onchange="return CallArea(this.value)">
    <option value="">Select City</option>
    	<?php 
		// error_reporting(-1);
		if(mysql_num_rows($branchArr)>0){ 
		   while($resultBranch=mysql_fetch_assoc($branchArr)){
		?>
    <option value="<?php echo $resultBranch['City_id']; ?>" <?php if($resultBranch['City_Name']==$_REQUEST['City_Name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['City_Name'])); ?></option>
                              <?php }}else {?>
    <option value="">No Record available</option>
<?php } ?>
	</select>

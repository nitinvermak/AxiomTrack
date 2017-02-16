<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$state=$_REQUEST['state'];
error_reporting(0);
$branchArr=mysql_query("SELECT * FROM `tbl_district` WHERE State_id='$state' Order by District_name ASC");
?>
	<select name="district" id="district" class="form-control" style="width: 100%"   onchange="return CallCity(this.value)">
    <option value="">Select District</option>
    	<?php 
		// error_reporting(-1);
		if(mysql_num_rows($branchArr)>0){ 
		   while($resultBranch=mysql_fetch_assoc($branchArr)){
		?>
    <option value="<?php echo $resultBranch['District_id']; ?>" <?php if($resultBranch['District_name']==$_REQUEST['District_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['District_name'])); ?></option>
                              <?php }}else {?>
    <option value="">No Record available</option>
<?php } ?>
	</select>

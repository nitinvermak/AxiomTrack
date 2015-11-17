<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$state=$_REQUEST['state'];
error_reporting(0); 
$branchArr = mysql_query( "select District_id, District_name from tbl_district where State_id =".$state."  order by District_name	" );
/*echo $branchArr;*/
?>
<select name="city" id="city" class="form-control input-sm drop_down">
   <option value="">Select City</option>
   <?php 
   // error_reporting(-1);
   if(mysql_num_rows($branchArr)>0)
   { 
		while($resultBranch=mysql_fetch_assoc($branchArr))
		{
	?>
    <option value="<?php echo $resultBranch['District_id']; ?>"><?php echo stripslashes(ucfirst($resultBranch['District_name'])); ?></option>
   	<?php }}else {?>
	<option value="">No Record available</option>
	<?php } ?>
</select>

<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$area = $_REQUEST['area'];
/*echo "Area". $area;*/
error_reporting(0);
$branchArr=mysql_query("SELECT * FROM tbl_pincode WHERE Area_id='$area'");
?>
	<select name="pin_code" id="pin_code" class="form-control">
    	<?php 
		// error_reporting(-1);
		if(mysql_num_rows($branchArr)>0){ 
		   while($resultBranch=mysql_fetch_assoc($branchArr)){
		?>
    <option value="<?php echo $resultBranch['pincode_id']; ?>" <?php if($resultBranch['Area_name']==$_REQUEST['Area_name']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['Pincode'])); ?></option>
                              <?php }}else {?>
    <option value="">No Record available</option>
<?php } ?>
	</select>

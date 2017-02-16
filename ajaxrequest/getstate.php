<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$country = $_REQUEST['country'];
error_reporting(0);

$branchArr=mysql_query("SELECT * FROM tblstate WHERE Country_id='$country' Order by State_name ASC");
?>
	<select name="state" id="state" class="form-control" style="width: 100%" onchange="return CallDistrict(this.value)">
    <option value="">Select State</option>
    	<?php 
		// error_reporting(-1);
		if(mysql_num_rows($branchArr)>0){ 
		   while($resultBranch=mysql_fetch_assoc($branchArr)){
		?>
    <option value="<?php echo $resultBranch['State_id']; ?>" <?php if($resultBranch['State_name']==$_REQUEST['State_id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultBranch['State_name'])); ?></option>
                              <?php }}else {?>
    <option value="">No Record available</option>
<?php } ?>
	</select>
    
    

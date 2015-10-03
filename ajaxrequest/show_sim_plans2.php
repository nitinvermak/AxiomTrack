<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$provider2=$_REQUEST['provider2'];
error_reporting(0);
$sql = "SELECT * FROM tblplan where serviceprovider_id='$provider2'";
/*echo $sql;*/
$result = mysql_query($sql);
?>		
<select name="plan2" id="plan2" class="form-control drop_down">
<option value="">Select Plan</option>
<?php 
	while($resultPlan=mysql_fetch_assoc($result)){
?>
<option value="<?php echo $resultPlan['id']; ?>" <?php if(isset($result['plan_categoryid']) && $resultPlan['id']==$result['plan_categoryid']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultPlan['plan_rate'])); ?></option>
<?php } ?>
</select>	

<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$provider=$_REQUEST['provider'];
error_reporting(0);
/*echo $provider;*/
$sql = "SELECT * FROM tblplan where serviceprovider_id='$provider'";
$result = mysql_query($sql);
?>		
<select name="plan1" id="plan1" class="form-control select2" style="width: 100%">
<option value="">Select Plan</option>
<?php 
	while($resultPlan=mysql_fetch_assoc($result)){
?>
<option value="<?php echo $resultPlan['id']; ?>" <?php if(isset($result['plan_categoryid']) && $resultPlan['id']==$result['plan_categoryid']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultPlan['plan_rate'])); ?></option>
<?php } ?>
</select>	

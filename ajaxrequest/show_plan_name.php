<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$catId = mysql_real_escape_string($_POST['catId']);
if($catId == 3)
	{
?>
<select name="provider" id="provider" class="form-control drop_down">
<option value="">Select Service Provider</option>
<?php $Country=mysql_query("select * from tblserviceprovider");
	  while($resultCountry=mysql_fetch_assoc($Country)){
?>
<option value="<?php echo $resultCountry['id']; ?>" <?php if(isset($result['id']) && $resultCountry['id']==$result['id']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?></option>
<?php } ?>
</select>             
<?php }
else 
	{
?>
<select name="ticketId" id="ticketId" class="form-control drop_down ticket">
                    	 <option value="">Select Plan</option>
						 <?php $Country=mysql_query("select * from tblplansubcategory where planCategoryId = '$catId'");
                               while($resultCountry=mysql_fetch_assoc($Country)){
                                 ?>
                        <option value="<?php echo $resultCountry['planSubid']; ?>" <?php if(isset($result['planSubid']) && $resultCountry['planSubid']==$result['planSubid']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['plansubCategory'])); ?></option>
                        <?php } ?>
                    </select>
<?php } ?>

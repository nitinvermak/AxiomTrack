<?php 
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php");
$taxType = mysql_real_escape_string($_POST['taxType']);
?>
<select name="taxRate" id="taxRate" class="form-control drop_down">
<option value="">Select Tax Rate</option>
<?php $Country=mysql_query("select * from tblTax where taxTypeId = '$taxType'");
      while($resultCountry=mysql_fetch_assoc($Country)){
?>
<option value="<?php echo $resultCountry['taxId']; ?>"
<?php if(isset($result['productCategoryId']) && $resultCountry['id']==$result['productCategoryId']){
?>selected<?php } ?>>
<?php echo stripslashes(ucfirst($resultCountry['taxRate'])); ?></option>
<?php } ?>
</select>


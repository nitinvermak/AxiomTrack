<?php 
include("../includes/config.inc.php"); 
$moduleCategory = mysql_real_escape_string($_POST['moduleCategory']);
?>
<select name="parentModuleId" id="parentModuleId" class="form-control input-sm drop_down">
	<option label="" value="">Select Parent Module</option>
    <option value="0">No Parent</option>
    <?php $Country=mysql_query("SELECT * FROM tblmoduleparentname Where moduleCatId = '$moduleCategory' ORDER BY parentName ASC");
          while($resultCountry=mysql_fetch_assoc($Country)){
    ?>
    <option value="<?php echo $resultCountry['parentId']; ?>" <?php if(isset($result['parentId']) && $resultCountry['parentId']==$result['parentId']){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['parentName'])); ?></option>
    <?php } ?>
</select>
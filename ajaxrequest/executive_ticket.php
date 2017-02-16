<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branchId = mysql_real_escape_string($_POST['branch']);
/*echo 'afafs'.$branchId;*/

if($branchId == 0)
{
?>
			<select name="executive" id="executive" class="form-control select2">
			<option label="" value="" selected="selected">Select Technician</option>
				<?php $Country=mysql_query("select * from tbluser Order by First_Name");
							   while($resultCountry=mysql_fetch_assoc($Country)){
				?>
			<option value="<?php echo $resultCountry['id']; ?>" >
			<?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
			<?php } ?>
			</select>
<?php
}
else
{
?>
			<select name="executive" id="executive" class="form-control select2">
			<option label="" value="" selected="selected">Select Technician</option>
				<?php $Country=mysql_query("select * from tbluser where branch_id = '$branchId' Order by First_Name");
							   while($resultCountry=mysql_fetch_assoc($Country)){
				?>
			<option value="<?php echo $resultCountry['id']; ?>" >
			<?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
			<?php } ?>
			</select>
<?php
}?>
		 
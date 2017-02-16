<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$branchId = mysql_real_escape_string($_POST['branch']);
/*echo 'afafs'.$branchId;*/
if($branchId == 0)
{
?>
			<label for= "exampleInputEmail2">Technician</label>
			<select name="technician_id" id="technician_id" class="form-control drop_down">
				<option label="" value="0" selected="selected">All</option>
				<?php $Country=mysql_query("select `id`, `First_Name`, `Last_Name` from tbluser 
											where User_Category=5 or User_Category=8 
											AND User_Status = 'A'");
							   while($resultCountry=mysql_fetch_assoc($Country)){
				?>
				<option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
				<?php } ?>
			</select>
<?php
}
else
{
?>
			<label for= "exampleInputEmail2">Technician</label>
			<select name="technician_id" id="technician_id" class="form-control drop_down" onChange="return ShowByTechnician();">
			<option label="" value="0" selected="selected">All</option>
				<?php $Country=mysql_query("select `id`, `First_Name`, `Last_Name` from tbluser where branch_id = '$branchId' and (User_Category=5 or User_Category=8) and User_Status = 'A' ");
							   while($resultCountry=mysql_fetch_assoc($Country)){
				?>
			<option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
			<?php } ?>
			</select>
<?php
}?>
		 
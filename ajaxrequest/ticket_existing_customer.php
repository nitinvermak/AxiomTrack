<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$existingClient = mysql_real_escape_string($_POST['existingClient']);

error_reporting(0);
?>
<select name="orgranization" id="orgranization" class="form-control drop_down orgranization select2" style="width: 100%" onchange="getVehicle();">
	<option value="">Select Orgranization</option>                         
	<?php $Country=mysql_query("SELECT * FROM tblcallingdata WHERE STATUS='1' ORDER BY Company_Name ASC");								
       	  while($resultCountry=mysql_fetch_assoc($Country))
                {
    ?>
    <option value="<?php echo $resultCountry['id']; ?>" 
    <?php if(isset( $_SESSION['Company_Name']) && $resultCountry['id']== $_SESSION['Company_Name']){ ?>selected	<?php } ?>>
    <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
    <?php } ?>
</select>
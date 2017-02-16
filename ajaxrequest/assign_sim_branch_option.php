<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
?>
<div>
	<h4 class="red">&nbsp;</h4>
</div>
<div class="form-inline">
	<div class="form-group">
		<label for="exampleInputName2">Provider <i>*</i></label>
		<select name="sim_provider" id="sim_provider" class="form-control select2" >
            <option label="" value="0" selected="selected">All</option>
            <?php $Country=mysql_query("select * from tblserviceprovider order by serviceprovider");
						while($resultCountry=mysql_fetch_assoc($Country)){
			?>
            <option value="<?php echo $resultCountry['id']; ?>" 
            	<?php if(isset($State_name) && $resultCountry['id']==$State){ ?>selected<?php } ?>><?php echo stripslashes(ucfirst($resultCountry['serviceprovider'])); ?>
            </option>
            <?php } ?>
        </select>
	</div>
	<div class="form-group">
	    <label for="exampleInputName2">Branch</label>
	    <select name="branch" id="branch" class="form-control drop_down">
            <?php 
			$branch_sql= "select * from tblbranch ";
			$authorized_branches = BranchLogin($_SESSION['user_id']);
			echo $authorized_branches;
			if ( $authorized_branches != '0'){
				$branch_sql = $branch_sql.' where id in '.$authorized_branches;		
			}
			if($authorized_branches == '0'){
				echo'<option value="0">All</option>';	
			}
			else{
				echo'<option value="">--Select--</option>';
			}
			//echo $branch_sql;
			$Country = mysql_query($branch_sql);					
			while($resultCountry=mysql_fetch_assoc($Country)){
			 ?>
            <option value="<?php echo $resultCountry['id']; ?>" >
            	<?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?>
            </option>
            <?php } ?>
        </select>
	</div>
	<input type="button" name="assign" value="Assign Sim" id="submit" class="btn btn-primary btn-sm" onClick="showUnassignedStock()" />
    <input type="button" name="view" id="view" value="View Assigned Sim" class="btn btn-primary btn-sm" onClick="showAssignedStock()"/>
</div>		    			
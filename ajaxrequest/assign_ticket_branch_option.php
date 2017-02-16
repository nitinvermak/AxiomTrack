<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
?>
<div>
	<h4 class="red">&nbsp;</h4>
</div>
<div class="form-inline">
	<div class="form-group">
		<label for="exampleInputName2">Date <i>*</i></label>
		<input type="text" name="date" id="date" class="form-control date"/>
	</div>
	<div class="form-group">
	    <label for="exampleInputName2">Branch</label>
	    <select name="branch" id="branch" class="form-control select2" >
            <option label="" value="" selected="selected">Select Branch</option>
            <?php 
            $branch_sql= "select * from tblbranch ";
            $authorized_branches = BranchLogin($_SESSION['user_id']);
            //echo $authorized_branches;
            if ( $authorized_branches != '0'){
                $branch_sql = $branch_sql.' where id in '.$authorized_branches;		
            }
            if($authorized_branches == '0'){
                echo'<option value="0">All Branch</option>';	
            }
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
        </select>
	</div>
	<input type="button" name="assign" value="Assign Ticket" onclick="getInstockBranch();" id="assign" class="btn btn-primary btn-sm"/>
    <input type="button" name="view" id="view" value="View Assigned Ticket" onclick="getAssignBranch();" class="btn btn-primary btn-sm"/>
</div>		    			
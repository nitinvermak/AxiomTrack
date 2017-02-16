<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
?>
<div>
	<h4 class="red">&nbsp;</h4>
</div>
<div class="form-inline">
	<div class="form-group">
	    <label for="exampleInputName2">Branch</label>
	    <select name="branch" id="branch" class="form-control select2" onchange="getTechnicianList();">
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
            <option value="<?php echo $resultCountry['id']; ?>" >
            <?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?>
            </option>
            <?php } ?>
        </select>
	</div>
	
	<div class="form-group">
        <label for="exampleInputEmail2">Technician</label>
        <span id="showTechnician">
            <select name="executive" id="executive" class="form-control select2">
                <option label="" value="" selected="selected">Select Technician</option>
            </select>
        </span>
    </div>
	<input type="button" name="unassign" id="unassign" onclick="getTicketBranchInstk();" value="Assign Ticket" class="btn btn-primary btn-sm" />
    <input type="button" name="assign_view" id="assign_view" onclick="getTicketTech();" value="Assigned Ticket" class="btn btn-primary btn-sm" />
</div>		    			
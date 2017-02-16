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
	    <select name="branch" id="branch" class="form-control drop_down" onchange="getTechnicianList()">
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
            else{
                echo'<option value="">--Select--</option>';
            }   
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);                    
            while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
        </select>
	</div>
	
	<div class="form-group">
        <label for="exampleInputEmail2">Technician</label>
        <span id="showTechnician">
            <select name="technician_id" id="technician_id" class="form-control drop_down">
                <option label="" value="" selected="selected">All</option>
            </select>
        </span>
    </div>
	<input type="button" name="assign_sim" id="assign_sim" value="Assign Sim" onclick="getBranchInstock()" class="btn btn-primary btn-sm"/>
    <input type="button" name="view_assign" id="view_assign" value="View Assign" onclick="getTechnicianInstock()" class="btn btn-primary btn-sm"  />
</div>		    			
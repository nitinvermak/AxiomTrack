<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = mysql_real_escape_string($_POST['searchText']);
error_reporting(0);

$linkSQL = "select * from tblsim 
			where (sim_no like '{$searchText}%' 
			or mobile_no like '{$searchText}%') 
			and status_id <> '1'";
		/*echo $linkSQL;*/
$oRS = mysql_query($linkSQL);
?>		
<div class="delete-multiple-button">
	<button type="submit" name="delete_selected" onClick="return val();" class="btn btn-danger btn-sm">
		<i class="fa fa-trash" aria-hidden="true"></i> Delete
	</button>
</div>
<table border="0" class="table table-hover table-bordered" width="100%" cellspacing="0" id="example">
	<thead>
		<tr>
		    <th><small>S. No.</small></th>  
		    <th><small>Service Provider Name</small></th>  
		    <th><small>Sim  No.</small></th>
		    <th><small>Mobile No.</small></th> 
		    <th><small>Status</small></th>
		    <th><small>Action</small>            
		      	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
		      	&nbsp;&nbsp;
		      	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>
		    </th>   
	    </tr> 
    </thead>  
    <tbody> 
    <?php
	$kolor=1;
	if(mysql_num_rows($oRS)>0){
  		while ($row = mysql_fetch_array($oRS)){
 	?>
    <tr>
	    <td><small><?php print $kolor++;?>.</small></small></td>
		<td><small><?php echo getserviceprovider(stripslashes($row["company_id"]));?></small></td>
	    <td><small><?php echo stripslashes($row["sim_no"]);?></small></td>
	    <td><small><?php echo stripslashes($row["mobile_no"]);?></small></td>
	    <td><?php
			if($row["status_id"] == "0"){
				echo "<small><p class='label label-success'>InStock</p></small>";
			}
			else if($row["status_id"] == "2"){
				echo "<small><p class='label label-danger'>Replacement</p></small>";
			}
			else if($row["status_id"] == "3"){
				echo "<small><p class='label label-danger'>Damage</p></small>";
			}
			?>
	    </td>
		<td> <?php if($row["id"]!=1){?><a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_sim.php?id=<?php echo $row["id"]; ?>&type=del&token=<?php echo $token ?>' } " ><img src="images/drop.png" title="Delete" border="0" /></a> <?php } ?>    <?php if($row["id"]!=1){?> <a href="edit_sim.php?id=<?php echo $row["id"] ?>&amp;token=<?php echo $token ?>"><img src='images/edit.png' title='Edit' border='0' /></a><?php } else {?>  <?php } ?> &nbsp;&nbsp;<?php if($row["id"]!=1){?>
	        <a href="#" data-toggle="modal" data-target="#myModal" onclick="getSimStatusForm(<?= $row["id"] ?>)">Status</a>
	        <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'><?php } ?></td>
    </tr>
    <?php 
        }
           	echo "</tbody>";
           	echo "</table>";
    }
 	?>

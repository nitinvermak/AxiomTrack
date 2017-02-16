<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$searchText = mysql_real_escape_string($_POST['searchText']);
error_reporting(0);

$sql = "select * from tbl_device_master 
		where (id like '{$searchText}%' 
		or imei_no like '{$searchText}%') 
		and status <> '1'";
$result = mysql_query($sql);
?>
<div class="col-md-12 delete-multiple-button">
	<button type="submit" name="delete_selected" class="btn btn-danger btn-sm" onclick="return val();"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
</div>
<table border='0' class='table table-hover table-bordered display nowrap' width="100%" cellspacing="0" id="example">
<!-- <table id="example" class="display nowrap" width="100%" cellspacing="0"> -->
	<thead>
		<tr>
			<th><small>S. No.</small></th>     
		    <th><small>Device Id</small></th>    
		    <th><small>IMEI No.</small></th>
		    <th><small>Device Model</small></th>
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
$sno = 1;
while ( $row = mysql_fetch_array($result)) {
	if($row["status"] == "0"){
        $status = "<span class='label label-success'>InStock</span>";
    }
    else if($row["status"] == "2"){
        $status = "<span class='label label-warning'>Replacement</span>";
    }
    else if($row["status"] == "3"){
        $status = "<span class='label label-danger'>Damage</span>";
    }
	echo "<tr>
			<td><small>".$sno++."</small></td>
			<td><small>".$row["id"]."</small></td>
			<td><small>".$row["imei_no"]."</small></td>
			<td><small>".getdevicename($row["device_name"])."</small></td>
			<td><small>".$status."</small></td>
			<td><a href='manage_model.php?id=".$row["id"]."&type=del&token=".$token."'><img src='images/drop.png' title='Delete' border='0' /></a>
				<a href='model.php?id=".$row["id"]."&token=".$token."''><img src='images/edit.png' title='Edit' border='0' /></a>
					<a href='#' data-toggle='modal' data-target='#myModal' onClick='getForm(".$row["id"].")'>Status</a>
        			<input type='checkbox' name='linkID[]' value='".$row["id"]."'>
			</td>
		</tr>";
}
	echo "</tbody>";
	echo "</table>";
?>
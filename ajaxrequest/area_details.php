<?php
include("../includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
$areaname = mysql_real_escape_string($_POST['areaname']);
?>
<table id="example" class="table table-hover table-bordered ">
	<thead>
    <?php  
    $linkSQL = "select * from tbl_area_new where Area_name like '%$areaname%'  order by Area_name";
    // echo "qry=".$linkSQL;
    $oRS = mysql_query($linkSQL); 
    ?>
        <tr>
            <th><small>S. No.</small></th>     
            <th><small>City</small></th>
            <th><small>Area</small></th>    
            <th><small>Action &nbsp;             
                       <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" 
                        style="color:#fff; font-size:11px;">Check All</a>&nbsp;&nbsp;
                       <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>
            </small></th>   
        </tr> 
    </thead> 
    <tbody>  
    <?php
    $kolor=1;
    if(mysql_num_rows($oRS)>0){
        while ($row = mysql_fetch_array($oRS)){
    ?>
    <tr>
        <td><small><?php print $kolor++;?>.</small></td>
        <td><small><?php echo getcityname(stripslashes($row["city_id"]));?></small></td>
        <td><small><?php echo stripslashes($row["Area_name"]);?></small></td>
        <td>
            <a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_city.php?id=<?php echo $row["area_id"]; ?>&type=del&token=<?php echo $_SESSION['token'] ?>' } " >
            	<img src="images/drop.png" title="Delete" border="0" />
            </a>
            <a href="add_area.php?id=<?php echo $row["area_id"] ?>&token=<?php echo $_SESSION['token']; ?>">
                <img src='images/edit.png' title='Edit' border='0' />
            </a>
            &nbsp;&nbsp;
            <input type='checkbox' name='linkID[]' value='<?php echo $row["area_id"]; ?>'>
        </td>
    </tr>
    <?php }
    }
    ?>
    </tbody>
</table>

<?php
include("../includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
$cityName = mysql_real_escape_string($_POST['cityName']);
?>
<table id="example" class="table table-hover table-bordered ">
    <thead>
        <?php      
        $linkSQL = "select * from tbl_city_new Where City_Name like '%$cityName%' order by City_Name";
        $oRS = mysql_query($linkSQL); 
        ?>                  
        <tr>
            <th><small>S. No.</small></th>     
            <th><small>District</small></th>
            <th><small>City</small></th>    
            <th><small>Action &nbsp;             
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All</a>
                            &nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All</a>
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
            <td><small><?php echo getdistrict(stripslashes($row["District_ID"]));?></small></td>
            <td><small><?php echo stripslashes($row["City_Name"]);?></small></td>
            <td>
                <a href="#" onClick="if(confirm('Do you really want to delete this record?')){ window.location.href='manage_city.php?id=<?php echo $row["City_id"]; ?>&type=del&token=<?php echo $_SESSION['token']; ?>' } " >
                    <img src="images/drop.png" title="Delete" border="0" />
                </a> 
                <a href="add_city.php?id=<?php echo $row["City_id"] ?>&token=<?php echo $_SESSION['token']; ?>">
                    <img src='images/edit.png' title='Edit' border='0' />
                </a>
                &nbsp;&nbsp;
                <input type='checkbox' name='linkID[]' value='<?php echo $row["City_id"]; ?>'>
            </td>
        </tr>
        <?php }
        }
        ?>
    </tbody>
</table>


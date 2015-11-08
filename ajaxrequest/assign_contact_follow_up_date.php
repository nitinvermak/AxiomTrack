<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$date =$_REQUEST['date']; 
$telecaller =$_REQUEST['telecaller']; 
error_reporting(0);
/*echo $date;*/
if($telecaller == 0)
	{
	$linkSQL = "SELECT A.First_Name as fname, A.Last_Name as lname, A.Company_Name as cname, A.Phone as ph, A.Mobile as mob, C.follow_up_date as fdate, C.callingdata_id as cid
				FROM tblcallingdata As A 
				INNER JOIN tblassign As B 
				ON A.id = B.callingdata_id 
				INNER JOIN tbl_telecalling_status As C 
				ON B.callingdata_id = C.callingdata_id WHERE A.status='0' AND C.follow_up_date LIKE'$date%'";
				/* echo $linkSQL;*/
	}
else
	{
	$linkSQL = "SELECT A.First_Name as fname, A.Last_Name as lname, A.Company_Name as cname, A.Phone as ph, A.Mobile as mob, C.follow_up_date as fdate, C.callingdata_id as cid 
				FROM tblcallingdata As A 
				INNER JOIN tblassign As B 
				ON A.id = B.callingdata_id 
				INNER JOIN tbl_telecalling_status As C 
				ON B.callingdata_id = C.callingdata_id WHERE A.status='0' AND B.telecaller_id='$telecaller'";
	}
	$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-hover table-bordered">  ';
?>		
				<tr>
               	<th><small>S. No.</small></th>    
                <th><small>Name</small></th>  
                <th><small>Company Name</small></th>  
                <th><small>Phone</small></th>
                <th><small>Mobile</small></th>
                <th><small>Follow-up Date</small></th>
               	<th><small>Actions</small></th>                  
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                &nbsp;&nbsp;
                <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a></small></th>   
                </tr>    
				<?php
                  $kolor =1;
                  while ($row = mysql_fetch_array($stockArr))
                    {
                       if($row["assignstatus"]==0)
                            {
                                $stock ='In Stock';
                            }
                       if($row["assignstatus"]==1)
                            {
                                $stock = 'Assigned';
                            }
              
                       if($kolor%2==0)
                            $class="bgcolor='#ffffff'";
                       else
                            $class="bgcolor='#fff'";
                
                ?>
              <tr <?php print $class?>>
              <td><small><?php print $kolor++;?>.</small></td>
              <td><small><?php echo stripslashes($row["fname"]." ".$row["lname"]);?></small></td>
              <td><small><?php echo stripslashes($row["cname"]);?></small></td>
              <td><small><?php echo stripslashes($row["ph"]);?></small></td>
              <td><small><?php echo stripslashes($row["mob"]);?></small></td>
              <td><small><?php echo stripslashes($row["fdate"]);?></small></td>
              <td><small><a href="update_follow_up.php?id=<?php echo $row["cid"] ?>&token=<?php echo $token ?>">Follow-up</a></small></td>
              </tr>
		<?php 
	      }
	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
?> 
             <form method="post">
             <table>
             <tr>
             <td colspan="3"><input type="submit" name="submit" class="btn btn-primary btn-sm" value="Submit" id="submit" /></td>
             <td></td>
             </tr>
             </table>
             </form>   
             
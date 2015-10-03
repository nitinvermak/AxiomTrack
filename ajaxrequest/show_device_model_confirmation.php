<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch_id'];
$model=$_REQUEST['model'];
 
error_reporting(0);
if ($model == 0)
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B 
				where A.id = B.device_id and A.assignstatus ='1' and b.branch_confirmation_status ='0' order by id desc";
				/*select * from tbl_device_master as A, tbl_device_assign_branch as B where
	 			A.id =  B.device_id and A.assignstatus = '1' and B.branch_confirmation_status = 0
	 			 order by A.id desc*/
else
	$linkSQL = "select * from tbl_device_master as A, tbl_device_assign_branch as B
				where A.id = B.device_id and A.assignstatus= '1' and B.branch_confirmation_status ='0'";
	
 
$stockArr=mysql_query($linkSQL);

if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table border="0" width="100%" class="textlightblue">  ';
?>		
				  <?php if($_SESSION['sess_msg']!=''){?>
                  
							<tr>
                            <td class="textred" colspan="7" align="center"><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></td>
                            </tr>
							
				  <?php } ?>
                 
    	              <tr bgcolor='#000000'>
	                  <td width="4%">
	                  <b>Sl. No.</b>                  </td>                        
	                  <td width="14%">
	                  <b>Device Model</b>                  </td>  
	                  <td width="14%">
	                  <b>Device Id</b>                  </td>
	                  <td width="5%">
	                  <b> IMEI NO</b>                  </td>  
	                  <td width="14%">
	                  <b>Status</b>                  </td>
	                  <td width="20%">
	                  	<b>Actions</b>                  
	                 	 <div> 
                       	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                       	&nbsp;&nbsp;
                       	<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>
                       	</div>      
                      </td>   
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
				$class="bgcolor='#DCDCDC'";
  	
 	?>
                   <tr <?php print $class?>>
                          <td align="left" class="txt" valign="middle" ><?php print $kolor++;?>.</td>
						   <td align="left" valign="middle" class="txt" ><?php echo getdevicename(stripslashes($row["device_name"]));?></td>
                           <td align="left" class="txt"><?php echo stripslashes($row["id"]);?></td>	
						   <td align="left" class="txt"><?php echo stripslashes($row["imei_no"]);?></td>
                           	
						   <td align="left" class="txt"><?php echo stripslashes($row["date_of_purchase"]);?></td>			  
                           <td valign="middle" class="txt" align="left">
                        <input type='checkbox' name='linkID[]' value='<?php echo $row["id"]; ?>'></td>
                      </tr>
 
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3>No records found!</h3></td><tr/></table>";
?> 
                          </table> 
                          </div>
          				<form method="post">
                          <tr>
                          <td></td>
                          <td colspan="3"><input type="submit" name="submit" value="Submit" id="submit" /> </td>
                          <td></td>
                          </tr>
                   	    </form>   
                          </td>
              </tr>
           
            </table></td>
          </tr>
        </table></td>

      </tr>
    
    </table></td>
  </tr>
  <tr>
  <td>
  <img src="images/spacer.gif" width="100%" height="5px" />
  </td>
  </tr>
    <tr>
        <td height="28" bgcolor="#000000">
		<?php //include_once('footer.php');?>
		  
		  </td>
      </tr>
</table>
 
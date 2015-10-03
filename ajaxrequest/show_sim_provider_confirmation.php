<?php
include("../includes/config.inc.php"); 
//include("includes/crosssite.inc.php"); 
$branch_id=$_REQUEST['branch'];
$sim_provider=$_REQUEST['sim_provider'];
 
error_reporting(0);
if ($sim_provider == 0)
	{
	$linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id and B.branch_id='{$branch_id}' order by A.company_id";
	}
	else
	{
		 
		$linkSQL = "select * from tblsim as A, tbl_sim_branch_assign as B where A.id = B.sim_id and B.branch_id='{$branch_id}' and A.company_id='{$sim_provider}'";
		//echo $linkSQL;
 	}
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
	                  <td width="4%"><b>Sl. No.</b></td>                        
	                  <td width="14%"><b>Provider</b></td>  
	                  <td width="14%"><b>Sim No.</b></td>
	                  <td width="5%"><b>Mobile No.</b></td>  
	                  <td width="14%"><b>Date of Purchase</b></td>
                      <td width="14%"><b>Status</b></td>
	                  <td width="20%"><b>Actions</b>  
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>
                      &nbsp;&nbsp;
                      <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>
                      </div>      
                      </td>   
                  </tr>   
	
	<?php
	  	
	  $kolor = 1;
	  while ($row = mysql_fetch_array($stockArr))
  		{
 		   if($row["branch_assign_status"]==0)
			{
				$stock ='In Stock';
			}
			if($row["branch_assign_status"]==1)
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
				   <td align="left" class="txt"><?php echo getsimprovider(stripslashes($row["company_id"]));?></td>	
                   <td align="left" class="txt"><?php echo stripslashes($row["sim_no"]);?>
                   <input type="hidden" name="sim_no" value="<?php echo stripslashes($row["sim_no"]);?>" /></td>	
				   <td align="left" class="txt"><?php echo stripslashes($row["mobile_no"]);?>
                   <input type="hidden" name="mob_no" value="<?php echo stripslashes($row["mobile_no"]);?>" /></td>                           	
				   <td align="left" class="txt"><?php echo stripslashes($row["date_of_purchase"]);?></td>
                   <td align="left" class="txt"><?php echo stripslashes($stock);?></td>			  
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
 
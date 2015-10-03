<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$search_id = $_REQUEST['search_id']; 
error_reporting(0);
	/*echo $search_id;*/
	$linkSQL = "SELECT * FROM tblticket as A
				INNER JOIN tbl_ticket_assign_branch as B 
				ON A.ticket_id = B.ticket_id 
				INNER JOIN tbl_ticket_assign_technician as C
				ON B.ticket_id = C.ticket_id WHERE C.ticket_id='$search_id' and A.ticket_status='0'";
 
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
                  <td width="4%"><b>S. No.</b></td>     
                  <td width="4%"><strong>Ticket Id</strong></td> 
                  <td width="10%"><strong>Organization Name</strong></td>  
                  <td width="10%"><strong>Product</strong></td>
                  <td width="10%"><strong>Request Type</strong></td> 
                  <td width="10%"><strong>Created</strong></td> 
                  <td width="10%"><strong>Appointment Date Time</strong></td>              
                  <td width="20%">
                  <b>Actions</b>                  
                  <div> 
                  <a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',true)" style="color:#fff; font-size:11px;">Check All </a>&nbsp;&nbsp;<a href='#' onClick="SetAllCheckBoxes('fullform','linkID[]',false)" style="color:#fff; font-size:11px;">Uncheck All </a>             </div>                  
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
                 <td align="left" valign="middle" class="txt" ><?php echo stripslashes($row["ticket_id"]);?></td>
				 <td align="left" valign="middle" class="txt" ><?php echo getOraganization(stripslashes($row["organization_id"]));?></td>
				 <td align="left" valign="middle" class="txt" ><?php echo getproducts(stripslashes($row["product"]));?></td>
                 <td align="left" valign="middle" class="txt" ><?php echo getRequesttype(stripslashes($row["rqst_type"]));?></td>
				 <td align="left" valign="middle" class="txt" ><?php echo stripslashes($row["createddate"]);?></td>
                 <td align="left" valign="middle" class="txt" ><?php echo stripslashes($row["appointment_date"]." ".$row["appointment_time"]);?></td>
                 <td valign="middle" class="txt" align="left">
                 <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>"><span>Close</span></a>&nbsp;&nbsp;  <a href="close_ticket.php?ticket_id=<?php echo $row["ticket_id"];?>&token=<?php echo $token ?>"><span>Reschedule</span></a>
                 </td>
                 </tr>
	<?php 
	      }

 

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3>No records found!</h3></td><tr/></table>";
?> 
                          </table> 
                          </div>
          				<!--<form method="post">
                          <tr>
                          <td></td>
                          <td colspan="3"><input type="submit" name="submit" value="Submit" id="submit" /> </td>
                          <td></td>
                          </tr>
                   	    </form>   -->
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
 
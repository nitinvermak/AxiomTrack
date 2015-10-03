<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
$dateFrom = mysql_real_escape_string($_GET['dateFrom']);
$dateto = mysql_real_escape_string($_GET['dateto']);
$users = mysql_real_escape_string($_GET['users']);
error_reporting(0);
$linkSQL = "select A.createddate as Date, B.ticket_id as TicketId, A.product as Pid, A.rqst_type as VisitType, A.organization_id as 			Company, B.technician_id as Tid from tblticket as A 
			inner join tbl_ticket_assign_technician as B 
			on A.ticket_id = B.ticket_id" ;
			/*echo $linkSQL; */

if ( ( $dateFrom !='' and $dateto !='') or ($users != 0) ) {
	$linkSQL  = $linkSQL." WHERE ";	
}
$counter = 0;
if ( $dateFrom !='' and $dateto !='') {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
		$linkSQL  =$linkSQL." DATE(A.createddate) BETWEEN '$dateFrom' AND '$dateto'" ;
		$counter+=1;
		/*echo $linkSQL;*/
}
if ( $users != 0) {
	if ($counter > 0 )
	 	$linkSQL =$linkSQL.' AND ';
	$linkSQL  =$linkSQL."B.technician_id = '$users'" ;
	$counter+=1;
	/*echo $linkSQL;*/
}
$stockArr=mysql_query($linkSQL);
if(mysql_num_rows($stockArr)>0)
	{
	
	 	echo '  <table class="table table-bordered table-hover" id="my-table">  ';
?>                 
    	          <tr>
                  <th><small>S. No.</small></th>
                  <th><small>Date</small></th>         
                  <th><small>Ticket Id</small></th> 
                  <th><small>Product</small></th>
                  <th><small>Visit (Repair/New)</small></th>  
                  <th><small>Company Name</small></th>
                  <th><small>Executive</small></th>
                  <th><small>Description</small></th>
                  <th><small>KM Travelled</small></th> 
                  <th><small>Fare</small></th> 
                  <th><small>Amount</small></th> 
                  </tr>    
	
	<?php
	  $kolor =1;
	  while ($row = mysql_fetch_array($stockArr))
  		{  
 		   if($kolor%2==0)
				$class="bgcolor='#ffffff'";
		   else
				$class="bgcolor='#fff'";
  	
 	?>
       			 <tr <?php print $class?>>
                 <td><small><?php print $kolor++;?>.</small></td>
                 <td><small><?php echo stripslashes($row["Date"]);?></small></td>
				 <td><small><?php echo stripslashes($row["TicketId"]);?></small></td>
				 <td><small><?php echo getproducts(stripslashes($row["Pid"]));?></small></td>
                 <td><small><?php echo getRequesttype(stripslashes($row["VisitType"]));?></small></td>
				 <td><small><?php echo getOraganization(stripslashes($row["Company"]));?></small></td>
                 <td><small><?php echo gettelecallername(stripslashes($row["Tid"]));?></small></td>
                 <td><textarea name="description" style="width:100px;"></textarea></td>
                 <td>
                 <input type="text" name="kmTravel" id="kmTravel<?php print $kolor -1; ?>"  class="kmTravel" style="width:50px;">
                 </td>
                 <td><input type="text" name="fare" id="fare<?php print $kolor -1 ?>" 
                   onchange="calTotal(<?php print $kolor -1; ?>)"  class="fare" style="width:50px;"></td>
                 <td><input type="text" name="amount" id="amount<?php print $kolor-1; ?>" class="amount" style="width:50px;" readonly>                  <br>
                 <input type="button" class="clickbtn" onclick="chck()" value="Click"></td>
                 </tr>
	<?php 
	      }

 		  echo ' <input type="hidden" id="totalFields" value="'.($kolor-1).'">';	

	}
    else
   		 echo "<tr><td colspan=6 align=center><h3 style='color:red;'>No records found!</h3><br></td><tr/></table>";
?> 

 	
        <!-- Modal -->

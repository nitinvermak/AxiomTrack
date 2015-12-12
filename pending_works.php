<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 
if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) 
{
	session_destroy();
	header("location: index.php?token=".$token);
}
if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!--<script type="text/javascript" src="js/ticket_report.js"></script>-->
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script>
// calender script
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End calender script
// send ajax request
$(document).ready(function(){
	$("#submit").click(function(){
		$('.loader').show();
		$.post("ajaxrequest/view_technician_ticket_report.php?token=<?php echo $token;?>",
				{
					date : $('#date').val(),
					dateto : $('#dateto').val(),
					executive : $('#executive').val(),
					branch : $('#branch').val(),
					status : $('#status').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
//end
</script>
<!--Datepicker-->

<!--end--
</head>
<body>
<!--open of the wraper-->
<div id="wraper">
	<!--include header-->
    <?php include_once('includes/header.php');?>
    <!--end-->
    <!--open of the content-->
<div class="row" id="content">
	<div class="col-md-12">
    	<h3>Pending Ticket</h3>
      <hr>
    </div>
    <div class="col-md-12">
        
    <div class="table-responsive">
      <table class="table table-hover table-bordered ">
      <?php
		$where='';
		$linkSQL="";			
  		if(!isset($linkSQL) or $linkSQL =='')		
     	$linkSQL = "SELECT A.ticket_id as T_Id, A.organization_id as O_Id, 
					A.createddate as Create_date, A.close_date as C_date, 
					A.product as P_id, A.rqst_type as R_type, A.ticket_status as T_status, 
					A.appointment_date as ap_date, C.technician_id as T_name, B.branch_id as B_name
					FROM tblticket as A 
					LEFT OUTER JOIN tbl_ticket_assign_branch as B 
					ON A.ticket_id = B.ticket_id
					LEFT OUTER JOIN tbl_ticket_assign_technician as C 
					ON B.ticket_id = C.ticket_id
					LEFT OUTER JOIN tbluser as D 
					ON C.technician_id = D.id WHERE A.ticket_status <> 1 
					AND C.technician_id =".$_SESSION['user_id'];
   		$pagerstring = Pages($linkSQL,PER_PAGE_ROWS,'manage_area.php?',$token);
 		if(isset($_SESSION['linkSQL']))
 		$mSQL=$_SESSION['linkSQL']." ".$_SESSION['limit'];
 		$oRS = mysql_query($mSQL); 
 		?>
       <tr>
	   <th><small>S. No.</small></th>     
	   <th><small>Ticket Id.</small></th>  
       <th><small>Organization</small></th> 
       <th><small>Products</small></th> 
       <th><small>Purpose</small></th>  
       <th><small>Appointment Date</small></th> 
       <th><small>Action</small></th>                       
       </tr>  
	  <?php
		$kolor=1;
		if(isset($_GET['page']) and is_null($_GET['page']))
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']==1)
			{ 
				$kolor = 1;
			}
		elseif(isset($_GET['page']) and $_GET['page']>1)
			{
				$kolor = ((int)$_GET['page']-1)* PER_PAGE_ROWS+1;
			}
	  if(mysql_num_rows($oRS)>0)
	  	{
  			while ($row = mysql_fetch_array($oRS))
  			{
  				if($kolor%2==0)
					$class="bgcolor='#ffffff'";
				else
					$class="bgcolor='#fff'";
 	  ?>
       <tr <?php print $class?>>
       <td><small><?php print $kolor++;?>.</small></td>
       <td><small><?php echo stripslashes($row["T_Id"]);?></small></td>
       <td><small><?php echo getOraganization(stripslashes($row["O_Id"]));?></small></td>
       <td><small><?php echo getproducts(stripslashes($row["P_id"]));?></small></td>
       <td><small><?php echo getRequesttype(stripslashes($row["R_type"]));?></small></td>
       <td><small><?php echo $row["ap_date"];?></small></td>
       <td><small> 
       <a href="ticket_status_update.php?ticket_id=<?php echo $row["T_Id"];?>&token=<?php echo $token ?>" >Update Status</a>
       </small></td>            
       </tr> 
<?php }
		echo $pagerstring;
	  }
    else
    echo "<tr><td colspan=6 align=center><h3 style='color:red'>No records found!</h3><br></td><tr/></table>";
?>
    </table>
    </div>
    </div>
       
    </div>
</div>
<!--end of the content-->
<!--open of the footer-->
<div class="row" id="footer">
	<div class="col-md-12">
    <p>Copyright &copy; 2015 INDIAN TRUCKERS, All rights reserved.</p>
    </div>
</div>
<!--end footer-->
<!-- hidden loader division -->
<div class="loader">
	<img src="images/loader.gif" alt="loader">
</div>
<!-- end hidden loader division-->
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>

</html>
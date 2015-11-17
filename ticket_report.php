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
if(count($_POST['linkID'])>0 && (isset($_POST['submit'])) )
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
             	{
					$branch_id=$_POST['branch'];
					$status_id="1";
					$createdby=$_SESSION['user_id'];
					$check_ticketId = mysql_query("SELECT * FROM tbl_ticket_assign_branch WHERE ticket_id='$chckvalue'") or die(mysql_errno());
					if(!$row = mysql_fetch_array($check_ticketId) or die(mysql_error()))
					{
						$sql = "update tblticket set branch_assign_status='$status_id' where ticket_id='$chckvalue'";
						/*echo $sql;*/
						$results = mysql_query($sql); 	
						$assign = "insert into tbl_ticket_assign_branch set ticket_id= '$chckvalue', branch_id= '$branch_id', assign_by='$createdby', assign_date=Now()";
						/*echo $assign;*/
						$query = mysql_query($assign);
					}
					else
					{
						header("location: assign_ticket_branch.php?token=".$token);
					}
   			    }
			 }  
  		$id="";
}
if(count($_POST['linkID'])>0 && (isset($_POST['remove'])) )
   {			   
  		$dsl="";
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_ticket_assign_branch where 	ticket_id='$chckvalue'";
				$results = mysql_query($sql); 	
				$assign = "update tblticket set branch_assign_status='$status_id' where ticket_id='$chckvalue'";
				//echo $sql;
				$query = mysql_query($assign);
				/* echo $query;*/
	  			
   			   }
			 }  
  		$id="";
  
  }
if(isset($_POST['export']))
{
	echo "afhsafhsajkfh";
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
		$.post("ajaxrequest/view_ticket_report.php?token=<?php echo $token;?>",
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
// send ajax when select branch
$(document).ready(function(){
	$("#branch").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#showTechnician").html(data);
				});
	});
});
// End
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
    	<h3>Ticket Report</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12 table-responsive">
      <table class="form-field" width="100%">
     <tr>
     <td class="col-xs-1"><strong>Date (From)* </strong></td>
     <td class="col-xs-2"><input type="text" name="date" id="date" class="form-control text_box-sm date"/></td>
     <td class="col-xs-1"><strong>Branch*</strong></td>
	 <td class="col-xs-2">
     	<select name="branch" id="branch" class="form-control drop_down">
        	<option label="" value="" selected="selected">Select Branch</option>
            <?php 
            $branch_sql= "select * from tblbranch ";
            $authorized_branches = BranchLogin($_SESSION['user_id']);
            //echo $authorized_branches;
            if ( $authorized_branches != '0')
			{
             	$branch_sql = $branch_sql.' where id in '.$authorized_branches;		
            }
            if($authorized_branches == '0')
			{
            	echo'<option value="0">All Branch</option>';	
            }
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
      </select>
     </td>
     <td class="col-xs-1"><strong>Status*</strong></td>
     <td><select name="status" id="status" class="form-control drop_down-sm">
     	 <option value="" selected>All</option>
         <option value="0">Pending</option>
         <option value="1">Closed</option>
         <option value="2">Reschedule</option>
         </select></td>
     <td>&nbsp;</td>
     <td><p class="ico pull-right"><a name="export" id="export" href="ticket_report_export.php?token=<?php echo $token;?>" title="Download CSV"> <span class="glyphicon glyphicon-download-alt"></span></a></p></td>
     </tr>
      <tr>
     <td class="col-xs-1"><strong>Date&nbsp;(To)*</strong></td>
     <td class="col-xs-2"><input type="text" name="dateto" id="dateto" class="form-control text_box-sm date"/></td>
     <td class="col-xs-1"><strong>Executive*</strong></td>
	 <td class="col-xs-2">  
     <div id="showTechnician">
     	<select name="executive" id="executive" class="form-control drop_down-sm">
        <option value="">Select Executive</option>                         
        </select>
     </div>
     </td>
     <td>&nbsp;</td>
     <td><input type="button" name="assign" value="Submit" id="submit" class="btn btn-primary btn-sm pull-left"/>&nbsp;<input type="button" name="assign" value="Summary" onClick="window.location.replace('ticket_summary.php?token=<?php echo $token;?>')" id="submit" class="btn btn-primary btn-sm" /></td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
      <?php
		$where='';
		$linkSQL="";	
   		$oRS = mysql_query($linkSQL); 
  		?>
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
    	<input type='hidden' name='pagename' value='assigncontacts'>            	
        <div id="divassign" class="col-md-12 table-responsive assign_grid">
       		<!-- Ajaxrequest-->
      	</div>
    </form>
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
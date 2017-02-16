<?php
include("includes/config.inc.php"); 
include("includes/crosssite.inc.php"); 

if ( isset ( $_GET['logout'] ) && $_GET['logout'] ==1 ) {
	session_destroy();
	header("location: index.php?token=".$token);
}

if (isset($_SESSION) && $_SESSION['login']=='') 
{
	session_destroy();
	header("location: index.php?token=".$token);
}


 if(count($_POST['linkID'])>0)
   {			   
  		$dsl="";
		if(isset($_POST['linkID']) && (isset($_POST['submit'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$technician_id=$_POST['technician_id'];
		  		$status_id="1";
		  		$createdby=$_SESSION['user_id'];
				$sql = "insert into tbl_ticket_assign_technician set ticket_id='$chckvalue', technician_id ='$technician_id', assigned_date	=Now()";
				$results = mysql_query($sql);
	  			$assign_technician = "update tbl_ticket_assign_branch set technician_assign_status='$status_id' where ticket_id='$chckvalue'";
				/*echo $assign_technician;*/
				$confirm = mysql_query($assign_technician);
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
	   	  		$technician_id=$_POST['technician_id'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_ticket_assign_technician where ticket_id='$chckvalue'";
				$results = mysql_query($sql); 	
				$assign = "update tbl_ticket_assign_branch set 	technician_assign_status='$status_id' where ticket_id='$chckvalue'";
				
				$query = mysql_query($assign);
   			   }
			 }  
  		$id="";
  
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="images/ico.png" type="image/x-icon">
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script>
 $(function() {
    $( "#dateform" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
  $(function() {
    $( "#dateto" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>
<script type="text/javascript" language="javascript">
// filter Records
$(document).ready(function(){
	$("#search").click(function(){
		$.post("ajaxrequest/update_assign_ticket_branch.php?token=<?php echo $token;?>",
				{
					dateform : $('#dateform').val(),
					branch	:	$('#branch').val(),
					users	:	$('#users').val(),
					dateto	:	$('#dateto').val()
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
	});
});
// filter by ticketId
$(document).ready(function(){
	$("#searchById").click(function(){
		$.post("ajaxrequest/update_assign_ticket_techician.php?token=<?php echo $token;?>",
				{
					ticket_id : $('#ticket_id').val()
				},
					function( data){
						/*alert(data);*/
						$("#divassign").html(data);
				});	 
	});
});
//End
</script>
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
    	<h3> Update Ticket</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' method='post' class="form-inline">
	<table class="form-field" width="100%">
     <tr>
     <td class="col-xs-1"><strong>Executive*</strong></td>
     <td class="col-xs-2"><select name="users" id="users" class="form-control drop_down-sm" style="max-width:140px;">
       <option value="0">All Executive</option>
       <?php
                $branch = $_SESSION['branch']; 
                $Country=mysql_query("select * from tbluser where branch_id = '$branch' ORDER BY First_Name, Last_Name ASC");
                    while($resultCountry=mysql_fetch_assoc($Country)){
           ?>
       <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
       <?php } ?>
     </select></td>
     <td class="col-xs-1"><input type="button" name="search" id="search" value="Submit" class="btn btn-primary btn-sm" onClick="return ShowRecords()"/></td>
     <td class="col-xs-2">&nbsp;</td>
     <td class="col-xs-1">&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td></td>
     </tr>
      <tr>
     <td class="col-xs-1">&nbsp;</td>
     <td class="col-xs-2">&nbsp;</td>
     <td class="col-xs-1">&nbsp;</td>
     <td class="col-xs-2">&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
      <tr>
        <td class="col-xs-1">&nbsp;</td>
        <td class="col-xs-2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
     </table>
    </form>
     <div class="col-md-6">
        	<p class="form_span">
        	   </p>
    </div>
    <div class="col-md-12" id="divassign"> 
    
         
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
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
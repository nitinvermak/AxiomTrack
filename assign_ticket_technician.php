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
				$technician_id = $_POST['executive'];
		  		$status_id = "1";
		  		$createdby = $_SESSION['user_id'];
		  		/*$ticketId = mysql_real_escape_string($_POST['ticketId']);*/
		  		$companyName = mysql_real_escape_string($_POST['companyName']);
		  		$requestType = mysql_real_escape_string($_POST['requestType']);
		  		$organizationContact = mysql_real_escape_string($_POST['organizationContact']);
		  		$description = mysql_real_escape_string($_POST['description']);
				$vehicleNo = mysql_real_escape_string($_POST['vehicleNo']);

		  		$mssg = 'T Id: '.$chckvalue.' '.'Cmpny: '.$companyName.' '.'Rqst.: '.$requestType.' '.' Veh.: '.$vehicleNo.' '.'Mob.: '.$organizationContact.' '.'Rmrk. '.$description;
		  		//echo $mssg.'<br>'.$technician_id;
				$check_ticketId = mysql_query("SELECT * FROM tbl_ticket_assign_technician 
											   WHERE ticket_id='$chckvalue'");
					if(mysql_num_rows($check_ticketId) <= 0)
					{ 
						$sql = "insert into tbl_ticket_assign_technician set ticket_id='$chckvalue', 
								technician_id = '$technician_id', assigned_by = '$createdby', 
								assigned_date	= Now()";
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
						// End Activity Log Function
						$results = mysql_query($sql);

						$assign_technician = "update tbl_ticket_assign_branch set technician_assign_status = '$status_id' 
											  where ticket_id='$chckvalue'";
						$confirm = mysql_query($assign_technician);
						$_SESSION['sess_msg'] = "<span style='color:#006600;'>Ticket Assign Successfully</span>";
						
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $assign_technician);
						// End Activity Log Function
						
						// Call sms send function
						sendTicketAlert($technician_id, $mssg);
						
					}
					else
					{
						$_SESSION['sess_msg'] = "<span style='color:red;'>Ticket already Assign</span>";
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
	   	  		$technician_id=$_POST['technician_id'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_ticket_assign_technician where ticket_id='$chckvalue'";
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
				// End Activity Log Function
				$results = mysql_query($sql); 	
				$assign = "update tbl_ticket_assign_branch set 	technician_assign_status='$status_id' 
						   where ticket_id='$chckvalue'";
				 				
				$query = mysql_query($assign);
				$_SESSION['sess_msg']="<span style='color:red;'>Ticket Removed</span>";
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
<!-- Bootstrap Datatable CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript" src="js/ticket_assign_technician.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Jquery Latest CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- DataTable CDN-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
// send ajax request when click assign ticket button
$(document).ready(function(){
	$("#unassign").click(function(){
		$('.loader').show();
		$.post("ajaxrequest/assign_ticket_branch_technician.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$('#example').DataTable();
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// end
// send ajax request when click assigned ticket
$(document).ready(function(){
	$("#assign_view").click(function(){
		$('.loader').show();
		$.post("ajaxrequest/view_assign_ticket_branch_technician.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val(),
					executive : $('#executive').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$('#example1').DataTable();
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// end
// send ajax when select branch
$(document).ready(function(){
	$("#branch").change(function(){
		$.post("ajaxrequest/executive_ticket.php?token=<?php echo $token;?>",
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
    	<h3> Assign Executive</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
     	<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Branch*</label>
                <div class="col-sm-10">
                 	<select name="branch" id="branch" class="form-control drop_down">
	                <option label="" value="" selected="selected">Select Branch</option>
	                
	                  <?php 
	                        $branch_sql= "select * from tblbranch ";
	                        $authorized_branches = BranchLogin($_SESSION['user_id']);
	                        //echo $authorized_branches;
	                        if ( $authorized_branches != '0'){
	                             
	                            $branch_sql = $branch_sql.' where id in '.$authorized_branches;		
	                        }
	                        if($authorized_branches == '0'){
	                            echo'<option value="0">All Branch</option>';	
	                        }
	                        //echo $branch_sql;
	                        $Country = mysql_query($branch_sql);					
	                                                      
	                        while($resultCountry=mysql_fetch_assoc($Country)){
	                  ?>
	                <option value="<?php echo $resultCountry['id']; ?>" >
	                <?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?>
	                </option>
	                <?php } ?>
	                </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" >
                <label for="inputEmail3" class="col-sm-2 control-label">Executive*</label>
                <div class="col-sm-10" id="showTechnician">
                  <select name="executive" id="executive" class="form-control drop_down">
            		<option label="" value="" selected="selected">Select Technician</option>
            	 </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
             <div class="col-sm-10 pull-right">
               <input type="button" name="unassign" id="unassign" value="Assign Ticket" class="btn btn-primary btn-sm" />
               <input type="button" name="assign_view" id="assign_view" value="Assigned Ticket" class="btn btn-primary btn-sm" />
               </div>
            </div>
        </div>
        </div>
       	 <?php
		 $where='';
		 $linkSQL="";
  		 ?>
		 <input type="hidden" name="token" value="<?php echo $token; ?>" />
    	 <input type='hidden' name='pagename' value='assigncontacts'> 
		<div class="col-md-12"> 
		   <!--<div id="messages" class="hide" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
				</button>--->
				 <?php if($_SESSION['sess_msg']!='')
					{
						echo "<p class='success-msg'>".$_SESSION['sess_msg'];$_SESSION['sess_msg']=''."</p>";
					} 
				 ?>
                  <?php if($_SESSION['ticket_msg']!='')
					{
						echo "<p class='success-msg'>".$_SESSION['ticket_msg'];$_SESSION['ticket_msg']=''."</p>";
					} 
				 ?>
		  <!-- </div>--->
		  </div>
        <div id="divassign" class="col-md-12 table-responsive assign_grid">
       		<!-- Ajaxrequest-->
      	</div>
    </form>
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
<!--<script src="js/jquery.js"></script>-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
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
					$branch_id = $_POST['branch'];
					$status_id = "1";
					$createdby = $_SESSION['user_id'];
					$check_ticketId = mysql_query("SELECT * FROM tbl_ticket_assign_branch 
												   WHERE ticket_id='$chckvalue'");
					if(mysql_num_rows($check_ticketId) <= 0)
					{
						$sql = "update tblticket set branch_assign_status='$status_id' where ticket_id='$chckvalue'";
						/*echo $sql;*/
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
						// End Activity Log Function
						$results = mysql_query($sql); 	
						$assign = "insert into tbl_ticket_assign_branch set ticket_id= '$chckvalue', 
								   branch_id= '$branch_id', assign_by='$createdby', assign_date=Now()";
						/*echo $assign;*/
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $assign);
						// End Activity Log Function
						$query = mysql_query($assign);
						$_SESSION['sess_msg'] = "<span style='color:#006600;'>Ticket Branch Assign Successfully</span>";
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
	   	  		$branch_id=$_POST['branch'];
		  		$status_id="0";
		  		$createdby=$_SESSION['user_id'];
				$sql = "delete from tbl_ticket_assign_branch where 	ticket_id='$chckvalue'";
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $sql);
				// End Activity Log Function
				$results = mysql_query($sql); 	
				$assign = "update tblticket set branch_assign_status='$status_id' where ticket_id='$chckvalue'";
				//echo $sql;
				// Call User Activity Log function
				UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], $assign);
				// End Activity Log Function
				$query = mysql_query($assign);
				/* echo $query;*/
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
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="http://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!--<script type="text/javascript" src="js/assign_ticket_branch.js"></script>-->
<script type="text/javascript" src="js/checkValidation.js"></script>
<script>
 $(function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
</script>
<script type="text/javascript">
function confirmdelete(obj)
	{
		if(obj.branch.value == "")
		{
			alert("Please Select Branch");
			obj.branch.focus();
			return false;
		}
	}
// call ajax when click assign ticket
$(document).ready(function(){
	$('#assign').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/show_ticket_unassigned.php?token=<?php echo $token;?>",
				{
					date : $('#date').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// end
// call ajax when click assign ticket
$(document).ready(function(){
	$('#view').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/show_ticket_assigned.php?token=<?php echo $token;?>",
				{
					date : $('#date').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// end
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
    	<h3>Ticket Assign</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this);">
      <div class="col-md-12">
     	<div class="col-md-6">
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">Date*</label>
                <div class="col-sm-10">
                  <input type="text" name="date" id="date" class="form-control text_box"/>
                </div>
            </div>
        </div>
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
                    <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                    <?php } ?>
                 </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
             <div class="col-sm-10 pull-right">
               <input type="button" name="assign" value="Assign Ticket" id="assign" class="btn btn-primary btn-sm"/>
               <input type="button" name="view" id="view" value="View Assigned Ticket" class="btn btn-primary btn-sm"/>
               </div>
            </div>
        </div>
        </div>
        <?php
		$where='';
		$linkSQL="";	
   		$oRS = mysql_query($linkSQL); 
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
<script src="js/bootstrap.min.js"></script>
</body>

</html>
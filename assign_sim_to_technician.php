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
				$technician_id = $_POST['technician_id'];
				$status = 1;
				$assignby = $_SESSION['user_id'];
				$check_deviceId = mysql_query("SELECT * FROM tbl_sim_technician_assign WHERE sim_id='$chckvalue'"); 
                if(mysql_num_rows($check_deviceId) <= 0)
					{
						$sql = "insert into tbl_sim_technician_assign set sim_id='$chckvalue', assigned_by = '$assignby', 
								technician_id='$technician_id', assigned_date=Now()";
						/*echo $sql;*/
						$results = mysql_query($sql);	
						$assign_techician = "update tbl_sim_branch_assign set technician_assign_status= '$status' 
											 where sim_id='$chckvalue'";
						$query = mysql_query($assign_techician);
						// Call User Activity Log function
						UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
						$sql."<br>".$assign_techician);
						$_SESSION['sess_msg']="<span style='color:#006600;'>Sim Assign Successfully</span>";	
					}
					else
					{
						$_SESSION['sess_msg']="<span style='color:red;'>Sim already Assign</span>";
					}
				}  		
   			  }
			}  
  		$id="";

// Remove Assign Sim

		if(isset($_POST['linkID']) && (isset($_POST['remove'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
				$status = 0;
		   		$sql = "DELETE FROM tbl_sim_technician_assign WHERE sim_id = '$chckvalue'";
				/*echo $sql;*/
				$results = mysql_query($sql);	
				$assign_techician = "update tbl_sim_branch_assign set technician_assign_status= '$status' 
									 where sim_id='$chckvalue'";
				/*echo $assign_techician;*/
				// Call User Activity Log function
			    UserActivityLog($_SESSION['user_id'], $_SERVER['REMOTE_ADDR'], $_SERVER['PHP_SELF'], 
				$sql."<br>".$assign_techician);
				$query = mysql_query($assign_techician);
				$_SESSION['sess_msg']="<span style='color:red;'>Sim Removed</span>";   		
   			   }
			 }  
  		$id="";

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
<!-- Jquery Latest CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- DataTable CDN-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script type="text/javascript">
// pass ajax request when click assign sime
$(document).ready(function(){
	$("#assign_sim").click(function(){
		$('.loader').show();
		$.post("ajaxrequest/assign_sim_branch_technician.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$('#example').DataTable({ "bPaginate": false });
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// end 
// pass ajax request when click view assign
$(document).ready(function(){
	$('#view_assign').click(function(){
	$('.loader').show();
	$.post("ajaxrequest/view_assign_sim_branch_technician.php?token=<?php echo $token;?>",
				{
					technician_id : $('#technician_id').val(),
					branch : $('#branch').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$('#example1').DataTable({ "bPaginate": false });
						
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// end
// send ajax when select branch
$(document).ready(function(){
	$("#branch").change(function(){
		$.post("ajaxrequest/get_branch_technician.php?token=<?php echo $token;?>",
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
    	<h3>Assign Technician</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post'>
      <div class="col-md-12">
      	<div class="form-group">
    		<label for="exampleInputName2">Branch</label>
            	<select name="branch" id="branch" class="form-control drop_down" >
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
						else {
							echo'<option value="">--Select--</option>';
						}	
                        //echo $branch_sql;
                        $Country = mysql_query($branch_sql);					
                                                      
                        while($resultCountry=mysql_fetch_assoc($Country)){
                  ?>
                <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
                <?php } ?>
                </select>
  		</div>
        <div class="form-group" id="showTechnician">
            <label for="exampleInputEmail2">Technician</label>
            	<select name="technician_id" id="technician_id" class="form-control drop_down">
                <option label="" value="" selected="selected">All</option>
               
                </select>
        </div>
  		<input type="button" name="assign_sim" id="assign_sim" value="Assign Sim" class="btn btn-primary btn-sm"/>
        <input type="button" name="view_assign" id="view_assign" value="View Assign" class="btn btn-primary btn-sm"  />
      </div> 
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
          <!---- this division shows the Data of devices from Ajax request --->
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
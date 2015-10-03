<?php
//echo("hi");
//die;
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
<title><?=SITE_PAGE_TITLE?></title>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-submenu.min.css">
<link rel="stylesheet" href="css/custom.css">
<script type="text/javascript" src="js/checkbox_validation_assign_pages.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript" src="js/ticket_assign_technician.js"></script>
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
                  <option label="" selected="selected">Select Branch</option>
                  <option value="0">All Branch</option>
                  <?php $Country=mysql_query("select * from tblbranch");									  
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
                <label for="inputEmail3" class="col-sm-2 control-label">Executive*</label>
                <div class="col-sm-10">
                  <select name="technician_id" id="technician_id" class="form-control drop_down" onChange="return ShowByTechnician();">
                  <option label="" value="" selected="selected">Select Executive</option>
                  <?php $Country=mysql_query("select * from tbluser");
						while($resultCountry=mysql_fetch_assoc($Country)){
				  ?>
                  <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['First_Name']." ". $resultCountry["Last_Name"])); ?></option>
                  <?php } ?>
                  </select>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
             <div class="col-sm-10 pull-right">
               <input type="button" name="unassign" value="Assign Ticket" class="btn btn-primary" onClick="return ShowByBranch()" />
               <input type="button" name="assign_view" value="Assigned Ticket" class="btn btn-primary" onClick="return ShowByBranchAssigned()" />
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
</div>
<!--end wraper-->
<!-------Javascript------->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
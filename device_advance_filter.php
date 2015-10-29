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
<script type="text/javascript" src="js/installed_vehicle_report.js"></script>
<script>
// date picker
 $(function() {
    $( "#dateFrom" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
  $(function() {
    $( "#dateTo" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
 // End date picker
//send ajax request
$(document).ready(function(){
	$('#filter').click(function(){
		$.post("ajaxrequest/show_device_details.php?token=<?php echo $token;?>",
				{
					dateFrom : $('#dateFrom').val(),
					dateTo : $('#dateTo').val(),
					statusDevice : $('#statusDevice').val()
				},
					function(data){
						/*alert(data);*/
						$("#divShow").html(data);
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
    	<h3>Device  Report</h3>
        <hr>
    </div>
   
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
    <div class="col-md-12 table-responsive">
     <table class="form-field" width="100%">
     <tr>
     <td width="10%">Date (From)* </td>
     <td width="18%"><input type="text" name="dateFrom" id="dateFrom" class="form-control text_box-sm"></td>
     <td width="7%">Status</td>
     <td width="16%"><select name="statusDevice" id="statusDevice" class="form-control drop_down-sm">
             <option value="">All Device</option>                         
             <option value="1">Installed</option>
             <option value="0">Instock</option>
        </select>     
     </td>
     <td width="30%"><input type="button" name="filter" value="Submit" id="filter" class="btn btn-primary btn-sm"/></td>
     <td width="15%">&nbsp;</td>
     <td width="2%">&nbsp;</td>
     <td width="2%"><p class="ico"><a href="vehicle_report_csv.php?token=<?php echo $token;?>" title="Download CSV"> <span class="glyphicon glyphicon-download-alt"></span></a></p></td>
     </tr>
      <tr>
     <td>Date&nbsp;(To)*</td>
     <td><input type="text" name="dateTo" id="dateTo" class="form-control text_box-sm"></td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
     <td>&nbsp;</td>
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
    </div>
	
      <div class="col-md-12" style="margin-top:10px;"></div> 
      
      <div id="divShow" class="col-md-12 table-responsive assign_grid">
		<!-- Show Data from Ajax Request -->
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
<script src="js/bootstrap.min.js"></script>
</body>
</html>
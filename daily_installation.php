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
// Configure New Vehicle Status
if(count($_POST['linkID'])>0)
	{			   
  		$dsl="";
		if(isset($_POST['linkID']) &&(isset($_POST['submitNew'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	            $sql = "UPDATE tempvehicledata SET configStatus = 'Y' WHERE id = '$chckvalue'";
				//echo $sql;
				$results = mysql_query($sql);
		  		$_SESSION['sess_msg']="Configuration Successfully!";
   			   }
			 }  
  		$id="";
		if(isset($_POST['linkID']) &&(isset($_POST['submitRepair'])))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
	            $sql = "UPDATE tempvehicledatarepair SET configStatus = 'Y' WHERE id = '$chckvalue'";
				//echo $sql;
				$results = mysql_query($sql);
		  		$_SESSION['sess_msg']="Configuration Successfully!";
   			   }
			 }  
  		$id="";
    }
// End	
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
<script type="text/javascript" src="js/checkValidation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<script type="text/javascript">
// Divison Show and Hide
function newInstallation() {
    document.getElementById("newReport").style.display = "";
	document.getElementById("repariReport").style.display = "none";
	
}

function repairInstallation() {
//alert("test");
   document.getElementById("newReport").style.display = "none";
   document.getElementById("repariReport").style.display = "";
}
// End Divison Show and Hide
// Datepicker script
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End Datepicker
// Send Ajax Request When Search New Installation Details
$(document).ready(function(){
	$('#searchNew').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/daily_installation_details.php?token=<?php echo $token;?>",
				{
					depositDateFrom : $('#depositDateFrom').val(),
					depositDateTo : $('#depositDateTo').val(),
					branch : $('#branch').val(),
					executive : $('#executive').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassignNew").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// End
// Send Ajax Request When Search Repair Installation Details
$(document).ready(function(){
	$('#searchRepair').click(function(){
		$('.loader').show();
		$.post("ajaxrequest/repair_installation_details.php?token=<?php echo $token;?>",
				{
					depositDateFrom : $('#depositDateFrom').val(),
					depositDateTo : $('#depositDateTo').val(),
					branch : $('#branch').val(),
					executive : $('#executive').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassignRepair").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
	});
});
// End
// send ajax when select branch
$(document).ready(function(){
	$("#branchNew").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $('#branchNew').val()
				},
					function(data){
						/*alert(data);*/
						$("#showTechnicianNew").html(data);
				});
	});
});
// End
// send ajax when select branch
$(document).ready(function(){
	$("#branchRepair").change(function(){
		$.post("ajaxrequest/executive.php?token=<?php echo $token;?>",
				{
					branch : $('#branchRepair').val()
				},
					function(data){
						/*alert(data);*/
						$("#showTechnicianRepair").html(data);
				});
	});
});
// End
// export CSV
$(document).ready(function () {
	 console.log("HELLO")
            function exportTableToCSV($table, filename) {
				console.log("HELLO")
                var $headers = $table.find('tr:has(th)')
                    ,$rows = $table.find('tr:has(td)')

                    // Temporary delimiter characters unlikely to be typed by keyboard
                    // This is to avoid accidentally splitting the actual contents
                    ,tmpColDelim = String.fromCharCode(11) // vertical tab character
                    ,tmpRowDelim = String.fromCharCode(0) // null character

                    // actual delimiter characters for CSV format
                    ,colDelim = '","'
                    ,rowDelim = '"\r\n"';

                    // Grab text from table into CSV formatted string
                    var csv = '"';
                    csv += formatRows($headers.map(grabRow));
                    csv += rowDelim;
                    csv += formatRows($rows.map(grabRow)) + '"';

                    // Data URI
                    var csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

                // For IE (tested 10+)
                if (window.navigator.msSaveOrOpenBlob) {
                    var blob = new Blob([decodeURIComponent(encodeURI(csv))], {
                        type: "text/csv;charset=utf-8;"
                    });
                    navigator.msSaveBlob(blob, filename);
                } else {
                    $(this)
                        .attr({
                            'download': filename
                            ,'href': csvData
                            //,'target' : '_blank' //if you want it to open in a new window
                    });
                }

                //------------------------------------------------------------
                // Helper Functions 
                //------------------------------------------------------------
                // Format the output so it has the appropriate delimiters
                function formatRows(rows){
                    return rows.get().join(tmpRowDelim)
                        .split(tmpRowDelim).join(rowDelim)
                        .split(tmpColDelim).join(colDelim);
                }
                // Grab and format a row from the table
                function grabRow(i,row){
                     
                    var $row = $(row);
                    //for some reason $cols = $row.find('td') || $row.find('th') won't work...
                    var $cols = $row.find('td'); 
                    if(!$cols.length) $cols = $row.find('th');  

                    return $cols.map(grabCol)
                                .get().join(tmpColDelim);
                }
                // Grab and format a column from the table 
                function grabCol(j,col){
                    var $col = $(col),
                        $text = $col.text();

                    return $text.replace('"', '""'); // escape double quotes

                }
            }


            // This must be a hyperlink
          $(document).on("click","#export", function(){
                // var outputFile = 'export'
                var outputFile = window.prompt("Please Enter the name your output file.") || 'Installation Report';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('.dvData > table'), outputFile]);
                
                // IF CSV, don't do event.preventDefault() or return false
                // We actually need this to be a typical hyperlink
            });
         })
//end
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
    	<h3>Installation Report</h3>
        <hr>
    </div>
	 <div class="col-md-12 select_form">
    	<div class="radio-inline">
              <label>
                <input type="radio" name="rdopt"  value="Single Contact"  checked="checked" id="single" onClick="newInstallation()" /> 
                New Installation Report </label>
    	</div>
        <div class="radio-inline">
        <label>
              <input type="radio" name="rdopt"  value="Upload Multiple Contacts"  id="multiple" onClick="repairInstallation()"/>
              Repair Installation Report</label>
         </div>
    </div>    
<!----- New Installation Report Section ---->
    <div class="col-md-12" id = "newReport">
	<div class="col-md-12"><h5 class="small-title">New Installation Details</h5></div>
    <form name='fullform' class="form-inline"  method='post'>
      <div class="col-md-12">
      <table width="715">
      <tr>
      <td width="95"><strong>Date (From)* </strong></td>
      <td width="173"><input type="text" name="depositDateFrom" id="depositDateFrom" class="form-control text_box date"></td>
      <td width="114"><strong>Branch</strong></td>
      <td width="230">
      	<select name="branch" id="branchNew" class="form-control drop_down">
        	<option label="" value="" selected="selected">All Branch</option>
            <?php 
            $branch_sql= "select * from tblbranch ";
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
      	</select>
      </td>
      <td width="79">&nbsp;</td>
      </tr>
      <tr>
      <td><strong>Date (To)*</strong></td>
      <td><input type="text" name="depositDateTo" id="depositDateTo" class="form-control text_box date"></td>
      <td><strong>Executive</strong></td>
      <td>
      		<span id="showTechnicianNew">
            <select name="executive" id="executive" class="form-control drop_down-sm">
            <option value="">Select Executive</option>                         
            </select>
           	</span>
      </td>
      <td><input type="button" name="searchNew" id="searchNew" value="Search" class="btn btn-primary btn-sm"></td>
      </tr>
      </table>
  	  </div> 
      <div id="divassignNew" class="col-md-12 table-responsive report dvData">
			<?php if($_SESSION['sess_msg']!=''){?>
                <center>
                    <div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;">
                    <?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?>
                    </div>
                </center>
  	 		<?php } ?>
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
    </form>
    </div>
<!--------- End New Installation Report --------->
<!---------- Repair Installation Report Section --------->
<div class="col-md-12" id = "repariReport" style="display:none;">
	<div class="col-md-12"><h5 class="small-title">Repair Installation Details</h5></div>
    <form name='fullform' class="form-inline"  method='post'>
      <div class="col-md-12">
      <table width="715">
      <tr>
      <td width="95"><strong>Date (From)* </strong></td>
      <td width="173"><input type="text" name="depositDateFrom" id="depositDateFrom" class="form-control text_box date"></td>
      <td width="114"><strong>Branch</strong></td>
      <td width="230">
      	<select name="branch" id="branchRepair" class="form-control drop_down">
        	<option label="" value="" selected="selected">All Branch</option>
            <?php 
            $branch_sql= "select * from tblbranch ";
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
      	</select>
      </td>
      <td width="79">&nbsp;</td>
      </tr>
      <tr>
      <td><strong>Date (To)*</strong></td>
      <td><input type="text" name="depositDateTo" id="depositDateTo" class="form-control text_box date"></td>
      <td><strong>Executive</strong></td>
      <td>
      		<span id="showTechnicianRepair">
            <select name="executive" id="executive" class="form-control drop_down-sm">
            <option value="">Select Executive</option>                         
            </select>
           	</span>
      </td>
      <td><input type="button" name="searchRepair" id="searchRepair" value="Search" class="btn btn-primary btn-sm"></td>
      </tr>
      </table>
  	  </div> 
      <div id="divassignRepair" class="col-md-12 table-responsive report dvData">
          <!---- this division shows the Data of devices from Ajax request --->
      </div>
    </form>
    </div>
<!-----------------End Repair Installation ---------------------->
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
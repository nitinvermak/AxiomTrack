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
//Delete single record
if(isset($_GET['id']))
	{
		$id = $_GET['id'];
		$delete_single_row = "DELETE FROM tbluser WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End

//Delete multiple records
if(count($_POST['linkID'])>0 && (isset($_POST['delete_selected'])) )
   {			   
		if(isset($_POST['delete_selected']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		       	$sql = "DELETE FROM tbluser WHERE id='$chckvalue'";
				$result = mysql_query($sql);
   			   }
			   if($result)
			   {
			   echo "<script> alert('Records Deleted Successfully'); </script>";
			   }
			 }    
  }
//end
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
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<!-- Jquery Latest CDN -->
<script type="text/javascript" src="https://code.jquery.com/jquery-1.12.0.min.js"></script>
<!-- DataTable CDN-->
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('#example').DataTable();
});

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
                var outputFile = window.prompt("Please Enter the name your output file.") || 'deviceReport';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#dvData > table'), outputFile]);
                
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
    	<h3>Payment Profile</h3>
        <hr>
    </div>
    <div class="col-md-12">
    
    </div>
    <div class="col-md-12">
        
    <div class="table-responsive">
    <div class="col-md-12">
			<div class="download pull-right">
				<a href="#" id ="export" role="button" class="red"><span class="glyphicon glyphicon-save"></span></a>
		    </div>
    </div>
    <div id="dvData">
    <table class="table table-striped table-bordered" cellspacing="0" width="100%">
    <?php 		
    $linkSQL = "SELECT B.callingdata_id as companyId, A.vehicle_no as vehicleNo, A.installation_date as activationDate,
	 			C.service_branchId as assignBranch, B.LeadGenBranchId as refer, C.service_area_manager as areaManager, 
				C.service_executive as serviceExecutive 
				FROM tbl_gps_vehicle_master as A 
				INNER JOIN tbl_customer_master as B 
				ON A.customer_Id = B.cust_id
				LEFT OUTER JOIN tbl_assign_customer_branch as C 
				ON B.cust_id = C.cust_id
				WHERE A.paymentActiveFlag = 'N' 
				AND A.activeStatus = 'Y'  
				ORDER BY A.installation_date";
   	$oRS = mysql_query($linkSQL); 
   ?>
               	        
   <?php if($_SESSION['sess_msg']!=''){?>
	 		<center>
            <div style="color:#009900; padding:0px 0px 10px 0px; font-weight:bold;"><?php echo $_SESSION['sess_msg'];$_SESSION['sess_msg']='';?></div>
            </center>
   <?php } ?>
   	  <thead>
      <tr>
      	<th><small>S. No.</small></th>
        <th><small>Company Name</small></th>
        <th><small>Vehicle No.</small></th>
        <th><small>ActivationDate</small></th>
        <th><small>Assign Branch</small></th>
        <th><small>Refer by</small></th>
        <th><small>Area Manager</small></th>
        <th><small>Service Executive</small></th>
      </tr>   
      </thead> 
	  <?php
	  $kolor=1;
	  if(mysql_num_rows($oRS)>0)
	  	{
  			while ($row = mysql_fetch_array($oRS))
  			{
 	  ?>
      <tr>
          <td><small><?php print $kolor++;?>.</td>
          <td><small><?php echo getOraganization(stripslashes($row["companyId"]));?></small></td>
          <td><small><?php echo stripslashes($row["vehicleNo"]);?></small></td>
          <td><small><?php echo stripslashes($row["activationDate"]);?></small></td>
          <td><small><?php echo getBranch(stripslashes($row["assignBranch"]));?></small></td>
          <td><small><?php echo gettelecallername(stripslashes($row["refer"]));?></small></td>
          <td><small><?php echo gettelecallername(stripslashes($row["areaManager"]));?></small></td>
          <td><small><?php echo gettelecallername(stripslashes($row["serviceExecutive"]));?></small></td>
      </tr>
<?php }
	}
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
</div>
<!--end wraper-->
<!-------Javascript------->
<!--<script src="js/jquery.js"></script>-->
<script src="js/bootstrap.min.js"></script>
</body>
</html>
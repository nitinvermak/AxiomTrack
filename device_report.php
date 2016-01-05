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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script type="text/javascript" src="js/checkbox.js"></script>
<script  src="js/ajax.js"></script>
<script type="text/javascript">
// send ajax request when select branch
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
// send ajax request when select branch
/*$(document).ready(function(){
	$("#installedStatus").change(function(){
		$.post("ajaxrequest/branch_assign_status.php?token=<?php echo $token;?>",
				{
					installedStatus : $('#installedStatus').val()
				},
					function(data){
						alert(data);
						$("#showStatus").html(data);
				});
	});
});*/
// End
// send ajax request when click submit
function getReport()
{
	$('.loader').show();
	$.post("ajaxrequest/device_report_details.php?token=<?php echo $token;?>",
				{
					branch : $('#branch').val(),
					installedStatus : $('#installedStatus').val(),
					executive : $('#executive').val()
					/*assignStatus : $('#assignStatus').val(),*/
				},
					function(data){
						/*alert(data);*/
						$("#dvData").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});
}
// end
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
    	<h3>Device Report</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-inline"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12">
      	<table class="form-field" width="100%">
         <tr>
         <td width="9%"><strong>Branch*</strong></td>
         <td width="20%">
             <select name="branch" id="branch" class="form-control drop_down-sm">
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
                        echo'<option value="0">All</option>';	
                    }
                    //echo $branch_sql;
                    $Country = mysql_query($branch_sql);					
                        while($resultCountry=mysql_fetch_assoc($Country)){
                    ?>
               <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
               <?php } ?>
             </select>
         </td>
         <td width="7%"><strong>Status*</strong></td>
         <td width="12%">
             <select name="installedStatus" id="installedStatus" class="form-control drop_down-sm">
               <option value="" selected>All</option>
               <option value="0">Instock</option>
               <option value="1">Installed</option>
             </select>
         </td>
         <td width="11%" class="col-xs-1">&nbsp;</td>
         <td width="13%">&nbsp;</td>
         <td width="13%">&nbsp;</td>
         <td width="15%"></td>
         </tr>
      	 <tr>
         <td><strong>Executive*</strong></td>
         <td><div id="showTechnician">
           <select name="executive" id="executive" class="form-control drop_down-sm">
             <option value="">Select Executive</option>
           </select>
         </div></td>
         <td><strong><!--Assign Status*--></strong></td>
         <td>
         <div id="showStatus">
         	<!--<select name="assignStatus" id="assignStatus" class="form-control drop_down-sm">
               <option value="" selected>All</option>
            </select>-->
         </div>
         </td>
         <td><input type="button" name="submit" value="Submit" onClick="getReport();" class="btn btn-primary btn-sm pull-left"/></td>
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
      <div id="dvData" class="col-md-12 table-responsive assign_grid">
      	
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
<!--Javascript-->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>
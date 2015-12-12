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
		$delete_single_row = "DELETE FROM tblsim WHERE id='$id'";
		$delete = mysql_query($delete_single_row);
	}
	if($delete)
	{
		echo "<script> alert('Record Delted Successfully'); </script>";
	}
//End
//Delete  multiple records
if(count($_POST['linkID'])>0 && (isset($_POST['delete_selected'])) )
   {			   
		if(isset($_POST['linkID']))
     		{
			  foreach($_POST['linkID'] as $chckvalue)
              {
		       	$sql = "DELETE FROM tblsim WHERE id='$chckvalue'";
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
 $(function() {
    $( "#date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
  $(function() {
    $( "#dateto" ).datepicker({dateFormat: 'yy-mm-dd'});
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
                var outputFile = window.prompt("Please Enter the name your output file.") || 'vehicleReport';
                outputFile = outputFile.replace('.csv','') + '.csv'
                 
                // CSV
                exportTableToCSV.apply(this, [$('#divassign > table'), outputFile]);
                
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
    	<h3>Vehicle  Report</h3>
        <hr>
    </div>
   
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
    <div class="col-md-12 table-responsive">
     <table class="form-field" width="100%">
     <tr>
     <td>Date (From)* </td>
     <td><input type="text" name="date" id="date" class="form-control text_box-sm"></td>
     <td>Company Name</td>
     <td><select name="company" id="company" class="form-control drop_down-sm">
             <option value="0">All Company</option>                         
             <?php $Country=mysql_query("SELECT B.id as id, B.Company_Name as Company_Name
			 							 FROM tbl_customer_master as A 
										 INNER JOIN tblcallingdata as B
										 ON A.callingdata_id =  B.id Order by Company_Name ASC");								
                   while($resultCountry=mysql_fetch_assoc($Country))
                    {
             ?>
             <option value="<?php echo $resultCountry['id']; ?>">
             <?php echo stripslashes(ucfirst($resultCountry['Company_Name'])); ?></option>
             <?php } ?>
        </select>     </td>
     <td>Technician</td>
     <td><select name="technician" id="technician" class="form-control drop_down drop_down-sm">
       <option value="0">All Technician</option>
       <?php $Country=mysql_query("SELECT * FROM `tbluser` where User_Category=5");								
                  while($resultCountry=mysql_fetch_assoc($Country))
                   {
            ?>
       <option value="<?php echo $resultCountry['id']; ?>"> <?php echo stripslashes(ucfirst($resultCountry['First_Name']." " .$resultCountry['Last_Name'])); ?></option>
       <?php } ?>
     </select></td>
     <td>&nbsp;</td>
     <td></td>
     </tr>
      <tr>
     <td>Date&nbsp;(To)*</td>
     <td><input type="text" name="dateto" id="dateto" class="form-control text_box-sm"></td>
     <td>Reffered by</td>
     <td><select name="reffered" id="reffered" class="form-control drop_down drop_down-sm">
            <option value="0" selected>All</option>                         
            <?php $Country=mysql_query("SELECT distinct telecaller_id FROM tbl_customer_master");								
                  while($resultCountry=mysql_fetch_assoc($Country))
                   {
            ?>
            <option value="<?php echo $resultCountry['telecaller_id']; ?>">
            <?php echo gettelecallername(stripslashes(ucfirst($resultCountry['telecaller_id']))); ?></option>
            <?php } ?>
            </select>     </td>
     <td>&nbsp;</td>
     <td><input type="button" name="assign" value="Submit" id="submit" class="btn btn-primary btn-sm"  onclick="ShowReport()" />
     	 <input type="button" name="assign" value="Summary" onClick="window.location.replace('installation_summary.php?token=<?php echo $token;?>')" id="submit" class="btn btn-primary btn-sm"  />
     </td>
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
      
      <div id="divassign" class="col-md-12 table-responsive assign_grid">
		
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
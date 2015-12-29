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
<!--<script type="text/javascript" src="js/ticket_report.js"></script>-->
<script type="text/javascript" src="js/checkbox_validation.js"></script>
<script>
// calender script
 $(function() {
    $( ".date" ).datepicker({dateFormat: 'yy-mm-dd'});
  });
// End calender script
// Pass ajax request 
function getDetails()
{
	/*alert('asfsafs');*/
	$('.loader').show();
		$.post("ajaxrequest/sales_analysis_details.php?token=<?php echo $token;?>",
				{
					dateFrom : $('#dateFrom').val(),
					dateTo : $('#dateTo').val(),
					branch : $('#branch').val(),
					customerType : $('#customerType').val(),
					leadGenBy : $('#leadGenBy').val(),
					installedBy : $('#installedBy').val()
				},
					function(data){
						/*alert(data);*/
						$("#divassign").html(data);
						$(".loader").removeAttr("disabled");
						$('.loader').fadeOut(1000);
				});	
}
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
                var outputFile = window.prompt("Please Enter the name your output file.") || 'ticketReport';
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
    	<h3>Sales Analysis</h3>
        <hr>
    </div>
    <div class="col-md-12">
    <form name='fullform' class="form-horizontal"  method='post' onSubmit="return confirmdelete(this)">
      <div class="col-md-12 table-responsive">
      <table class="form-field" width="100%">
     <tr>
     <td width="10%"><strong>Date (From)* </strong></td>
     <td width="19%"><input type="text" name="dateFrom" id="dateFrom" class="form-control text_box-sm date"/></td>
     <td width="12%"><strong>Branch*</strong></td>
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
            	echo'<option value="0" selected="selected">All Branch</option>';	
            }
            //echo $branch_sql;
            $Country = mysql_query($branch_sql);					
            	while($resultCountry=mysql_fetch_assoc($Country)){
            ?>
            <option value="<?php echo $resultCountry['id']; ?>" ><?php echo stripslashes(ucfirst($resultCountry['CompanyName'])); ?></option>
            <?php } ?>
      </select>     </td>
     <td width="12%"><strong>Lead gen. By*</strong></td>
     <td width="27%">
     	<select name="leadGenBy" id="leadGenBy" class="form-control drop_down-sm">
			<option label="" value="0" selected="selected">All</option>
			<?php $sqlLead = mysql_query("select * from tbluser order by First_Name");
				 while($resultlead = mysql_fetch_assoc($sqlLead)){
			?>
			<option value="<?php echo $resultlead['id']; ?>" ><?php echo stripslashes(ucfirst($resultlead['First_Name']." ". $resultlead["Last_Name"])); ?></option>
			<?php } ?>
		</select>
     </td>
     </tr>
      <tr>
     <td><strong>Date&nbsp;(To)*</strong></td>
     <td><input type="text" name="dateTo" id="dateTo" class="form-control text_box-sm date"/></td>
     <td><strong>Customer Type*</strong></td>
	 <td>  
     
     	<select name="customerType" id="customerType" class="form-control drop_down-sm">
        <option value="">All</option> 
        	 <?php $sqlQuery = mysql_query("select * from tbl_customer_type order by customer_type");
                                  while($resultQuery=mysql_fetch_assoc($sqlQuery)){
                    ?>
                    <option value="<?php echo $resultQuery['customer_type_id']; ?>">
					<?php echo stripslashes(ucfirst($resultQuery['customer_type'])); ?>
                    </option>
            <?php } ?>                        
        </select>
     </td>
     <td><strong>Installed By*</strong></td>
     <td>
       <select name="installedBy" id="installedBy" class="form-control drop_down-sm">
          <option label="" value="0" selected="selected">All</option>
				<?php $sqlTech = mysql_query("select * from tbluser where User_Category=5 or User_Category=8 Order by First_Name");
							   while($resultTech=mysql_fetch_assoc($sqlTech)){
				?>
		  <option value="<?php echo $resultTech['id']; ?>" ><?php echo stripslashes(ucfirst($resultTech['First_Name']." ". $resultTech["Last_Name"])); ?>
          </option>
		  <?php } ?>
       </select></td>
     </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><input type="button" name="submit" value="Submit" id="submit" onClick="getDetails();" class="btn btn-primary btn-sm pull-left"/></td>
        </tr>
     </table>
      
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
    	<input type='hidden' name='pagename' value='assigncontacts'>            	
        <div id="divassign" class="col-md-12 table-responsive assign_grid">
       		<!-- Ajaxrequest-->
      	</div>
    </form>
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
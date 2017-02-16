<?php


// session_save_path('/tmp');
// ini_set('session.gc_probability', 1);
// ini_set('upload_tmp_dir','/tmp');
//ini_set('max_execution_time','2000');
error_reporting(0);
$session_timeout = 3600 * 12;
// session_set_cookie_params(3600,"/");
session_set_cookie_params($session_timeout);
session_start(); // starting user session here]
//ob_start();
//header( "Set-Cookie: name=value; httpOnly" );
/*
defining all the required Constants
*/

// path of site used to call images,style,js etc by their absolute path.
define('SITE_WS_PATH','http://localhost/CRM/AxiomTrack/'); 

// title of site								
define('SITE_TITLE','Welcome To IndianTruckers.com'); 												

// Location of airtel directory on server use to include class files
define('SITE_FS_PATH',$_SERVER['DOCUMENT_ROOT']."/CRM/AxiomTrack");								

define('SITE_PAGE_TITLE','IndianTruckers.com');
define('PER_PAGE_ROWS',10);

 
/*
including common files
*/

// general_function.php contains all important and common sql functions
include("includes/general_function.php");

// to search in differenet path if called from  the ajaxrequest folder
include("../includes/general_function.php");

 
// array.inc.php contains array of all alert messages 
//include(SITE_FS_PATH."/includes/array.inc.php");

//class_drop_down.php contains functions to show all drop down list
//include(SITE_FS_PATH."/includes/class_drop_down.php");
  


//$host_name="localhost";    
//$user_name="truckson_trucker";		// holds User name for sql server
//$password="trucker$123";			// holds Password for sql server
//$database="truckson_indiantruckers";		//  holds database name 
$host_name="localhost";    
$user_name="root";
$password="";
$database="crm";
//$host_name="localhost";    
//$user_name="truckson_trucker";		// holds User name for sql server
//$password="trucker$123";			// holds Password for sql server
//$database="truckson_indiantruckers";		//  holds database name 



//Connecting to the sql server
mysql_connect($host_name,$user_name,$password) or die(mysql_errno());

//Connecting to the database
mysql_select_db($database) or die("Error in database connection");


function redirect($str)
{
?>
<script>
window.location.replace(<?=$str?>);
</script>
<?php
}



function Pages($tbl_name,$limit,$path,$token1)
{
 //echo "<br>Inside Pages:".
 $query = $tbl_name;
 if(isset($_SESSION['ratefilter']) and $_SESSION['ratefilter']!='')
 { 
  $query = str_replace("where","where 1=1 ".$_SESSION['ratefilter']." and ",$query);
 }
	
	$rowrs = mysql_query($query);
	$total_pages = mysql_num_rows($rowrs);
	$adjacents = "2";

	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
	$page = ($page == 0 ? 1 : $page);

	if($page)
	$start = ($page - 1) * $limit;
	else
	$start = 0;


if($total_pages)
$sql = $tbl_name. " LIMIT $start, $limit";
else
$sql = $tbl_name;


$_SESSION['linkSQL'] = $tbl_name;
$_SESSION['limit']= " LIMIT $start, $limit";
//$_SESSION['linkSQL']="";
//echo "<br>Query1 :".$sql;

// if(isset($_SESSION['ratefilter']) and $_SESSION['ratefilter']!='')
// { 
//  $sql = str_replace("where","where 1=1 ".$_SESSION['ratefilter']." and ",$sql);
// }
//echo "<br>Query2 :".$sql;
$result = mysql_query($sql);

	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total_pages/$limit);
	$lpm1 = $lastpage - 1;

	$pagination = "";
    if($lastpage > 1)
    {   
	$pagination .= "<ul class='pagination'>";
    if ($page > 1)
    	$pagination.= " <li> <a href='".$path."page=$prev&token=$token1'><< </a> </li>";
    else
    	$pagination.= "<li class='disabled'> <span class='disabled'><<</span> </li>";   
    
        if ($lastpage < 7 + ($adjacents * 2))
        {   
            for ($counter = 1; $counter <= $lastpage; $counter++)
            {
                if ($counter == $page)
                	$pagination.= "<li class='active'><span class='active '>$counter</span></li>";
                else
                	$pagination.= "<li> <a href='".$path."page=$counter&token=$token1'>$counter</a> </li>";     
                         
            }
        }elseif($lastpage > 5 + ($adjacents * 2)){
        if($page < 1 + ($adjacents * 2)){
            for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++){
            if ($counter == $page)
            	$pagination.= "<li class='active'><span class='active '>$counter</span></li>";
            else
            	$pagination.= "<li> <a href='".$path."page=$counter&token=$token1'>$counter</a> </li>";     
                         
            }
        	$pagination.= "<li><a href=''>...</a></li>";
        	$pagination.= "<li><a href='".$path."page=$lpm1&token=$token1'>$lpm1</a></li>";
        	$pagination.= "<li><a href='".$path."page=$lastpage&token=$token1'>$lastpage</a></li>";   
           
        }elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)){
        	$pagination.= "<li><a href='".$path."page=1&token=$token1'>1</a></li>";
        	$pagination.= "<li><a href='".$path."page=2&token=$token1'>2</a></li>";
        	$pagination.= "<li><a href=''>...</a></li>";
        for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
        {
        if ($counter == $page)
        	$pagination.= "<li class='active'><span class='active '>$counter</span></li>";
        else
        	$pagination.= "<li><a href='".$path."page=$counter&token=$token1'>$counter</a></li>";     
                     
        }
        	$pagination.= "<li><a href=''>..</a></li>";
        	$pagination.= "<li><a href='".$path."page=$lpm1&token=$token1'>$lpm1</a></li>";
        	$pagination.= "<li><a href='".$path."page=$lastpage&token=$token1'>$lastpage</a></li>";   
           
        }else{
        	$pagination.= "<li><a href='".$path."page=1&token=$token1'>1</a></li>";
        	$pagination.= "<li><a href='".$path."page=2&token=$token1'>2</a></li>";
        	$pagination.= "<li><a href=''>..</a></li>";
        for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
        {
        if ($counter == $page)
        	$pagination.= "<li class='active'><span class='active'>$counter</span></li>";
        else
        	$pagination.= "<li><a href='".$path."page=$counter&token=$token1'>$counter</a></li>";     
                     
        }
        }
    }
    
    if ($page < $counter - 1)
    	$pagination.= "<li><a href='".$path."page=$next&token=$token1'>>></a></li>";
    else
    	$pagination.= "<li class='disabled'><span class='disabled'>>></span></li>";
    	$pagination.= "</ul>";       
    }


return $pagination;
}

?>
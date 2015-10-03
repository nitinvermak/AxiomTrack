<?php
include("../includes/config.inc.php"); 
include("../includes/crosssite.inc.php"); 
 
echo $_POST["postdata"];
echo var_dump($_POST["postdata"]);
 
echo var_dump(json_decode($_POST["postdata"], true));

foreach ($_POST["postdata"] as $param_name => $param_val) {
	echo 'new ele';
    echo "Param: $param_name; Value: $param_val<br />\n";
}

 

 echo "kokook";

?>
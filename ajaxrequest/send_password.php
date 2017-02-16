<?php
include("../includes/config.inc.php"); 
$register_mobile = $_POST['mobile'];
getPassword($register_mobile);
?>
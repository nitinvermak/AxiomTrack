<?php
ob_start();
include("includes/config.inc.php"); 
session_destroy();
header("location: index.php");
exit;
?>
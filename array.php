<!DOCTYPE html>
<html>
<body>

<?php
$age = array(
			array("name"=>"John", 
			"age"=>"37", 
			"city"=>"california"),
			array("name"=>"Maria", 
			"age"=>"30", 
			"city"=>"Florida"),
			array("name"=>"Maria", 
			"age"=>"30", 
			"city"=>"Florida")
			);
foreach ($age as $value) {
	echo "<pre>";
	print_r($value);
	// echo $value['name'];
	// echo "<br>";
}
?>

</body>
</html>
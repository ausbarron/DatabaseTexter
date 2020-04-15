<?php

$name=$_POST['Name']; 
$phoneNumber=$_POST['phoneNumber'];
$zipCode=$_POST['zipCode'];

if(!empty($name) || !empty($phoneNumber) || !empty($zipCode){
	$hostname="localhost";
	$username="testuser"; //user login for sqldatabase
	$password="test123"; //password for user login for sqldatabase
	$db_name="persons"; //database accessed
	$tbl_name="testcase";//table used

	$connection = new mysqli($hostname, $username, $password, $db_name);

	if(mysqli_connect_error()) {
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	} else {
		$SELECT = "SELECT phoneNumber From testcase Where phoneNumber = ? Limit 1";
		$INSERT = "INSERT Into testcase (Name, phoneNumber, zipcode) values(?, ?, ?)";

		$stmt = $connection->prepare($SELECT);
		$stmt->bind_param("s", $phoneNumber);
		$stmt->execute();
		$stmt->bind_result($phoneNumber);
		$stmt->store_result();
		$rnum = $stmt->num_rows;
		
		if($rnum == 0) {
			$stmt->close();

			$stmt= $connection->prepare($INSERT);
			$stmt->bind_param("sss", $Name, $phoneNumber, $zipCode);
			$stmt->execute();
			echo "New record inserted successfully";
		} else {
			echo "Number already exists.";
		}
	}
} else {
	echo "All field are required";
	die();
}
?>

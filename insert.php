<?php

$name=$_POST['Name']; //posted name from form
$phoneNumber=$_POST['phoneNumber']; //posted number from form
$zipCode=$_POST['zipCode']; //posted zip code from form

// if name, phoneNumber, and zipCode are not empty a SQL server will be connected to, else the system echo prints and site dies.
if(!empty($name) || !empty($phoneNumber) || !empty($zipCode)) {
	$hostname="localhost";
	$username="testuser"; //user login for sql database
	$password="test123"; //password for user login for sql database
	$db_name="persons"; //database accessed

	$connection = new mysqli($hostname, $username, $password, $db_name);
	
	//If $connection fails, the error is printed, else input into database is prepared.
	if(mysqli_connect_error()) {
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	} else {
		$SELECT = "SELECT phoneNumber From testcase Where phonenumber = ? Limit 1"; //Checks if phonenumber already exists in system.
		$INSERT = "INSERT Into testcase (name, phonenumber, ZIP_CODE) values(?, ?, ?)"; //insert query statement into database.

		$stmt = $connection->prepare($SELECT); //prepares $SELECT for execution
		$stmt->bind_param("s", $phoneNumber); //assigns the phonenumber from the form and replaces the ? in $SELECT
		$stmt->execute(); //executes the query
		$stmt->bind_result($phoneNumber); //binds the phonenumber to prepared statement
		$stmt->store_result(); //stores result
		$rnum = $stmt->num_rows; //stores the number of rows selected in rnum
		
		/*
		 checks whether number of rows selected is 0. If 0, previous statement is closed and $INSERT is prepared for execution. the elements from the form are bound as strings, and then the 			 $INSERT statement is executed. System prints echo statemet. If rnum is not 0, then system echo will print.
		*/
		if($rnum == 0) {
			$stmt->close();

			$stmt= $connection->prepare($INSERT);
			$stmt->bind_param("sss", $name, $phoneNumber, $zipCode);
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

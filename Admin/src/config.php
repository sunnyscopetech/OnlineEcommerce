<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ecommerce";

// Create connection
$conn = new mysqli($servername, 
	$username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
	die("Connection failed: "
		. $conn->connect_error);
}

// $sql = "INSERT INTO user VALUES 
// 	('John', 'john@example.com','chbjbj')";

// if ($conn->query($sql) === TRUE) {
// 	echo "record inserted successfully";
// } else {
// 	echo "Error: " . $sql . "<br>" . $conn->error;
// }

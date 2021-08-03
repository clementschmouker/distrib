<?php

	// connection informations
	$servername = 'localhost';
	$username = 'root';
	$password = '';
	$db = 'randomizelinks';

	$conn = new mysqli($servername, $username, $password, $db);

	if ($conn->connect_error) {
		die("connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT INTO links(value) VALUES (" . $_GET['id'] . ")"; // change table name if needed
	$result = $conn->query($sql);
?>
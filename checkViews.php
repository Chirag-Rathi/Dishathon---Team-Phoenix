<?php

	$servername="localhost";
	$username="root";
	$password="";
	$dbname="hackDb";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	$views = $_POST['views'];
	$id = $_POST['id'];

	$sql = "UPDATE videodata set views=".$views." WHERE ID =".$id;
	$conn->query($sql);

?>
<?php
	session_start();
	$points = $_POST['points'];
	$id = $_POST['id'];

	$conn = OpenCon();
	function OpenCon()
	 {
	 $dbhost = "localhost";
	 $dbuser = "root";
	 $dbpass = "";
	 $db = "hackDb";
	 $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);
 
	 return $conn;
	 }

	$sqlupd = "UPDATE userlogin SET UserPoints =".$points." WHERE ID = ".$id;
	$resultupd=$conn->query($sqlupd);

	echo json_encode($points);
		
?>
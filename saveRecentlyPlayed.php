<?php
	session_start();
	$videoId = $_POST['id'];
	$timePlayedFor = $_POST['time'];
	$pointsEarned = $_POST['pointsEarned'];

	$servername="localhost";
	$username="root";
	$password="";
	$dbname="hackDb";
	$conn = new mysqli($servername, $username, $password, $dbname);

	if ($conn->connect_error) {
	  die("Connection failed: " . $conn->connect_error);
	}
	
	if(isset($_SESSION['userId'])) {
		$sql = "SELECT UserPoints, recentlyPlayed FROM userlogin WHERE ID = ".$_SESSION['userId'];
		$result=$conn->query($sql);
		$row = $result->fetch_assoc();
		$points = $row['UserPoints'];
		$recentlyPlayed = $row['recentlyPlayed'];

	    $recentlyPlayedArray = explode(';', $recentlyPlayed);

	    for ($i=1; $i < sizeof($recentlyPlayedArray); $i++) { 
	      $element = array_map(function($v) {return intval($v);} ,explode(':', $recentlyPlayedArray[$i]));
	      $recentlyPlayedVideos[$element[0]] = $element[1];
	    }
	   
	    if(array_key_exists($videoId, $recentlyPlayedVideos)) {
	    	$recentlyPlayed = "";
	    	$recentlyPlayedVideos[$videoId] = $timePlayedFor;
	    	foreach ($recentlyPlayedVideos as $key => $value) {
	    		$recentlyPlayed = $recentlyPlayed.";".$key.":".$value;
	    	}
	    } else {
	    	$recentlyPlayed = $recentlyPlayed.";".$videoId.":".$timePlayedFor;
	    }

	    $newPoints = $pointsEarned + $points;

		$sql = "UPDATE userlogin SET recentlyPlayed ='".$recentlyPlayed."', 
		UserPoints = ".$newPoints." WHERE ID = ".$_SESSION['userId'];
		$result=$conn->query($sql);
		
		$_SESSION['userpoints'] = $pointsEarned;

		echo json_encode($pointsEarned);
	}
?>
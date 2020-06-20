<?php
	session_start();
	$_SESSION['videoId'] = $_POST['id'];
	$_SESSION['videoViews'] = $_POST['views'];
	
	if (isset($_SESSION['videoId'],$_SESSION['videoViews'])) {
		echo json_encode($_SESSION['videoId'],$_SESSION['videoViews']);	
	}

?>

<?php

$servername="localhost";
$username="root";
$password="";
$dbname="hackDb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$selected_vid=$_POST["vidList"];
$selected_points=$_POST["vidName"];
switch($_POST['com'])
{
	case 'addInc': $sql="UPDATE videoData set VideoPoints =".$selected_points." where ID = ".$selected_vid;
					if ($conn->query($sql) === TRUE) {
  					function function_alert($message) { 
    				echo "<script>alert('$message');"; 
    				echo "window.location.href='adminCheckVideo.php';</script>";
					}  
					function_alert("Successful!"); 
					} else {
  					echo "Error: " . $sql . "<br>" . $conn->error;
  					}
  					break;
  	case 'delVid': $sql2="DELETE from videoData where ID = ".$selected_vid;
					if ($conn->query($sql2) === TRUE) {
  					function function_alert($message) { 
    				echo "<script>alert('$message');"; 
    				echo "window.location.href='adminCheckVideo.php';</script>";
					}  
					function_alert("Successful!"); 
					} else {
 	 				echo "Error: " . $sql . "<br>" . $conn->error;
					}
					break;
	case 'gb': 		header("Location: adminMain.php");
  					exit();
  					break;
}

$conn->close();

?>
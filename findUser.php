<?php

$servername="localhost";
$username="root";
$password="";
$dbname="hackDb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$usr=$_POST["findUsr"];
switch($_POST['com'])
{
	case 'check':   $sql="SELECT UserPoints from userLogin where Username='".$usr."'";
					$result=$conn->query($sql);
					$row = $result->fetch_assoc();
					function function_alert($message) { 
    				echo "<script>alert('$message');"; 
    				echo "window.location.href='adminCheckUsers.php';</script>";
					}  
					function_alert($row['UserPoints']); 
  					break;
  	case 'delUsr': $sql2="DELETE from userLogin where Username = '".$usr."'";
					if ($conn->query($sql2) === TRUE) {
  					function function_alert($message) { 
    				echo "<script>alert('$message');"; 
    				echo "window.location.href='adminCheckUsers.php';</script>";
					}  
					function_alert("Successful!"); 
					} else {
 	 				echo "Error: " . $sql . "<br>" . $conn->error;
					}
					break;
	case 'gb':  header("Location: adminMain.php");
  				exit();
  				break;
}

if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>
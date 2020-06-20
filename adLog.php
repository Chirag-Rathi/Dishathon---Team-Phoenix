<?php
session_start();
$servername="localhost";
$username="root";
$password="";
$dbname="hackDb";
$flag=0;
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$usr=$_POST["uname"];
$pwd=$_POST["psw"];
$sql="SELECT * from adminLogin where Username='".$usr."' and Password= '".$pwd."'";
$result=$conn->query($sql);
$count=mysqli_num_rows($result);
	if($count==0) {
		function function_alert($message) { 
    	echo "<script>alert('$message');"; 
    	echo "window.location.href='adminLogin.php';</script>";
		}  
		function_alert("Invalid!"); 
		
	} else {
		$_SESSION['LoggedIn']= TRUE;
		header("Location: adminMain.php");
		exit();
	}
	
if ($conn->query($sql) === TRUE) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

?>

<?php
session_start();
$servername="localhost";
$username="root";
$password="";
$dbname="hackDb";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$usr=$_POST["uname"];
$pwd=$_POST["psw"];
$sql="SELECT ID, Password from userLogin where Username='".$usr."'";
$result=$conn->query($sql);
$row = $result->fetch_assoc();

if(strcmp($row['Password'],$pwd)==0)
{	
	$_SESSION['userId'] = $row['ID'];
	// $_SESSION['userpoints'] = 0;
	header("Location: user.php");
	exit();
}
else{
	echo $row['Password'];
}

$conn->close();

?>
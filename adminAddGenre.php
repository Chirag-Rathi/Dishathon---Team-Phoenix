<?php

$servername="localhost";
$username="root";
$password="";
$dbname="hackDb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$genre=$_POST["genreName"];
switch($_POST['com'])
{
	case 'add': $sql="INSERT INTO genreData(GenreName) values('$genre')";
				if ($conn->query($sql) === TRUE) {
					echo "<script>alert(\"New record created successfully\");</script>";
				} else {
  				echo "Error: " . $sql . "<br>" . $conn->error;
				}
			  	break;

  	case 'gb':  header("Location: adminMain.php");
  				exit();
  				break;
}

$conn->close();
header("Location: adminCheckCategories.php")
?>
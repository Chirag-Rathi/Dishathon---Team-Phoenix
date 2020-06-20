<?php

$servername="localhost";
$username="root";
$password="";
$dbname="hackDb";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$selected_genre=$_POST["genreList"];
$name=$_POST["vidName"];
echo "$selected_genre";
$path=$_POST["pathName"];
$points=$_POST["points"];
$thumbPath=$_POST["thumbPath"];
$rating=$_POST["vidRating"];
$incentive=$_POST["vidIncent"];
$sql1 = "SELECT * FROM videoData";
$id1=0;
$vidViews=0;
$result = $conn->query($sql1);
while($row = $result->fetch_assoc()) {
 $id1=($row["ID"]);
}
$sql2 = "SELECT * FROM genreData";
$result2 = $conn->query($sql2);
while($row = $result2->fetch_assoc()) {
  if($row['ID'] == $selected_genre) {
    echo "string";
    $genName=$row["GenreName"];
  }
}

$id1=$id1++;

$data1 = "[{'name': '".$genName."'}]";
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$sheet->setCellValue('A1', 'Id');
$sheet->setCellValue('B1', 'Title');
$sheet->setCellValue('C1', 'Genre');
$sheet->setCellValue('D1', 'Rating');
$sheet->setCellValue('E1', 'Incentive');
$sheet->setCellValue('F1', 'Views');

$sheet->setCellValue('A2', $id1);
$sheet->setCellValue('B2', $name);
$sheet->setCellValue('C2', $data1);
$sheet->setCellValue('D2', $rating);
$sheet->setCellValue('E2', $incentive);
$sheet->setCellValue('F2', $vidViews);


$writer = new Xlsx($spreadsheet);
$writer->save('test12.xlsx');

switch($_POST['com'])
{
	case 'sb':   $sql="INSERT INTO videoData (VideoName,VideoGenre,VideoPath,VideoPoints,VideoThumbnail,VideoRating,VideoIncentive) values('$name','$selected_genre','$path',$points,'$thumbPath',$rating,$incentive)";
				if ($conn->query($sql) === TRUE) {
  				function function_alert($message) { 
    			echo "window.location.href='adminUploadVideo.php';</script>";
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

$conn->close();

?>
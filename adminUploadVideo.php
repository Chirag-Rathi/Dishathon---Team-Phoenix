<?php 
  session_start();
  if(!isset($_SESSION['LoggedIn']))
  {
    header("Location: adminLogin.php"); 
  } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Upload Video</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style type="text/css">

div#bt2 {
  padding-top: 10px;
}
div#bta {
  padding-top: 10px;
}
div#btb {
  padding-top: 10px;
}
div#c1 {
  display: flex;
  padding: 10px 20px;
}
div#c2 {
  display: flex;
  padding: 10px 20px;
  
}
div#c3 {
  display: flex;
  padding: 10px 20px;
 
}
div#c4 {
  display: flex;
  padding: 10px 20px;
  
}
div#head{
  display: flex;
  margin-left: 200px;
  
}
</style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header" id="head">
      <b><h2><p style="color:#ffffff">Upload Video</p></h2></b>
    </div>
     <form action="adLogOut.php" method="post">
     <div id="bt2">
        <button style= type="submit" class="btn btn-danger pull-right">Logout</button> 
      </div>
    </form>
  </div>
</nav>

<div class="container">
  <div class="card" id="c1">
  <div class="card-header">

  </div>
  <div class="card-body">
    <h2 class="card-title">Select Genre of the Video:</h2>
    <div class="container">
        <?php
          $servername="localhost";
          $username="root";
          $password="";
          $dbname="hackDb";
          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
          }
          $sql = "SELECT * FROM genredata";
          $result = $conn->query($sql);
          //print_r ($result);
          echo "<form action='addVideoDetails.php' method='post'>";
          echo "<div class='form-group'>";
          echo "<select class='form-control' id='sel1' name='genreList'>";
         while($row = $result->fetch_assoc()) 
            {
             echo "<option value=".$row["ID"].">".$row["GenreName"]."</option>";
             //print_r("$rows")
            }
          echo "</select>";
          echo "</div>";
        ?>
  </div>
</div>
</div>
  <div class="card" id="c2">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Name of the Video:</h2>
    <div class="form-group">
      <input type="text" class="form-control" id="vidN" placeholder="Enter Video Name" name="vidName">
      </div>
</div>
</div>
<div class="card" id="c3">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Path of the Video:</h2>
     <div class="form-group">
      <input type="text" class="form-control" id="pathN" placeholder="Enter Path Name" name="pathName">
    </div>
</div>
</div>
<div class="card" id="c4">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Points for the Video:</h2>
      <div class="form-group">
      <input type="text" class="form-control" id="ptn" placeholder="Enter Points" name="points">
     </div>
</div>
</div>
  <div class="card" id="c5">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Path of the thumbnail:</h2>
    <div class="form-group">
      <input type="text" class="form-control" id="thbPt" placeholder="Enter Path of thumbnail:" name="thumbPath">
      </div>
</div>
</div>
  <div class="card" id="c6">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Rating  of the video:</h2>
    <div class="form-group">
      <input type="text" class="form-control" id="vidRat" placeholder="Enter Rating:" name="vidRating">
      </div>
</div>
</div>
  <div class="card" id="c7">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Incentive Slab:</h2>
    <div class="form-group">
      <input type="text" class="form-control" id="vidInc" placeholder="Enter Incentive from 1 to 3:" name="vidIncent">
      </div>
</div>
</div>
     <div id="bta">
       <center><button type="submit" class="btn btn-primary btn-lg" name="com" value="sb">Submit</button></center>
     </div>
     <div id="btb">
        <center><button type="submit" class="btn btn-warning btn-lg" name="com" value="gb">Go back</button></center>
     </div>
        
    </div>
</form>
 
  
</body>
</html>


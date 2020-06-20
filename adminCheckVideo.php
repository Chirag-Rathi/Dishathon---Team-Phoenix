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
  <title>Check Videos</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
  div#bt {
  display: flex;
  align-items: center;
  padding: 15px 32px;
  justify-content: center;
}
div#bt2 {
  display: flex;
  align-items: center;
   padding: 15px 32px;
  justify-content: center;
}
div#bta {
  padding-top: 10px;
}
</style>

<body>
  <nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <h2><p style="color:#ffffff">Check Video</p></h2>
    </div>
     <form action="adLogOut.php" method="post">
     <div id="bta">
        <button style= type="submit" class="btn btn-danger pull-right">Logout</button> 
      </div>
    </form>
  </div>
</nav>

<div id="main" class="container">
    <div class="card" id="c1">
  <div class="card-header">

  </div>
  <div class="card-body">
    <h2 class="card-title">Select Video:</h2>
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
          $sql = "SELECT * FROM videoData";
          $result = $conn->query($sql);
          //print_r ($result);
          echo "<form action='adminAddIncentive.php' method='post'>";
          echo "<div class='form-group'>";
          echo "<select class='form-control' id='sel1' name='vidList'>";
         while($row = $result->fetch_assoc()) 
            {
             echo "<option value=".$row["ID"].">".$row["VideoName"]."</option>";
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
    <h2 class="card-title">Points for the Video:</h2>
    <div class="form-group">
      <input type="text" class="form-control" id="vidN" placeholder="Enter Points" name="vidName">
      </div>
</div>
</div>
</div>


<div id="bt">
<button style= type="submit" class="btn btn-primary btn-lg" name="com" value="addInc">Assign points for selected video manually</button> 
</div>
  

<div id="bt2">
  <button style= type="submit" class="btn btn-danger btn-lg" name="com" value="delVid">Delete selected video</button>
</div>
<div id="btb">
      <center><button type="submit" class="btn btn-warning btn-lg" name="com" value="gb">Go back</button></center>
    </div>
</form>

</body>
</html>
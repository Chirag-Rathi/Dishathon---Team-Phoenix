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
  <title>Check Genres</title>
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
 div#main {
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
}
</style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header" id="head">
      <b><h2><p style="color:#ffffff">Check Genre</p></h2></b>
    </div>
     <form action="adLogOut.php" method="post">
     <div id="bta">
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
    <h2 class="card-title">Check Genres:</h2>
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
          $sql = "SELECT * FROM genreData";
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
</form>
</div>


<form action="adminAddGenre.php" method="post">
  <div class="card" id="c4">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Name of Genre:</h2>
      <div class="form-group">
      <input type="text" class="form-control" id="vidName" placeholder="Enter Genre Name" name="genreName">
     </div>
    </div>
    </div>
    <div id="bt">
    <button style= type="submit" class="btn btn-primary btn-lg" name="com" value="add">Add new genre</button> 
    </div>
      <div class="card" id="c4">
     <div class="card-header">
      </div>
    <div id="btb">
    <center><button style= type="submit" class="btn btn-warning btn-lg" name="com" value="gb">Go Back</button> </center>
    </div> 
</form>
</div> 

</body>
</html>
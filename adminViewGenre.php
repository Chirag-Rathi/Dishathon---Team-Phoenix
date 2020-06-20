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
<body>

<div class="container">
  <h2>Check existing genres</h2>
        <?php
          $servername="localhost";
          $username="root";
          $password="";
          $dbname="hackDb";
          $conn = new mysqli($servername, $username, $password, $dbname);
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT GenreName FROM genreData";
          $result = $conn->query($sql);
          //print_r ($result);
          echo "<div class='form-group'>";
          echo "<label for='sel1'>Select Genre:</label>";
          echo "<select class='form-control' id='sel1' name='genreList'>";
         while($row = $result->fetch_assoc()) 
            {
             echo "<option>".$row["GenreName"]."</option>";
             //print_r("$rows")
            }
          echo "</select>";
          echo "</div>";
          $conn->close();
        ?>
</div>
</body>
</html>
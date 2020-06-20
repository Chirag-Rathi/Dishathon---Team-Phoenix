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
  <title>Check Users</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
  div#main {
  display: flex;
  align-items: center;
  padding: 50px 32px;
  justify-content: center;
}
 div#disp {
  display: flex;
  align-items: center;
  padding: 15px 32px;
  justify-content: center;
}
 div#bt {
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
      <h2><p style="color:#ffffff">Check Users</p></h2>
    </div>
     <form action="adLogOut.php" method="post">
     <div id="bta">
        <button style= type="submit" class="btn btn-danger pull-right">Logout</button> 
      </div>
    </form>
  </div>
</nav>
  <form action="findUser.php" method="post">
  <div class="container">
  <div class="card" id="c4">
  <div class="card-header">
  </div>
  <div class="card-body">
    <h2 class="card-title">Search User:</h2>
      <div class="form-group">
       <input class="form-control" type="text" placeholder="Search for user" aria-label="Search" name="findUsr">
     </div>
    </div>
    </div>

<div id="bt">
  <button style= type="submit" class="btn btn-primary btn-lg" name="com" value="check">Check User Points</button> 
</div>
<div id="bt">
  <button style= type="submit" class="btn btn-danger btn-lg" name="com" value="delUsr">Delete selected user</button> 
</div>
<div id="btb">
        <center><button type="submit" class="btn btn-warning btn-lg" name="com" value="gb">Go back</button></center>
     </div>
</div>
</form>

</body>
</html>
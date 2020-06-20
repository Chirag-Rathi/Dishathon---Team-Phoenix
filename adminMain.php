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
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<style type="text/css">
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
</style>
<body>
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <h1><p style="color:#ffffff">Admin Dashboard</p></h1>
    </div>
    <form action="adLogOut.php" method="post">
     <div id="bt">
        <button style= type="submit" class="btn btn-danger btn-lg pull-right">Logout</button> 
      </div>
    </form>
  </div>
</nav>
<div class="container">
  <div class="card" id="c1">
  <div class="card-header">
    <b><h1>Upload Video</h1></b>
  </div>
  <div class="card-body">
    <h2 class="card-title">Fill in Video Details and Upload.</h2>
    <a href="adminUploadVideo.php" class="btn btn-primary btn-lg">Upload Video</a>
  </div>
</div>
<div class="card" id="c2">
  <div class="card-header">
    <b><h1>Check Video</h1></b>
  </div>
  <div class="card-body">
    <h2 class="card-title">View all videos to either delete or add incentive points.</h2>
    <a href="adminCheckVideo.php" class="btn btn-primary btn-lg">Check Videos</a>
  </div>
</div>
<div class="card" id="c3">
  <div class="card-header">
    <b><h1>Check Users</h1></b>
  </div>
  <div class="card-body">
    <h2 class="card-title">View all users to either check points or delete user.</h2>
    <a href="adminCheckUsers.php" class="btn btn-primary btn-lg">Check Users</a>
  </div>
</div>
<div class="card" id="c4">
  <div class="card-header">
    <b><h1>Check Categories</h1></b>
  </div>
  <div class="card-body">
    <h2 class="card-title">View or Add Categories.</h2>
    <a href="adminCheckCategories.php" class="btn btn-primary btn-lg">Check Categories</a>
  </div>
</div>
      </div>

</body>
</html>


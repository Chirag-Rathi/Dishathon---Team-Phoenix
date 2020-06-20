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
	$points = 0;
	if(isset($_SESSION['userId'])) {
		$sql="SELECT UserPoints from userlogin where ID = ".$_SESSION['userId'];
		$result=$conn->query($sql);
		$points = $result->fetch_assoc()['UserPoints'];
		if(isset($_SESSION['userpoints'])) {
			$pointsEarned = $_SESSION['userpoints'];
			if($pointsEarned > 0) {
				echo "<script>alert(\"You have earned ".$pointsEarned." by watching the movie.\")</script>";
			}
		}
	}
?>

<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> 
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <style type="text/css">
  	.badge-success {
	  background-color: #468847;
	  color: yellow;
	}
  	#image,
  	#overlay-color {
		width:100%;
		height: 100%;
  	}
  	#image,
	#overlay-text,
	#overlay-color {
		position: absolute;
	}
	#overlay-color {
		z-index: 10;
		background-color: rgba(0, 0, 0, 0.5);
	}
	#overlay-text {
		z-index: 10;
		bottom: 0;
		color: white;
		width: 100%;
	}
	.mycard {
	  position: relative;
	  width: calc(100%-30px);
	  height: 100%;
	}
	#elements {
		height: 200px;
	}
	hr{
		position: relative; 
        border: none; 
        height: 3px; 
        background: #808080; 
	}
	body{
		background-color: #F8F8F8;
	}
	</style>

</head>
<body style="background-color: #202020">


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
       <a class="navbar-brand" href="#" style="color: lightblue; font-weight: bold;">Watcho Prototype</a>
    </div>
    <ul class="nav navbar-nav">
      <!-- <li class="active"><a href="#">Home</a></li> -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
    	<li style="margin-right: 20px; margin-top: 8px; font-size: 20px; color: #FFD700;"><span class="glyphicon glyphicon-star"></span> Points: <?php echo $points; ?></li>
    	<li style="margin-right: 20px; margin-top: 5px; font-size: 20px; color: grey;">
	      	<div class="dropdown">
	    		<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
	    		<span class="glyphicon glyphicon-user"></span></button>
	    		<ul class="dropdown-menu">
	      			<li><a href="coupons.php">Redeem Coupons</a></li>
	      			<li><a href="userLogOut.php">Logout</a></li>
	    		</ul>
	    	</div>
    	</li>
    </ul>
  </div>
</nav>


<?php

	if(isset($_SESSION['userId'])) {
		$sql="SELECT * from videodata";
		$result=$conn->query($sql);
		$counter = 1;
		$numOfVideos = $result->num_rows;
		$columns = 4;
		$rows = ceil($numOfVideos/$columns);

		$sql2 = "SELECT * from videodata order by VideoPoints desc limit 4";
		$result2 = $conn->query($sql2);

		while($row2 = $result2->fetch_assoc()) {
   		 $topMovies[] = $row2;
  }

  		$sql3 = "SELECT * from videodata order by views desc limit 4";
		$result3 = $conn->query($sql3);

		while($row3 = $result3->fetch_assoc()) {
   		 $MostWatched[] = $row3;
  }
?>
<div class="container" style="margin-top: 20px;">
	<center><h1 style="color: #808080">What would you like to watch today?</h1></center>
	<hr>
	<center><h2 style="color: #808080">Whole Arsenal</h2></center>
	<hr>
	<br>
	<?php
		$row = $result->fetch_assoc();
		for ($i=0; $i < $rows; $i++) { 
	?>
	<div class="row" id="elements">
		<?php
			
			for ($j=0; $j < $columns; $j++) { 
				if($counter <= $numOfVideos) {
		?>
		<div class="col-md-3" align="left" style="height: 100%">
			<div class="mycard" id="cardId1" onmouseenter="show(this)" onmouseleave="hide(this)">
				<img src="<?php echo $row['VideoThumbnail'] ?>" id="image" alt="Card image">
				<div id="overlay-color" onclick="playMovie('<?php echo $row['ID']; ?>','<?php echo $row['views']; ?>')" style="visibility: hidden;"></div>
				<div id="overlay-text" style="padding-right:10px; padding-left: 10px;">
					<div class="row">
						<div class="col-md-6" align="center">
							<label><?php echo $row['VideoName'] ?></label>
						</div>
			    		<div class="col-md-3" align="center">
			    			<span class="badge badge-success" style="margin-bottom: 2px;">Points: <?php echo $row['VideoPoints'] ?></span>
			    		</div>
			    		<div class="col-md-3"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
				$row = $result->fetch_assoc();
				$counter++;
				}  else {
	              break;
	            }
			}
		?>
	</div><br>
	<?php
		}
	?>
	<hr>
	<center><h2 style="color: #808080">Highest Point Gainers</h2></center>
	<hr>
	<div class="row" id="elements">
		<?php 
		for ($i=0; $i < 4; $i++) { 
			# code...
		?>
	<div class="col-md-3" align="left" style="height: 100%">
			<div class="mycard" id="cardId1" onmouseenter="show(this)" onmouseleave="hide(this)">
				<img src="<?php echo $topMovies[$i]['VideoThumbnail']; ?>" id="image" alt="Card image">
				<div id="overlay-color" onclick="playMovie('<?php echo $topMovies[$i]['ID'] ?>','<?php echo $row['views']; ?>')" style="visibility: hidden;"></div>
				<div id="overlay-text" style="padding-right:10px; padding-left: 10px;">
					<div class="row">
						<div class="col-md-6" align="center">
							<label><?php echo $topMovies[$i]['VideoName'] ?></label>
						</div>
			    		<div class="col-md-3" align="center">
			    			<span class="badge badge-success" style="margin-bottom: 2px;">Points: <?php echo $topMovies[$i]['VideoPoints'] ?></span>
			    		</div>
			    		<div class="col-md-3"></div>
					</div>
				</div>
			</div>
		</div>
		<?php  
	}
		?>
	</div>
	<hr>
	<center><h2 style="color: #808080">Most Watched Movies</h2></center>
	<hr>
	<div class="row" id="elements">
		<?php 
		for ($i=0; $i < 4; $i++) { 
			
		?>
	<div class="col-md-3" align="left" style="height: 100%">
			<div class="mycard" id="cardId1" onmouseenter="show(this)" onmouseleave="hide(this)">
				<img src="<?php echo $MostWatched[$i]['VideoThumbnail']; ?>" id="image" alt="Card image">
				<div id="overlay-color" onclick="playMovie('<?php echo $MostWatched[$i]['ID'] ?>','<?php echo $row['views']; ?>')" style="visibility: hidden;"></div>
				<div id="overlay-text" style="padding-right:10px; padding-left: 10px;">
					<div class="row">
						<div class="col-md-6" align="center">
							<label><?php echo $MostWatched[$i]['VideoName'] ?></label>
						</div>
			    		<div class="col-md-3" align="center">
			    			<span class="badge badge-success" style="margin-bottom: 2px;">Points: <?php echo $MostWatched[$i]['VideoPoints'] ?></span>
			    		</div>
			    		<div class="col-md-3"></div>
					</div>
				</div>
			</div>
		</div>
		<?php  
	}
		?>
	</div>
</div>
<br><br><hr><br>
<?php 
	} else {
?>
	<div class="jumbotron" style="margin-top: 250px;">
		<center>
			<h1>Login First</h1>
			<a href="userLogin.html">Click here to go to Login Page</a>
		</center>
	</div>
<?php
}
?>
<script type="text/javascript">
	
	function playMovie(id,views) {
        // console.log(path);
        $.ajax({
          url:"setPathVariable.php", //the page containing php script
          type: "post", //request type,
          dataType: 'json',
          data: {id: id,views: views},
          success:function(result,result1){
            window.location.assign("timing_demo.php");
          }
        });
    }

	function show(div) {
		div.children[1].style.visibility = "visible";
	}

	function hide(div) {
		div.children[1].style.visibility = "hidden";
	}

</script>
</body>
</html>
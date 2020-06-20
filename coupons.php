<?php
		session_start();
		$conn = OpenCon();

		function OpenCon()
		 {
		 $dbhost = "localhost";
		 $dbuser = "root";
		 $dbpass = "";
		 $db = "hackDb";
		 $conn = new mysqli($dbhost, $dbuser, $dbpass, $db) or die("Connect failed: %s\n". $conn -> error);
	 
		 return $conn;
		 }
	 
		function CloseCon($conn) {
		 $conn -> close();
		}

		$sql = "SELECT UserPoints FROM userlogin where ID =".$_SESSION['userId'];
		$Ptresult = $conn->query($sql);
		$userTotalPoints = $Ptresult->fetch_assoc()['UserPoints'];

		$_SESSION['points'] = $userTotalPoints;

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
	  margin: 10px;
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
<body>

	<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
       <a class="navbar-brand" href="#" style="color: lightblue; font-weight: bold;">Watcho Prototype</a>
    </div>
    <ul class="nav navbar-nav">
      <!-- <li class="active"><a href="#">Home</a></li> -->
    </ul>
    <ul class="nav navbar-nav navbar-right">
        <li style="margin-right: 20px; margin-top: 8px; font-size: 20px; color: #FFD700;"><span class="glyphicon glyphicon-star"></span> Points: <?php echo $userTotalPoints; ?></li>
        <!-- <li style="margin-right: 20px; margin-top: 5px; font-size: 20px; color: grey;">
              <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                <span class="glyphicon glyphicon-user"></span></button>
                <ul class="dropdown-menu">
                      <li><a href="#">Redeem Coupons</a></li>
                      <li><a href="#">Logout</a></li>
                </ul>
            </div>
        </li> -->
    </ul>
  </div>
</nav>

<?php

	$sql="SELECT * from coupons";
	$result=$conn->query($sql);
	$counter = 1;
	$numOfCoupons = $result->num_rows;
	$columns = 4;
	$rows = ceil($numOfCoupons/$columns);
?>


<div class="container bg-primary" style="margin-top: 20px">
	<center><h1 style="color: black">What would you like to Redeem Today?</h1></center>
	<hr>
	<br>
	<?php
		$row = $result->fetch_assoc();
		for ($i=0; $i < $rows; $i++) { 
	?>
	<div class="row" id="elements">
		<?php
			
			for ($j=0; $j < $columns; $j++) { 
				if($counter <= $numOfCoupons) {
		?>
		<div class="col-md-3" align="left" style="height: 100%">
			<div class="mycard" id="cardId1" onmouseenter="show(this)" onmouseleave="hide(this)">
				<img src="<?php echo $row['item_image'] ?>" id="image" alt="Card image">
				<div id="overlay-color" style="visibility: hidden;"></div>
				<div id="overlay-text" style="padding-right:10px; padding-left: 10px;">
					<div class="row">
						<div class="col-md-6" align="center">
							<label><?php echo $row['item_id'] ?></label>
						</div>
			    		<div class="col-md-3" align="center">
			    			<span class="badge badge-success" style="margin-bottom: 2px;">Points: <?php echo $row['item_price_coupons']; $currentPrice = $row['item_price_coupons']; ?></span>
			    		</div>
			    		<div class="col-md-3"></div>
					</div>
					<div class="row" align="center">
						<button type="button" class="btn btn-primary" onclick="redeem(<?php echo $currentPrice; ?>)">Redeem</button>
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
</div>

<script type="text/javascript">

	var user_currency = <?php echo $userTotalPoints; ?>;
	 
	var userId = <?php echo $_SESSION['userId']; ?>;

	function redeem(x){
		if(x>user_currency){
			alert("Not Enough Coins");
		}
		else{
			user_currency = user_currency-x;
			redeemUpdate(user_currency, userId);
			alert("Purchase Successfully done");
		}
	}

	function redeemUpdate(points,id) {
        $.ajax({
          url:"setPoints.php", 
          type: "post",
          dataType: 'json',
          data: {points: points, id: id},
          success:function(result){
            window.location.assign("coupons.php");
          }
        });
    }
	
	function playMovie() {
		window.location.assign("timing_demo.html");
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

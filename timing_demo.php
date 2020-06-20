<?php
  session_start();
  $id = $_SESSION['videoId'];
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
    $sql="SELECT * from videodata where ID=".$id;
    // echo $sql;
    $result=$conn->query($sql);
    $row = $result->fetch_assoc();
    $path = $row['VideoPath'];
    $points = $row['VideoPoints'];

    $sql="SELECT recentlyPlayed from userlogin where ID=".$_SESSION['userId'];
    $result=$conn->query($sql);
    $recentlyPlayed = $result->fetch_assoc()['recentlyPlayed'];
    
    $recentlyPlayedArray = explode(';', $recentlyPlayed);
    $recentlyPlayedVideos = array();
    for ($i=1; $i < sizeof($recentlyPlayedArray); $i++) { 
      $element = array_map(function($v) {return intval($v);} ,explode(':', $recentlyPlayedArray[$i]));
      $recentlyPlayedVideos[$element[0]] = $element[1];
    }

    if(array_key_exists($id, $recentlyPlayedVideos)) {
      $timePlayed = $recentlyPlayedVideos[$id];
    } else {
      $timePlayed = 0;
    } 

  }
?>
<!DOCTYPE html>
<html>
  <head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style type="text/css">
    video{
      position: absolute;
    }
    div{
      z-index: 10;
      float: right;
      margin-top: 15px;
      margin-right: 25px;
      color: grey;
    }
    </style>
  </head>
  <body style="margin: 0px; background-color: white;">
    <video controls="true" poster="" id="myVideo">
      <source type="video/mp4" src="<?php echo $path ?>"></source>
    </video>
    <div onclick="goBack()">
      <span class="glyphicon glyphicon-remove"></span>
    </div>
    <input type="hidden" id="points" value="<?php echo $points ?>">
    <input type="hidden" id="videoId" value="<?php echo $id ?>">
    <input type="hidden" id="timePlayed" value="<?php echo $timePlayed ?>">
    <input type="hidden" id="videoViews" value="<?php echo $_SESSION['videoViews'] ?>">
  <script>
    var timeStarted = -1;
    var preTimePlayed = parseInt(document.getElementById('timePlayed').value);
    var timePlayed = 0;
    var duration = 0;  
    var video = document.getElementById("myVideo");
    console.log(preTimePlayed);
    video.style.width = "100%";
    video.style.height = screen.height-100 + "px";
    
    if(video.readyState > 0) { 
      getDuration.call(video);
    } else {         
      video.addEventListener('loadedmetadata', getDuration);
    }

    function pointsGiven() {
      var eightyFivePercent = Math.floor(0.85 * duration);
      
      var pointsGiven = false;
      if(timePlayed > eightyFivePercent){
        pointsGiven = true;
      }
      return pointsGiven;
    }
    function videoStartedPlaying() {
      timeStarted = new Date().getTime()/1000;
    }

    function videoStoppedPlaying(event) {
      timePlayed = calcTimePlayed();
      console.log(calculatePoints(Math.floor(timePlayed)));
      if(timePlayed>=duration && event.type=="ended") {
        saveWatched();
      } else if(event.type=="ended") {
        saveWatched();
      }
    }

    function calcTimePlayed() {
      if(timeStarted>0) {
        var playedFor = new Date().getTime()/1000 - timeStarted;
        timeStarted = -1;
        timePlayed+=playedFor;
      }
      return timePlayed;
    }

    function goBack(){
      timePlayed = calcTimePlayed();
      saveWatched();
    }

    function saveWatched() {
        var id = document.getElementById('videoId').value;
        var time = Math.floor(timePlayed);
        var pointsEarned = calculatePoints(time);
        isView(time);
        // alert("Time: " + time + ", " + "Points Earned: " + pointsEarned)
        $.ajax({
          url:"saveRecentlyPlayed.php", 
          type: "post",
          dataType: 'json',
          data: {id: id, time: time, pointsEarned: pointsEarned},
          success: function(result){
            console.log(result);
            window.location.assign("user.php");
          }
        });
    }

    function calculatePoints(timePlayedFloor) {
      var pointsEarned = 0; 
      if(!pointsGiven()) {  
        var points = parseInt(document.getElementById('points').value);
        var twentyFivePercent = Math.floor(0.25 * duration);
        var eightyFivePercent = Math.floor(0.85 * duration);
        var difference = eightyFivePercent - twentyFivePercent;
        var pointsPerSec = 5;
        var pointIncrease = pointsPerSec/difference * points;
        if(timePlayedFloor >= twentyFivePercent) {
          var timePlayedAfter25 = timePlayedFloor - twentyFivePercent;
          if (timePlayedFloor >= eightyFivePercent) {
            pointsEarned = points;
            return pointsEarned.toFixed(2);
          } else {
            if(preTimePlayed>=twentyFivePercent) {
              if (timePlayedFloor >= preTimePlayed) {
                pointsEarned = Math.floor((timePlayedFloor-preTimePlayed)/5) * pointIncrease;
              }            
            } else {
              pointsEarned = Math.floor((timePlayedFloor-twentyFivePercent)/5)*pointIncrease;
            }
            return pointsEarned.toFixed(2);
          }
        }
        return pointsEarned.toFixed(2);
      } else{
        return pointsEarned.toFixed(2);
      }
    }
    function getDuration() {
      duration = video.duration;
    }
    function isView(timePlayedFloor1) {
      var id1 = document.getElementById('videoId').value;
      var views1 = parseInt(document.getElementById('videoViews').value);
      var fiftyPercent = Math.floor(0.10 * duration);
      if(timePlayedFloor1 >= fiftyPercent)
      {
        views1 = views1+1;
           $.ajax({
          url:"checkViews.php", 
          type: "post",
          dataType: 'json',
          data: {id: id1, views: views1},
          success: function(result){
             console.log(result);
          }
        });
      }
    }

    video.addEventListener("play", videoStartedPlaying);
    video.addEventListener("playing", videoStartedPlaying);

    video.addEventListener("ended", videoStoppedPlaying);
    video.addEventListener("pause", videoStoppedPlaying);

  </script>
  </body>
</html>
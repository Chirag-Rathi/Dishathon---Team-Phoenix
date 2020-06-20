<?php
    session_start();
    $conn = OpenCon();

    function OpenCon() {
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

    $sql = "SELECT VideoPoints FROM videodata";
    $Ptresult = $conn->query($sql);

    while($row3 = $Ptresult->fetch_assoc()) {
        $TotalPoints[] = $row3['VideoPoints'];
    }


    $sql = "SELECT VideoIncentive FROM videodata";
    $Ptresult = $conn->query($sql);

    while($row3 = $Ptresult->fetch_assoc()) {
        $TotalIncentive[] = $row3['VideoIncentive'];
    }

    $sql2 = "SELECT views FROM videodata";
    $ViewResult = $conn->query($sql2);

    while($row3 = $ViewResult->fetch_assoc()) {
        $TotalViews[] = $row3['views'];
    }

    $sql3 = "SELECT sum(views) FROM videodata";
    $TotalViewResult = $conn->query($sql3);
    $count = $TotalViewResult->fetch_assoc()['sum(views)'];

    $newPoints = [];
    for ($i=0; $i < sizeof($TotalPoints); $i++) {
        $newPoints[$i] = $TotalPoints[$i] - exp(-$TotalViews[$i]/$count) + 100/(0.0001+($TotalViews[$i]/$count));
    }

    $max = max($newPoints);
    $min = min($newPoints);

    $scaledNewPoints = [];

    for ($i=0; $i < sizeof($newPoints) ; $i++) {
        $scaledNewPoints[$i] = round(((($newPoints[$i]-$min)/($max-$min))*10),2) + $TotalIncentive[$i]*2;
        if($scaledNewPoints[$i]<3){
            if ($scaledNewPoints<2) {
                $scaledNewPoints[$i] = 2;
            }
            else{
                $scaledNewPoints[$i] = 3;
            }
        }
    }

    $sqlid = "SELECT * FROM videodata";
    $res = $conn->query($sqlid);

    while($row3 = $res->fetch_assoc()) {
        $ids[] =$row3['ID'];
    }

    for($i = 0;$i<sizeof($ids);$i++){
    $sqlupd = "UPDATE videodata SET VideoPoints =".$scaledNewPoints[$i]." WHERE ID = ".$ids[$i];
    $resultupd=$conn->query($sqlupd);
    }
    print_r($ids);
    echo $count;
    echo "<br><br>Initial Points: <br><br>";
    print_r($TotalPoints);
    echo "<br><br>Views: <br><br>";
    print_r($TotalViews);
    echo "<br><br>Incentive: <br><br>";
    print_r($TotalIncentive);
    echo "<br><br>New Points: <br><br>";
    print_r($newPoints);
    echo "<br><br>Scaled Points: <br><br>";
    print_r($scaledNewPoints);
?>
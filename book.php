<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AlastAIR</title>
    <link rel="stylesheet" href="css/airline.css">
</head>
<body>
<div class = "header">
    <ul>
        <li class = "left"><h2 href="airline.php">AlastAIR</h2></li>

        <li class = "right"><a href="airline.php">Home</a></li>
        <li class = "right"><a href="book.php">Book</a></li>
        <li class = "right"><a href="add.php">Add Flight</a></li>
    </ul>
</div>

<h1>Flights</h1>
<form action="book.php" METHOD="POST">

    <?php
    echo "Select days to fly: </br>";
    $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');

    foreach ($days as $day) {

        echo '<input type="radio" name="day" value="';
        echo $day;
        echo '">' . $day . "<br>";
    }
    ?>
    <br>
    <label for="code">Airline Code:</label>
    <textarea id="" name="code" rows="1" cols="2" maxlength="2" placeholder="AC"></textarea>
    <br><br>
    <input type="submit" value="Search">
</form>
<br>
<?php
include 'connectdb.php';
?>
<?php
$join = "";

if(isset($_POST["day"])){
    echo "<h6>".$_POST["code"] ." Flights on ". $_POST['day']."</h6>";
    $day = $_POST["day"];

    $join .= " join daysOffered df on df.flightCode=f.flightCode and df.airlineCode=f.airlineCode where df.day='$day'";
    if(isset($_POST["code"]) && $_POST["code"]!=""){
        $code = $_POST["code"];
        $join .=" and f.airlineCode='$code'";
    }

} else {
    if(isset($_POST["code"]) && $_POST["code"]!=""){
        echo "<h6>".$_POST["code"] ." Flights</h6>";
        $code = $_POST["code"];
        $join .=" where f.airlineCode='$code'";
    }
}

$query = "select * from flight f ".$join;

$query2 = "select avg(a.maxSeats) as av 
from (airplaneType a join airplane ap on a.name = ap.type)
    join flight f on f.airplane = ap.id".$join;

$result = $connection->query($query);
$result2 = $connection->query($query2);

while ($row = $result2->fetch()) {
    echo "<p> Average of ".$row["av"]." Seats</p>";
}

echo "</br></br>
<table>
  <tr>
    <th>Flight Number</th>
    <th>Depart City</th>
    <th>Arrive City</th>
  </tr>
    ";

while ($row = $result->fetch()) {
    $depart = $row['departureAirport'];
    $result2 = $connection->query("select *  from airport where code='$depart'");
    $arrive = $row['arrivalAirport'];
    $result3 = $connection->query("select *  from airport where code='$arrive'");

    echo"<tr>";
    echo "<td>".$row["airlineCode"] ."-".$row["flightCode"]. "</td>";
    echo "<td>".$result2->fetch()["city"] . "</td>";
    echo "<td>".$result3->fetch()["city"] . "</td>";
    echo "</tr>";
}

?>


</body>
</html>
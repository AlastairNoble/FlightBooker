<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Alastair Add </title>
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
<?php
include 'connectdb.php';
?>

<h1>Add Flight</h1>

    <form action="add.php" METHOD="POST">
        <?php
            echo "<h3>Airline</h3>";

            $query  = "select code from airline";
            $result = $connection->query($query);

            while ($row = $result->fetch()) {
                echo '<input type="radio" name="airlineCode" value="'.$row["code"].'" checked>' . $row["code"] . "<br>";
            }

        $query  = "select code from airport";
        $result = $connection->query($query);
        $depart = "";
        $arrive = "";
        while ($row = $result->fetch()) {
            $depart.= '<input type="radio" name="departCode" value="'.$row["code"].'" checked>' . $row["code"] . "<br>";
            $arrive.= '<input type="radio" name="arriveCode" value="'.$row["code"].'" checked>' . $row["code"] . "<br>";
        }

        echo "<h3>Depart Airport</h3>".$depart;
        echo "<h3>Arrive Airport</h3>".$arrive;

        echo "<h3>Flight Number</h3>
            <textarea id='' name='flightNo' rows='1' cols='4' maxlength='4' placeholder='1234'>".rand(1000,9999)."</textarea>
            </br>
        ";
        echo "<h3>Select days to fly</h3> ";
        $days = array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday');

        foreach ($days as $day) {

            echo '<input type="checkbox" id="'.$day.'" name="'.$day.'" value="'.$day.'">';
            echo '<label for="'.$day.'">'. $day.'</label><br>';
            //echo "<input type='radio' name='day' value=".$day.">" . $day . "<br>";
        }

        $query  = "select id from airplane";
        $result = $connection->query($query);
        $planes = "";
        while ($row = $result->fetch()) {
            $planes .= '<input type="radio" name="plane" value="' . $row["id"] . '" checked>' . $row["id"] . "<br>";
        }
        echo "<h3>Plane</h3>".$planes;



        ?>
        <input type="submit" value="Add Flight">
    </form>

    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {


            $airlineCode = "'" . $_POST["airlineCode"] . "'";
            $flightCode = $_POST["flightNo"];
            $arrivalAirport = "'" . $_POST["arriveCode"] . "'";
            $departAirport = "'" . $_POST["departCode"] . "'";
            $airPlane = "'" . $_POST["plane"] . "'";
            $args = implode(", ", array($airlineCode, $flightCode, 'null', 'null', 'null', 'null', $arrivalAirport, $departAirport, $airPlane));
            //$add_flight = "insert into flight values ('WJ',1655,'09:22:00', '10:22:00', '10:22:00', '10:22:00','YVR','YYZ','Plane12');";
            $add_flight = "insert into flight values (" . $args . ");";
            //echo $add_flight;
            if ($connection->exec($add_flight)) {
                echo "FLIGHT ADDED <br>";

            } else {
                echo "FAIL";
            }

            foreach ($days as $day) {
                if(isset($_POST[$day])){
                    $args = implode(", ",array($airlineCode,$flightCode, "'".$day."'"));
                    $add_days = "INSERT into DaysOffered VALUES(".$args.");";
                    //echo $add_days;
                    if ($connection->exec($add_days)) {
                        echo $day." ADDED <br>";
                    }
                }
            }

        }
    ?>
</body>
</html>
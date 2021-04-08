<?php
$result = $connection->query("select *  from flight");

$onTime = "<br><h3>On Time</h3>Scheduled Arrival time = Actual Arrival Time
    <table>  <tr>
    <th>Flight no.</th>
    <th>Departure Time</th>

    <th>Arrival Time</th>

  </tr>";


while ($row = $result->fetch()) {
    if ($row["arrivalScheduledTime"]==$row["arrivalActualTime"] && $row["arrivalScheduledTime"]!=null)
        $onTime.= "<tr>
                    <td>".$row["airlineCode"] ."-".$row["flightCode"]. "</td>
                    <td>".$row["departureScheduledTime"]."</td>
                    <td>".$row["arrivalScheduledTime"]."</td>
              </tr>";

}
echo $onTime."</table><br><br>";

$allFlights = "<h3>All Flights</h3>
<table>  <tr>
    <th>Flight no.</th>
    <th>Scheduled Departure Time</th>
    <th>Actual Departure Time</th>

    <th>Arrival Time</th>
  </tr>";








$result = $connection->query("select *  from flight");

while ($row = $result->fetch()) {

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST[$row["airlineCode"] . "-" . $row["flightCode"]])) {
        $newTime = $_POST[$row["airlineCode"] . "-" . $row["flightCode"]];

        $update = "update flight set departureArrivalTime = '" . $newTime . "' where airlineCode='" . $row['airlineCode'] . "' and flightCode=" . $row['flightCode'] . ";";

        if ($connection->exec($update)) {
            echo "ACTUAL DEPARTURE TIME FOR FLIGHT " . $row["airlineCode"] . "-" . $row["flightCode"] . "UPDATED <br>";
        }

    }
}
$result = $connection->query("select *  from flight");

while ($row = $result->fetch()) {


    $allFlights.= "<tr>
                    <td>".$row["airlineCode"] ."-".$row["flightCode"]. "</td>
                    <td>".$row["departureScheduledTime"]."</td>

                    <td>".$row["departureArrivalTime"]."</nobr>
                    <form action='airline.php' METHOD='POST'>
                        <textarea id='' name='".$row["airlineCode"] ."-".$row["flightCode"]."' rows='1' cols='8' maxlength='8' placeholder=".$row["departureArrivalTime"]."></textarea>

                        <input type='submit' value='Update'>
                    </form>
                    </td>
                    <td>".$row["arrivalScheduledTime"]."</td>
              </tr>";
}
echo $allFlights."</table>";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>AlastAIR Home</title>
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

    <?php
        include 'connectdb.php';
        ?>
    <?php
        include 'getdata.php';
        ?>

</body>
</html>
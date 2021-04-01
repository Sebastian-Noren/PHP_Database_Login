<?php
include "db_conn.php";
session_start();
//Check seesion if ok or hide the page and send user back
if(isset($_SESSION['loggedInUser'])) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hidden Page - articles</title>
</head>

<body>
    <h2>Hidden Page</h2>
    <a href="logout.php">Logout</a>

<?php
$sql = "SELECT * FROM articles";

$queryResult = mysqli_query($connection, $sql);

// Loop through the result
while ($row = $queryResult->fetch_assoc()) {
    $head = $row['headline'];
    $text = $row['text'];
    echo   "<h3>$head</h3>";
   echo   "<p>$text</p>";
}
?>

</body>

</html>

<?php
}else{
    header("Location: index.php"); // Send back if no session exist
    exit();
}
?>
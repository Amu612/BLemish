<?php
$servername = "localhost";
$username = "root";
$password = "sumo@123";
$database = "BLemish";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if ($conn) {
    // echo "Connected successfully!";
}
else
{
    echo "connection failed";
}
?>

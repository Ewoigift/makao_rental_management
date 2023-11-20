<?php
$conn = mysqli_connect("localhost", "root", "Ichoro22*", "makaodb");
if ($conn) {
    echo ("Connection Successful");
} else {
    echo ("Connection Failed" . mysqli_connect_error());
}
?>
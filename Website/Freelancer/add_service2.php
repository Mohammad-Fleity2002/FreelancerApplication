<?php
include("connection.php");
session_start();
$service_title = "title";
$unique = "SELECT * FROM services WHERE freelancer_id='" . $_SESSION['id'] . "' AND service_title='" . $service_title . "';";
$res = mysqli_query($conn, $unique);
mysqli_close($conn);
print_r($res);
while ($r = mysqli_fetch_array($res)) {
    print_r($r);
}

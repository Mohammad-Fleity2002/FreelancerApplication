<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}

if (!isset($_GET["uid"])) {
    header("location: admins.php");
    exit;
}
$uid = $_GET["uid"];
$today = date("Y-m-d");
// $update = "UPDATE users SET user_delete_date =" . $today . " WHERE user_id ='" . $uid . "';";
$update = "UPDATE `users` SET `user_delete_date` = '$today' WHERE `users`.`user_id` = $uid";
// $update = "UPDATE users SET user_delete_date =" . $today . " WHERE user_id ='" . $uid . "';";
include("connection.php");
$res = mysqli_query($conn, $update);
mysqli_close($conn);
if (!$res) {
    header("location: users.php?Err=" . urlencode(mysqli_error($conn)));
    exit;
}
header("location: users.php");

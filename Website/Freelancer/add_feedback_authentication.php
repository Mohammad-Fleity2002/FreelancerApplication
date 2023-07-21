<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
if (empty($_POST["sid"])) {
    header("location: search.php");
    exit;
} else {
    $sid = $_POST["sid"];
}
if (
    !empty($_POST["feedback_description"]) &&
    !empty($_POST["rate"])
) {
    $today = date("Y-m-d");
    $uid = $_SESSION['id'];
    $feedback_description = htmlspecialchars($_POST["feedback_description"]);
    $rate = htmlspecialchars($_POST["rate"]);
    include("connection.php");
    $insert = "INSERT INTO rates_feedbacks 
    (feedback_description,feedback_rate,feedback_date,service_id,customer_id) VALUES 
    ('$feedback_description','$rate','$today','$sid','$uid');";
    $result = mysqli_query($conn, $insert);
    mysqli_close($conn);
    if ($result) {
        header("location: feedback.php?sid=" . $sid);
        // echo "location: feedback.php?sid=" . $sid;
        // exit;
    } else {
        // echo "location: add_feedbacks.php?sid=" . urlencode($sid);
        header("location: add_feedbacks.php?sid=" . urlencode($sid) . "&Err=" . urlencode(mysqli_error($conn)));
        exit;
    }
} else {
    // echo "location: add_feedbacks.php?sid=" . urlencode($sid);
    header("location: add_feedbacks.php?sid=" . urlencode($sid) . "&Err=" . urlencode("All fields Are required"));
}

<?php
session_start();
if (!empty($_POST["email"]) && !empty($_POST["password"])) {
    include_once "connection.php";
    $email = htmlspecialchars($_POST["email"]);
    $pass = htmlspecialchars($_POST["password"]);
    $query = "SELECT * FROM users WHERE user_email='" . $email . "' and user_password='" . $pass . "' and user_delete_date IS NULL;";
    $res = mysqli_query($conn, $query);
    mysqli_close($conn);
    if (!$res) {
        header("location: login.php?Err=" . urlencode(mysqli_error($con)));
        exit;
    } else if (!$row = mysqli_fetch_array($res)) {
        header("location: login.php?Err=" . urlencode("invalid credentials!"));
        exit;
    }
    $_SESSION['id'] = $row["user_id"];
    $_SESSION['name'] = $row["user_first_name"];
    $_SESSION['code_role'] = $row["code_role"];
    header("location: search.php");
    exit;
} else {
    header("location: login.php");
}

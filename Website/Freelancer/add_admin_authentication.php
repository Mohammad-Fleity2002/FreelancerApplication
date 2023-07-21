<?php
session_start();
include 'connection.php';
if (
    !empty($_POST["name"]) &&
    !empty($_POST["email"]) &&
    !empty($_POST["phone_number"]) &&
    !empty($_POST["code_gender"]) &&
    !empty($_POST["birthdate"]) &&
    !empty($_POST["password"]) &&
    !empty($_POST["code_area"]) &&
    !empty($_POST["code_role"])
) {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone_number = htmlspecialchars($_POST["phone_number"]);
    $code_gender = htmlspecialchars($_POST["code_gender"]);
    $birthdate = htmlspecialchars($_POST["birthdate"]);
    $password = htmlspecialchars($_POST["password"]);
    $code_area = htmlspecialchars($_POST["code_area"]);
    $code_role = htmlspecialchars($_POST["code_role"]);
    $email_pattern = "//";
    $password_pattern = "//";
    $phonenb_pattern = "/\+(961)-\d{2}\/\d{6}/";
    $query_unique = "SELECT * FROM users WHERE user_email='" . $email . "';";
    include("connection.php");
    $unique = mysqli_query($conn, $query_unique);
    mysqli_close($conn);
    if (mysqli_num_rows($unique) == 0) {
        if (preg_match($phonenb_pattern, $phone_number)) {
            if (preg_match($email_pattern, $email)) {
                if (preg_match($password_pattern, $password)) {
                    $today = date("Y-m-d");
                    $query = "INSERT INTO users
                ( user_name, user_email, user_phone_number, code_gender, user_birthdate, user_password, user_join_date, code_area, code_role)
                VALUES 
                ( '$name', '$email', '$phone_number', '$code_gender', '$birthdate','$password', '$today', '$code_area', '$code_role')";
                    include("connection.php");
                    $result = mysqli_query($conn, $query);
                    mysqli_close($conn);
                    if (!$result) {
                        header("location: add_admin.php?Err=" . urlencode(mysqli_error($conn)));
                        exit;
                    } else {
                        header("location: users.php");
                        exit;
                    }
                } else {
                    header("location: add_admin.php?Err=" . urlencode("can't use this password"));
                    exit;
                }
            } else {
                header("location: add_admin.php?Err=" . urlencode("email already used")); //email already used
                exit;
            }
        } else {
            header("location: add_admin.php?Err=" . urlencode("wrong phone patterns"));
            exit;
        }
    }
} else {
    header("location: add_admin.php?Err=" . urlencode("All fields Are required"));
    exit;
}

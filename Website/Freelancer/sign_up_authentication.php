<?php
session_start();
include 'connection.php';
print_r($_POST);
if (
    !empty($_POST["first_name"]) &&
    !empty($_POST["last_name"]) &&
    !empty($_POST["email"]) &&
    !empty($_POST["phone_number"]) &&
    !empty($_POST["code_gender"]) &&
    !empty($_POST["birthdate"]) &&
    !empty($_POST["password"]) &&
    !empty($_POST["confirm_password"]) &&
    !empty($_POST["code_area"]) &&
    !empty($_POST["code_role"])
) {
    $first_name = htmlspecialchars($_POST["first_name"]);
    $last_name = htmlspecialchars($_POST["last_name"]);
    $email = htmlspecialchars($_POST["email"]);
    $phone_number = htmlspecialchars($_POST["phone_number"]);
    $code_gender = htmlspecialchars($_POST["code_gender"]);
    $birthdate = htmlspecialchars($_POST["birthdate"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirm_password = htmlspecialchars($_POST["confirm_password"]);
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
                if ($password == $confirm_password) {
                    if (preg_match($password_pattern, $password)) {
                        $today = date("Y-m-d");
                        $query = "INSERT INTO users
                        ( user_first_name ,user_last_name ,user_email, user_phone_number, code_gender, user_birthdate, user_password, user_join_date, code_area, code_role)
                        VALUES 
                        ( '$first_name', '$last_name', '$email', '$phone_number', '$code_gender', '$birthdate','$password', '$today', '$code_area', '$code_role')";
                        include("connection.php");
                        $result = mysqli_query($conn, $query);
                        mysqli_close($conn);
                        if (!$result) {
                            header("location: sign_up.php?Err=" . urlencode(mysqli_error($conn)));
                            exit;
                        } else {
                            header("location:login.php");
                            exit;
                        }
                    } else {
                        header("location: sign_up.php?Err=" . urlencode("can't use this password"));
                        exit;
                    }
                } else {
                    header("location: sign_up.php?Err=" . urlencode("Password is not confirmed"));
                    exit;
                }
            } else {
                header("location: sign_up.php?Err=" . urlencode("wrong email patterns"));
                exit;
            }
        } else {
            header("location: sign_up.php?Err=" . urlencode("wrong phone patterns"));
            exit;
        }
    } else {
        header("location: sign_up.php?Err=" . urlencode("email already used")); //email already used
        exit;
    }
} else {
    header("location: sign_up.php?Err=" . urlencode("All fields Are required"));
}

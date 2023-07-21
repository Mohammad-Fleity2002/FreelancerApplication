<?php
if (isset($_SESSION['id']))
    header("location: loginpage.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <title>Sign Up</title>
    <style>
        .card-registration .select-input.form-control[readonly]:not([disabled]) {
            font-size: 1rem;
            line-height: 2.15;
            padding-left: .75em;
            padding-right: .75em;
        }

        .card-registration .select-arrow {
            top: 13px;
        }

        .bg_radial_2 {
            background: rgb(22, 13, 25);
            background: linear-gradient(90deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 30%, rgba(225, 135, 255, 1) 100%);
        }
    </style>

</head>

<body class="bg_radial_2">
    <section class="h-100 ">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col">
                    <div class="card card-registration my-4">
                        <div class="row g-0">
                            <div class="col-xl-6 d-none d-xl-block">
                                <img src="./image/signup1.webp" alt="Sample photo" class="img-fluid" style="border-top-left-radius: .25rem; border-bottom-left-radius: .25rem;" />
                            </div>
                            <div class="col-xl-6">
                                <form action="sign_up_authentication.php" method="post">
                                    <div class="card-body p-md-5 text-black">
                                        <span class="h2 fw-bold mb-0 text-gold">Sign Up</span>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <label class="form-label" for="first_name">First name</label>
                                                    <input type="text" name="first_name" required id="first_name" class="form-control  border border-dark border-1 " />
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <div class="form-outline">
                                                    <label class="form-label" for="last_name">Last name</label>
                                                    <input type="text" name="last_name" required id="last_name" class="form-control  border border-dark border-1 " />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="email">Email</label>
                                            <div class="input-group border border-dark border-1 rounded-1">
                                                <div class="input-group-text">@</div>
                                                <input type="email" id="email" required name="email" class="form-control  " />
                                            </div>
                                        </div>
                                        <div class="d-md-flex justify-content-start align-items-center mb-4 py-2">
                                            <h6 class="mb-0 me-4">Gender: </h6>
                                            <?php
                                            include "connection.php";
                                            $quer = "SELECT * FROM genders";
                                            $res = mysqli_query($conn, $quer);
                                            if ($res) {
                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    $c = $row["code_gender"];
                                                    $r = $row["gender_description"];
                                                    // echo "<option value=" . $c . ">$r</option>";
                                                    echo "<div class=\"form-check form-check-inline mb-0 me-4\">
                                                        <input class=\"form-check-input\" type=\"radio\" name=\"code_gender\" id=\"Gender" . $c . "\" value=\"" . $c . "\" />
                                                        <label class=\"form-check-label\" for=\"Gender" . $c . "\">" . $r . "</label></div>";
                                                }
                                            }
                                            mysqli_close($conn);
                                            ?>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 mb-4">
                                                <select class="select form-control border border-dark border-1" required name="code_role">
                                                    <option selected>choose role</option>
                                                    <?php
                                                    include "connection.php";
                                                    $quer = "SELECT * FROM user_roles";
                                                    $res = mysqli_query($conn, $quer);
                                                    if ($res) {
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                            $c = $row["code_role"];
                                                            $r = $row["role_title"];
                                                            if ($r == "Admin") {
                                                                continue;
                                                            }
                                                            echo "<option value=" . $c . ">$r</option>";
                                                        }
                                                    }
                                                    mysqli_close($conn);
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6 mb-4">
                                                <select class="select form-control border border-dark border-1" required name="code_area">
                                                    <option selected>choose area</option>
                                                    <?php
                                                    include "connection.php";
                                                    $quer = "SELECT * FROM areas";
                                                    $res = mysqli_query($conn, $quer);
                                                    if ($res) {
                                                        while ($row = mysqli_fetch_assoc($res)) {
                                                            $c = $row["code_area"];
                                                            $r = $row["area_name"];
                                                            echo "<option value=" . $c . ">$r</option>";
                                                        }
                                                    }
                                                    mysqli_close($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="tel">Phone number</label>
                                            <div class="input-group border border-dark border-1 rounded-1">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z" />
                                                    </svg>
                                                </div>
                                                <input type="tel" class="form-control " required name="phone_number" id="tel" placeholder="+961-xx/xxxxxxx">
                                            </div>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="birthdate"> Birthdate</label>
                                            <input type="date" name="birthdate" id="birthdate" required class="form-control border border-dark border-1">
                                        </div>
                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="password">Password</label>
                                            <div class="input-group border border-dark border-1 rounded-1">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                                                        <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                                                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z" />
                                                    </svg>
                                                </div>
                                                <input type="password" id="password" required name="password" class="form-control " />
                                            </div>
                                        </div>
                                        <div class="form-outline mb-3">
                                            <label class="form-label" for="confirm_password">Confirm Password</label>
                                            <div class="input-group border border-dark border-1 rounded-1">
                                                <div class="input-group-text">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-shield-lock" viewBox="0 0 16 16">
                                                        <path d="M5.338 1.59a61.44 61.44 0 0 0-2.837.856.481.481 0 0 0-.328.39c-.554 4.157.726 7.19 2.253 9.188a10.725 10.725 0 0 0 2.287 2.233c.346.244.652.42.893.533.12.057.218.095.293.118a.55.55 0 0 0 .101.025.615.615 0 0 0 .1-.025c.076-.023.174-.061.294-.118.24-.113.547-.29.893-.533a10.726 10.726 0 0 0 2.287-2.233c1.527-1.997 2.807-5.031 2.253-9.188a.48.48 0 0 0-.328-.39c-.651-.213-1.75-.56-2.837-.855C9.552 1.29 8.531 1.067 8 1.067c-.53 0-1.552.223-2.662.524zM5.072.56C6.157.265 7.31 0 8 0s1.843.265 2.928.56c1.11.3 2.229.655 2.887.87a1.54 1.54 0 0 1 1.044 1.262c.596 4.477-.787 7.795-2.465 9.99a11.775 11.775 0 0 1-2.517 2.453 7.159 7.159 0 0 1-1.048.625c-.28.132-.581.24-.829.24s-.548-.108-.829-.24a7.158 7.158 0 0 1-1.048-.625 11.777 11.777 0 0 1-2.517-2.453C1.928 10.487.545 7.169 1.141 2.692A1.54 1.54 0 0 1 2.185 1.43 62.456 62.456 0 0 1 5.072.56z" />
                                                        <path d="M9.5 6.5a1.5 1.5 0 0 1-1 1.415l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99a1.5 1.5 0 1 1 2-1.415z" />
                                                    </svg>
                                                </div>
                                                <input type="password" id="confirm_password" required name="confirm_password" class="form-control  " />
                                            </div>
                                        </div>
                                        <?php
                                        if (isset($_GET['Err'])) {
                                            echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
                                        }
                                        ?>
                                        <div class="d-flex justify-content-end pt-3">
                                            <input type="reset" value="Reset all" class="btn btn-light btn-lg">
                                            <input class="btn btn-light btn-lg ms-1 text-white" style="background-color: #31284c;" type="submit" value="Register">
                                        </div>
                                        <p class=" pb-lg-2" style="color: #635199">Already registered? <a href="login.php" style="color: #393f81;">login</a></p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
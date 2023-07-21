<?php
if (isset($_SESSION['id']))
    header("location: search.php");
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
    <title>Login</title>
    <style>
        .bg_radial_2 {
            background: rgb(22, 13, 25);
            background: linear-gradient(90deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 30%, rgba(225, 135, 255, 1) 100%);
        }
    </style>

</head>

<body>
    <section class="vh-100 bg_radial_2">
        <!-- <section class="vh-100" style="background-color: #9A616D;"> -->
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="./image/login1.webp" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="authentication.php" method="post">

                                        <div class=" mb-3 pb-1">
                                            <span class="h2 fw-bold mb-0 text-gold">Freelancer</span>
                                            <!-- <span class="h2 fw-bold mb-0" style="color: #9A616D">Freelancer</span> -->

                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign in to your account</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example17">Email address</label>
                                            <input type="email" id="form2Example17" name="email" class="form-control form-control-lg" />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label" for="form2Example27">Password</label>
                                            <input type="password" id="form2Example27" name="password" class="form-control form-control-lg" />
                                        </div>

                                        <?php
                                        if (isset($_GET['Err'])) {
                                            echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
                                        }
                                        ?>
                                        <div class="pt-1 mb-4">
                                            <button type="submit" class="btn bg-gold fw-bold text-black px-3">Login</button>
                                        </div>

                                        <a class="small text-muted" href="#!">Forgot password?</a>
                                        <p class="mb-5 pb-lg-2" style="color: #635199">Don't have an account? <a href="sign_up.php" style="color: #393f81;">Register here</a></p>
                                        <a href="#!" class="small text-muted">Terms of use.</a>
                                        <a href="#!" class="small text-muted">Privacy policy</a>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
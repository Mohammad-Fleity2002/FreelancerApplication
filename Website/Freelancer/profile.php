<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: login.php");
} else {
    include 'connection.php';
    $qry = "SELECT * FROM users WHERE user_id=" . $_SESSION['id'] . ";";
    $res = mysqli_query($conn, $qry);
    mysqli_close($conn);
    if (!$row = mysqli_fetch_array($res)) {
        header("location: login.php?Err=" . urlencode(mysqli_error($conn)));
        exit;
    } else {
        $email = $row["user_email"];
        $birthdate = $row["user_birthdate"];
        $code_area = $row["code_area"];
        $tel = $row["user_phone_number"];
        $code_gender = $row["code_gender"];
        $join_date = $row["user_join_date"];
        $full_name = $row['user_first_name'] . " " . $row['user_last_name'];
        $profile = $row["user_profile_link"];
        include "connection.php";
        // $qry = "SELECT gender_description FROM genders WHERE code_gender=" . $code_gender . ";";
        $qry = "SELECT area_name FROM areas WHERE code_area=" . $code_area . ";";
        $res_area = mysqli_query($conn, $qry);
        $row_area = mysqli_fetch_array($res_area);
        $qry = "SELECT role_title FROM user_roles WHERE code_role=" . $_SESSION['code_role'] . ";";
        $res_role = mysqli_query($conn, $qry);
        $row_role = mysqli_fetch_array($res_role);
        $qry = "SELECT gender_description FROM genders WHERE code_gender=" . $code_gender . ";";
        $res_gender = mysqli_query($conn, $qry);
        $row_gender = mysqli_fetch_array($res_gender);
        mysqli_close($conn);
        $freelancer_role = $row_role[0];
        $freelancer_area = $row_area[0];
        $freelancer_gender = $row_gender[0];
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $_SESSION['name'] ?></title>
    <link href="./css/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>

    <style>
        body {
            /* margin-top: 20px; */
            color: #1a202c;
            text-align: left;
            background-color: #e2e8f0;
        }

        .main-body {
            padding: 15px;
        }

        .card {
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, .1), 0 1px 2px 0 rgba(0, 0, 0, .06);
        }

        .card {
            position: relative;
            display: flex;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-body {
            flex: 1 1 auto;
            min-height: 1px;
            padding: 1rem;
        }

        .gutters-sm {
            margin-right: -8px;
            margin-left: -8px;
        }

        .gutters-sm>.col,
        .gutters-sm>[class*=col-] {
            padding-right: 8px;
            padding-left: 8px;
        }

        .mb-3,
        .my-3 {
            margin-bottom: 1rem !important;
        }

        .bg-gray-300 {
            background-color: #e2e8f0;
        }

        .h-100 {
            height: 100% !important;
        }

        .shadow-none {
            box-shadow: none !important;
        }

        .bg_radial_3 {
            background: rgb(225, 135, 255);
            background: linear-gradient(90deg, rgba(225, 135, 255, 1) 0%, rgba(249, 231, 255, 1) 50%, rgba(252, 252, 252, 1) 100%);
        }
    </style>
</head>

<body class="bg_radial_3">
    <!-- <div class="container">
        <div class="main-body">

            <nav aria-label="breadcrumb" class="main-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                    <li class="breadcrumb-item"><a href="javascript:void(0)">User</a></li>
                    <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                </ol>
            </nav>
 -->
    <nav class="navbar navbar-expand-md py-1 navbar-light border border-2 border-purple bg-white">
        <div class="container-md py-1">
            <a href="#intro" class="navbar-brand">
                <span class="fw-bold" style="color:rgba(2, 0, 36, 1) ;">Freelancer</span>
            </a>
            <button class="navbar-toggler bg-purple text-white" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end align-items-end" id="main-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="profile.php" class="h3 py-0 my-0 text-capitalize text-purple fw-bold nav-link"><?php echo $_SESSION['name'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="search.php" class="h4 py-0 my-0 text-purple fw-bold nav-link">search</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="h4 py-0 my-0 text-purple fw-bold nav-link">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section class="px-3 pt-3  vh-100">
        <div class="row ">
            <div class="col-md-4 mb-3 ">
                <div class="card border border border-2 border-purple rounded-1">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <img src="<?php echo $profile; ?>" alt="Admin" class="rounded-circle" width="150">
                            <div class="mt-3">
                                <h4><?php echo $_SESSION['name'] ?></h4>
                                <p class="text-secondary mb-1"><?php echo $freelancer_role; ?></p>
                                <p class="text-muted font-size-sm"><?php echo $freelancer_area; ?></p>
                                <?php
                                if ($freelancer_role == "freelancer") {
                                    echo "<div class=\"container text-center\">
                                        <button class=\"bg-purple text-white btn\">
                                        <a href=\"my_services.php\" class=\"text-white\" style=\"text-decoration: none;\">
                                        My Services
                                        </a>
                                        </button>
                                        </div>";
                                } elseif ($freelancer_role == "Admin") {
                                    echo "<div class=\"container text-center\">
                                    <button class=\"bg-purple text-white btn\">
                                    <a href=\"users.php\" class=\"text-white\" style=\"text-decoration: none;\">
                                    Manage System
                                    </a>
                                    </button>
                                    </div>";
                                } else {
                                    // echo "<button class=\"btn btn-purple\">Report</button>";
                                }
                                ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 mb-3">
                <div class="card mb-3">
                    <div class="card-body border border-2 border-purple rounded-1">
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Full Name</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $full_name; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Email</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $email; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Gender</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $freelancer_gender; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Phone</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                <?php echo $tel; ?>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <h6 class="mb-0">Address</h6>
                            </div>
                            <div class="col-sm-9 text-secondary">
                                Lebanon,<?php echo $freelancer_area; ?>.
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-info " target="__blank" href="https://www.bootdey.com/snippets/view/profile-edit-data-and-skills">Edit</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mt-2 border border-2 border-purple rounded-1">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe mr-2 icon-inline">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="2" y1="12" x2="22" y2="12"></line>
                                    <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path>
                                </svg>Website</h6>
                            <span class="text-secondary">https://bootdey.com</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-github mr-2 icon-inline">
                                    <path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path>
                                </svg>Github</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-twitter mr-2 icon-inline text-info">
                                    <path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path>
                                </svg>Twitter</h6>
                            <span class="text-secondary">@bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram mr-2 icon-inline text-danger">
                                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>Instagram</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                            <h6 class="mb-0"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-facebook mr-2 icon-inline text-primary">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>Facebook</h6>
                            <span class="text-secondary">bootdey</span>
                        </li>
                    </ul>
                </div>

            </div>
        </div>

        </div>
        </div>
</body>

</html>
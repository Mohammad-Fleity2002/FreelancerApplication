<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
if (!isset($_GET["sid"])) {
    header("location: search.php");
    exit;
} else {
    $sid = $_GET["sid"];
    $uid = $_SESSION["id"];
    // $sid = "2";
    $qry = "SELECT * FROM services WHERE service_id='" . $sid . "';";
    include("connection.php");
    $result = mysqli_query($conn, $qry);
    if ($result) {
        $row = mysqli_fetch_array($result);
        $service_title = $row["service_title"];
        $service_location = $row["service_location"];

        $freelancer = "SELECT * FROM users WHERE user_id='" . $row["freelancer_id"] . "';";
        $resultfreelancer = mysqli_query($conn, $freelancer);
        $rowfreelancer = mysqli_fetch_array($resultfreelancer);
        $user_name = $rowfreelancer["user_name"];
        $user_email = $rowfreelancer["user_email"];
        $user_phone_number = $rowfreelancer["user_phone_number"];
        $aid = $row["area_code"];
        $tid = $row["service_code"];
        $area = "SELECT * FROM areas WHERE code_area='" . $row["area_code"] . "';";
        $result_area = mysqli_query($conn, $area);
        $row_area = mysqli_fetch_array($result_area);
        $area_name = $row_area["area_name"];
        $rate = "SELECT AVG(feedback_rate) FROM rates_feedbacks WHERE service_id='" . $row["service_id"] . "';";
        if ($avg = mysqli_query($conn, $rate)) {
            $ravg = mysqli_fetch_row($avg);
            $a = $ravg[0];
            if ($a == null) {
                $a = 0;
            }
        }
        $feedback_query = "SELECT * FROM rates_feedbacks WHERE service_id='" . $sid . "';";
        $result_feedbacks = mysqli_query($conn, $feedback_query);
        if (!$result_feedbacks) {
            header("location: search.php");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="./css/main.min.css" rel="stylesheet">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
    <title><?php echo $service_title; ?></title>
</head>
<style>
    .bg_radial_1 {
        background: rgb(2, 0, 36);
        background: linear-gradient(90deg, rgba(2, 0, 36, 1) 0%, rgba(165, 135, 255, 1) 60%, rgba(203, 186, 255, 1) 100%);
    }

    .bg_radial_2 {
        background: rgb(22, 13, 25);
        background: linear-gradient(90deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 50%, rgba(225, 135, 255, 1) 100%);
    }
</style>

<body class="bg_radial_2">
    <!-- <nav class="navbar navbar-expand-md py-1 navbar-light border border-2 border-purple bg-white">
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
    </nav> -->
    <nav class="navbar navbar-expand-md py-1 bg-white navbar-light border border-2 border-purple">
        <div class="container-md py-1">
            <a href="#intro" class="navbar-brand">
                <span class="fw-bold text-gold">Freelancer</span>
            </a>
            <button class="navbar-toggler bg-purple text-white" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end align-items-end" id="main-nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="profile.php" class="h3 py-0 my-0 text-capitalize  fw-bold nav-link"><?php echo $_SESSION['name'] ?></a>
                    </li>
                    <li class="nav-item">
                        <a href="search.php" class="h4 py-0 my-0 fw-bold nav-link">search</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="h4 py-0 my-0 fw-bold  nav-link">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <?php
    echo "
    <section class=\" row  mx-1 \" >
    <div class=\"container-md text-center text-white col-10  py-1 px-2\" >
      <h5 class=\"h4  d-inline-block p-1 m-0\">
        " . $user_name . "
      </h5>
      <p class=\" font-italic font-weight-bold p-0 m-0\">
        " . $user_email . "
      </p>
      <p class=\" font-italic font-weight-light p-0 mb-1\">
        " . $user_phone_number . "
      </p>
      <p class=\" p-0 m-0\">" . $area_name . "</p>
      <p class=\" font-italic font-weight-light p-0 mb-1 mx-0 mt-0\">
        " . $service_location . "
      </p>
      <h6 class=\" font-weight-light p-0 m-0\">
        " . $service_title . "
      </h6>";
    if ($a == 0) {
        echo "<p class=\"text-light fw-light\"> <i> No rate available </i></p>";
    } else {
        while ($a > 0) {
            echo "<i class=\"bi bi-star-fill text-gold\"></i>";
            $a--;
        }
    }
    echo "</div></section>";
    $images = "SELECT photo_link FROM service_photos WHERE service_id='" . $sid . "';";
    $res_images = mysqli_query($conn, $images);
    if (mysqli_num_rows($res_images) != 0) {
        echo "<section class=\"gallery mx-1 row\" >
        <div class=\" container-md col-10   p-3\" style=\"background-color:rgb(250,250,250,0.4);\">
            <div class=\"row row-cols-1 row-cols-sm-2 row-cols-md-3\" style=\"filter: blur(0px);-webkit-filter: blur(0px);\">";
        while ($r = mysqli_fetch_array($res_images)) {
            echo "<div class=\"col\"><img src=\"" . $r["photo_link"] . "\" class=\"gallery-item\" /></div>";
        }
        echo "</div></div></section>";
    }
    mysqli_close($conn);
    ?>
    <div class="d-flex justify-content-center align-items-center text-center my-2 p-0 mx-0 ">
        <span class="me-2">
            <a class="text-decoration-none" <?php echo "href=\"search_result.php?service_type=" . $tid . "&area=" . $aid . "\""; ?>>
                <button style="color:rgba(2, 0, 36, 1) ;" class=" btn btn-gold btn-md m-0">
                    Similar Services
                </button>
            </a>
        </span>
        <span class="ms-2">
            <a class="text-decoration-none" <?php echo "href=\"feedback.php?sid=" . $sid . "\""; ?>>
                <button class=" btn btn-gold btn-md m-0" style="color:rgba(2, 0, 36, 1) ;">
                    View Feedbacks
                </button>
            </a>
        </span>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="gallery-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $service_title; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="img/1.jpg" class="modal-img" alt="modal img">
                </div>
            </div>
        </div>
    </div>


    <script src="./to_be_del/img_gallery/img gallery/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("click", function(e) {
            if (e.target.classList.contains("gallery-item")) {
                const src = e.target.getAttribute("src");
                document.querySelector(".modal-img").src = src;
                const myModal = new bootstrap.Modal(document.getElementById('gallery-modal'));
                myModal.show();
            }
        })

        function goBack() {
            history.go(-1);
        }
    </script>
</body>

</html>
</body>

</html>
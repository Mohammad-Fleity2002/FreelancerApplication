<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("location: login.php");
    exit;
}
include("connection.php");
$areas_query = "SELECT * FROM areas;";
$service_type_query = "SELECT * FROM service_types;";
$areas = mysqli_query($conn, $areas_query);
$service_types = mysqli_query($conn, $service_type_query);
$res = null;
if (!empty($_GET["service_type"]) && !empty($_GET["area"])) {
    extract($_GET);
    $query = "SELECT * FROM services WHERE area_code='" . $area . "' and service_code='" . $service_type . "';";
    $areaOfService = "SELECT * FROM areas WHERE code_area='" . $area . "';";
    $areaOfServices = mysqli_query($conn, $areaOfService);
    $rowArea = mysqli_fetch_array($areaOfServices);
    $areaChoosen = $rowArea["area_name"];
    $res = mysqli_query($conn, $query);
} else {
    header("location: search.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.min.css" rel="stylesheet">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <title>Search</title>
</head>
<style>
    .bg_radial_2 {
        background: rgb(22, 13, 25);
        background: linear-gradient(90deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 50%, rgba(225, 135, 255, 1) 100%);
    }

    .text_radial_2 {
        color: rgb(22, 13, 25);
        color: linear-gradient(90deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 50%, rgba(225, 135, 255, 1) 100%);
    }
</style>

<body class="bg_radial_2">
    <!-- <div style="width: max-content; height: max-content; background: rgb(250, 250, 250,0.6);"> -->
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
    <section class="container ">
        <form action="<?php $_SERVER["PHP_SELF"] ?>" method="get">
            <div class="container-md ">
                <div class="row text-center align-item-center justify-content-center">
                    <div class="container-md align-self-center">
                        <div class="row align-item-center justify-content-center mt-2 mb-4">
                            <div class="col-5 align-self-center">
                                <select name="service_type" class="form-select" id="type">
                                    <option value="" <?php if (empty($service_type)) {
                                                            echo "selected";
                                                        } ?>>Select Type</option>
                                    <?php
                                    while ($res_service_type = mysqli_fetch_array($service_types)) {
                                        if ($service_type == $res_service_type["code_type"]) {
                                            $selected = " selected ";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value=\"" . $res_service_type["code_type"] . "\"" . $selected . ">" . $res_service_type["type_title"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-5 align-self-center">
                                <select name="area" class="form-select" id="area">
                                    <option value="" <?php if (empty($area)) {
                                                            echo "selected";
                                                        } ?>>Selecte area</option>
                                    <?php
                                    while ($res_area = mysqli_fetch_array($areas)) {
                                        if ($area == $res_area["code_area"]) {
                                            $selected = " selected ";
                                        } else {
                                            $selected = "";
                                        }
                                        echo "<option value=\"" . $res_area["code_area"] . "\"" . $selected . ">" . $res_area["area_name"] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-1 align-self-center">
                                <a href="#result">
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-gold px-3">search</button>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
        <div class="container-lg ">
            <?php
            if ($res) {
                if (($n = mysqli_num_rows($res)) != 0) {
                    $i = 0;
                    while ($row = mysqli_fetch_array($res)) {
                        $rate = "SELECT AVG(feedback_rate) FROM rates_feedbacks WHERE service_id='" . $row["service_id"] . "';";
                        $provider = "SELECT * FROM users WHERE user_id='" . $row["freelancer_id"] . "';";
                        $freelancer = mysqli_query($conn, $provider);
                        $rfreelancer = mysqli_fetch_array($freelancer);
                        if ($avg = mysqli_query($conn, $rate)) {
                            $ravg = mysqli_fetch_row($avg);
                            $a = $ravg[0];
                            if ($a == null) {
                                $a = 0;
                            }
                        }
                        echo "<a class=\"text-black\" id=\"result\" href=\"service.php?sid=" . $row["service_id"] . "\" style=\"text-decoration: none;\"><div class=\"container-md border border-1 border-purple my-2 py-1 px-2\" style=\"background:rgb(250,250,250,0.6)\">
          <h5 class=\" text-white d-inline-block p-1 m-0\" style=\"background-color:rgba(225, 135, 255, 1) \">" .
                            $rfreelancer["user_name"] . "
          </h5>
          <p class=\" font-italic font-weight-bold p-0 m-0\">" .
                            $rfreelancer["user_email"] . "
          </p>
          <p class=\" font-italic font-weight-light p-0 mb-1\">" .
                            $rfreelancer["user_phone_number"] . "
          </p>
          <p class=\" p-0 m-0\">" . $areaChoosen . "</p>
          <p class=\" font-italic font-weight-light p-0 mb-1 mx-0 mt-0\">" .
                            $row["service_location"] . "
          </p>
          <h6 class=\" font-weight-light p-0 m-0\">" . $row["service_title"] . "</h6>
          <p class=\" font-italic font-weight-light py-1 my-1 justify-content-around\">" .
                            $row["service_title"] . "
          </p>
          ";
                        if ($a == 0) {
                            echo "<p class=\"text-white fw-light p-0 m-0 d-inline-block\"><i> No rate available</i>";
                        } else {
                            echo "<p class=\"text-gold p-0 m-0 d-inline-block\">";
                            while ($a > 0) {
                                echo "<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"16\" height=\"16\" fill=\"currentColor\" class=\"bi bi-star-fill\" viewBox=\"0 0 16 16\">
              <path d=\"M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z\"/>
            </svg>";
                                $a--;
                            }
                        }
                        echo "</p><div class=\"container text-center\">
          <button class=\" text-white btn btn-md m-0\" style=\"background-color:rgba(22, 13, 25, 1) \">
            <a href=\"feedback.php?sid=" . $row["service_id"] . "\" class=\"text-white\" style=\"text-decoration: none;\">
              Feedbacks
            </a>
          </button>
        </div>
      </div>
      </a>";
                    }
                }
            }
            ?>
    </section>
</body>

</html>
<?php
mysqli_close($conn);

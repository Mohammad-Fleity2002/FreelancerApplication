<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="./css/main.min.css" rel="stylesheet">
  <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
  <title>My Services</title>
</head>

<body>
  <nav class="navbar navbar-expand-md py-1 navbar-light border border-2 border-purple">
    <div class="container-md py-1">
      <a href="#intro" class="navbar-brand">
        <span class="fw-bold text-purple">Freelancer</span>
      </a>
      <button class="navbar-toggler bg-purple text-white" type="button" data-bs-toggle="collapse" data-bs-target="#main-nav" aria-controls="main-nav" aria-expanded="false" aria-label="toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end align-items-end" id="main-nav">
        <ul class="navbar-nav">
          <li class="nav-item">
          <a href="profile.php" class="nav-link"><?php echo $_SESSION['name'] ?></a>
          </li>
          <li class="nav-item">
            <a href="search.php" class="nav-link">search</a>
          </li>
          <li class="nav-item">
            <a href="logout.php" class="nav-link">log out</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container-sm my-2 p-1">
    <div class="row">
      <!-- <div class="col-11"></div> -->
      <div class="text-center"><a href="add_service.php">
          <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" fill="#A0AEF9" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
          </svg></a></div>
    </div>

    <?php include "connection.php";
    $query = "SELECT * FROM services WHERE freelancer_id='" . $_SESSION['id'] . "';";
    $res = mysqli_query($conn, $query);

    if ($res) {
      $i = 0;
      while ($row = mysqli_fetch_array($res)) {
        $rate = "SELECT AVG(feedback_rate) FROM rates_feedbacks WHERE service_id='" . $row["service_id"] . "';";
        $loc = "SELECT * FROM areas WHERE code_area='" . $row["area_code"] . "';";
        $result = mysqli_query($conn, $loc);
        $areaChoosen = mysqli_fetch_array($result);
        $qry = "SELECT * FROM users WHERE user_id=" . $_SESSION['id'] . ";";
        $resultat = mysqli_query($conn, $qry);
        $array = mysqli_fetch_array($resultat);
        if ($avg = mysqli_query($conn, $rate)) {
          $ravg = mysqli_fetch_row($avg);
          $a = $ravg[0];
          if ($a == null) {
            $a = 0;
          }
        }
        echo "<div class=\"container-md border border-1 border-purple my-2 py-1 px-2\">
            <h5 class=\"bg-purple text-white d-inline-block p-1 m-0\">" .
          $array["user_name"] . "
            </h5>
            <p class=\"text-purple font-italic font-weight-bold p-0 m-0\">" .
          $array["user_email"] . "
            </p>
            <p class=\"text-purple font-italic font-weight-light p-0 mb-1\">" .
          $array["user_phone_number"] . "
            </p>
            <p class=\"text-black p-0 m-0\">" . $areaChoosen["area_name"] . "</p>
            <p class=\"text-purple font-italic font-weight-light p-0 mb-1 mx-0 mt-0\">" .
          $row["service_location"] . "
            </p>
            <h6 class=\"text-black font-weight-light p-0 m-0\">" . $row["service_title"] . "</h6>
            <p class=\"text-black font-italic font-weight-light py-1 my-1 justify-content-around\">" .
          $row["service_title"] . "
            </p>
            <p class=\"text-black p-0 m-0 d-inline-block\">
            ";
        if ($a == 0) {
          echo "<p class=\"text-secondary\"> No rate available</p>";
        } else {
          while ($a > 0) {
            echo "<i class=\"bi bi-star-fill text-gold\"></i>";
            $a--;
          }
        }
        echo "</div>  ";
      }
    } else {
      echo "<font color='red'>No services added yet</b></font><br/>";
    }
    mysqli_close($conn);
    ?>
  </div>
</body>

</html>
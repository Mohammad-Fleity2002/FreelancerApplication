<?php
session_start();
if (!isset($_SESSION['id'])) {
  header("location: login.php");
}
include("connection.php");
$areas_query = "SELECT * FROM areas;";
$service_type_query = "SELECT * FROM service_types;";
$areas = mysqli_query($conn, $areas_query);
$service_types = mysqli_query($conn, $service_type_query);
$res = null;
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
    <form action="./search_result.php" method="get">
      <div class="container-md ">
        <div class="row text-center vh-100  align-item-center justify-content-center">
          <div class="container-md align-self-center">
            <div class="row align-item-center justify-content-center mb-2 pb-5">
              <div class="col-10 text-white m-0 p-0 text-align-center">
                <p class="h4 p-0 m-0">Welcome to <span class="h2 m-0 p-0 text_radial_2"><b>Freelancer</b></span></p>
                <p class="p-0 m-0">Lorem ipsum dolor sit amet consectetur adipisicing elit. Culpa officiis aliquam quod nemo architecto sint magni nulla! Quas debitis cupiditate maxime at deserunt dolore nemo asperiores? Doloribus voluptatibus facere rem.</p>
              </div>
            </div>
            <div class="row align-item-center justify-content-center mt-2 mb-4">
              <div class="col-5 align-self-center">
                <select name="service_type" class="form-select" id="type">
                  <option value="" selected>Select Type</option>
                  <?php
                  while ($service_type = mysqli_fetch_array($service_types)) {
                    echo "<option value=\"" . $service_type["code_type"] . "\">" . $service_type["type_title"] . "</option>";
                  }
                  ?>
                </select>
              </div>
              <div class="col-5 align-self-center">
                <select name="area" class="form-select" id="area">
                  <option value="" selected>Select area</option>
                  <?php
                  while ($area = mysqli_fetch_array($areas)) {
                    echo "<option value=\"" . $area["code_area"] . "\">" . $area["area_name"] . "</option>";
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
  </section>
</body>

</html>
<?php
mysqli_close($conn);

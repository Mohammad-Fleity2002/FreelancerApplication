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
  $uid = $_SESSION['id'];
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <title>Feedbacks</title>
  <style>
    .bg_radial_2 {
      background: rgb(22, 13, 25);
      background: linear-gradient(90deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 50%, rgba(225, 135, 255, 1) 100%);
    }

    .bg_radial_2_op {
      background: rgb(22, 13, 25);
      background: linear-gradient(270deg, rgba(22, 13, 25, 1) 0%, rgba(135, 81, 153, 1) 50%, rgba(225, 135, 255, 1) 100%);
    }
  </style>
</head>

<body>
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

  <section class="bg_radial_2_op vh-100 pt-4">
    <div class="container-sm p-2">
      <form class="container-md border border-2 border-gold pt-1" method="post" action="add_feedback_authentication.php">
        <input type="text" class="d-none" name="sid" value="<?php echo $sid; ?>" />
        <table>
          <tr>
            <th>
              <label for="rate" class="form-label">Rate:</label>
            </th>
            <td class="container-sm">
              <div class="m-0 input-group">
                <input type="number" max="5" min="0" maxlength="1" minlength="1" name="rate" id="rate" class="m-0 form-control" placeholder="rate" />
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="form-floating mb-4" style="background-color: rgba(255,255,255,0.4);">
                <textarea class="form-control" id="feedback_description" name="feedback_description" style="height: 140px"></textarea>
                <label for="feedback_description" class="form-label">Feedback Description:</label>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="2">
              <div class="form-floating mb-4">
                <?php
                if (isset($_GET['Err'])) {
                  echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
                }
                ?>
              </div>
            </td>
          </tr>
        </table>
        <div class="mb-4 text-center">
          <span><a href="<?php echo "feedback.php?sid=" . $sid . ""; ?>" class="text-decoration-none">
              <p class="btn btn-gold my-0">back</p>
            </a></span>
          <span class="ms-2"><button type="submit" class="btn btn-gold">Add Feedback</button></span>
        </div>
      </form>
    </div>
  </section>

</body>

</html>
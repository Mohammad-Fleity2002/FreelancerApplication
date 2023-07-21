<?php
session_start();
if (!isset($_SESSION["id"])) {
  header("location: login.php");
  exit;
}
include("connection.php");
$areas_query = "SELECT * FROM areas;";
$service_type_query = "SELECT * FROM service_types;";
$areas = mysqli_query($conn, $areas_query);
$service_types = mysqli_query($conn, $service_type_query);
// $code_area = 1;
// $service_type = 1;
$res = null;
if (
  isset(($_POST["service_title"])) &&
  isset(($_POST["service_description"])) &&
  isset(($_POST["service_location"])) &&
  isset(($_POST["type"])) &&
  isset(($_POST["service_area"]))
) {
  if (
    !empty($_POST["service_title"]) &&
    !empty($_POST["service_description"]) &&
    !empty($_POST["service_location"]) &&
    !empty($_POST["service_area"]) &&
    !empty($_POST["type"])
  ) {
    extract($_POST);
    $unique = "SELECT * FROM services WHERE freelancer_id='" . $_SESSION['id'] . "' AND service_title='" . $service_title . "';";
    $res_unique = mysqli_query($conn, $unique);
    if (mysqli_num_rows($res_unique) == 0) {
      $today = date("Y-m-d");
      // $service_description = "description";
      $freelancer_id = $_SESSION['id'];
      // $service_title = "title";
      // $service_area = "1";
      // $service_location = "link location";
      // $type = "1";
      $query = "INSERT INTO services
  ( service_title, service_description, service_location, area_code, service_code, freelancer_id, service_add_date)
  VALUES 
  ( '$service_title', '$service_description', '$service_location', '$service_area', '$type','$freelancer_id', '$today')";
      $result = mysqli_query($conn, $query);
      if ($result) {
        if ($_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
          $get_id = "SELECT service_id FROM services WHERE service_title='" . $service_title . "' and freelancer_id='" . $_SESSION['id'] . "';";
          $res_get_id = mysqli_query($conn, $get_id);
          if (mysqli_num_rows($res_get_id) != 0) {
            $r = mysqli_fetch_array($res_get_id);
            $service_id = $r['service_id'];
            $folder = "./image/" . $_SESSION['id'];
            $filename = $_FILES["uploadfile"]["name"];
            $tempname = $_FILES["uploadfile"]["tmp_name"];
            print_r($_FILES);
            if (!is_dir($folder)) {
              mkdir($folder, 0755);
            }
            $folder .= "/" . $service_id;
            if (!is_dir($folder)) {
              mkdir($folder, 0755);
            }
            $filename = $folder . "/" . uniqid("photo_", true) . "_" . $_FILES["photo"]["name"];
            /*
    $sourceFile = $_FILES["photo"]["tmp_name"]; // Temporary location of the uploaded file
    $destinationDir = "uploads/"; // Change this to your desired destination directory

    // Check if the upload was successful
    if ($_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
        // Create the destination directory if it doesn't exist
        if (!is_dir($destinationDir)) {
            mkdir($destinationDir, 0755, true);
        }

        // Generate a unique filename to avoid overwriting existing files
        $destinationFile = $destinationDir . uniqid("photo_", true) . "_" . $_FILES["photo"]["name"];

        // Move the uploaded file to the destination directory
        if (move_uploaded_file($sourceFile, $destinationFile)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error moving file.";
        }
    } else {
        echo "Error uploading file.";
    }
*/
            $sql = "INSERT INTO service_photos (photo_link,service_id) VALUES ('$filename','$service_id')";
            mysqli_query($conn, $sql);
            $upluoded = move_uploaded_file($tempname, $filename);
            mysqli_close($conn);
            if ($upluoded) {
              header("location: search.php");
              exit;
            } else {
              header("location: add_service.php?Err=" . urlencode("server error uploading photo"));
              exit;
            }
          }
        } else {
          header("location: add_service.php?Err=" . urlencode("client error uploading photo"));
          exit;
        }
      } else {
        $err = urlencode(mysqli_error($conn));
        header("location:add_service.php?Err=$err");
        exit;
      }
    } else {
      header("location: add_service.php?Err=" . urlencode("service title already used"));
      exit;
    }
  } else {
    header("location: add_service.php?Err=" . urlencode("All fields Are required"));
    exit;
  }
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
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
  <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
  <title>Add Service</title>
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
    <form enctype="multipart/form-data" class="container-md border p-3 my-3 border-1 border-purple " method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
      <table>
        <tr>
          <th><label for="area" class="form-label">area</label></th>
          <td class="container-sm">
            <select name="service_area" class="form-select" id="area">
              <?php
              while ($area = mysqli_fetch_array($areas)) {
                echo "<option value=\"" . $area["code_area"] . "\">" . $area["area_name"] . "</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <th><label for="type" class="form-label">Type</label></th>
          <td class="container-sm">
            <select name="type" class="form-select" id="type">
              <?php
              while ($service_type = mysqli_fetch_array($service_types)) {
                echo "<option value=\"" . $service_type["code_type"] . "\">" . $service_type["type_title"] . "</option>";
              }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <th>
            <label for="service_title" class="form-label">Title:</label>
          </th>
          <td class="container-sm">
            <div class="m-0 input-group">
              <input type="text" name="service_title" id="service_title" class="m-0 form-control" placeholder="   " />
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="mb-4 input-group container-sm">
              <span class="input-group-text">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                  <path d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A31.493 31.493 0 0 1 8 14.58a31.481 31.481 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94zM8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10z" />
                  <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6z" />
                </svg>
              </span>
              <input type="text" id="service_location" name="service_location" class="form-control" placeholder="e.g.: coogle/maps/link/location" />
            </div>
          </td>
        </tr>
        <tr>
          <td colspan="2">
            <div class="form-floating mb-4">
              <textarea class="form-control" id="service_description" name="service_description" style="height: 140px"></textarea>
              <label for="service_description" class="form-label">Service Description:</label>
            </div>
          </td>
        </tr>
        <tr>
          <td>
            <input class="form-control" type="file" name="uploadfile" value="" />
          </td>
        </tr>
      </table>
      <div class="mb-4 text-center">
        <button type="submit" class="btn btn-purple">Submit</button>
      </div>
      <?php
      if (isset($_GET['Err'])) {
        echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
      }
      ?>
    </form>
  </div>
</body>

</html>
<?php
mysqli_close($conn);

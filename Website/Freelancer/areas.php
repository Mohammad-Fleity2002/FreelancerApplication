<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
include("connection.php");
// $country_query = "SELECT * FROM countries;";
// $res_country = mysqli_query($conn, $country_query);
// while ($role = mysqli_fetch_row($res_country)) {
//     $country_array[$role[0]] = $role[1];
// }
$area_query = "SELECT * FROM areas;";
$res_area = mysqli_query($conn, $area_query);
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <title>Areas</title>
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
                        <a href="users.php" class="nav-link">Users</a>
                    </li>
                    <li class="nav-item">
                        <a href="areas.php" class="nav-link">Areas</a>
                    </li>
                    <li class="nav-item">
                        <a href="services.php" class="nav-link">Service Types</a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link">log out</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container-sm border border-1 border-black text-center ">
        <table border="2" class="container-sm">
            <tr>
                <th>
                    code_area
                </th>
                <th>
                    area_name
                </th>
            </tr>
            <?php
            if ($res_area) {
                $i = 0;
                while ($row = mysqli_fetch_array($res_area)) {
                    if ($i % 2 == 0) {
                        echo "<tr class=\"bg-secondary text-white\">";
                    } else {
                        echo "<tr>";
                    }
                    $i++;
                    echo "<td>" . $row["code_area"] . "</td>";
                    echo "<td>" . $row["area_name"] . "</td>";
                    // foreach ($country_array as $id => $value) {
                    //     if ($id == $row["code_country"]) {
                    //         echo "<td>" . $value . "</td>";
                    //         break;
                    //     }
                    // }
                }
            }
            ?>
        </table>
        <div class="container">
            <button class="bg-primary text-white btn btn-sm my-5">
                <a href="add_area.php" class="text-white" style="text-decoration: none;">
                    Add Area
                </a>
            </button>
        </div>
        <?php
        if (isset($_GET['Err'])) {
            echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
        }
        ?>

    </div>
</body>

</html>
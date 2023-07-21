<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
include("connection.php");
$type_query = "SELECT * FROM service_types;";
$res_type = mysqli_query($conn, $type_query);
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
    <title>Service Types</title>
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
    <div class="container-sm border border-2 border-black text-center p-1 my-2">
        <table border="2" class="container-sm">
            <tr>
                <th>
                    code_type
                </th>
                <th>
                    type_title
                </th>
            </tr>
            <?php
            if ($res_type) {
                $i = 0;
                while ($row = mysqli_fetch_array($res_type)) {
                    if ($i % 2 == 0) {
                        echo "<tr class=\"bg-secondary text-white\">";
                    } else {
                        echo "<tr>";
                    }
                    $i++;
                    echo "<td>" . $row["code_type"] . "</td>";
                    echo "<td>" . $row["type_title"] . "</td>";
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
                <a href="add_service_type.php" class="text-white" style="text-decoration: none;">
                    Add Service Type
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
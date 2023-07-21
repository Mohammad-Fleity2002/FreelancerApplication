<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
if (!empty($_POST["area_name"])) {
    include("connection.php");
    $area_name = htmlspecialchars($_POST["area_name"]);
    // INSERT INTO areas ( area_name, country_code) VALUES ( ".$area_name.", '1');
    $query_insert_area = "INSERT INTO areas ( area_name, country_code) VALUES ( '$area_name', '1');";
    $res_insert_area = mysqli_query($conn, $query_insert_area);
    mysqli_close($conn);
    if ($res_insert_area) {
        header("location: areas.php");
        exit;
    }
    header("location: areas.php?Err" . urlencode(mysqli_error($conn)));
    exit;
} ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <title>Add Area</title>
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
    <form action="<?php $_SERVER["PHP_SELF"] ?>" method="post" class="p-2 my-2 text-center container-sm border border-1 border-purple">
        <fieldset>
            <div class="input-group my-3">
                <input type="text" class="form-control" placeholder="area name" id="area_name" required name="area_name">
            </div>
            <input type="submit" value="add area" class="btn btn-purple">
        </fieldset>
    </form>
    <?php
    if (isset($_GET['Err'])) {
        echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
    }
    ?>

</body>

</html>
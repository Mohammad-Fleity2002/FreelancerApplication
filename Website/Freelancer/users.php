<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
    exit;
}
include("connection.php");
$role_query = "SELECT * FROM user_roles ;";
$res_role = mysqli_query($conn, $role_query);
while ($role = mysqli_fetch_row($res_role)) {
    $role_array[$role[0]] = $role[1];
}

$gender_query = "SELECT * FROM genders;";
$res_gender = mysqli_query($conn, $gender_query);
while ($gender = mysqli_fetch_row($res_gender)) {
    $gender_array[$gender[0]] = $gender[1];
}

$area_query = "SELECT * FROM areas;";
$res_area = mysqli_query($conn, $area_query);
while ($area = mysqli_fetch_row($res_area)) {
    $area_array[$area[0]] = $area[1];
}

$admin_query = "SELECT * FROM users WHERE user_delete_date IS NULL";
$res_admin = mysqli_query($conn, $admin_query);
mysqli_close($conn);
if (!$res_admin) {
    echo mysqli_error($conn);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/main.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <title>Users</title>
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
    <div class="container-md border border-1 border-black">
        <table border="2">
            <tr>
                <th>
                    user_name
                </th>
                <th>
                    user_email
                </th>
                <th>
                    user_birthdate
                </th>
                <th>
                    user_join_date
                </th>
                <th>
                    user_phone_number
                </th>
                <th>
                    user_delete_date
                </th>
                <th>
                    user_gender
                </th>
                <th>
                    user_area
                </th>
                <th>
                    user_role
                </th>
            </tr>
            <?php
            if ($res_admin) {
                $i = 0;
                while ($row = mysqli_fetch_array($res_admin)) {
                    if ($i % 2 == 0) {
                        echo "<tr class=\"bg-secondary text-white\">";
                    } else {
                        echo "<tr>";
                    }
                    $i++;
                    echo "<td>" . $row["user_name"] . "</td>";
                    echo "<td>" . $row["user_email"] . "</td>";
                    echo "<td>" . $row["user_birthdate"] . "</td>";
                    echo "<td>" . $row["user_join_date"] . "</td>";
                    echo "<td>" . $row["user_phone_number"] . "</td>";
                    echo "<td>" . $row["user_delete_date"] . "</td>";
                    foreach ($gender_array as $id => $value) {
                        if ($id == $row["code_gender"]) {
                            echo "<td>" . $value . "</td>";
                            break;
                        }
                    }
                    foreach ($area_array as $id => $value) {
                        if ($id == $row["code_area"]) {
                            echo "<td>" . $value . "</td>";
                            break;
                        }
                    }
                    foreach ($role_array as $id => $value) {
                        if ($id == $row["code_role"]) {
                            echo "<td>" . $value . "</td>";
                            break;
                        }
                    }
                    echo "<td class=\"bg-white\"><a class=\"text-danger\" href=\"delete_user.php?uid=" . $row["user_id"] . "\">delete</a> </td>";
                }
            }
            ?>
        </table>
        <div class="container text-center">
            <button class="bg-primary text-white btn btn-lg my-5">
                <a href="add_admin.php" class="text-white" style="text-decoration: none;">
                    Add Admin
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
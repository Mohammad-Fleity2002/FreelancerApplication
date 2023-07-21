<?php
session_start();
if (!isset($_SESSION["id"])) {
    header("location: login.php");
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <title>Add Admin</title>
</head>

<body class="bg-purple">
    <nav class="navbar bg-white navbar-expand-md py-1 navbar-light border border-2 border-purple">
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

    <div class="container my-5 col-lg-6">
        <div class="text-center"><svg xmlns="http://www.w3.org/2000/svg" width="5em" height="5em" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
            </svg></i></div>
        <form action="add_admin_authentication.php" method="post">
            <fieldset>
                <div class="input-group my-3">
                    <input type="text" class="form-control" placeholder="Full Name" id="fname" required name="name">
                </div>

                <div class="input-group my-3">
                    <input type="email" class="form-control" placeholder="Email" id="email" required name="email">
                </div>

                <div class="input-group my-3">
                    <select name="code_gender" id="gender" class="form-select" required>
                        <?php
                        include "connection.php";
                        $quer = "SELECT * FROM genders";
                        $res = mysqli_query($conn, $quer);
                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $c = $row["code_gender"];
                                $r = $row["gender_description"];
                                echo "<option value=" . $c . ">$r</option>";
                            }
                        }
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="input-group my-3">
                    <input type="tel" class="form-control" name="phone_number" id="tel" placeholder="+961-xx/xxxxxxx">
                </div>
                <div class="input-group my-3">
                    <select name="code_role" id="role" class="form-select" required>
                        <?php
                        include "connection.php";
                        $quer = "SELECT * FROM user_roles";
                        $res = mysqli_query($conn, $quer);
                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $c = $row["code_role"];
                                $r = $row["role_title"];
                                echo "<option value=" . $c . ">$r</option>";
                            }
                        }
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="input-group my-3">
                    <select name="code_area" id="location" class="form-select" required>
                        <?php
                        include "connection.php";
                        $quer = "SELECT * FROM areas";
                        $res = mysqli_query($conn, $quer);
                        if ($res) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $c = $row["code_area"];
                                $r = $row["area_name"];
                                echo "<option value=" . $c . ">$r</option>";
                            }
                        }
                        mysqli_close($conn);
                        ?>
                    </select>
                </div>
                <div class="input-group my-3">
                    <input type="date" name="birthdate" id="birthdate" class="form-control">
                </div>

                <div class="input-group my-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" placeholder="password" id="Pass" required name="password">

                </div>
                <div class="input-group my-3">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" placeholder="Confirm Password" id="ConfPass" required name="confirm_pass">

                </div>
                <?php
                if (isset($_GET['Err'])) {
                    echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
                }
                ?>
                <div class="row my-5">
                    <div class="col-9 "><button type="submit" class="btn btn-light"> <b>Sign Up</b></button></div>
                </div>
            </fieldset>
        </form>
        <?php
        if (isset($_GET['Err'])) {
            echo "<font color='red'><b>Please retry: " . $_GET['Err'] . "</b></font><br/>";
        }
        ?>

    </div>
</body>

</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./css/main.min.css" rel="stylesheet">
    <script src="./bootstrap_5_1_3/js/bootstrap.js"></script>
    <title>Reset Password</title>
</head>

<body class="d-flex flex-column h-100">
    <div class="container my-5 col-lg-6">
        <form action="Resest.php" method="post">
            <fieldset>
                <div>
                    <h1 class="col-1">Reset Password</h1>
                </div>
                <div class="input-group my-3">
                    <input type="email" class="form-control" placeholder="Email" id="email" required name="Email">
                </div>
                <div class="row my-5">
                    <div class="col-9 "><button type="submit" class="btn btn-purple"> <b>send code</b></button></div>
                    <div class="col-3"><a href="login.php"> login</a></div>
                </div>
            </fieldset>
        </form>
    </div>
</body>

</html>
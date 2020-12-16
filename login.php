<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<?php include 'menu.php';
$errorCode = $_REQUEST['failed'] ?? 0;
?>
<main class="h-100">
    <div class="d-flex h-100">
        <div class="row m-auto w-75">
            <div class="offset-lg-7 offset-md-5 col-md-7 col-lg-5 border-left">
                <div class="p-4">
                    <h2 class="lead" style="font-size: 2rem">Login</h2>
                    <form class="mt-4" action="service/login.php" enctype="multipart/form-data" method="post">
                        <label class="form-label" for="username_input">Email</label>
                        <input type="email" name="username" id="username_input"
                               class="form-control" value="<?php echo $_COOKIE['email'] ?? '' ?>" required>
                        <label class="form-label mt-2" for="password_input">Password</label>
                        <input type="password" name="password" id="password_input"
                               class="form-control <?php echo $errorCode != 0 ? 'is-invalid' : '' ?>"
                               required>
                        <?php
                        // If the server returns the error code for wrong password, display message.
                        if ( $errorCode == 1) {
                            echo '<p class="text-danger mt-2 mb-0">' .
                                '<small>Invalid Username/Password. Please try Again.</small></p>';
                        }

                        if ( $errorCode == 2) {
                            echo '<p class="text-danger mt-2 mb-0">' .
                                '<small>User Account has been disabled. Please contact YMCA Staff.</small></p>';
                        }
                        // If the server returns the error code for reauth, display message.
                        if ($_REQUEST['reauth'] ?? 0 == '1') {
                            echo '<p class="text-danger mt-2 mb-0">' .
                                '<small>Please sign in before continuing.</small></p>';
                        }
                        ?>

                        <div class="d-flex mt-3">
                            <button class="btn btn-primary">Login</button>
                            <small class="my-auto ml-3">New? <a href="register.php">Register</a> now!</small>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
<html lang="en">
<?php include 'menu.php'; ?>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
</head>
<body>
<main class="h-100 bg-light">
    <div class="d-flex h-100">
        <div class="m-auto w-75">
            <div class="row">
                <div class="offset-lg-3 col-lg-6">
                    <div class="border rounded bg-white shadow">
                        <div class="p-4">
                            <h2 class="lead" style="font-size:2rem">Register</h2>
                            <hr>
                            <div class="alert alert-danger alert-dismissible fade
                                <?php echo $_REQUEST['reason'] ? 'show' : 'd-none' ?> mt-2"
                                 role="alert">
                                <p class="mb-2"><em>Whoops</em>, that wasn't supposed to happen!</p>
                                <small>Error Code:
                                    <strong>
                                        <?php echo $_REQUEST['reason'] ? base64_encode($_REQUEST['reason']) : 'N/A' ?>
                                    </strong>
                                </small>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form class="mt-4" action="service/register.php" enctype="multipart/form-data" method="post">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label class="form-label" for="firstNameInput">First Name</label>
                                        <input type="text" name="firstName" id="firstNameInput" maxlength="20"
                                               class="form-control"
                                               value="<?php echo $_COOKIE['firstName'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="form-label" for="lastNameInput">Last Name</label>
                                        <input type="text" name="lastName" id="lastNameInput" class="form-control"
                                               value="<?php echo $_COOKIE['lastName'] ?? '' ?>" required>
                                    </div>
                                </div>
                                <div class="form-group is-invalid">
                                    <label class="form-label" for="username_input">Email</label>
                                    <input type="email" name="username" id="username_input" required
                                           value="<?php echo $_COOKIE['email'] ?? '' ?>"
                                           class="form-control
                                           <?php echo $_REQUEST['failed'] == 1 ? 'is-invalid' : '' ?>">
                                    <small class="invalid-feedback">This email is taken.</small>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password_input">Password</label>
                                    <input type="password" name="password" id="password_input" required
                                           class="form-control">
                                </div>
                                <button type="submit" class="btn btn-outline-primary mt-2">Register</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
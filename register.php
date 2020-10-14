<html lang="en">
<head>
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
                            <form class="mt-4">
                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label class="form-label" for="firstNameInput">First Name</label>
                                        <input type="text" name="firstName" id="firstNameInput" maxlength="20" class="form-control"
                                               required>
                                    </div>
                                    <div class="col-6 form-group">
                                        <label class="form-label" for="lastNameInput">Last Name</label>
                                        <input type="text" name="lastName" id="lastNameInput" class="form-control"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="username_input">Email</label>
                                    <input type="email" name="username" id="username_input" required
                                           class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password_input">Password</label>
                                    <input type="password" name="password" id="password_input" required
                                           class="form-control">
                                </div>
                                <button class="btn btn-outline-primary mt-2">Register</button>
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
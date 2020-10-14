<html lang="en">
<head>
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
          integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>
<main class="h-100">
    <div class="d-flex h-100">
        <div class="row m-auto w-75">
            <div class="col-lg-7">

            </div>
            <div class="offset-lg-7 offset-md-5 col-md-7 col-lg-5 border-left">
                <div class="p-4">
                    <h2 class="lead" style="font-size: 2rem">Login</h2>
                    <form class="mt-4">
                        <label class="form-label" for="username_input">Email</label>
                        <input type="email" autocomplete="username" name="username" id="username_input"
                               class="form-control" required>
                        <label class="form-label mt-2" for="password_input">Password</label>
                        <input type="password" autocomplete="password" name="password" id="password_input"
                               class="form-control" required>
                        <button class="btn btn-primary mt-3">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>
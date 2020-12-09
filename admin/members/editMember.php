<?php

require_once 'admin/authorize.php'; ?>
<html lang="en">
<head>
    <title>Modify Member Details</title>
    <style>
        .form-check-input.is-valid ~ .form-check-label, .was-validated .form-check-input:valid ~ .form-check-label {
            color: black !important;
        }
    </style>
</head>
<body>
<?php
include 'menu.php';
include_once 'models/User.php';

if (isset($_REQUEST['m'])) {
    $user = User::get((int)$_REQUEST['m']);
}
?>
<main>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
                <form action="/service/api.php?action=editMember" class="mt-2 needs-validation" method="post"
                      novalidate>
                    <label class="sr-only"><input type="number" value="<?php echo $_REQUEST['m'] ?>" name="id"
                                                  hidden></label>
                    <br>
                    <h2 class="font-weight-light mt-2">Modify Member Details</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first">First Name</label>
                                <input class="form-control" name="first" id="first" minlength="0"
                                       value="<?php echo $user->firstName ?>" required>
                                <div class="invalid-feedback">Don't forget a first name!</div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last">First Name</label>
                                <input class="form-control" name="last" id="last" minlength="0"
                                       value="<?php echo $user->lastName ?>" required>
                                <div class="invalid-feedback">Don't forget a last name!</div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" name="email" id="email"
                                       value="<?php echo $user->email ?>" required>
                                <div class="invalid-feedback">What's their email?</div>
                                <div class="valid-feedback">Nice email!</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="status">Membership</label>
                                <select class="custom-select" id="status" name="status">
                                    <option value="<?php echo MembershipStatus::NONMEMBER ?>"
                                        <?php if ($user->status == MembershipStatus::NONMEMBER) echo 'selected' ?>>
                                        Non Member
                                    </option>
                                    <option value="<?php echo MembershipStatus::MEMBER ?>"
                                        <?php if ($user->status == MembershipStatus::MEMBER) echo 'selected' ?>>
                                        Member
                                    </option>
                                    <option value="<?php echo MembershipStatus::STAFF ?>"
                                        <?php if ($user->status == MembershipStatus::STAFF) echo 'selected' ?> disabled>
                                        Staff
                                    </option>
                                </select>
                                <div class="invalid-feedback">What is their membership?</div>
                                <div class="valid-feedback">Perfect!</div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    <a class="btn btn-outline-secondary" type="button" href="/admin/members/">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</main>
<script>
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    let form = document.getElementsByClassName('needs-validation')[0];
    // Loop over them and prevent submission
    form.addEventListener('submit', function (event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
</script>
</body>
</html>
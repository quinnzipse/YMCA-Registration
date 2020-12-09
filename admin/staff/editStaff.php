<?php

require_once 'admin/authorize.php'; ?>
<html lang="en">
<head>
    <title>Edit Staff Details</title>
    <style>
        .form-check-input.is-valid ~ .form-check-label, .was-validated .form-check-input:valid ~ .form-check-label {
            color: black !important;
        }
    </style>
</head>
<body>
<?php
include 'menu.php';
include_once 'models/Staff.php';

if (isset($_REQUEST['s'])) {
    $staff = Staff::get((int)$_REQUEST['s']);
}
?>
<main>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
                <form action="/service/api.php?action=editStaff" class="mt-2 needs-validation" method="post"
                      novalidate>
                    <br>
                    <h3 class="mt-2">Edit a Staff Member</h3>
                    <hr>
                    <label for="id" class="sr-only">id
                        <input id="id" name="id" value="<?php echo $staff->id ?>" hidden readonly>
                    </label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" id="name"
                                       value="<?php echo "$staff->firstName $staff->lastName" ?>" maxlength="50"
                                       minlength="3" readonly/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ssn">SSN</label>
                                <input class="form-control" name="ssn" id="ssn" type="password" maxlength="9"
                                       value="<?php echo $staff->ssn; ?>" minlength="9" required autocomplete="off"/>
                                <div class="invalid-feedback">
                                    SSN is Required!
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <label for="middle">Middle Initial</label>
                                <input class="form-control" name="middle" type="text" id="middle" maxlength="1"
                                       minlength="1" required value="<?php echo $staff->middleInit; ?>">
                                <div class="invalid-feedback">Middle Initial?</div>
                                <div class="valid-feedback">Perfect!</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone">Phone Number</label>
                                <input class="form-control" name="phone" type="tel" id="phone" maxlength="10"
                                       minlength="10" value="<?php echo $staff->phoneNumber; ?>" required/>
                                <div class="invalid-feedback">What's the phone number?</div>
                                <div class="valid-feedback">Perfect!</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob">DOB</label>
                                <input class="form-control" name="dob" id="dob" type="date" required
                                       value="<?php echo $staff->dob->format('Y-m-d'); ?>">
                                <div class="invalid-feedback">
                                    Invalid Date of Birth.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input class="form-control" name="start_date" id="start_date" type="date"
                                       required value="<?php echo $staff->startDay->format('Y-m-d'); ?>">
                                <div class="invalid-feedback">
                                    Invalid Start Date.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="salary">Salary</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input class="form-control" name="salary" id="salary" type="number" required
                                           value="<?php echo $staff->salary; ?>">
                                    <div class="invalid-feedback">
                                        What are we paying them?
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input class="form-control" name="address" id="address" type="text" required
                                       value="<?php echo $staff->address; ?>"/>
                                <div class="invalid-feedback">
                                    Invalid Address.
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Make Changes</button>
                    <a class="btn btn-outline-secondary" type="button" href="/admin/staff/">Cancel</a>
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
        } else {
            $("input").prop('disabled', false);
        }
        form.classList.add('was-validated');
    }, false);

</script>
</body>
</html>
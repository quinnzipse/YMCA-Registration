<?php require_once 'admin/authorize.php';
require_once 'models/User.php' ?>
<html lang="en">
<head>
    <title>Add a Staff Member</title>
    <style>
        .form-check-input.is-valid ~ .form-check-label, .was-validated .form-check-input:valid ~ .form-check-label {
            color: black !important;
        }

        .clickable:hover {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
            transition: box-shadow 180ms ease-in-out;
            cursor: pointer;
        }
    </style>
</head>
<body>
<?php include 'menu.php';
$users = User::getNonStaff();
?>
<main>
    <div class="container mb-5">
        <div class="row">
            <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-3 mt-5"
                 id="selector">
                <h3>Select User to become Staff</h3>
                <hr>
                <?php
                foreach ($users as $user) {
                    if($user->isInactive) continue;
                    echo '<div class="card my-3 clickable" onclick="select(' . $user->id . ')">
                    <div class="card-body">
                        <div class="card-text">
                            <h4>' . $user->firstName . ' ' . $user->lastName . '</h4>
                            <small class="my-3">' . $user->email . '</small>
                        </div>
                    </div>
                </div>';
                }
                ?>
                <hr>
                <button class="btn btn-secondary" onclick="window.location = '/admin/staff'; ">Cancel</button>
            </div>
            <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2 d-none" id="form-col">
                <form action="/service/api.php?action=addStaff" class="mt-2 needs-validation" method="post"
                      novalidate>
                    <br>
                    <h3 class="mt-2">Add a Staff Member</h3>
                    <hr>
                    <label for="id" class="sr-only">id
                        <input class="form-control" id="id" name="id" hidden readonly></label>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input class="form-control" id="name" maxlength="50" minlength="3" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="ssn">SSN</label>
                                <input class="form-control" name="ssn" id="ssn" type="password" maxlength="9"
                                       minlength="9" required>
                                <div class="invalid-feedback">
                                    SSN is Required!
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-xl-2">
                            <div class="form-group">
                                <label for="middle">Middle Initial</label>
                                <input class="form-control" name="middle" type="text" id="middle" maxlength="1"
                                       minlength="1" required>
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
                                       minlength="10" required>
                                <div class="invalid-feedback">What's the phone number?</div>
                                <div class="valid-feedback">Perfect!</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="dob">DOB</label>
                                <input class="form-control" name="dob" id="dob" type="date" required>
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
                                <input class="form-control" name="start_date" id="start_date" type="date" required>
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
                                    <input class="form-control" name="salary" id="salary" type="number" required>
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
                                <input class="form-control" name="address" id="address" type="text" required>
                                <div class="invalid-feedback">
                                    Invalid Address.
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Add Staff!</button>
                    <button class="btn btn-outline-secondary" type="button" onclick="goBack()">Back</button>
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
        if (form.checkValidity() === false || !checked) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);


    async function select(id) {
        $('#form-col').removeClass('d-none');
        $('#selector').addClass('d-none');

        const response = await fetch("/service/api.php?action=getUserByID&id=" + id);

        if (!response) {
            console.error("Bad Response");
            return;
        }

        const staff = await response.json();

        $('#name').val(staff.firstName + " " + staff.lastName);
        $('#id').val(staff.id);
    }

    function goBack(){
        $('#form-col').addClass('d-none');
        $('#selector').removeClass('d-none');
    }

</script>
</body>
</html>
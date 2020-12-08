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
                <form action="/service/api.php?action=editProgram" class="mt-2 needs-validation" method="post"
                      novalidate>
                    <label class="sr-only"><input type="number" value="<?php echo $_REQUEST['p'] ?>" name="id"
                                                  hidden></label>
                    <br>
                    <h2 class="font-weight-light mt-2">Edit Staff Details</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Program Name</label>
                                <input class="form-control" name="name" id="name" maxlength="50" minlength="3"
                                       value="<?php echo $staff->name ?>" required>
                                <div class="invalid-feedback">Don't forget a catchy name!</div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input class="form-control" name="location" id="location" maxlength="50"
                                       value="<?php echo $staff->location ?>" required>
                                <div class="invalid-feedback">Where will you be holding this program?</div>
                                <div class="valid-feedback">Nice spot!</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input class="form-control" name="capacity" type="number"
                                       value="<?php echo $staff->capacity ?>" id="capacity" min="0"
                                       required>
                                <div class="invalid-feedback">How many people can sign up?</div>
                                <div class="valid-feedback">Perfect!</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input class="form-control" name="start_date" id="start_date"
                                       value="<?php echo $staff->startDate->format('Y-m-d') ?>" type="date" required>
                                <div class="invalid-feedback">
                                    Invalid Start Date.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input class="form-control" name="end_date" id="end_date"
                                       value="<?php echo $staff->endDate->format('Y-m-d') ?>" type="date" required>
                                <div class="invalid-feedback">
                                    Invalid End Date.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <input class="form-control" name="start_time" id="start_time"
                                       value="<?php echo $staff->startTime->format('H:i:s') ?>" type="time" required>
                                <div class="invalid-feedback">
                                    Invalid Start Time.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <input class="form-control" name="end_time" id="end_time"
                                       value="<?php echo $staff->endTime->format('H:i:s') ?>" type="time" required>
                                <div class="invalid-feedback">
                                    Invalid End Time.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mem_price">Member Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input class="form-control rounded-right" name="mem_price" id="mem_price"
                                           type="number" min="0" value="<?php echo $staff->memberFee ?>"
                                           required>
                                    <div class="invalid-feedback">Please enter a member price.</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="non_mem_price">Non-Member Price</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">$</span>
                                    </div>
                                    <input class="form-control rounded-right" name="non_mem_price"
                                           id="non_mem_price" type="number" value="<?php echo $staff->nonMemberFee ?>"
                                           min="0" required>
                                    <div class="invalid-feedback">Please enter a non-member price.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description"
                                          name="description" rows="3"
                                          maxlength="100"><?php echo $staff->shortDesc ?></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save Changes</button>
                    <a class="btn btn-outline-secondary" type="button" href="/admin/programs/index.php">Cancel</a>
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
        let checked = validateChecks();
        if (form.checkValidity() === false || !checked) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);

    let startDate = $('#start_date');
    let endDate = $('#end_date');
    let startTime = $('#start_time');
    let endTime = $('#end_time');

    startDate[0].addEventListener('change', () => endDate.prop('min', startDate.val()));
    endDate[0].addEventListener('change', () => startDate.prop('max', endDate.val()));
    startTime[0].addEventListener('change', () => endTime.prop('min', addMins(startTime.val(), 15)));
    endTime[0].addEventListener('change', () => startTime.prop('max', endTime.val()));

    function addMins(t, mins) {
        let d = new Date();

        d.setHours(Number(t.substr(0, t.indexOf(":"))));
        d.setMinutes(Number(t.substr(t.indexOf(":") + 1)) + mins);

        return d.toTimeString().substr(0, 5);
    }

    function validateChecks() {
        let checked = false;

        $('input[type=checkbox]').each((i, val) => {
            if (val.checked) checked = true;
        });

        if (!checked) $('#check_message').addClass('d-block');
        else $('#check_message').removeClass('d-block');

        return checked;
    }

</script>
</body>
</html>
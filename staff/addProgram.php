<?php require_once 'authorize.php'; ?>
<html lang="en">
<head>
    <title>Add a Program</title>
</head>
<body>
<?php include '../menu.php'; ?>
<main>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-10 offset-md-1 offset-lg-2">
                <form action="" class="mt-2 needs-validation" method="post" novalidate>
                    <br>
                    <h2 class="font-weight-light mt-4">Add a Program</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Program Name</label>
                                <input class="form-control" name="name" id="name" maxlength="50" minlength="3" required>
                                <div class="invalid-feedback">Don't forget a catchy name!</div>
                                <div class="valid-feedback">Looks good!</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input class="form-control" name="location" id="location" maxlength="50" required>
                                <div class="invalid-feedback">Where will you be holding this program?</div>
                                <div class="valid-feedback">Nice spot!</div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input class="form-control" name="capacity" type="number" id="capacity" min="0"
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
                                <input class="form-control" name="start_date" id="start_date" type="date" required>
                                <div class="invalid-feedback">
                                    Invalid Start Date.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input class="form-control" name="end_date" id="end_date" type="date" required>
                                <div class="invalid-feedback">
                                    Invalid End Date.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <input class="form-control" name="start_time" id="start_time" type="time" required>
                                <div class="invalid-feedback">
                                    Invalid Start Time.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <input class="form-control" name="end_time" id="end_time" type="time" required>
                                <div class="invalid-feedback">
                                    Invalid End Time.
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Every...</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Sunday"
                                           value="1">
                                    <label class="form-check-label" for="Sunday">Sunday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Monday"
                                           value="2">
                                    <label class="form-check-label" for="Monday">Monday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Tuesday"
                                           value="4">
                                    <label class="form-check-label" for="Tuesday">Tuesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Wednesday"
                                           value="8">
                                    <label class="form-check-label" for="Wednesday">Wednesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Thursday"
                                           value="16">
                                    <label class="form-check-label" for="Thursday">Thursday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Friday"
                                           value="32">
                                    <label class="form-check-label" for="Friday">Friday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Saturday"
                                           value="64">
                                    <label class="form-check-label" for="Saturday">Saturday</label>
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
                                           type="number" min="0"
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
                                           id="non_mem_price" type="number"
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
                                          name="description" rows="5" maxlength="100"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Create Program!</button>
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
        if (validateInput() || form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);

    function validateDateTime() {

        endDate.prop('min', startDate.val());
        startDate.prop('max', endDate.val());

        console.log(endTime.val());
        console.log(startTime.val());

        startTime.prop('max', endTime.val());
        endTime.prop('min', startTime.val());

        endDate.removeClass("is-invalid");
        endTime.removeClass("is-invalid");

        // if (endDate.val() && startDate.val() > endDate.val()) {
        //     endDate.val('');
        //     endDate.addClass("is-invalid");
        // }
        //
        // if (startTime.val() > endTime.val()) {
        //     endTime.val('');
        //     endTime.addClass("is-invalid");
        // }
    }

    let startDate = $('#start_date');
    let endDate = $('#end_date');
    let startTime = $('#start_time');
    let endTime = $('#end_time');

    startDate[0].addEventListener('change', validateDateTime);
    endDate[0].addEventListener('change', validateDateTime);
    startTime[0].addEventListener('change', validateDateTime);
    endTime[0].addEventListener('change', validateDateTime);

</script>
</body>
</html>
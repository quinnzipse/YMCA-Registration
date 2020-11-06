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
                <form action="../service/addProgram.php" class="mt-2" method="post">
                    <br>
                    <h2 class="font-weight-light mt-4">Add a Program</h2>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="name">Program Name</label>
                                <input class="form-control" name="name" id="name" maxlength="50" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-group">
                                <label for="location">Location</label>
                                <input class="form-control" name="location" id="location" maxlength="50" required>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="capacity">Capacity</label>
                                <input class="form-control" name="capacity" type="number" id="capacity" min="0"
                                       required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_date">Start Date</label>
                                <input class="form-control" name="start_date" id="start_date" type="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_date">End Date</label>
                                <input class="form-control" name="end_date" id="end_date" type="date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_time">Start Time</label>
                                <input class="form-control" name="start_time" id="start_time" type="time" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_time">End Time</label>
                                <input class="form-control" name="end_time" id="end_time" type="time" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Every...</label>
                                <br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Sunday" value="0000001">
                                    <label class="form-check-label" for="Sunday">Sunday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Monday" value="0000010">
                                    <label class="form-check-label" for="Monday">Monday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Tuesday" value="0000100">
                                    <label class="form-check-label" for="Tuesday">Tuesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Wednesday" value="0001000">
                                    <label class="form-check-label" for="Wednesday">Wednesday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Thursday" value="0010000">
                                    <label class="form-check-label" for="Thursday">Thursday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Friday" value="0100000">
                                    <label class="form-check-label" for="Friday">Friday</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" name="DayOfWeek[]" type="checkbox" id="Saturday" value="1000000">
                                    <label class="form-check-label" for="Saturday">Saturday</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="mem_price">Member Price</label>
                                <input class="form-control" name="mem_price" id="mem_price" type="number" min="0"
                                       required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="non_mem_price">Non-Member Price</label>
                                <input class="form-control" name="non_mem_price" id="non_mem_price" type="number"
                                       min="0" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="5"
                                          maxlength="100"></textarea>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary">Create Program!</button>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>
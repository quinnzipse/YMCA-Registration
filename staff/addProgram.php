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
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="day_of_week">Day of the Week</label>
                                <select class="form-control" name="day_of_week" id="day_of_week" required>
                                    <option disabled selected>Choose One...</option>
                                    <option value="Sunday">Sunday</option>
                                    <option value="Monday">Monday</option>
                                    <option value="Tuesday">Tuesday</option>
                                    <option value="Wednesday">Wednesday</option>
                                    <option value="Thursday">Thursday</option>
                                    <option value="Friday">Friday</option>
                                    <option value="Saturday">Saturday</option>
                                </select>
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
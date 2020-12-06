<?php
// Author: Quinn Zipse
require_once '../authorize.php';
?>
<html lang="en">
<head>
    <title>Staff Home</title>
</head>
<body>
<?php include 'menu.php'; ?>
<!--<nav aria-label="breadcrumb">-->
<!--    <ol class="breadcrumb">-->
<!--        <li class="breadcrumb-item"><a href="index.php">Staff</a></li>-->
<!--        <li class="breadcrumb-item"><a href="manage.php">Manage</a></li>-->
<!--        <li class="breadcrumb-item active" aria-current="page">Programs</li>-->
<!--    </ol>-->
<!--</nav>-->
<div class="container-fluid mt-4">
    <div class="row pr-2" style="height: calc(100vh - 80px)">
        <div class="col-xl-4 col-lg-5" style="height: available">
            <div class="jumbotron shadow-sm">
                <a href="/admin"><small>Back to Admin Home</small></a>
                <h2 class="mt-1">Manage Staff</h2>
                <span class="lead">Select a staff member from the table to view more details</span>
            </div>
            <div class="card shadow my-4 d-none" id="detail-card">
                <div class="card-body">
                    <h3 class="card-title" id="name">Shark</h3>
                    <hr>
                    <div class="card-text">
                        <p class="my-4" id="description">
                            This is a test description. It just shows what this card may look like.
                        </p>
                        <hr class="mb-4">
                        <div class="row my-1">
                            <div class="col-lg-12 col-xl-5">
                                <span><strong>Location:</strong></span>
                                <p id="location">YMCA Onalaska Pool</p>
                            </div>
                            <div class="col-lg-6 col-xl-3">
                                <span><strong>Member Fee:</strong></span>
                                <p class="mt-1">$<span id="memberFee">85</span></p>
                            </div>
                            <div class="col-lg-6 col-xl-4">
                                <span><strong>Non-Member Fee:</strong></span>
                                <p class="mt-1">$<span id="nonMemberFee">230</span></p>
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-7 col-xl-8 text-truncate">
                                <span><strong>Days of the Week:</strong></span>
                                <p class="mt-1" id="dayOfWeek">Sunday,
                                    Monday, Tuesday, Wednesday, Thursday, Friday</p>
                            </div>
                            <div class="col-lg-5 col-xl-4">
                                <span><strong>Capacity:</strong></span>
                                <p class="mt-1" id="capacity">8</p>
                            </div>
                        </div>
                        <div class="row my-1">
                            <div class="col-lg-6 col-xl-5">
                                <span><strong>Date Range:</strong></span>
                                <p class="mt-1" id="date-range">11/15/2020 - 12/13/2020</p>
                            </div>
                            <div class="col-lg-6 col-xl-5">
                                <span><strong>Time Range:</strong></span>
                                <p class="mt-1" id="time-range">5:00 PM - 5:40 PM</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer py-2 px-3">
                    <div class="float-right">
                        <button class="btn btn-sm btn-info" id="roster">View Roster</button>
                        <button class="btn btn-sm btn-primary" id="edit">Edit</button>
                        <button class="btn btn-sm btn-danger" id="cancel">Cancel</button>
                    </div>
                </div>
            </div>
            <div class="card shadow d-none" id="roster-card">
                <div class="card-body">
                    <h4 class="card-title">Roster for <span id="rosterName"></span></h4>
                    <div class="card-text">
                        <table class="table my-4" id="roster-data">
                            <!-- This will be generated -->
                        </table>
                        <button class="btn btn-sm btn-secondary float-right" onclick="hideRoster()">Back</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-7">
            <div class="row mb-2">
                <div class="col-md-2">
                    <a href="addProgram.php" class="btn btn-sm btn-success">&plus; New</a>
                </div>
                <div class="col-md-4 offset-md-6">
                    <label for="search" class="sr-only">Search:</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input class="form-control-sm form-control" placeholder="Search..." type="text"
                                   id="search">
                            <div class="input-group-append">
                                <div class="btn btn-sm btn-outline-primary" onclick="search()">Search</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="thead-light">
                    <tr>
                        <th>Name</th>
                        <th>Capacity</th>
                        <th>Days of Week</th>
                        <th>Dates</th>
                        <th>Time</th>
                        <!--                        <th></th>-->
                    </tr>
                    </thead>
                    <tbody id="table_body">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 2500,
        timerProgressBar: true,
        icon: 'success'
    });

    <?php
    if (isset($_REQUEST['programCreated'])) echo "Toast.fire({title: 'Program Created! 🎉'});";
    if (isset($_REQUEST['programEdited'])) echo "Toast.fire({title: 'Program Updated!'});";
    ?>

    // TODO
    const programs = [];

    function hideRoster() {
        $('#roster-card').addClass('d-none');
        $('#roster-data').html('');
        $('#detail-card').removeClass('d-none');
    }

    async function getRoster(id) {
        let request = await fetch('/service/api.php?action=getRoster&programID=' + id);
        let json = await request.json();
        if (!json) console.log("Got nothing :(");

        let program = programs.find(val => val.id === id);

        $('#rosterName').text(program.name);

        // Setup roster data.
        let listOfPeps = $('#roster-data');

        let html = '';

        // Generate the header
        html += '<thead>';
        if (json.length === 0) html += '<tr><th>No one has signed up yet!</th></tr>';
        else html += '<tr><th>Last Name</th><th>First Name</th><th>Email</th></tr>';
        html += '</thead>';

        // Generate the body
        html += '<tbody>';
        json.forEach(val => {
            html += `<tr><td>${val[0]}</td><td>${val[1]}</td><td>${val[3]}</td></tr>`;
        });
        html += '</tbody>';

        listOfPeps.html(html);

        // Show our work off!
        $('#detail-card').addClass('d-none');
        $('#roster-card').removeClass('d-none');
    }

    function deleteProgram(id) {
        // TODO!!!
    }

    let searchField = $("#search");

    searchField.on('keypress', (val) => val.code === 'Enter' ? search() : '');

    // getPrograms();

    async function search() {
        let value = searchField.val();
        console.log(value);
        let response = await fetch(`/service/api.php?action=search_programs&v=${value}`);// TODO

        if (response.redirected) {
            window.location = '/login.php?reauth=1';
        }

        let json = await response.json();
        let html = '';

        json.forEach(val => {
            html += generateLine(val);
        });

        $('#table_body').html(html);
    }

    async function getPrograms() {
        const response = await fetch(`/service/api.php?action=get_programs`);

        if (response.redirected) {
            window.location = '/login.php?reauth=1';
        }

        let json = await response.json();
        let html = '';

        json.forEach(val => html += generateLine(val));

        $('#table_body').html(html);
    }

    function generateLine(val) {
        programs.push(val);

        let startDate = new Date(val['startDate']['date']).toLocaleDateString("en-US");
        let endDate = new Date(val['endDate']['date']).toLocaleDateString("en-US");
        let startTime = new Date(val['startTime']['date']).toLocaleTimeString("en-US", {
            timeStyle: 'short'
        });
        let endTime = new Date(val['endTime']['date']).toLocaleTimeString("en-US", {
            timeStyle: 'short'
        });

        return ` <tr onclick="get(${val['id']})">
                <td id='${val['id']}'>${val['name']}</td>
                <td>${val['capacity']}</td>
                <td class='text-truncate'>${val['days'].join(', ')}</td>
                <td>${startDate} - ${endDate}</td>
                <td>${startTime} - ${endTime}</td>

            </tr>`;
    }

    function setupButtons(id) {
        // get the buttons
        let rosterButton = $('#roster');
        let cancelButton = $('#cancel');
        let editButton = $('#edit');

        // Destroy the previous onclick listeners.
        rosterButton.off();
        cancelButton.off();
        editButton.off();

        // Create new listeners
        rosterButton.on('click', () => getRoster(id));
        cancelButton.on('click', () => cancel(id));
        editButton.on('click', () => window.location = `editProgram.php?p=${id}`);
    }

    function get(id) {

        // Find the program in the array.
        let program = programs.find(it => it.id === id);

        // Fill in the card.
        $('#name').text(program.name);
        $('#description').text(program.shortDesc);
        $('#capacity').text(program.capacity);
        $('#location').text(program.location);
        $('#nonMemberFee').text(program.nonMemberFee.toFixed(2));
        $('#memberFee').text(program.memberFee.toFixed(2));

        let dow = program.days.join(", ");
        let dowEl = $('#dayOfWeek');
        dowEl.text(dow);
        dowEl.prop('title', dow);

        let startTime = new Date(program.startTime.date).toLocaleTimeString('en-US', {
            hour: "numeric",
            minute: "numeric"
        });
        let endTime = new Date(program.endTime.date).toLocaleTimeString('en-US', {hour: "numeric", minute: "numeric"});
        $('#time-range').text(`${startTime} - ${endTime}`);

        let startDate = new Date(program.startDate.date).toLocaleDateString('en-US');
        let endDate = new Date(program.endDate.date).toLocaleDateString('en-US');
        $('#date-range').text(`${startDate} - ${endDate}`);

        setupButtons(id);

        // Make it visible
        $('#detail-card').removeClass('d-none');
        $('#roster-card').addClass('d-none');

    }

    function cancel(id) {
        let program = programs.find(it => it.id === id);

        Swal.fire({
            title: `Cancel ${program.name}?`,
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Cancel it!',
            cancelButtonText: 'No, Go Back',
            footer: '<small class="text-center">This will cancel registrations for this class and notify all participants.<br>' +
                'The program will be retained for historical purposes.</small>'
        }).then((result) => {
                // TODO: Cancel Class HERE.
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Cancelled!',
                        text: 'Your program has been cancelled successfully.',
                        icon: 'success',
                        timer: 1500,
                        timerProgressBar: true
                    }).then(() => {
                        $('#detail-card').addClass('d-none');
                        getPrograms();
                    });
                }


            }
        )
    }

</script>
<style>
    .table-hover tr:hover {
        cursor: pointer;
    }
</style>
</html>
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
                    <h3 class="card-title" id="name"><span id="lastName"></span>, <span id="firstName"></span> <span
                                id="middleInit"></span></h3>
                    <hr>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-lg-6">
                                <h4 class="lead"><strong>Contact Info:</strong></h4>

                                <small><strong>Email: </strong></small>
                                <a id="email" href="mailto:qzipse@outlook.com">qzipse@outlook.com</a>
                                <br>

                                <small><strong>Phone:</strong></small>
                                <span id="phoneNumber">(507) 273-6959</span>
                                <br>
                            </div>
                            <div class="col-lg-6">
                                <h4 class="lead"><strong>Work Info:</strong></h4>

                                <small><strong>Start Date: </strong></small>
                                <span class="mt-1" id="startDate">12/7/2020</span>
                                <br>

                                <small><strong>Salary:</strong></small>
                                <span>$<span id="salary">100,000</span></span>
                                <br>
                            </div>

                        </div>

                        <h4 class="lead mt-3"><strong>Personal Info:</strong></h4>

                        <small><strong title="Date of Birth">DOB: </strong></small>
                        <span class="mt-1" id="dob">5/11/2001</span>
                        <br>

                        <small><strong>SSN (Last 4): </strong></small>
                        <span class="mt-1">XXX-XX-<span id="ssn">2042</span></span>
                        <br>

                        <small><strong>Address:</strong></small>
                        <span id="address">24795 555th St, West Concord, MN 55985</span>
                        <br>

                    </div>
                </div>
                <div class="card-footer py-2 px-3">
                    <div class="float-right">
                        <button class="btn btn-sm btn-primary" id="edit">Edit</button>
                        <button class="btn btn-sm btn-danger" id="remove">Remove</button>
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
                    <a href="addStaff.php" class="btn btn-sm btn-success">&plus; Add</a>
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
                        <th>Last</th>
                        <th>First</th>
                        <th>Email</th>
                        <th>Phone Number</th>
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

    const staff = [];

    function disableStaff(id) {
        // TODO!!!
    }

    let searchField = $("#search");

    searchField.on('keypress', (val) => val.code === 'Enter' ? search() : '');

    getStaff();

    async function search() {
        let value = searchField.val();
        console.log(value);
        let response = await fetch(`/service/api.php?action=search_staff&v=${value}`);

        if (response.redirected) {
            window.location = '/login.php?reauth=1';
        }

        let json = await response.json();
        let html = '';

        json.forEach(val => html += generateLine(val));

        $('#table_body').html(html);
    }

    async function getStaff() {
        const response = await fetch(`/service/api.php?action=get_staff`);

        if (response.redirected) {
            window.location = '/login.php?reauth=1';
        }

        let json = await response.json();
        let html = '';

        json.forEach(val => html += generateLine(val));

        $('#table_body').html(html);
    }

    function generateLine(val) {
        staff.push(val);

        return ` <tr onclick="get(${val['id']})">
                <td>${val['lastName']}</td>
                <td>${val['firstName']}</td>
                <td>${val['email']}</td>
                <td>${formatPhoneNumber(val['phoneNumber'])}</td>
            </tr>`;
    }

    function setupButtons(id) {
        // get the buttons
        let removeButton = $('#remove');
        let editButton = $('#edit');

        // Destroy the previous onclick listeners.
        removeButton.off();
        editButton.off();

        // Create new listeners
        removeButton.on('click', () => removeStaff(id));
        editButton.on('click', () => window.location = `editStaff.php?s=${id}`);
    }

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function formatPhoneNumber(number){
        return "(" +  number.substr(0, 3) + ") " + number.substr(3, 3) + "-" + number.substring(6);
    }

    function get(id) {

        // Find the program in the array.
        let user = staff.find(it => it.id === id);

        // Fill in the card.
        $('#lastName').text(user.lastName);
        $('#firstName').text(user.firstName);
        $('#middleInit').text(user.middleInit.toUpperCase());
        $('#salary').text(numberWithCommas(user.salary.toFixed(2)));
        $('#address').text((user.address === '' ? 'N/A' : user.address));
        $('#ssn').text(user.ssn.substr(-4));
        $('#phoneNumber').text(formatPhoneNumber(user.phoneNumber));

        let emailEl = $("#email");
        emailEl.text(user.email);
        emailEl.prop('href', `mailto:${user.email}`);

        let startDate = new Date(user.startDay.date).toLocaleDateString('en-US');
        let dob = new Date(user.dob.date).toLocaleDateString('en-US');
        $('#start_date').text(startDate);
        $('#dob').text(dob);

        setupButtons(id);

        // Make it visible
        $('#detail-card').removeClass('d-none');
        $('#roster-card').addClass('d-none');

    }

    function removeStaff(id) {
        let person = staff.find(it => it.id === id);

        Swal.fire({
            title: `Remove ${person.firstName} ${person.lastName}?`,
            text: "This action is dangerous!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Remove',
            cancelButtonText: 'No, Go Back',
            footer: '<small class="text-center">This will revoke staff access for this user!<br>' +
                'All data will be retained for historical purposes.</small>'
        }).then((result) => {
                // TODO: Cancel Class HERE.
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Permission Revoked!',
                        text: `${person.firstName} ${person.lastName}'s permission was revoked.`,
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        $('#detail-card').addClass('d-none');
                        getStaff();
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
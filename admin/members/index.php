<?php
// Author: Quinn Zipse
require_once '../authorize.php';
?>
<html lang="en">
<head>
    <title>Members Home</title>
</head>
<body>
<?php include 'menu.php'; ?>
<div class="container-fluid mt-4">
    <div class="row pr-2" style="height: calc(100vh - 80px)">
        <div class="col-xl-4 col-lg-5" style="height: available">
            <div class="jumbotron shadow-sm">
                <a href="/admin"><small>Back to Admin Home</small></a>
                <h2 class="mt-1">Manage Members</h2>
                <span class="lead">Select a member from the table to view more details</span>
            </div>
            <div class="card shadow my-4 d-none" id="detail-card">
                <div class="card-body">
                    <h3 class="card-title" id="name"><span id="lastName"></span>, <span id="firstName"></span>
                    </h3>
                    <hr>
                    <div class="card-text">
                        <div class="row">
                            <div class="col-lg-6">
                                <small class="d-block mb-2"><strong>Email: </strong></small>
                                <a id="email" href=""></a>
                            </div>
                            <div class="col-lg-6">
                                <small class="d-block mb-2"><strong>Membership Status: </strong></small>
                                <span id="status"></span>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer py-2 px-3">
                    <div class="float-right">
                        <button class="btn btn-sm btn-primary" id="edit">Edit</button>
                        <button class="btn btn-sm btn-danger" id="cancel">Disable</button>
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
                <div class="col-md-4 offset-md-8">
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
                        <th>First</th>
                        <th>Last</th>
                        <th>Email</th>
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
    if (isset($_REQUEST['memberEdited'])) echo "Toast.fire({title: 'Member Updated!'});";
    ?>

    let members = [];

    // function hideRoster() {
    //     $('#roster-card').addClass('d-none');
    //     $('#roster-data').html('');
    //     $('#detail-card').removeClass('d-none');
    // }

    // async function getRoster(id) {
    //     let request = await fetch('/service/api.php?action=getRoster&programID=' + id);
    //     let json = await request.json();
    //     if (!json) console.log("Got nothing :(");
    //
    //     let program = programs.find(val => val.id === id);
    //
    //     $('#rosterName').text(program.name);
    //
    //     // Setup roster data.
    //     let listOfPeps = $('#roster-data');
    //
    //     let html = '';
    //
    //     // Generate the header
    //     html += '<thead>';
    //     if (json.length === 0) html += '<tr><th>No one has signed up yet!</th></tr>';
    //     else html += '<tr><th>Last Name</th><th>First Name</th><th>Email</th></tr>';
    //     html += '</thead>';
    //
    //     // Generate the body
    //     html += '<tbody>';
    //     json.forEach(val => {
    //         html += `<tr><td>${val[0]}</td><td>${val[1]}</td><td>${val[3]}</td></tr>`;
    //     });
    //     html += '</tbody>';
    //
    //     listOfPeps.html(html);
    //
    //     // Show our work off!
    //     $('#detail-card').addClass('d-none');
    //     $('#roster-card').removeClass('d-none');
    // }

    let searchField = $("#search");

    searchField.on('keypress', (val) => val.code === 'Enter' ? search() : '');

    getMembers();

    async function search() {
        let tableEl = $('#table_body');
        let s = $('#search').val().toLowerCase();

        let filtered = members.filter(it => it.firstName.toLowerCase().includes(s) || it.lastName.toLowerCase().includes(s));

        tableEl.html('');
        let html = '';

        filtered.forEach(val => {
            html += generateLine(val);
        });

        tableEl.html(html);
    }

    async function getMembers() {
        const response = await fetch(`/service/api.php?action=get_members`);

        if (response.redirected) {
            window.location = '/login.php?reauth=1';
        }

        let json = await response.json();
        let html = '';

        json.forEach(val => html += generateLine(val));

        setMembers(json);

        $('#table_body').html(html);
    }

    function setMembers(json) {
        members = [...json];
    }

    function generateLine(val) {
        return ` <tr onclick="get(${val['id']})">
                <td>${val['firstName']}</td>
                <td>${val['lastName']}</td>
                <td>${val['email']}</td>
            </tr>`;
    }

    async function getParticipantPrograms(id) {
        let response = await fetch('/service/api.php?action=getProgramsByUser&id=' + id);
        if (!response.ok) return;

        let json = await response.json();
        let html = '';

        json.forEach((val) => {
            html += `<tr><td>${val.name}</td><td>${val.name}</td></tr>`;
        });
    }

    // TODO
    function setupButtons(id) {
        // get the buttons
        let programButton = $('#program');
        let cancelButton = $('#cancel');
        let editButton = $('#edit');

        // Destroy the previous onclick listeners.
        programButton.off();
        cancelButton.off();
        editButton.off();

        // Create new listeners
        programButton.on('click', () => getParticipantPrograms(id));
        cancelButton.on('click', () => cancel(id));
        editButton.on('click', () => window.location = `editMember.php?m=${id}`);
    }

    function get(id) {

        // Find the program in the array.
        let member = members.find(it => it.id === id);

        // Make the status a human readable string.
        let status = 'Non Member';
        if (member.status === 1) status = 'Member';
        else if (member.status === 3) status = 'Staff';

        // Fill in the card.
        $('#firstName').text(member.firstName);
        $('#lastName').text(member.lastName);
        $('#email').text(member.email);
        $('#status').text(status);

        setupButtons(id);

        // Make it visible
        $('#detail-card').removeClass('d-none');
        $('#roster-card').addClass('d-none');

    }

    function cancel(id) {
        let member = members.find(it => it.id === id);

        Swal.fire({
            title: `Disable ${member.firstName} ${member.lastName}?`,
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Disable it!',
            cancelButtonText: 'No, Go Back',
            footer: '<small class="text-center">This will cancel registrations for this user.<br>' +
                'The user will be retained for historical purposes.</small>'
        }).then((result) => {
                if (result.isConfirmed) {
                    fetch('/service/api.php?action=disableMember&id=' + id).then((res) => {
                        if (res.ok) {
                            Swal.fire({
                                title: 'Disabled!',
                                text: `${member.firstName} ${member.lastName}'s account has been disabled.`,
                                icon: 'success',
                                timer: 1500,
                                timerProgressBar: true
                            }).then(() => {
                                $('#detail-card').addClass('d-none');
                                getMembers();
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: `An error has occurred!`,
                                icon: 'danger',
                                timer: 1500,
                                timerProgressBar: true
                            });
                        }
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
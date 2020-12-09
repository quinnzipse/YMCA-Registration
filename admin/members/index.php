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
                        <button class="btn btn-sm btn-info" id="program">View Programs</button>
                        <button class="btn btn-sm btn-primary" id="edit">Edit</button>
                        <button class="btn btn-sm btn-danger" id="cancel">Disable</button>
                    </div>
                </div>
            </div>
            <div class="card shadow d-none" id="program-card">
                <div class="card-body">
                    <h4 class="card-title">Programs for <span id="userName"></span></h4>
                    <div class="card-text">
                        <table class="table my-4">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Location</th>
                                <th>Days</th>
                            </tr>
                            </thead>
                            <tbody id="program-data">
                            <!-- This will be generated -->
                            </tbody>
                        </table>
                        <button class="btn btn-sm btn-secondary float-right" onclick="hidePrograms()">Back</button>
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

    function showPrograms() {
        $('#program-card').removeClass('d-none');
        $('#detail-card').addClass('d-none');
    }

    function hidePrograms() {
        $('#program-card').addClass('d-none');
        $('#program-data').html('');
        $('#detail-card').removeClass('d-none');
    }

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

        let mem = members.find(it => it.id === id);

        let json = await response.json();
        let html = '';

        $('#userName').text(mem.firstName + " " + mem.lastName);

        json = json.filter(val => val.inactive === false);

        if(json.length === 0) html += '<tr><td colspan="3" class="text-center text-muted">No Active Registrations</td></tr>';
        json.forEach((val) => html += `<tr><td>${val.name}</td><td>${val.location}</td><td>${val.days.join(", ")}</td></tr>`);

        $("#program-data").html(html);

        showPrograms();
    }

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
        let emailEl = $('#email');
        let status = 'Non Member';
        if (member.status === 1) status = 'Member';
        else if (member.status === 3) status = 'Staff';

        // Fill in the card.
        $('#firstName').text(member.firstName);
        $('#lastName').text(member.lastName);
        emailEl.text(member.email);
        emailEl.prop('href', 'mailto:' + member.email);
        $('#status').text(status);

        setupButtons(id);

        // Make it visible
        hidePrograms();

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
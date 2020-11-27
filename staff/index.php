
<html lang="en">
<head>
    <title>Staff Home</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #0851c7;">
    <a class='navbar-brand' href='http://104.131.34.30/'>YMCA</a>    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
                                                                             aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <a class='nav-link' href='http://104.131.34.30/'>Home</a>
            <a class='nav-link' href='http://104.131.34.30/program/'>Programs</a><a class='nav-link' href='http://104.131.34.30/staff/'>Staff</a><a class='nav-link' href='http://104.131.34.30/accountinfo.php'>Quinn</a><a class='nav-link' href='http://104.131.34.30/logout.php'>Logout</a>        </div>
    </div>
</nav>

<div class="mx-5">
    <div class="container-fluid">
        <div class="row mt-4 mb-2">
            <div class="col-md-2">
                <a href="addProgram.php" class="btn btn-outline-success">Add a program!</a>
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
        <table class="table">
            <thead class="thead-light">
            <tr>
                <th>Name</th>
                <th>Desc</th>
                <th>Capacity</th>
                <th>Days of Week</th>
                <th>Dates</th>
                <th>Time</th>
                <th>Member</th>
                <th>Non Member</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr><td id='17'>Shark</td><td class='text-truncate'>Participants
                    must have passed pike level before.</td><td>8</td><td class='text-truncate'>Sunday</td><td>11/15/2020 - 12/13/2020</td><td>5:00 PM - 5:40 PM</td><td>$48</td><td>$96</td><td><button class='btn btn-outline-primary mr-2' onclick='getRoster(17)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/></svg></button><button class='btn btn-outline-danger' onclick='deleteProgram(17)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/></svg></button></td></tr><tr><td id='18'>Shark</td><td class='text-truncate'>Participants
                    must have passed pike level before.</td><td>8</td><td class='text-truncate'>Monday, Wednesday</td><td>11/15/2020 - 12/13/2020</td><td>6:00 PM - 6:40 PM</td><td>$65</td><td>$130</td><td><button class='btn btn-outline-primary mr-2' onclick='getRoster(18)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/></svg></button><button class='btn btn-outline-danger' onclick='deleteProgram(18)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/></svg></button></td></tr><tr><td id='19'>Log Rolling</td><td class='text-truncate'>Log Rolling.</td><td>1</td><td class='text-truncate'>Sunday</td><td>11/15/2020 - 12/13/2020</td><td>5:00 PM - 5:40 PM</td><td>$100</td><td>$200</td><td><button class='btn btn-outline-primary mr-2' onclick='getRoster(19)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/></svg></button><button class='btn btn-outline-danger' onclick='deleteProgram(19)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/></svg></button></td></tr><tr><td id='20'>Testing Indexer</td><td class='text-truncate'>This some thing</td><td>6</td><td class='text-truncate'>Monday, Tuesday</td><td>11/24/2020 - 12/08/2020</td><td>8:42 PM - 10:42 PM</td><td>$58</td><td>$59</td><td><button class='btn btn-outline-primary mr-2' onclick='getRoster(20)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-person-lines-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z"/></svg></button><button class='btn btn-outline-danger' onclick='deleteProgram(20)'><svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-trash-fill" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z"/></svg></button></td></tr>            </tbody>
        </table>
    </div>
</div>
<div class="modal fade" id="rosterModal" tabindex="-1" aria-labelledby="rosterModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="m_title">Roster for </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid my-3">
                    <table id="m_listOfPeople" class="table">
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    async function getRoster(id) {
        let request = await fetch('/service/api.php?action=getRoster&programID=' + id);
        let json = await request.json();
        if (!json) console.log("Got nothing :(");
        let listOfPeps = $('#m_listOfPeople');

        $("#m_listOfPeople").html('');
        $('#m_title').text('Roster for ' + $(`#${id}`).text());

        // Generate the header
        listOfPeps.append('<thead class="thead-light">');
        if (json.length === 0) listOfPeps.append('<tr><th>No one has signed up yet!</th></tr>');
        else listOfPeps.append('<tr><th>Last Name</th><th>First Name</th><th>Email</th></tr>');
        listOfPeps.append('</thead>');

        // Generate the body
        listOfPeps.append('<tbody>');
        json.forEach(val => {
            listOfPeps.append(`<tr><td>${val[0]}</td><td>${val[1]}</td><td>${val[3]}</td></tr>`);
        });
        listOfPeps.append('</tbody>');

        // Show our work off!
        $('#rosterModal').modal('show');
    }

    function deleteProgram(id) {

    }
</script>
</html>

<script>

    let searchField = $("#search");

    searchField.on('keypress', (val) => val.keyCode === 13 ? search() : '');

    function search() {
        let value = searchField.val();
        console.log(value);
    }
</script>

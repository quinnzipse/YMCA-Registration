<?php
include_once "authorize.php";
include_once "models/Program.php";

$programs = Program::getPrograms();
?>
    <html lang="en">
    <head>
        <title>Staff Home</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    </head>
    <?php include '../menu.php'; ?>

    <div class="mx-5">
        <div class="container-fluid">
            <a href="addProgram.php" class="btn btn-outline-primary my-3">Add a program!</a>
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
                <?php
                $rosterIcon = "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-person-lines-fill\" " .
                    "fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">" .
                    "<path fill-rule=\"evenodd\" d=\"M1 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H1zm5-6a3 3 0 1 0 0-6 3 3 0 0 " .
                    "0 0 6zm7 1.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5zm-2-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 " .
                    "1 0 1h-4a.5.5 0 0 1-.5-.5zm0-3a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1h-4a.5.5 0 0 1-.5-.5zm2 9a.5.5 0 0 1 " .
                    ".5-.5h2a.5.5 0 0 1 0 1h-2a.5.5 0 0 1-.5-.5z\"/>" .
                    "</svg>";
                $trashIcon = "<svg width=\"1em\" height=\"1em\" viewBox=\"0 0 16 16\" class=\"bi bi-trash-fill\" " .
                    "fill=\"currentColor\" xmlns=\"http://www.w3.org/2000/svg\">" .
                    "<path fill-rule=\"evenodd\" d=\"M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0" .
                    " 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 " .
                    ".5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z\"/>" .
                    "</svg>";

                foreach ($programs as $program) {
                    $days = join(", ", $program->getDaysOfWeek());
                    $sdate = $program->startDate->format("m/d/Y");
                    $edate = $program->endDate->format("m/d/Y");
                    $stime = $program->startTime->format('g:i A');
                    $etime = $program->endTime->format('g:i A');
                    echo "<tr>" .
                        "<td id='" . $program->getID() . "'>$program->name</td>" .
                        "<td class='text-truncate'>$program->shortDesc</td>" .
                        "<td>$program->capacity</td>" .
                        "<td class='text-truncate'>$days</td>" .
                        "<td>$sdate - $edate</td>" .
                        "<td>$stime - $etime</td>" .
                        "<td>$$program->memberFee</td>" .
                        "<td>$$program->nonMemberFee</td>" .
                        "<td>" .
                        "<button class='btn btn-outline-primary mr-2' onclick='getRoster(" . $program->getID() . ")'>$rosterIcon</button>" .
                        "<button class='btn btn-outline-danger' onclick='deleteProgram(" . $program->getID() . ")'>$trashIcon</button>" .
                        "</td>" .
                        "</tr>";
                }
                ?>
                </tbody>
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
<?php
if ($_REQUEST['programCreated'] ?? 0 == 1)
    echo "<script>
    const Toast = Swal.mixin({ //when firing the toast, the first window closes automatically
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        icon: 'success',
        title: 'Program Created Successfully!',
        timer: 2000,
        timerProgressBar: true
    });

    Toast.fire();
</script>";
?>
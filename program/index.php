<html lang="en">
<head>
    <title>Browse Programs</title>
</head>
<?php include '../menu.php';
?>

<div class="container">
    <div class="row mt-3">
        <div class='col-lg-4 col-md-6 mt-3 '>
            <div class='card border-dark h-100' style='border-radius: 20px'>
                <div class='card-body'>
                    <h5 class='card-title'>$obj->Name</h5>
                    <p class='card-text'>$obj->ShortDesc</p>
                </div>
                <p class='list-group list-group-flush'>
                <li class='list-group-item'>$obj->Location</li>
                <li class='list-group-item'><p>$sdate to $edate</p><p> $obj->day_of_week's, $stime - $etime</p></li>
                <li class='list-group-item'><p>Member Fee:   $$obj->MemberFee</p> <p>Non Member Fee:   $$obj->NonMemberFee</p></li>
                </ul>
                <div class='card-body'>
                    <a href='#' class='btn btn-block' style='background-color: gray; color: white '>Register For Class</a>
                </div>
                <li class='list-group-item' style='color: red' >
                    <p>You are already registered for:</p>
                    <p>Put name of program here</p>
                </li>
            </div>
        </div>
    </div>


        <?php
        require "../models/Program.php";
        $page = $_GET['page'] ?? 0;
        $progs = Program::getPrograms($page);

        foreach ($progs as $obj) {

            $sdate = $obj->startDate->format("M, d Y");
            $edate = $obj->endDate->format("M, d Y");
            $stime = $obj->startTime->format('g:i A');
            $etime = $obj->endTime->format('g:i A');
            $days_of_week = join("'s, ", $obj->getDaysOfWeek());

            echo "<div class='col-lg-4 col-md-6 mt-3 '>
            <div class='card border-dark h-100' style='border-radius: 20px'>
                <div class='card-body'>
                    <h5 class='card-title'>$obj->name</h5>
                    <p class='card-text'>$obj->shortDesc</p>
                </div>
                <p class='list-group list-group-flush'>
                    <li class='list-group-item'>$obj->location</li>
                    <li class='list-group-item'>
                        <p>$sdate to $edate</p>
                        <p> $days_of_week's, $stime - $etime</p>
                    </li>
                    <li class='list-group-item'><p>Member Fee:   $$obj->memberFee</p> <p>Non Member Fee:   $$obj->nonMemberFee</p></li>
                </ul>
                <div class='card-body'>";
            if ($auth->isLoggedIn()) {
                echo "<a href='#' class='btn btn-block' style='background-color: #0851c7; color: white '>Register For Class</a>";
            } else {
                echo "<a href='../login.php' class='btn btn-block' style='background-color: #0851c7; color: white '>Register For Class</a>";
            }
            echo "
                </div>
             </div>
                
         </div>";
        } ?>


    </div>
</div>
</html>


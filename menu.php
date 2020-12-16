<?php
//Turn on for debug mode:
$DEBUG = true;

//check if user is logged in and create authentication
$host =  'http://' . $_SERVER['HTTP_HOST'];
require_once  ($_SERVER["DOCUMENT_ROOT"] . '/service/Auth.php');
$auth = new Auth();
$user = $auth->isLoggedIn();
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-dark shadow" style="background-color: #0851c7;">
    <?php echo "<a class='navbar-brand' href='$host/'>YMCA</a>"; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="container-fluid">
        <div class="navbar-nav">
            <?php
                //dynamic menu based on whether the user is logged in or not
                echo "  <a class='nav-link' href='$host/'>Home</a>
                        <a class='nav-link' href='$host/program/'>Programs</a>";
                        if ($user) {
                            if ($user->MembershipStatus == 3) {
                                echo "<a class='nav-link' href='$host/admin/'>Admin</a>";
                            } 
                            echo "<a class='nav-link' href='$host/accountinfo.php'>$user->FirstName</a>";
                            echo "<a class='nav-link' href='$host/logout.php'>Logout</a>";
                        } else {
                            echo "<a class='nav-link' href='$host/login.php'>Login</a>";
                        }
            ?>
        </div>
        <ul class="nav navbar-nav navbar-right">
            <li><a class="nav-link" href="Help!.pdf" target="_blank">Help!</a></li>
        </ul>
        </div>
    </div>
</nav>

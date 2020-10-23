<?php
$host = ($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
require_once  ($_SERVER["DOCUMENT_ROOT"] . '/service/Auth.php');
$auth = new Auth();
$user = $auth->isLoggedIn();
?>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0851c7;">
    <?php echo "<a class='navbar-brand' href='$host/index.php'>YMCA</a>"; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
            aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <?php
                echo "  <a class='nav-link' href='$host/index.php'>Home</a>
                        <a class='nav-link' href='$host/program/index.php'>Programs</a>";
                        if ($user) {
                            if ($user->MembershipStatus == 3) {
                                echo "<a class='nav-link' href='$host/staff/index.php'>Staff</a>";
                            } 
                            echo "<a class='nav-link' href='$host/accountinfo.php'>$user->FirstName</a>";
                            echo "<a class='nav-link' href='$host/logout.php'>Logout</a>";
                        } else {
                            echo "<a class='nav-link' href='$host/login.php'>Login</a>";
                        }
            ?>
        </div>
    </div>
</nav>

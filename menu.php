<?php
$host = ($_SERVER['HTTPS'] ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
require_once  $host . '/service/Auth.php';
$auth = new Auth();
$user = $auth->isLoggedIn();
?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-dark" style="background-color: #0851c7;">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <?php
                echo "  <a class='nav-link' href='$host/index.php'>Home</a>
                        <a class='nav-link' href='$host/program/index.php'>Programs</a>";
                        if ($user) {
                            if ($user->MembershipStatus == 3) {
                                echo "<a class='nav-link' href='$host/staff/'>Staff</a>";
                            }  
                            echo "<a class='nav-link' href='$host/logout.php'>Logout</a>";
                        } else {
                            echo "<a class='nav-link' href='$host/login.php'>Login</a>";
                        }
            ?>
        </div>
    </div>
</nav>


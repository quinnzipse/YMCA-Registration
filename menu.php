<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
      integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #47b3ff;">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
            <?php $host = $_SERVER['HTTP_HOST'];
            echo '<a class="nav-link" href="http://' . $host . '/index.php">Home</a>';
            echo '<a class="nav-link" href="http://' . $host . '/program/index.php">Programs</a>';
            echo '<!--<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a> -->';
            echo '<a class="nav-link" href="login.php">Login</a>';
            ?>
        </div>
    </div>
</nav>


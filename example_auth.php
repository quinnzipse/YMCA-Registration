<?php
// You'll either get access to the $user array OR you'll get redirected.
require './service/authorize.php';
var_dump($user);
?>
<h1>You must be logged in!</h1>
<?php
//logout page

//auth page included for logging out
require_once './service/Auth.php';

$auth = new Auth();

//check if the user is logged in
if ($auth->isLoggedIn()) {
    $auth->logout($_COOKIE['cs341_uuid']);
}

header("Location: /?loggedOut=1");
exit(200);
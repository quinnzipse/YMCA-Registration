<?php
require_once './service/Auth.php';

$auth = new Auth();
if ($auth->isLoggedIn()) {
    $auth->logout($_COOKIE['cs341_uuid']);
}

header("Location: /?loggedout=1");
exit(200);
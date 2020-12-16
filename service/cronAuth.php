<?php
//additional authentication validation
require 'Auth.php';
$auth = new Auth();
$auth->validateSessions();
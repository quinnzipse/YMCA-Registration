<?php
// Validates that the sessions aren't expired.
require 'Auth.php';
$auth = new Auth();
$auth->validateSessions();
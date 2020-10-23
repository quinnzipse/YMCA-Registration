<?php
require "Program.php";

$prog = new Program();
$progs = $prog->getPrograms();

foreach($progs as $obj) {
	echo " <p> " . $obj->ID . "</p>\n";
}

<?php

require_once("../vendor/autoload.php");


$auth = new \AKEB\MRGS\Authorize(38, '123123123');
$auth->authorize();
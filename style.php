<?php
require_once('vendor/autoload.php');
require_once "vendor/leafo/scssphp/example/Server.php";
use Leafo\ScssPhp\Server;
	$server = new Server('wp-content/themes/summit/css/');
	$server->serve();
?>
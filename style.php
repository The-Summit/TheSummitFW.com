<?php
require_once('vendor/autoload.php');
require_once "vendor/leafo/scssphp/example/Server.php";
use Leafo\ScssPhp\Server;

	//$scss = new Compiler();
	//$scss->setImportPaths('wp-content/themes/summit/css/');
	//$scss->setFormatter('Leafo\ScssPhp\Formatter\Compressed');
	//echo $scss->compile('@import "style.scss";');
	$server = new Server('wp-content/themes/summit/css/');
	$server->serve();
?>
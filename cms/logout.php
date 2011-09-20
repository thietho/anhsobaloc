<?php
	ini_set("memory_limit","150M");
	include('directory.php');
	include(DIR_SYSTEM.'config/config.php');
	include(DIR_SYSTEM.'config/startup.php');
	
	// Front Controller
	$controller = new Front();
	
	$action = new Action('common/logout', 'index');
	// Dispatch
	$controller->dispatch($action, new Action('error/not_found', 'index'));
	
	// Output
	$response->output();
?>
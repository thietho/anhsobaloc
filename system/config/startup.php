<?php
	include(DIR_SYSTEM.'engine/action.php');
	include(DIR_SYSTEM.'engine/controller.php');
	include(DIR_SYSTEM.'engine/front.php');
	include(DIR_SYSTEM.'engine/model.php');
	include(DIR_SYSTEM.'engine/registry.php');
	include(DIR_SYSTEM.'engine/router.php');
	
	require_once(DIR_SYSTEM . 'library/document.php');
	require_once(DIR_SYSTEM . 'library/language.php');
	require_once(DIR_SYSTEM . 'library/url.php');
	require_once(DIR_SYSTEM . 'library/request.php');
	require_once(DIR_SYSTEM . 'library/response.php');
	require_once(DIR_SYSTEM . 'library/cache.php');
	require_once(DIR_SYSTEM . 'library/cachehtml.php');
	require_once(DIR_SYSTEM . 'library/session.php');
	require_once(DIR_SYSTEM . 'library/db.php');
	require_once(DIR_SYSTEM . 'library/loader.php');
	require_once(DIR_SYSTEM . 'library/config.php');
	require_once(DIR_SYSTEM . 'library/date.php');
	require_once(DIR_SYSTEM . 'library/pager.php');
	require_once(DIR_SYSTEM . 'library/upload.php');
	require_once(DIR_SYSTEM . 'library/validation.php');
	require_once(DIR_SYSTEM . 'library/string.php');
	require_once(DIR_SYSTEM . 'library/user.php');
	require_once(DIR_SYSTEM . 'library/member.php');
	require_once(DIR_SYSTEM . 'library/json.php');
	require_once(DIR_SYSTEM . 'library/image.php');
	require_once(DIR_SYSTEM . 'library/mailsmtp.php');
	include(DIR_COMPONENT."securimage/securimage.php");
	
	
	// Loader
	$loader = new Loader();
	Registry::set('load', $loader);
	
	// Config
	$config = new Config();
	Registry::set('config', $config);
	
	
	
	
	// Database 
	$db = new DB(DB_DRIVER, DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PREFIX);
	Registry::set('db', $db);
	
	// Request
	$request = new Request();
	Registry::set('request', $request);
	
	// Response
	$response = new Response();
	$response->addHeader('Content-Type', 'text/html; charset=UTF-8');
	Registry::set('response', $response);
	
	
	
	// Cache
	Registry::set('cache', new Cache());
	Registry::set('cachehtml', new Cachehtml());
	
	// Url
	Registry::set('url', new Url());
	
	// Session
	$session = new Session();
	Registry::set('session', $session);

			
	// Language
	$language = new Language();
	Registry::set('language', $language);
	
		
	// Document
	Registry::set('document', new Document());
	
	// DateTime
	$date = new Date();
	Registry::set('date', $date);
	
	// Upload
	$upload = new Upload();
	Registry::set('upload', $upload);
	
	// Validation
	$validation = new Validation();
	Registry::set('validation', $validation);
	
	//Pager
	$pager = new Pager();
	Registry::set('pager', $pager);
	
	//String
	$string = new String();
	Registry::set('string', $string);
	
	//JSON
	$json = new Json();
	Registry::set('json', $json);
	
	// User
	Registry::set('user', new User());
	
	// Member
	Registry::set('member', new Member());
	
	// mail
	Registry::set('mailsmtp', new MailSMTP());
	
?>
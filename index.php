<?php
	include_once('app.php');

	//error_log(sprintf("server: %s\n", print_r($_SERVER, true)));
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/index.php';
	$_GET['appTitle'] = APP_TITLE;
	$_GET['appPageName'] = APP_PAGENAME . ' - Home';
	$_GET['appNextPageHref'] = '/about.php';
	$_GET['appNextPageText'] = 'ABOUT';
	$_GET['appSsoVer'] = APP_SSOVERSION;
	$_GET['appClientKey'] = MERCHANT_CLIENT_KEY;
	$_GET['mncDigitalUrl'] = MNC_DIGITAL_URL;
	$_GET['userFullname'] = 'not login yet';
	$_GET['userEmail'] = '';
	$_GET['username'] = '';

	// error_log(sprintf("cookies: %s\n", print_r($_COOKIE, true)));
	error_log("index:1");
	if(isset($_COOKIE['ZxnsQxZ6IoI22OoX'])) {
		$cuuid = $_COOKIE['ZxnsQxZ6IoI22OoX'];
		$cpath = $_SERVER['DOCUMENT_ROOT']."/data/".$cuuid;
		error_log("index:2");
		if(file_exists($cpath)) {
			error_log("index:3");
			$scallback = file_get_contents($cpath."/callback.json");
			$jcallback = json_decode($scallback);
			if($jcallback != null) {
				error_log("index:4");
				if(array_key_exists('profile', $jcallback)) {
					error_log("index:5");
					$_GET['username'] = $jcallback->username;
					error_log("index:username: ". $_GET['username']);
					$sprofile = urldecode($jcallback->profile);
					$jprofile = json_decode($sprofile);
					if($jprofile != null) {
						$_GET['userFullname'] = $jprofile->firstname . " " . $jprofile->lastname;
						$_GET['userEmail'] = $jprofile->email;
						error_log("index:fullname: ". $_GET['userFullname']);
						error_log("index:email: ". $_GET['userEmail']);
					}
				}
			}
		}
	}

	require 'page.php';

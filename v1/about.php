<?php
	include_once('app.php');
	include_once('mncdigweb.php');

	//error_log(sprintf("server: %s\n", print_r($_SERVER, true)));
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	$domainName = $_SERVER['HTTP_HOST'].'/index.php';
	$_GET['appTitle'] = APP_TITLE;
	$_GET['appPageName'] = 'Clips Metube - About';
	$_GET['appNextPageHref'] = '/';
	$_GET['appNextPageText'] = 'HOME';
	$_GET['appSsoVer'] = APP_SSOVERSION;
	$_GET['mncDigitalUrl'] = MNC_DIGITAL_URL;
	$_GET['mncDigitalRegisterUrl'] = MNC_DIGITAL_URL . '/register?r=' . urlencode($protocol.$domainName);
	$_GET['mncDigitalLogoutUrl'] = MNC_DIGITAL_URL . '/logout?r=' . urlencode($protocol.$domainName);
	$_GET['mncDigitalProfileUrl'] = MNC_DIGITAL_URL . '/profile?r=' . urlencode($protocol.$domainName);
	$_GET['userFullname'] = 'not login yet';
	$_GET['userEmail'] = '';

	$response = mncdigGet(MNC_DIGITAL_CMURL, MERCHANT_STATIC_KEY, MERCHANT_REGISTERED_URL);
	//error_log(sprintf("response: %s\n", print_r($response, true)));
	if($response != null && json_last_error() == JSON_ERROR_NONE) {
		if($response->status != MDRST_FAILED && $response->data != null && $response->data->profile != null) {
			error_log(sprintf("profile: %s\n", print_r($response->data->profile, true)));
			error_log(sprintf("logged in email: %s\n", print_r($response->data->profile->email, true)));
			$_GET['userFullname'] = $response->data->profile->firstname . ' ' . $response->data->profile->lastname;
			$_GET['userEmail'] = $response->data->profile->email;
		}
	}

	require 'page.php';

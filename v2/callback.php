<?php

	include_once('app.php');

	////////////////////////////////////////////////////////////////////////////////////
	//
	// Please don't forget to chmod 777 on 'data' directory.
	//
	////////////////////////////////////////////////////////////////////////////////////

	function deleteDir($dirPath) {
		if(!is_dir($dirPath)) {
			error_log("dirPath must be a directory");
			return;
		}
		if(substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
			$dirPath .= '/';
		}
		$files = glob($dirPath . '*', GLOB_MARK);
		foreach($files as $file) {
			if (is_dir($file)) {
				deleteDir($file);
			} else {
				unlink($file);
			}
		}
		rmdir($dirPath);
	}

	error_log(sprintf("routeCallbackFromMncDigital:POST: %s\n", print_r($_POST, true)));

	header("Content-Type: text/plain");
	$retstat = 404;
	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['status'])) {
		$cuuid = $_POST['uuid'];
		$cusername = urldecode($_POST['username']);
		$cstatus = $_POST['status'];
		$json = '{}';
		$bNeedExtractToken = false;
		$ctoken = '';
		error_log('cusername: ' . $cusername . ', cstatus: ' . $cstatus);
		switch($cstatus) {
			case 'logout':
				// $json = '{"username":"'.$cusername.'", "logstat":"'.$cstatus.'"}';
				// file_put_contents($_SERVER['DOCUMENT_ROOT']."/data/".$cuuid."/callback.json", $json);
				deleteDir($_SERVER['DOCUMENT_ROOT']."/data/".$cuuid);
				break;
			case 'login':
			case 'profile':
				$ctoken = $_POST['token'];
				error_log("token = ". $ctoken);
				$bNeedExtractToken = true;
				break;
			default:
				break;
		}
		$retstat = 200;
	}

	http_response_code($retstat);
	print('.'); // response body akan diabaikan

	if(!$bNeedExtractToken) return;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, MNC_DIGITAL_URL . '/token/extract');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/x-www-form-urlencoded',
		'SecretKey: ' . MERCHANT_SERVER_KEY
	));
	curl_setopt($ch,CURLOPT_POST, 1);
	curl_setopt($ch,CURLOPT_POSTFIELDS, 'token='.$ctoken);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	$cprofile = curl_exec($ch);
	$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	if(curl_errno($ch)) {
		$rerr = curl_error($ch);
		curl_close($ch);
		error_log('requestTokenError: ' . $rerr);
		return;
	}
	curl_close($ch);
	error_log('httpcode: ' . $httpcode . ', requestTokenSuccess: ' . $cprofile);

	$json = '{"uuid":"'.$cuuid.'", "username":"'.$cusername.'", "logstat":"'.$cstatus.'", "profile":"'.$cprofile.'"}';

	$cpath = $_SERVER['DOCUMENT_ROOT']."/data/".$cuuid;
	if(!file_exists($cpath)) {
		if(!mkdir($cpath, 0755, true)) {
			error_log('UNABLE_TO_CREATE_DIRECTORY: ' . $cpath);
			return;
		}
	}

	file_put_contents($cpath."/callback.json", $json);

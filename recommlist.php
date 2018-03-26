<?php

	include_once('app.php');

	header("Content-Type: text/plain");
	$retstat = 404;
	$retbody = '.'; // response empty

	if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username'])) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, MNC_DIGITAL_URL . '/user/recommlist');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/x-www-form-urlencoded',
			'SecretKey: ' . MERCHANT_SERVER_KEY
		));
		curl_setopt($ch,CURLOPT_POST, 1);
		curl_setopt($ch,CURLOPT_POSTFIELDS, 'username=' . $_POST['username']);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		$crecommlist = curl_exec($ch);
		$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		if(curl_errno($ch)) {
			$rerr = curl_error($ch);
			error_log('requestRecommListError: ' . $rerr);
			$retstat = 400;
			$retbody = $rerr;
		} else {
			error_log('httpcode: ' . $httpcode . ', requestRecommListSuccess: ' . $crecommlist);
			$retstat = 200;
			$retbody = $crecommlist;
		}
		curl_close($ch);
	}

	http_response_code($retstat);
	print($retbody);

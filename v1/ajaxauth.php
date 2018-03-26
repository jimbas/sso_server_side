<?php

	include_once('app.php');
	include_once('mncdigweb.php');

	$response = mncdigAuth(MNC_DIGITAL_CMURL, MERCHANT_STATIC_KEY, MERCHANT_REGISTERED_URL);
	print(json_encode($response));

<?php

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// MNC Digital SSO API (mncdig.php)
	// 
	// CHANGES NOTES:
	//
	// v1.0
	//	  initial release
	//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	const MNCDIGDEBUG = false;
	const MDRST_SUCCESS = 11;
	const MDRST_FAILED = 10;

	function mncdigConnect($mncdigurl, $msk, $murl, $fields)
	{
		$strfields = '';
		foreach($fields as $key=>$value) { $strfields .= $key.'='.$value.'&'; }
		rtrim($strfields, '&');
		if(MNCDIGDEBUG) error_log('mncdigConnect:strfields= ' . $strfields);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $mncdigurl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Merchant-Static-Key: ' . $msk,
			'Merchant-Registered-URL: ' . $murl
		));
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $strfields);
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		$rval = curl_exec($ch);
		if(curl_errno($ch)) {
			$rerr = curl_error($ch);
			if(MNCDIGDEBUG) error_log('mncdigConnect:curlError= ' . $rerr);
			$jerr = json_decode(sprintf('{"status":10, "data":null, "message":"curlError: %s"}', $rerr));
			curl_close($ch);
			//$jerr->data = array('xml' => '<response><status>10</status><message>'.$rerr.'</message><data>null</data></response>');
			//return json_decode(json_encode($jerr)); // return stdClass instead of array
			return $jerr;
		}
		curl_close($ch);
		if(MNCDIGDEBUG) error_log(sprintf("mncdigConnect:rval= %s\n", $rval));
		//return json_decode($rval);
		$rvjson = json_decode($rval);
		if($rvjson == null && json_last_error() != JSON_ERROR_NONE) {
			return json_decode(sprintf('{"status":10, "data":null, "message":"jsonDecodeError: %s"}', json_last_error_msg()));
		}
		return $rvjson;
	}
?>

<?php

	////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//
	// MNC Digital SSO API for Backend Server (mncdigweb.php)
	// 
	// CHANGES NOTES:
	//
	// v1.0
	//	  initial release
	//
	////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	include_once('mncdig.php');

	//------------------------------------------------------------------------------------
	// authentication
	function mncdigAuth($mncdigurl, $msk, $murl)
	{
		$ck='';$ua='';$dsp='';$sw='';$cv='';$ts='';
		if(isset($_COOKIE['mncdigck'])) $ck = $_COOKIE['mncdigck'];
		if(isset($_POST['ua'])) $ua = $_POST['ua'];
		if(isset($_POST['dsp'])) $dsp = $_POST['dsp'];
		if(isset($_POST['sw'])) $sw = $_POST['sw'];
		if(isset($_POST['cv'])) $cv = $_POST['cv'];
		if(isset($_POST['ts'])) $ts = $_POST['ts'];
		$fields = array(
			'req' => urlencode('mncdigAuth'),
			'ck' => urlencode($ck),
			'ua' => urlencode($ua),
			'dsp' => urlencode($dsp),
			'sw' => urlencode($sw),
			'cv' => urlencode($cv),
			'ts' => urlencode($ts),
		);
		return mncdigConnect($mncdigurl, $msk, $murl, $fields);
	}

	//------------------------------------------------------------------------------------
	// to get data from mnc digital sso
	function mncdigGet($mncdigurl, $msk, $murl)
	{
		$ck='';$ua='';$dsp='';$sw='';$cv='';$ts='';
		if(isset($_COOKIE['mncdigck'])) $ck = $_COOKIE['mncdigck'];
		$fields = array(
			'req' => urlencode('mncdigGet'),
			'ck' => urlencode($ck),
		);
		return mncdigConnect($mncdigurl, $msk, $murl, $fields);
	}

?>

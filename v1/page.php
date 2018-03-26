<!DOCTYPE html>
<html>
<head>
	<title><?=$_GET['appTitle']?></title>
	<style>
		body {
			width: 35em;
			margin: 0 auto;
			font-family: Tahoma, Verdana, Arial, sans-serif;
		}
		.stdbtnoff {
			padding-top: 10px;
			padding-bottom: 10px;
			width: 30%;
			display: none;
		}
		.stdbtnoff .stdbtnon {
			display: block;
		}
	</style>
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
<br/>
<h1 align="center"><?=$_GET['appPageName']?></h1>
<h2 align="center">SSO <?=$_GET['appSsoVer']?></h2>
<h4 id="idusername" align="center"><?=$_GET['userFullname']?></h3>
<h4 id="iduseremail" align="center"><?=$_GET['userEmail']?></h4>
<p align="center">
	<button id="idbtn_mncsso" class="stdbtnon" type="button" onclick="doLogin()"> Login with MNC Digital </button>
	<br/>
	<button id="idbtn_mncsso_reg" class="stdbtnon" type="button" onclick="doRegister()"> Register with MNC Digital </button>
	<button id="idbtn_mncsso_prof" class="stdbtnon" type="button" onclick="doProfile()"> View your profile on MNC Digital </button>
	<button class="stdbtnon" type="button" onclick="doLogout()"> Logout from MNC Digital </button>
	<br/><br/>
	<a align="center" href="<?=$_GET['appNextPageHref']?>"><?=$_GET['appNextPageText']?></a>
</p>
<p align="center" id="idpuser" style="display:none;"></p>
</body>

<script type="text/javascript" src="/jquery.min.js"></script>
<script type="text/javascript" src="<?=$_GET['mncDigitalUrl']?>/public/js/mncdig.min.js?t=<?=time()?>"></script>

<script type="text/javascript">
	function doLogin() {
		mncdigLogin();
	}
	function doRegister() {
		window.location.href='<?=$_GET['mncDigitalRegisterUrl']?>';
	}
	function doProfile() {
		window.location.href='<?=$_GET['mncDigitalProfileUrl']?>';
	}
	function doLogout() {
		window.location.href='<?=$_GET['mncDigitalLogoutUrl']?>';
	}
	$(document).ready(function() {
		var suseremail = $('#iduseremail').html();
		var susername  = $('#idusername').html();
		// if(suseremail !== '' && susername !== '') {
		// 	return;
		// }
		mncdigAjaxAuth("/ajaxauth.php", function(stat, dat, msg) {
			var fsuccess = function(firstname, lastname, email) {
				$('#idusername').html(firstname + ' ' + lastname);
				$('#iduseremail').html(email);
			};
			switch(stat) {
				case 10: break;
				case 11: fsuccess(dat.firstname, dat.lastname, dat.email); break;
				case 12: break;
				case 13: fsuccess(dat.firstname, dat.lastname, dat.email); break;
			}
		});
	})
</script>
</html>

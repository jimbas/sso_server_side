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
<h4 align="center"><?=$_GET['userFullname']?></h4>
<h4 align="center"><?=$_GET['userEmail']?></h4>
<p align="center">
	<button id="idbtn_mncsso" class="stdbtnon" type="button" onclick="mncdigLogin('<?=$_GET['appClientKey']?>')"> Login with MNC Digital </button>
	<br/>
	<button id="idbtn_mncsso_prof" class="stdbtnon" type="button" onclick="mncdigProfile('<?=$_GET['appClientKey']?>')"> View your profile on MNC Digital </button>
	<button class="stdbtnon" type="button" onclick="mncdigLogout('<?=$_GET['appClientKey']?>')"> Logout from MNC Digital </button>
	<br/><br/>
	<a align="center" href="<?=$_GET['appNextPageHref']?>"><?=$_GET['appNextPageText']?></a>
	<br/><br/>
	<button class="stdbtnon" type="button" onclick="getRecommendationList()"> Get Recommendation List </button>
</p>
<p align="center" id="idpuser" style="display:none;"></p>
</body>

<script type="text/javascript" src="/jquery.min.js"></script>
<script type="text/javascript" src="<?=$_GET['mncDigitalUrl']?>/public/js/mncdig.min.js?t=<?=time()?>"></script>

<script type="text/javascript">

	$(document).ready(function() {
		mncdigAuth('<?=$_GET['username']?>', '<?=$_GET['appClientKey']?>');
	})

	function getRecommendationList() {
		var username = '<?=$_GET['username']?>';
		if(username === '') {
			alert('need login first');
			return;
		}
		var xmlhttp =  new XMLHttpRequest();
		xmlhttp.open('POST', '/recommlist.php', true);
		xmlhttp.onreadystatechange = function() {
			if(xmlhttp.readyState == 4) {
				if(xmlhttp.status != 200) {
					alert('Connection problem, please try again.');
					return;
				}
				console.log('responseText:', decodeURIComponent(xmlhttp.responseText));
			}
		}
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send('username='+encodeURIComponent(username));
	}

</script>
</html>

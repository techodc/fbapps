<?php
require './src/facebook.php';
require './src/DBManager.php';

$appId='177813092274900';
$secret='e2a5525597622b3745f64dbe0bc4ae50';
// app id and secret
$facebook = new Facebook(array(
  'appId'  => $appId,
  'secret' => $secret,
));

// User ID
$user = $facebook->getUser();
$db=new db_interact();
// if logged in
if ($user) {
	try {
		// get the profile
		$user_profile = $facebook->api('/me');
	} catch (FacebookApiException $e) {
		error_log($e);
		$user = null;
	}
}

// Login or logout url (depending on current user state).
if ($user) {
	$logoutUrl = $facebook->getLogoutUrl();
} else {
	$loginUrl = $facebook->getLoginUrl();
}

// admin profile.
$dc= $facebook->api('/deepak.chaudhry');
$token_url = "https://graph.facebook.com/oauth/access_token?" .
    "client_id=" .$appId.
    "&client_secret=" .$secret.
    "&grant_type=client_credentials";

  $app_access_token = file_get_contents($token_url);

  session_start(); 
$_SESSION['views'] = 1; // store session data
//echo "Pageviews = ". $_SESSION['views']; //retrieve data
  
$session =$_SESSION;
$session["fb"] = $facebook;
$_SESSION["uid"]=$user;
$session["appReqToken"] = $app_access_token;

?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="Stylesheet" href="css/ui-darkness/jquery-ui-1.8.12.custom.css" type="text/css"/>
<link rel="stylesheet" href="css/token-input.css" type="text/css" />
<link rel="stylesheet" href="css/token-input-facebook.css" type="text/css" />

<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>

<script type="text/javascript">
function saveCrushes(){

	var crushFrn=document.getElementById("frn-list").value;
	if (window.XMLHttpRequest)
	  {// code for IE7+, Firefox, Chrome, Opera, Safari
	  xmlhttp=new XMLHttpRequest();
	  }
	else
	  {// code for IE6, IE5
	  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	  }
	xmlhttp.onreadystatechange=function()
	  {
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
	    {
	    document.getElementById("status").innerHTML=xmlhttp.responseText;
	    }
	  }
		
	xmlhttp.open("GET","submit.php?q="+crushFrn+"&user="+<?php echo $user?>,true);
	xmlhttp.send();
}

</script>
<title>Find Your Crushes</title>
<style>
body {
	font-family: 'Lucida Grande', Verdana, Arial, sans-serif;
}

h1 a {
	text-decoration: none;
	color: #3b5998;
}

h1 a:hover {
	text-decoration: underline;
}
</style>
</head>
<body>
	<h1>Find your Friend-list Crushes</h1>
	<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
	</script>
	<div class="demo">
		<div id="tabs">
			<ul>
				<li><a href="#tabs-1">Tab 1</a></li>
				<li><a href="#tabs-3">Tab 3</a></li>
			</ul>
			<div id="tabs-1">
			<?php if ($user): ?>
				<table>
					<tr>
						<td width="25%">
							<h3>
								Welcome <br>
								<?php echo $user_profile[first_name] ?>
							</h3> 
							<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
						</td>
						<td><?php $friends = $facebook->api('/me/friends');?> <?php endif;?>
							<h2>Select Friends on which You have crushes</h2>
							<div>
								<input type="text" id="frn-list" name="blah" /> 
								<input type="button" value="Submit" onclick="saveCrushes();" />
								<p>Suggestions: <span id="status"></span></p>
								<script type="text/javascript">
        $(document).ready(function() {
            $("#frn-list").tokenInput([

<?php foreach($friends as $key=>$value){ 
	foreach ($value as $fkey=>$fvalue) {?>
{id:<?=$fvalue[id]?>, name: "<?=$fvalue[name]?>"},
<?php } }?>
{id: 47, name: "Java"} ]); });
        </script>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<div id="tabs-3">
				<p>Tab 3 a.</p>
				<form name="ftest">
					<ul>
						<li><input type="text" size="6" id="var1" name="var1" /> * <input
							type="text" size="6" id="var2" name="var2" /> = <input
							type="text" id="result" name="result" size="20" /> <input
							type="button"
							onsubmit="$('#result').val($.x_page_multiply($('#var1').val(),$('#var2').val()))"
							title="No action, just to triger onchange event in previous field"
							value="Count" /></li>
					</ul>
				</form>

				<p>Tab 3b.</p>
				<a href="javascript:attach_file( 'javascript.php' )">What time is
					it?</a> <br> <br> <span id="dynamic_span" />
			</div>
		</div>
	</div>

	<?php
	if($db){
		echo 'connection available';
		$id=$user;
		$name=$user_profile[name];
		echo 'id'.$id;
		echo 'name  '.$name;
	//	$db->saveRecord();
	}
	else
	echo 'null connection';
	?>
</body>
</html>

<?php
require './src/facebook.php';
require './src/DBManager.php';
require './RelController.php';

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
$relCont= new rel_controller();
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
$existCrushes=$relCont->getCrushes($user);
$existRln=$relCont->getRelations($user);
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link rel="Stylesheet"
	href="css/ui-darkness/jquery-ui-1.8.12.custom.css" type="text/css" />
<link rel="stylesheet" href="css/token-input.css" type="text/css" />
<link rel="stylesheet" href="css/token-input-facebook.css"
	type="text/css" />
<link rel="stylesheet" href="tablecloth.css" type="text/css" />
<style type="text/css" media="screen, print, projection">
#wrap {
	width: 750px;
	margin: 0 auto;
	background: #99c;
}

#crushes {
	float: left;
	width: 480px;
	padding: 10px;
	background: #9c9;
}

#reln {
	float: right;
	width: 230px;
	padding: 10px;
	background: #99c;
}
</style>
<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

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
							</h3> <img
							src="https://graph.facebook.com/<?php echo $user; ?>/picture">
						</td>
						<td><?php $friends = $facebook->api('/me/friends');?> <?php endif;?>
							<h2>Select Friends on which You have crushes</h2>
							<div>
								<input type="text" id="frn-list" name="blah" /> <input
									type="button" value="Submit" onclick="saveCrushes();" />
								<p>
									Suggestions: <span id="status"></span>
								</p>
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

			<?php
		 $i=0;
		 $showCrush;
		 $showRln;
		 while($row=mysql_fetch_array($existCrushes)){
		 	foreach($friends as $key=>$value){
		 		foreach ($value as $fkey=>$fvalue) {
						if($fvalue[id]==$row['SecondaryConn']){
							$facebookUrl = "https://graph.facebook.com/".$row['SecondaryConn'];
							$str = file_get_contents($facebookUrl);
							$result = json_decode($str);
							$showCrush[$i]= $result->name;
							$i=$i+1;
							continue;
						}
		 		}}}

		 		while($row=mysql_fetch_array($existRln)){
		 			foreach($friends as $key=>$value){
		 				foreach ($value as $fkey=>$fvalue) {
		 					if($fvalue[id]==$row['SecondaryConn']){
		 						$facebookUrl = "https://graph.facebook.com/".$row['SecondaryConn'];
		 						$str = file_get_contents($facebookUrl);
		 						$result = json_decode($str);
		 						$showRln[$i]= $result->name;
		 						$i=$i+1;
		 						continue;
		 					}
		 				}}}
		 				echo $showRln;
		 				?>
				<div id="wrap">
					<div id="crushes">
						<table name="test" cellpadding="0" cellspacing="0" border="0"
							class="tabledisplay" id="crushed">
							<thead>
								<tr>
									<th width="85%">Friend Name</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($showCrush as &$value) {
								echo "</td><td>";
								echo $value;
								echo "</td></tr>";
							}
							echo "</table>";
							?>
							</tbody>
							<tfoot>
							</tfoot>
						</table>
					</div>
					<div id="reln">
						<table name="test2" cellpadding="0" cellspacing="0" border="0"
							class="tabledisplay" id="crushed">
							<thead>
								<tr>
									<th width="85%">Friend Name</th>
								</tr>
							</thead>
							<tbody>
							<?php
							foreach ($showRln as &$value1) {
								echo "</td><td>";
								echo $value1;
								echo "</td></tr>";
							}
							echo "</table>";
							?>
							</tbody>
							<tfoot>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>

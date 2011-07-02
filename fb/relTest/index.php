<?php
require './src/facebook.php';
require './src/DBManager.php';

// app id and secret
$facebook = new Facebook(array(
  'appId'  => '177813092274900',
  'secret' => 'e2a5525597622b3745f64dbe0bc4ae50',
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
$session =$_SESSION;
?>
<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml"
	xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<link type="text/css" href="css/ui-darkness/jquery-ui-1.8.12.custom.css"
	rel="Stylesheet" />
<link rel="stylesheet" href="css/token-input.css" type="text/css" />
<link rel="stylesheet" href="css/token-input-facebook.css"
	type="text/css" />

<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.8.12.custom.min.js"></script>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script>
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
<script type="text/javascript">
    $(document).ready(function() {
        $("input[type=button]").click(function () {
            alert("Would submit: " + $(this).siblings("input[type=text]").val());
        });
    });
    </script>
    
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
				<h3>
					Welcome
					<?php echo $user_profile[first_name] ?>
				</h3>
				<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">
				<?php $friends = $facebook->api('/me/friends');?>

				<?php endif;?>
				<h2>Friend on which You have crushes</h2>
				<div>
					<input type="text" id="frn-list" name="blah" />
					<input	type="button" value="Submit" />
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

			</div>
			<div id="tabs-3">
				<p>Tab 3 a.</p>
				<p>Tab 3b.</p>
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
		$db->saveRecord();
	}
	else
	echo 'null connection';
	?>
</body>
</html>

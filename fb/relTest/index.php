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
					<h2>Simple Local Data Search</h2>
	<div>
		<input type="text" id="demo-input-local" name="blah" /> 
		<input type="button" value="Submit" />
		<script type="text/javascript">
        $(document).ready(function() {
            $("#demo-input-local").tokenInput([

<?php foreach($friends as $key=>$value){ 
	foreach ($value as $fkey=>$fvalue) {
	?>
{id:<?=$fvalue[id]?>, name: "<?=$fvalue[name]?>"},
<?php } }?>
                {id: 47, name: "Java"}
            ]);
        });
        </script>
	</div>
				
			</div>
			<div id="tabs-3">
				<p>Tab 3 a.</p>
				<p>Tab 3b.</p>
			</div>
		</div>
	</div>
	<?php if ($user): ?>
	<h3>Welcome</h3>
	<img src="https://graph.facebook.com/<?php echo $user; ?>/picture">

	<!-- h3>Your User Object (/me)</h3--s>

	<h3>Your friends</h3>
	<pre> <?php 
	$friends = $facebook->api('/me/friends');?>

	<!-- ?php foreach ($friends as $key=>$value) {
		echo count($value) . ' Friends';
		echo '<hr />';
		echo '<ul id="friends">';
		foreach ($value as $fkey=>$fvalue) {
			//	echo '$key'.$fkey;
			//			echo '$key'.$fvalue;
			//			echo '$fvalue[id]'.$fvalue[id];
			//			echo '$fvalue[name]'.$fvalue[name];
			echo '<li id="'. $fvalue[id] .'"><input type="checkbox"	 title="'.$fvalue[name] .'"/>'.$fvalue[name].'</li>';

		}
		echo '</ul>';
	}
	?-->
	</pre>


	<form name='ffriends' method="POST" action="" onsubmit="return false">
		<div class="scroll" id="listwords">
		<?php $i=0; ?>
			<ul style='margin-left: -44px'>
			<?php foreach($friends as $item){ ?>
				<li id="li<?=$item['id']?>" class='itemnormal'
					onclick="toggleSelect(<?=$item['id']?>)"><input
					id="chk<?=$item['id']?>" type="checkbox" /> <fb:name
						uid="<?=$item['id']?>" linked="false" />
				</li>
				<?php } ?>
			</ul>
		</div>
		<!-- div>
			<!--?php foreach ($friends as $key=>$value) {
		
		echo '<ul id="friends">';
		//	foreach ($value as $fkey=>$fvalue) {
		//	echo '$key'.$fkey;
		//			echo '$key'.$fvalue;
		//			echo '$fvalue[id]'.$fvalue[id];
		//			echo '$fvalue[name]'.$fvalue[name];
		//			echo '<li><img src="https://graph.facebook.com/' . $fvalue[id] . '/picture" title="' . $fvalue[name] . '"/></li>';
		//	}
		echo '</ul>';
	}
	?>
		</div-->
	</form>
	<fb:serverfbml width="615">

		<!-- fb:request-form action="http://fbrell.com/echo" method="POST"
			invite="true" type="Echo Type" content="Echo Content. 
			<fb:req-choice url='http://fbrell.com/echo?choice=echo' label='Echo Label' />">
			<fb:multi-friend-selector showborder="false" bypass="cancel" cols=4
				actiontext="Echo Action Text" />
		</fb:request-form-->

		<fb:request-form action="http://dccolumn.info/fb" method="POST"
			invite="true" type="reltracker"
			content=" TEXT SENT WITH INVITATIONS
<?php echo htmlentities("<fb:req-choice url=\"http://www.facebook.com/add.php?api_key=177813092274900 label=\"TEXT ON ACCEPT INVITATION BUTTON\"") ?> />
">

			<fb:multi-friend-selector
				actiontext="TEXT DISPLAYED ON THE FRIEND SELECTOR BOX (Example: Invite your friends.)"
				max="20" />

		</fb:request-form>
	</fb:serverfbml>

	<?php else: ?>
	<strong><em>You are not Connected.</em> </strong>
	<?php endif ?>

	<h3>Public profile of Naitik</h3>
	<img src="https://graph.facebook.com/naitik/picture">
	<?php
	//echo $naitik['name'];
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


	<iframe>
	<?php
	// Prepare the invitation text that all invited users will receive.
	$app_name='rel tracker';
	$app_url='reltracker';
	$app_base='dccolumn.info/';
	$content = "<fb:name uid=\"".$user."\" firstnameonly=\"true\" shownetwork=\"false\"/> <a href=\"http://apps.facebook.com/reltracker".$app_url."/\">".$app_name."</a> is cool bla bla. \n".
                        "<fb:req-choice url=\"".$app_base . $app_url."/index2.php?firs=fb{$user_profile["id"]}\" label=\" ".$app_name." Invite your friends!\"/>";

	?>
		<fb:serverFbml style="width: 760px;" width="760px">
			<script type="text/fbml">
    <fb:fbml width="760px">

    <fb:request-form
            action="http://facebookAppUrl/<? echo $invite_href; ?>"
            method="POST"

            invite="true"
            type="<? echo $app_name; ?>"
            content="<? echo htmlentities($content, ENT_COMPAT, 'UTF-8'); ?>">

            <fb:multi-friend-selector
                    actiontext="<? echo $app_name; ?>' invite your friends!"
                    exclude_ids="<? echo $friends; ?>"
                    style='width: 760px'
                    showborder="false"
                     />

    </fb:request-form>

    </fb:fbml>
    </script>
		</fb:serverFbml>

		<fb:serverFbml>
			<script type="text/fbml">
<fb:fbml>

<form action="<?php echo $base_url; ?>?page=testpage" method="post" enctype="multipart/form-data" onsubmit=" [ DO SOMETHING TO GET AND SET THE FRIEND UID AND NAME ON THE MAIn SITE ] return false;">
<fb:friend-selector uid="<?php echo $uid; ?>" name="friend_selector_name" idname="friend_selector_id" />
<input type="hidden" name="friend_selector_id" id="friend_selector_id" value="" />
<input type="submit" value="test" />
</form>
</fb:fbml>

</script>
		</fb:serverFbml>
	</iframe>
</body>
</html>

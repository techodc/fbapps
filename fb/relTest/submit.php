<?php
require './src/DBManager.php';

session_start();
//get the q parameter from URL
$q=$_GET["q"];
$uid=$_GET["user"];
$response="";
$db=new db_interact();

if (strlen($q) > 0)
{
	$delimiter=",";
	$splitcontents=explode($delimiter, $q);
	foreach ( $splitcontents as $id )
	{
		$counter = $counter+1;
		$response=$db->saveRecord($uid,$id);
		if($response==4){
			$apprequest_url ="https://graph.facebook.com/" . 
			$id. "/apprequests?message=’INSERT_UT8_STRING_MSG’" . "&data=’INSERT_STRING_DATA’&"  .
			 $_SESSION["appReqToken"]."&method=post";
			$result = file_get_contents($apprequest_url);
		}
	}
}

echo $response;
?>
<?php
require './src/DBManager.php';

session_start();
//get the q parameter from URL
$uid=$_GET["user"];
$response="";
$db=new db_interact();

if ($uid > 0)
{
		$response=$db->getCrushes($uid);
}

echo $response;
?>
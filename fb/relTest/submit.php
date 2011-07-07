<?php

require './src/DBManager.php';

// Fill up array with names
$a[]="Anna";
$a[]="Brittany";
$a[]="Cinderella";
$a[]="Diana";
$a[]="Eva";
$a[]="Fiona";
$a[]="Gunda";
$a[]="Hege";
$a[]="Inga";
$a[]="Elizabeth";
$a[]="Ellen";
$a[]="Wenche";
$a[]="Vicky";

//get the q parameter from URL
$q=$_GET["q"];
$uid=$_GET["user"];
$response="";
$db=new db_interact();
//echo $uid;
if (strlen($q) > 0)
{
	$delimiter=",";
	$splitcontents=explode($delimiter, $q);
	foreach ( $splitcontents as $id )
	{
		$counter = $counter+1;
$response=$response.",".$id;
		//echo "<b>Split $counter: </b> $id<br>";
		//$response=$response.$db->saveRelation('12', $id);
$db->saveRecord($uid,$id);		
	}
}

echo $response;
?>
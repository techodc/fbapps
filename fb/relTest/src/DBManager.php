<?php



class db_interact
{
	/**
	 * Version.
	 */
	const VERSION = '3.0.1';

	public $con;
	public function __construct() {
		//	$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		//if (!$con)
		//		{
		//			echo 'couldnt connect';
		//			die('Could not connect: ' . mysql_error());
		//		}
		//		else{
		//			echo 'connected';
		//			}

	}
	public function saveRecord($primPerson, $secondPerson){
		
		$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		echo  'inside save record'.$primPerson.$secondPerson;
		mysql_select_db("my_db", $con);
		//$sql = 'INSERT INTO `techodc`.`Active_A` (`RelationId`, `PrimaryConn`, `SecondaryConn`, `Comments`) VALUES (\'13\', \'14\', \'15\', \'163\');';
		//mysql_query("INSERT INTO techodc.Active_A (PrimaryConn, SecondaryConn, Comments) VALUES (2973, 374, '35')");
		mysql_query("INSERT INTO techodc.Active_A (PrimaryConn, SecondaryConn, Comments) VALUES ('.$primPerson.', '.$secondPerson.', '35')");
		mysql_close($con);

	}
	public function saveRelation($primPerson, $secondPerson) {
				$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		
		mysql_select_db("my_db", $con);
		$activeA = 'INSERT INTO `techodc`.`Active_A` (`PrimaryConn`, `SecondaryConn`, `Comments`) 
VALUES ('.$primPerson.', '.$secondPerson.', '.'fb'.')';
		$activeB = 'INSERT INTO `techodc`.`Active_B` (`PrimaryConn`, `SecondaryConn`, `Comments`) 
		VALUES ('.$secondPerson.', '.$primPerson.', '.'35123'.')';
		
		$err=mysql_query($activeA);

		$err=$err.mysql_query($activeB);

		mysql_close($con);
echo $err;
	}
}
?>
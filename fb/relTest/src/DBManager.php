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
	public function saveRecord(){
		$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		echo  'inside save record';
		mysql_select_db("my_db", $con);
		//$sql = 'INSERT INTO `techodc`.`Active_A` (`RelationId`, `PrimaryConn`, `SecondaryConn`, `Comments`) VALUES (\'13\', \'14\', \'15\', \'163\');';
		mysql_query("INSERT INTO techodc.Active_A (RelationId,PrimaryConn, SecondaryConn, Comments) VALUES (45,23, 34, '35')");
		mysql_query($sql);
		mysql_close($con);

	}
	public function saveRelation($primPerson, $secondPerson) {
		mysql_select_db("my_db", $con);

		mysql_query("INSERT INTO Active_A (PrimaryConn, SecondaryConn, Comments)
VALUES ('.$primPerson.', '.$secondPerson.', '35')");

		mysql_query("INSERT INTO Passive_B (PrimaryConn, SecondaryConn, Comments)
VALUES ('.$secondPerson.', '.$primPerson.', '35123')");

		mysql_close($con);

	}
}
?>
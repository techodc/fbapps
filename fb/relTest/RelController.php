<?php

require_once './src/DBManager.php';

class rel_controller
{
	/**
	 * Version.
	 */
	const VERSION = '3.0.1';

	public $con;
	public function __construct() {
	
	}
	public function getCrushes($userId){
		$db=new db_interact();
		/*
		$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		$returnMsg=0;
		mysql_select_db("my_db", $con);

		$crushes="Select * from techodc.Active_main where PrimaryConn=".$userId;

		$result=mysql_query($crushes);
		$num_rows = mysql_num_rows($result);
		*/
		$result=$db->getCrushes($userId);
		return $result;
	} 
	public function getRelations($userId){
		$db=new db_interact();
		/*
		$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		$returnMsg=0;
		mysql_select_db("my_db", $con);

		$crushes="Select * from techodc.Active_main where PrimaryConn=".$userId;

		$result=mysql_query($crushes);
		$num_rows = mysql_num_rows($result);
		*/
		$result=$db->getRelations($userId);
		return $result;
	} 
	
}
?>
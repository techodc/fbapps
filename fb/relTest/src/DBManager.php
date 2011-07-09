<?php

class db_interact
{
	/**
	 * Version.
	 */
	const VERSION = '3.0.1';

	public $con;
	public function __construct() {
		//$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
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
		$returnMsg=0;
		mysql_select_db("my_db", $con);

		$checkActive="Select * from techodc.Active_main where PrimaryConn=".$primPerson." And SecondaryConn=".$secondPerson;

		$existingAct=mysql_query($checkActive);
		$num_rows_act = mysql_num_rows($existingAct);

		if($num_rows_act=="0"){
			$insertActive="INSERT INTO techodc.Active_main (PrimaryConn, SecondaryConn, Comments)
							VALUES ('.$primPerson.', '.$secondPerson.', 'active')";	
			mysql_query($insertActive);
			$returnMsg=1;
		} else{
			// already exist . provide warning
			$returnMsg=2;
		}

		$checkPassive='Select * from techodc.Passive_main where PrimaryConn='.$secondPerson.' And SecondaryConn='.$primPerson;
		$existingPas=mysql_query($checkPassive,$con);

		$num_rows_pas = mysql_num_rows($existingPas);

		if($num_rows_pas==0){
			$insertPassive="INSERT INTO techodc.Passive_main (PrimaryConn, SecondaryConn, Comments)
							VALUES ('.$secondPerson.', '.$primPerson.', 'passive')";	
			mysql_query($insertPassive);
			$returnMsg=3;
		}
		else{
				
			//insert into relation and send notification
			$returnMsg=4;
		}
		mysql_close($con);
		return $returnMsg;
	}

}
?>
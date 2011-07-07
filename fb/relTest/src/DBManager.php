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
		mysql_select_db("my_db", $con);

		$checkActive="Select * from techodc.Active_main where PrimaryConn=".$primPerson." And SecondaryConn=".$secondPerson;

		$existingAct=mysql_query($checkActive);
		$num_rows_act = mysql_num_rows($existingAct);

		if($num_rows_act=="0"){
			$insertActive="INSERT INTO techodc.Active_main (PrimaryConn, SecondaryConn, Comments)
							VALUES ('.$primPerson.', '.$secondPerson.', 'active')";	
			mysql_query($insertActive);
		} else{
			// already exist . provide warning
		}

		$checkPassive='Select * from techodc.Passive_main where PrimaryConn='.$secondPerson.' And SecondaryConn='.$primPerson;
		$existingPas=mysql_query($checkPassive,$con);

		$num_rows_pas = mysql_num_rows($existingPas);

		if($num_rows_pas==0){
			$insertPassive="INSERT INTO techodc.Passive_main (PrimaryConn, SecondaryConn, Comments)
							VALUES ('.$secondPerson.', '.$primPerson.', 'passive')";	
			mysql_query($insertPassive);
		}
		else{
			
			//insert into relation and send notification
		}
		/*
		 mysql_query("INSERT INTO techodc.Active_A (PrimaryConn, SecondaryConn, Comments) VALUES ('.$primPerson.', '.$secondPerson.', '35')");
		 $activeB = 'INSERT INTO `techodc`.`Active_B` (`PrimaryConn`, `SecondaryConn`, `Comments`)
		 VALUES ('.$secondPerson.', '.$primPerson.', '.'35123'.')';
		 $err=mysql_query($activeB);
		 mysql_close($con);
		 */
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
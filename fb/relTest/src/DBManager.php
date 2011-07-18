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
		//primperson is the one who completes the relatoin. secondperson is the one who has started the relation.s
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
			$maxFullRelId="Select max(FullRelationId) from techodc.Relations";
			$maxIdResult=mysql_query($maxFullRelId);
			$row = mysql_fetch_row($maxIdResult);
			$max =$row[0]; // max value
				
			$insertRel="INSERT INTO techodc.Relations (FullRelationId,PrimaryConn, SecondaryConn)
							VALUES ('.$max.','.$primPerson.', '.$secondPerson.')";	
			mysql_query($insertRel);
			$returnMsg=4;
		}
		mysql_close($con);
		return $returnMsg;
	}

	public function getCrushes($userId){
		$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		$returnMsg=0;
		mysql_select_db("my_db", $con);

		$crushes="Select * from techodc.Active_main where PrimaryConn=".$userId;

		$result=mysql_query($crushes);
		$num_rows = mysql_num_rows($result);
		return $result;
	}

	public function getRelations($userId){
		$con = mysql_connect("techodc.db.8009021.hostedresource.com","techodc","accORA@8");
		$returnMsg=0;
		mysql_select_db("my_db", $con);

		$rln="Select * from techodc.Relations where PrimaryConn=".$userId." OR SecondaryConn=".$userId;

		$result=mysql_query($rln);
		$num_rows = mysql_num_rows($result);
/*
		$i=0;
		$showRln;
		while($row=mysql_fetch_array($result)){
			foreach($friends as $key=>$value){
				foreach ($value as $fkey=>$fvalue) {
					if($fvalue[id]==$row['SecondaryConn']){
						$facebookUrl = "https://graph.facebook.com/".$row['SecondaryConn'];
						$str = file_get_contents($facebookUrl);
						$result = json_decode($str);
						$showRln[$i]= $result->name;
						$i=$i+1;
						continue;
					}
				}}}
		return $showRln;
	*/
		return $result;
	}

}
?>
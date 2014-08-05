<?php 

include 'config.php';

$player= $_POST['player'];
$track= $_POST['track'];
$ranking= $_POST['ranking'];
$score= $_POST['score'];
$date= $_POST['date'];

// $player="test";
// $track="Nendaz-slalom";
// $ranking="1";
// $score="20";
// $date="01-01-2014";

/**************
 * Connection *
***************/
// Try to connect to DB with unity user
$con = mysql_connect($url,$sql_usr,$sql_pwd) or ("Cannot connect!"  . mysql_error());
if (!$con)
	die('Could not connect: ' . mysql_error());

// Select unity DB
mysql_select_db($db_name , $con) or die ("could not load the database" . mysql_error());

/***********************
 * Check if user exist *
***********************/
$check = mysql_query("SELECT * FROM `".$table_player."` WHERE `username`='".$player."'");
$numrows = mysql_num_rows($check);
if ($numrows == 0){
	echo txtToXML("achievement", "Error: player doesn't exist");
}else{
	add_score($table_achievement, $player, $track, $ranking, $score, $date);
}

/*****************************************
 * Add/update score to leaderboard table *
 *****************************************/
function add_score($table, $player, $track, $ranking, $score, $date){
		$ins = mysql_query("INSERT INTO  `".$table."` ( `player` ,  `track` , `ranking`, `score`, `date` ) VALUES
				 ('".$player."' ,  '".$track."' , '".$ranking."' , '".$score."' ,  '".date("Y-m-d H:i:s")."') ; ");
		if ($ins)
			echo txtToXML("achievement", "OK");
		else
			echo txtToXML("achievement", "Error: Cannot add achievement");
}
?>
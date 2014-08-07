<?php 

include 'config.php';

// $player= $_POST['player'];
// $track= $_POST['track'];
// $ranking= $_POST['ranking'];
// $score= $_POST['score'];
// $date= $_POST['date'];

$player="test";
$track="Nendaz-slalom";
$ranking="1";
$score="20";
$date="01-01-2014";

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
$playerArray = mysql_fetch_array($array);
if ($numrows == 0){
	echo txtToXML("achievement", "Error: player doesn't exist");
}else{
	$avg_previous = getLvl($player);
	echo "previous=".$avg_previous;
	add_score($table_achievement, $player, $track, $ranking, $score, $date);
	$avg_new = getLvl($player);
	echo "after=".$avg_new;
	updatePlayerLvl($playerArray, $avg_new-$avg_previous);
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


/*****************************************
 * Update player lvl *
*****************************************/
function updatePlayerLvl($playerArray, $delta){
	$lvl_old = $playerArray['lvl'];
	$min_max = mysql_fetch_array(mysql_query("SELECT MIN(value) AS min, MAX(value) AS max FROM `set_lvl`"));
	$lvl_new = 0;
	if($delta > 0){
		echo "Increase";
		// increase lvl if lvl < lvlMax
		if($lvl_old < $min_max['max'])
			$lvl_new += $lvl_old;
	}else if ($delta < 0){
		echo "Decrease";
		// lower lvl > lvlMin
		if($lvl_old > $min_max['min'])
			$lvl_new -= $lvl_old;
	}
	// else => Do nothing because delta==0
	$ins = mysql_query("UPDATE `dat_player` SET `lvl`='".$lvl_new."' WHERE `username` = '".$playerArray['username']."';");
}

function getLvl($player){
		$ins = mysql_query("SELECT AVG(score) AS avg FROM dat_achievement WHERE `player`='".$player."' GROUP BY player ");
		$ans = mysql_fetch_array($ins);
		return $ans['avg'];
}
?>
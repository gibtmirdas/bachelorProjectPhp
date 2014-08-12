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
// $score="10";
// $date="04-01-2014";

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
$playerArray = mysql_fetch_array($check);
if ($numrows == 0){
	echo txtToXML("achievement", "Error: player doesn't exist");
}else{
	$avg_previous = getLvl($player);
	echo "previous=".$avg_previous;
	add_score($table_achievement, $player, $track, $ranking, $score, $date);
	$avg_new = getLvl($player);
	echo "after=".$avg_new;
	echo "<br/>lvl:".$playerArray['lvl']."<br/>";
	updatePlayerLvl($playerArray['username'], $playerArray['lvl'], $avg_new-$avg_previous);
}

/*****************************************
 * Add/update score to leaderboard table *
 *****************************************/
/**
 * Push a new achievement into the database
 * @param string $table
 * @param string $player
 * @param string $track
 * @param int $ranking
 * @param int $score
 * @param datetime $date
 */
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
/**
 * Update the level value a the current player depending on the value of delta.
 * @param string $username
 * @param int $lvl
 * @param int $delta
 */
function updatePlayerLvl($username, $lvl, $delta){
	$lvl_old = $lvl;
	$min_max = mysql_fetch_array(mysql_query("SELECT MIN(value) AS min, MAX(value) AS max FROM `set_lvl`"));
	echo"<br/>MIN:".$min_max['min']."--MAX:".$min_max['max']."<br/>";
	$lvl_new = $lvl_old;
	if($delta > 0){
		echo "Increase";
		// increase lvl if lvl < lvlMax
		if($lvl_old < $min_max['max']){
			echo"FUCK0";
			$lvl_new = $lvl_old +1;
		}
	}else if ($delta < 0){
		echo "Decrease";
		// lower lvl > lvlMin
		if($lvl_old > $min_max['min']){
			echo"FUCK1";
			$lvl_new = $lvl_old-1;
		}
	}
	// else => Do nothing because delta==0
	echo "LvlNew:".$lvl_new."---LvlOld:".$lvl_old;
	mysql_query("UPDATE `dat_player` SET `lvl`='".$lvl_new."' WHERE `username` = '".$username."';");
	//mysql_fetch_object($ins);
}

/**
 * Return the level value of the specified player
 * @param string $player
 * @return the level value
 */
function getLvl($player){
		$ins = mysql_query("SELECT AVG(score) AS avg FROM dat_achievement WHERE `player`='".$player."' GROUP BY player ");
		$ans = mysql_fetch_array($ins);
		return $ans['avg'];
}
?>